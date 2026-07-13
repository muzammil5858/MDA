{{--
    partials/_objection_modal.blade.php
    ─────────────────────────────────────────────────────────────────────
    Variables expected (pass via @include):
      $modalId          string  — unique HTML id for the modal
      $modalTitle       string  — modal header title
      $objections       array   — collection/array of objection objects
      $attachmentTypes  array   — list of attachment type labels
      $replyRoute       string  — POST route for new reply submission
      $editRoute        string  — POST route for editing existing reply
    ─────────────────────────────────────────────────────────────────────
--}}

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0" style="border-radius:15px;">

            {{-- Header --}}
            <div class="modal-header text-white" style="background:var(--primary-blue); border-radius:15px 15px 0 0;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-history mr-2"></i>{{ $modalTitle }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            {{-- Summary bar --}}
            @php
                $total    = count($objections);
                $resolved = collect($objections)->where('status','resolved')->count();
                $pending  = $total - $resolved;
            @endphp
            <div class="px-4 pt-3 pb-2 d-flex gap-3" style="gap:12px; background:#f8f9fa; border-bottom:1px solid #dee2e6;">
                <span class="badge badge-secondary px-3 py-2" style="font-size:12px;">
                    Total: {{ $total }}
                </span>
                <span class="badge badge-success px-3 py-2" style="font-size:12px;">
                    Resolved: {{ $resolved }}
                </span>
                <span class="badge badge-danger px-3 py-2" style="font-size:12px;">
                    Pending: {{ $pending }}
                </span>
            </div>

            <div class="modal-body p-4">

                @foreach($objections as $index => $obj)
                    @php
                        $isPending           = strtolower($obj->status ?? 'pending') === 'pending';
                        $objResponses        = $obj->responses()->orderBy('created_at', 'desc')->get();
                        $hasAnyResponses     = $objResponses->count() > 0;
                        $latestResponse      = $objResponses->first();
                        $latestResponseStatus = $hasAnyResponses ? strtolower($latestResponse->status ?? 'pending') : null;
                        $canEditLatest       = $hasAnyResponses && $latestResponseStatus === 'pending';
                        $canAddNewResponse   = !$hasAnyResponses || ($hasAnyResponses && $latestResponseStatus !== 'pending');
                        $attachTypesJson     = json_encode($attachmentTypes);
                    @endphp

                    {{-- ── Objection Card ──────────────────────────────── --}}
                    <div class="obj-card {{ $isPending ? 'obj-pending' : 'obj-resolved' }}">

                        {{-- Card header --}}
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="font-weight-bold mb-0">
                                <i class="fas fa-flag mr-1"></i>
                                Objection #{{ $index + 1 }}
                            </h6>
                            <div class="d-flex align-items-center" style="gap:8px;">
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($obj->created_at)->format('d M Y') }}
                                </small>
                                <span class="badge {{ $isPending ? 'badge-danger' : 'badge-success' }} px-2 py-1">
                                    {{ strtoupper($obj->status ?? 'PENDING') }}
                                </span>
                            </div>
                        </div>

                        {{-- Clerk remarks --}}
                        <p class="mb-2">
                            <strong>Clerk Remarks:</strong>
                            {{ $obj->remarks ?? 'N/A' }}
                        </p>

                        {{-- ── Response History (all submitted responses) ────────────────── --}}
                        @if($hasAnyResponses)
                            <div class="mt-3">
                                <strong style="font-size:13px; color:#03346E;">
                                    <i class="fas fa-history mr-1"></i> Response History ({{ $objResponses->count() }})
                                </strong>

                                @foreach($objResponses as $respIndex => $response)
                                    @php
                                        $respStatus = strtolower($response->status ?? 'pending');
                                        $isLatestResp = ($respIndex === 0);
                                        $canEditThisResp = $isLatestResp && $respStatus === 'pending' && $isPending;
                                        $editFormId = $modalId . '_edit_resp_' . $response->id;
                                    @endphp

                                    <div class="response-preview mt-2 {{ $respStatus === 'pending' ? 'border-warning' : 'border-success' }}" style="border-left-color: {{ $respStatus === 'pending' ? '#f59e0b' : '#27aa80' }} !important;">
                                        {{-- Response Header --}}
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <small class="text-muted">
                                                    <strong>Response #{{ $respIndex + 1 }}</strong>
                                                    {{ \Carbon\Carbon::parse($response->created_at)->format('d M Y H:i') }}
                                                    @if($isLatestResp)
                                                        <span class="badge badge-info ml-2">Latest</span>
                                                    @endif
                                                </small>
                                            </div>
                                            <div style="display: flex; gap: 6px;">
                                                <span class="badge {{ $respStatus === 'pending' ? 'badge-warning' : 'badge-success' }} px-2 py-1">
                                                    {{ strtoupper($respStatus) }}
                                                </span>
                                                @if($canEditThisResp)
                                                    <button
                                                        class="btn btn-sm btn-outline-primary py-0 px-2"
                                                        style="font-size:11px;"
                                                        type="button"
                                                        data-toggle="collapse"
                                                        data-target="#{{ $editFormId }}"
                                                        title="Authority has not yet acted on this response">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Response Content --}}
                                        <p class="mb-1" style="font-size:13px;">{{ $response->response_text }}</p>

                                        {{-- Attachments --}}
                                        @if($response->attachments && $response->attachments->count() > 0)
                                            <div style="margin-top: 8px; display: flex; flex-wrap: wrap; gap: 6px;">
                                                @foreach($response->attachments as $att)
                                                    <a href="{{ route('viewObjectionFile', ['fileId' => $att->id]) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-info py-1 px-2"
                                                       style="font-size:11px;"
                                                       title="Click to view/download {{ $att->document_type ?? 'Attachment' }}">
                                                        <i class="fas fa-file-download fa-xs mr-1"></i>
                                                        {{ $att->document_type ?? 'File' }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Authority Remarks (if status is not pending) --}}
                                        @if($respStatus !== 'pending' && !empty($response->authority_remarks))
                                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #dee2e6;">
                                                <small class="text-muted d-block mb-1"><strong>Authority Remarks:</strong></small>
                                                <p class="mb-0" style="font-size:12px; color: #495057;">{{ $response->authority_remarks }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Edit form (collapsed) — only for latest & pending response --}}
                                    @if($canEditThisResp)
                                        <div id="{{ $editFormId }}" class="collapse">
                                            <form
                                                action="{{ $editRoute }}/{{ $response->id }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                                class="reply-box mt-2">
                                                @csrf
                                                @method('PUT')

                                                <p class="text-primary font-weight-bold mb-3" style="font-size:13px;">
                                                    <i class="fas fa-pencil-alt mr-1"></i> Edit Your Response
                                                </p>

                                                <div class="form-group">
                                                    <label class="font-weight-bold" style="font-size:13px;">Remarks</label>
                                                    <textarea
                                                        name="user_reply"
                                                        class="form-control form-control-sm"
                                                        rows="3"
                                                        required>{{ $response->response_text }}</textarea>
                                                </div>

                                                {{-- Attachment rows --}}
                                                <label class="font-weight-bold" style="font-size:13px;">
                                                    Attachments
                                                    <small class="text-muted font-weight-normal">(select type first)</small>
                                                </label>
                                                <div class="attachment-rows mb-2">
                                                    <div class="attachment-row">
                                                        <select name="attachment_types[]" class="form-control form-control-sm">
                                                            <option value="">-- Type --</option>
                                                            @foreach($attachmentTypes as $type)
                                                                <option value="{{ $type }}">{{ $type }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="file" name="attachments[]" class="form-control-file">
                                                    </div>
                                                </div>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-secondary mb-3 btn-add-attachment"
                                                    data-types="{{ $attachTypesJson }}">
                                                    <i class="fas fa-plus mr-1"></i> Add Another Attachment
                                                </button>

                                                <button type="submit" class="btn btn-primary btn-sm btn-block font-weight-bold">
                                                    <i class="fas fa-save mr-1"></i> Save Changes
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- ── Button to add new response ────────────────── --}}
                        @if($canAddNewResponse)
                            @php
                                $newReplyFormId = $modalId . '_new_reply_' . $obj->id;
                            @endphp

                            <div class="mt-3">
                                @if($hasAnyResponses)
                                    <button
                                        class="btn btn-outline-info btn-sm font-weight-bold"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#{{ $newReplyFormId }}"
                                        title="Authority has acted on the previous response. You can submit a new response.">
                                        <i class="fas fa-comment-dots mr-1"></i> Submit New Response
                                    </button>
                                @else
                                    <button
                                        class="btn btn-outline-danger btn-sm font-weight-bold"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#{{ $newReplyFormId }}">
                                        <i class="fas fa-reply mr-1"></i> Reply to this Objection
                                    </button>
                                @endif

                                <div id="{{ $newReplyFormId }}" class="collapse">
                                    <form
                                        action="{{ $replyRoute }}/{{ $obj->id }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        class="reply-box mt-2">
                                        @csrf

                                        <p class="text-danger font-weight-bold mb-3" style="font-size:13px;">
                                            @if($hasAnyResponses)
                                                <i class="fas fa-comment-dots mr-1"></i> Submit New Response to Objection #{{ $index + 1 }}
                                            @else
                                                <i class="fas fa-reply mr-1"></i> Responding to Objection #{{ $index + 1 }}
                                            @endif
                                        </p>

                                        <div class="form-group">
                                            <label class="font-weight-bold" style="font-size:13px;">Your Remarks</label>
                                            <textarea
                                                name="user_reply"
                                                class="form-control form-control-sm"
                                                rows="3"
                                                placeholder="Write your explanation here..."
                                                required></textarea>
                                        </div>

                                        {{-- Attachment rows --}}
                                        <label class="font-weight-bold" style="font-size:13px;">
                                            Attachments
                                            <small class="text-muted font-weight-normal">(optional — select type first)</small>
                                        </label>
                                        <div class="attachment-rows mb-2">
                                            <div class="attachment-row">
                                                <select name="attachment_types[]" class="form-control form-control-sm">
                                                    <option value="">-- Type --</option>
                                                    @foreach($attachmentTypes as $type)
                                                        <option value="{{ $type }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="file" name="attachments[]" class="form-control-file">
                                            </div>
                                        </div>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-secondary mb-3 btn-add-attachment"
                                            data-types="{{ $attachTypesJson }}">
                                            <i class="fas fa-plus mr-1"></i> Add Another Attachment
                                        </button>

                                        <button type="submit" class="btn btn-danger btn-sm btn-block font-weight-bold py-2">
                                            <i class="fas fa-paper-plane mr-1"></i> Submit Response
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                    </div>{{-- /obj-card --}}
                @endforeach

            </div>{{-- /modal-body --}}
        </div>
    </div>
</div>
