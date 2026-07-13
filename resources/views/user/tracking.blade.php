<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Progress Tracker</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            :root {
                --primary-blue:   #03346E;
                --success-green:  #27aa80;
                --danger-red:     #dc3545;
                --warning-orange: #f59e0b;
                --bg-light:       #F4F6F9;
            }

            .container { background: var(--bg-light); border-radius: 15px; padding-bottom: 30px; }
            .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,.05); margin-top: 40px; }
            .card-body { padding: 40px; border-radius: 15px; }

            #heading    { color: var(--primary-blue); font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
            #subheading { color: #6c757d; margin-bottom: 40px; }

            /* ── Tracker steps ────────────────────────────────────── */
            .order-tracking { text-align: center; position: relative; flex: 1; }

            .order-tracking .is-complete {
                display: block; position: relative; border-radius: 50%;
                height: 34px; width: 34px; background-color: #cbd5e1;
                margin: 0 auto; z-index: 2; transition: all .3s ease;
                line-height: 34px; color: #fff; font-size: 14px;
            }
            .order-tracking.completed   .is-complete { background-color: var(--success-green); box-shadow: 0 0 0 5px rgba(39,170,128,.2); }
            .order-tracking.objected    .is-complete { background-color: var(--danger-red);    box-shadow: 0 0 0 5px rgba(220,53,69,.2); }
            .order-tracking.not-completed .is-complete { background-color: var(--danger-red);  box-shadow: 0 0 0 5px rgba(220,53,69,.2); }

            .order-tracking::before {
                content: ''; display: block; height: 4px; width: 100%;
                background-color: #cbd5e1; position: absolute;
                left: -50%; top: 15px; z-index: 1;
            }
            .order-tracking:first-child::before { display: none; }
            .order-tracking.completed::before   { background-color: var(--success-green); }

            .order-tracking p { font-weight: 600; margin-top: 15px; font-size: 13px; color: #475569; line-height: 1.4; }
            .order-tracking.completed p { color: var(--primary-blue); }

            .btn-step-badge {
                font-size: 10px; padding: 2px 9px; border-radius: 20px;
                text-transform: uppercase; font-weight: 700; margin-top: 4px;
                cursor: pointer; transition: .3s; display: inline-block;
            }

            /* ── Objection cards ──────────────────────────────────── */
            .obj-card {
                border-radius: 10px; padding: 18px 20px; margin-bottom: 18px;
                border-left: 5px solid;
            }
            .obj-card.obj-resolved  { background: #e8f5e9; border-color: var(--success-green); }
            .obj-card.obj-pending   { background: #fff5f5; border-color: var(--danger-red); }

            /* ── Reply / Edit form ────────────────────────────────── */
            .reply-box {
                background: #fff; border: 1px solid #dee2e6;
                border-radius: 8px; padding: 18px; margin-top: 12px;
            }
            .attachment-row {
                display: flex; gap: 10px; align-items: center;
                background: #f8f9fa; border-radius: 6px;
                padding: 8px 10px; margin-bottom: 8px;
            }
            .attachment-row select { flex: 0 0 170px; }
            .attachment-row input[type=file] { flex: 1; }
            .attachment-row .btn-remove-att { flex: 0 0 auto; }

            /* Existing response preview */
            .response-preview {
                background: #e7f3ff; border-left: 4px solid #007bff;
                border-radius: 6px; padding: 12px 15px; margin-top: 10px;
            }
            .response-preview .att-chip {
                display: inline-block; background: #007bff; color: #fff;
                border-radius: 20px; font-size: 11px; padding: 2px 10px; margin: 2px;
            }
        </style>
    </head>

    <body>
        @php
            /*
            ┌─────────────────────────────────────────────────────────────┐
            │  REAL VARIABLES — passed from your controller               │
            │                                                             │
            │  $request       — the TransferRequest model                 │
            │  $track         — the tracking row (transfer_trackings)     │
            │  $property      — the property row                          │
            │  $smallRequest  — the map-request row                       │
            │                                                             │
            │  Controller should pass:                                    │
            │    'requestType'   => $request->type,          // 1|2|3|4  │
            │    'deoAction'     => $request->deo_action,    // 0|1|2     │
            │    'deoObjections' => $request->objections,                 │
            │    'hdmAction'     => $request->hdm_action,    // type 4    │
            │    'hdmObjections' => $request->hdmObjections, // type 4    │
            └─────────────────────────────────────────────────────────────┘
            */

            // ── Request type ───────────────────────────────────────────
            // Types 1, 2, 3  →  original 5-step flow
            // Type  4         →  new 6-step flow (HDM · Sub Eng · AD · DD)
            $requestType = $request->request_type ?? 1;
            $isType4     = ($requestType == 4);


            // ── Record Clerk / DEO step ────────────────────────────────
            // deo_action: null/0 = awaiting, 1 = approved, 2 = has objections
            $deoAction      = $request->deo_action ?? null;
            $deoObjections  = $request->deoObjections ?? collect();
            $deoObjCount    = $deoObjections->count();
            $deoHasPending  = $request->hasDeoPendingObjections() > 0;
          
            $deoStepClass   = match(true) {
                $deoAction == 2 => $deoHasPending ? 'objected' : 'completed',
                $deoAction == 1 => 'completed',
                default         => '',
            };

            // ── Types 1 / 2 / 3  —  original track flags ─────────────
            // These map to your existing $track model columns
            $hasAppointment    = $track->appointment    ?? false;  // bool / date
            $ddApproved        = ($track->dd_action     ?? '') == '1';
            $transferIssued    = ($track->transfer_order ?? '') == '1'; // add col if needed

            // ── Type 4  —  additional step flags ──────────────────────
            // HDM action: null/0 = awaiting, 1 = approved, 2 = has objections
            $hdmAction     = $request->head_status     ?? null;
            $hdmObjections = $request->hdmObjections  ?? collect();  // eager-loaded scope/relation
            $hdmObjCount   = $hdmObjections->count();
            $hdmHasPending = $hdmObjections->where('status', 'pending')->count() > 0;
            $hdmStepClass  = match(true) {
                $hdmAction == 2 => $hdmHasPending ? 'objected' : 'completed',
                $hdmAction == 1 => 'completed',
                default         => '',
            };

            // Sub Engineer → $track->sub_engineer_action == '1'
            $subEngClass = ($track->sub_engineer_action ?? '') == '1' ? 'completed' : '';

            // AD (Assistant Director) → $track->ad_action == '1'
            $adClass = ($track->ad_action ?? '') == '1' ? 'completed' : '';

            // DD (Deputy Director)    → $track->dd_action == '1'  (same column, both flows)
            $ddClass = $ddApproved ? 'completed' : '';

            // ── Attachment type list ───────────────────────────────────
            $attachmentTypes = [
                'CNIC Front', 'CNIC Back', 'Allotment Order', 'Fee Receipt',
                'Possession Chit', 'Attorney Letter', 'Map (PNG)', 'Map (PDF)',
                'Map (AutoCAD)', 'Other',
            ];
        @endphp

        <div class="container mt-4">
            <div class="card">
                <div class="card-body">
                    <h2 id="heading" class="text-center">Mangla Dam Housing Authority</h2>
                    <p id="subheading" class="text-center">Transfer Application Progress Tracker</p>

                    {{-- ═══════════════════════════════════════════════════
                         TRACKER STEPS
                    ════════════════════════════════════════════════════ --}}
                    <div class="row justify-content-center pt-4 pb-5">
                        <div class="col-12 col-md-11">
                            <div class="d-flex justify-content-between">

                                {{-- Step 1: Application Submitted (always) --}}
                                <div class="order-tracking completed">
                                    <span class="is-complete"><i class="fas fa-check"></i></span>
                                    <p>Application<br>Submitted</p>
                                </div>

                                {{-- Step 2: Record Clerk (always) --}}
                                <div class="order-tracking {{ $deoStepClass }}">
                                    <span class="is-complete">
                                        @if($deoStepClass === 'completed') <i class="fas fa-check"></i>
                                        @elseif($deoStepClass === 'objected') <i class="fas fa-exclamation"></i>
                                        @else <i class="fas fa-clock"></i>
                                        @endif
                                    </span>
                                    <p>
                                        Record Clerk
                                        @if($deoObjCount > 0)
                                            <br>
                                            <span
                                                class="btn-step-badge btn {{ $deoHasPending ? 'btn-danger' : 'btn-success' }}"
                                                data-toggle="modal"
                                                data-target="#deoObjectionModal">
                                                <i class="fas fa-history fa-xs"></i>
                                                {{ $deoObjCount }} Objection{{ $deoObjCount != 1 ? 's' : '' }}
                                            </span>
                                        @endif
                                    </p>
                                </div>

                                @if($isType4)
                                    {{-- ══════════════════════════════════════════════
                                         TYPE 4  →  Record Clerk · HDM · Sub Eng · AD · DD
                                    ═══════════════════════════════════════════════ --}}

                                    {{-- Step 3: HDM --}}
                                    <div class="order-tracking {{ $hdmStepClass }}">
                                        <span class="is-complete">
                                            @if($hdmStepClass === 'completed')    <i class="fas fa-check"></i>
                                            @elseif($hdmStepClass === 'objected') <i class="fas fa-exclamation"></i>
                                            @else                                 <i class="fas fa-clock"></i>
                                            @endif
                                        </span>
                                        <p>
                                            HDM
                                            @if($hdmAction == 2)
                                                <br>
                                                <span
                                                    class="btn-step-badge btn {{ $hdmHasPending ? 'btn-danger' : 'btn-success' }}"
                                                    data-toggle="modal"
                                                    data-target="#hdmObjectionModal">
                                                    <i class="fas fa-history fa-xs"></i>
                                                    {{ $hdmObjCount }} Objection{{ $hdmObjCount != 1 ? 's' : '' }}
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- Step 4: Sub Engineer ($track->sub_engineer_action == '1') --}}
                                    <div class="order-tracking {{ $subEngClass }}">
                                        <span class="is-complete">
                                            @if($subEngClass === 'completed') <i class="fas fa-check"></i>
                                            @else                             <i class="fas fa-clock"></i>
                                            @endif
                                        </span>
                                        <p>Sub<br>Engineer</p>
                                    </div>

                                    {{-- Step 5: AD ($track->ad_action == '1') --}}
                                    <div class="order-tracking {{ $adClass }}">
                                        <span class="is-complete">
                                            @if($adClass === 'completed') <i class="fas fa-check"></i>
                                            @else                         <i class="fas fa-clock"></i>
                                            @endif
                                        </span>
                                        <p>AD</p>
                                    </div>

                                    {{-- Step 6: DD ($track->dd_action == '1') --}}
                                    <div class="order-tracking {{ $ddClass }}">
                                        <span class="is-complete">
                                            @if($ddClass === 'completed') <i class="fas fa-check"></i>
                                            @else                         <i class="fas fa-clock"></i>
                                            @endif
                                        </span>
                                        <p>DD</p>
                                    </div>

                                @else
                                    {{-- ══════════════════════════════════════════════
                                         TYPES 1 · 2 · 3  →  original 5-step flow
                                         (from your original progress-tracker code)
                                         Appointment → Final Verification → Transfer Order
                                    ═══════════════════════════════════════════════ --}}

                                    {{-- Step 3: Appointment ($track->appointment) --}}
                                    <div class="order-tracking {{ $hasAppointment ? 'completed' : '' }}">
                                        <span class="is-complete">
                                            @if($hasAppointment) <i class="fas fa-check"></i>
                                            @else                <i class="fas fa-clock"></i>
                                            @endif
                                        </span>
                                        <p>Appointment</p>
                                    </div>

                                    {{-- Step 4: Final Verification ($track->dd_action == '1') --}}
                                    <div class="order-tracking {{ $ddApproved ? 'completed' : '' }}">
                                        <span class="is-complete">
                                            @if($ddApproved) <i class="fas fa-check"></i>
                                            @else            <i class="fas fa-clock"></i>
                                            @endif
                                        </span>
                                        <p>Final<br>Verification</p>
                                    </div>

                                    {{-- Step 5: Transfer Order ($track->transfer_order == '1') --}}
                                    <div class="order-tracking {{ $transferIssued ? 'completed' : '' }}">
                                        <span class="is-complete">
                                            @if($transferIssued) <i class="fas fa-check"></i>
                                            @else                <i class="fas fa-clock"></i>
                                            @endif
                                        </span>
                                        <p>Transfer<br>Order</p>
                                    </div>

                                @endif

                            </div>{{-- /d-flex --}}
                        </div>
                    </div>

                </div>{{-- /card-body --}}
            </div>{{-- /card --}}
        </div>{{-- /container --}}


        {{-- ═══════════════════════════════════════════════════════════════
             REUSABLE MACRO: Objection Modal
             Usage: @include('partials._objection_modal', [...])
             Inlined here as a Blade component-style include for clarity.
        ════════════════════════════════════════════════════════════════ --}}

        {{-- ── DEO / Record Clerk Objections Modal ────────────────────── --}}
        @include('partials.objections._objections_modal', [
            'modalId'        => 'deoObjectionModal',
            'modalTitle'     => 'Record Clerk — Objection History',
            'objections'     => $deoObjections,
            'attachmentTypes'=> $attachmentTypes,
            'replyRoute'     => '/objection-reply',       // adjust to your route
            'editRoute'      => '/objection-reply-edit',  // adjust to your route
        ])

        @if($isType4)
            {{-- ── HDM Objections Modal ────────────────────────────────── --}}
            @include('partials.objections._objections_modal', [
                'modalId'        => 'hdmObjectionModal',
                'modalTitle'     => 'HDM — Objection History',
                'objections'     => $hdmObjections,
                'attachmentTypes'=> $attachmentTypes,
                'replyRoute'     => '/hdm-objection-reply',
                'editRoute'      => '/hdm-objection-reply-edit',
            ])
        @endif

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
        /* ── Reset modals on close ──────────────────────────── */
        $('.modal').on('hidden.bs.modal', function () {
            $(this).find('.collapse').collapse('hide');
            $(this).find('form').trigger('reset');
            // Remove any dynamically added attachment rows (keep the first)
            $(this).find('.extra-att-row').remove();
        });

        /* ── Add attachment row ─────────────────────────────── */
        $(document).on('click', '.btn-add-attachment', function () {
            const container  = $(this).closest('form').find('.attachment-rows');
            const typeOptions = $(this).data('types');  // passed as JSON
            let opts = '';
            typeOptions.forEach(t => { opts += `<option value="${t}">${t}</option>`; });

            const row = `
            <div class="attachment-row extra-att-row">
                <select name="attachment_types[]" class="form-control form-control-sm">
                    <option value="">-- Type --</option>${opts}
                </select>
                <input type="file" name="attachments[]" class="form-control-file">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-att">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;
            container.append(row);
        });

        /* ── Remove attachment row ──────────────────────────── */
        $(document).on('click', '.btn-remove-att', function () {
            $(this).closest('.attachment-row').remove();
        });
        </script>
    </body>
</x-app-layout>
