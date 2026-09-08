<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <style>
        .preview-toolbar{
            display:flex;
            align-items:center;
            gap:8px;
            margin-bottom:8px;
            background:#f1f1f1;
            padding:6px 10px;
            border-radius:6px;
            width:fit-content;
        }
        .preview-toolbar button{
            background:#03346E;
            color:#fff;
            border:none;
            border-radius:4px;
            width:28px;
            height:28px;
            font-size:16px;
            line-height:1;
            cursor:pointer;
        }
        .preview-toolbar button:hover{ background:#022a57; }
        #zoomResetBtn{ width:auto; padding:0 10px; font-size:12px; }
        #zoomLevel{
            font-size:13px;
            color:#333;
            min-width:42px;
            text-align:center;
        }

        .preview-box {
            overflow: auto !important;
            position: relative;
        }

        .preview-box .pdf-scroll-outer {
            display: block;
            width: 100%;
            min-height: 100%;
        }

        .preview-box .pdf-viewer-container {
            transform-origin: top left;
            transition: transform 0.15s ease;
            width: fit-content;
            min-width: 100%;
            min-height: 100%;
        }
        .pdf-page-wrap{
            position:relative;
            margin:0 auto 12px auto;
            background:#fff;
            box-shadow:0 2px 6px rgba(0,0,0,0.3);
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:200px;
        }
        .pdf-page-wrap canvas{
            display:block;
            max-width:100%;
        }
        .pdf-page-loading{
            color:#888;
            font-size:13px;
            text-align:center;
        }
        .pdf-page-number{
            position:absolute;
            bottom:6px;
            right:8px;
            background:rgba(0,0,0,0.55);
            color:#fff;
            font-size:11px;
            padding:1px 6px;
            border-radius:3px;
        }
        .current-file-box {
            background: #f1f7ff;
            border: 1px solid #cfe0ff;
            border-radius: 4px;
            padding: 6px 10px;
            margin-top: -8px;
            margin-bottom: 15px;
            font-size: 13px;
        }
        .current-file-box .current-file-label {
            color: #555;
            font-weight: 600;
            margin-right: 4px;
        }

        .complete-file-check {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .complete-file-check input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
            min-width: 18px;
            max-width: 18px;
            margin: 0 10px 0 0 !important;
            padding: 0 !important;
            display: inline-block !important;
            flex: 0 0 18px;
            cursor: default;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #fff;
            border: 2px solid #03346E;
            border-radius: 3px;
            position: relative;
        }
        .complete-file-check input[type="checkbox"]:checked {
            background-color: #fff;
            border: 2px solid #03346E;
        }

        .complete-file-check input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            left: 4px;
            top: 0px;
            width: 5px;
            height: 10px;
            border: solid #000;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .complete-file-check input[type="checkbox"]:disabled {
            opacity: 0.7;
        }

        .complete-file-check label {
            margin: 0 !important;
            font-size: 14px;
            color: #333;
            cursor: default;
        }

        .current-file-box a {
            color: #03346E;
            word-break: break-all;
            text-decoration: underline;
        }

        p { color: grey }
        .select2-container{ width:100% !important; margin-bottom:15px; }
        .select2-container--default .select2-selection--single{
            background:#f5f5f5 !important; border:1px solid #ddd !important;
            border-radius:0 !important; height:42px !important; padding:0 15px;
            display:flex; align-items:center;
        }
        .select2-container--default .select2-selection__rendered{
            color:#2C3E50 !important; line-height:40px !important; padding-left:0 !important;
            font-size:16px; letter-spacing:1px;
        }
        .select2-container--default .select2-selection__arrow{ height:40px !important; right:10px !important; display:none !important; }
        .select2-container--default.select2-container--focus .select2-selection--single{ border:1px solid #03346E !important; box-shadow:none !important; }
        .select2-dropdown{ border:1px solid #03346E !important; }
        .select2-search__field{ border:none !important; outline:none !important; box-shadow:none !important; }

        #heading { text-transform: uppercase; color: #03346E; font-weight: bolder; font-size: 1.5rem; }

        .detail-label {
            font-weight: 600;
            color: #555;
            font-size: 13px;
            margin-bottom: 2px;
            display: block;
        }
        .detail-subheading {
            font-weight: 400;
            color: #2C2C2C;
            font-size: 11px;
            margin-bottom: 2px;
            display: block;
        }
        .detail-subheading-empty {
            color: #aaa;
            font-style: italic;
        }

        .section-title {
            font-size: 18px;
            color: #03346E;
            font-weight: 600;
            margin: 20px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #03346E;
        }

        .transferee-block {
            border: 1px dashed #03346E;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background: #fafcff;
        }

        .badge-success {
            background: #28a745;
            color: #fff;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
        }

        .py-4{
            height:calc(100vh - 80px);
            overflow:hidden;
        }

        .max-w-8xl{
            height:100%;
        }

        .bg-white{
            height:100%;
            border-radius:12px;
        }

        .bg-white > .row{
            height:100%;
        }

        .preview-col{
            height:100%;
            padding:18px;
        }

        .preview-box{
            height:calc(100% - 40px);
            border:1px solid #d9d9d9;
            border-radius:8px;
            overflow:hidden;
            background:#fafafa;
            user-select:none;
            -webkit-user-select:none;
            -moz-user-select:none;
        }

        .preview-box iframe{
            width:100%;
            height:100%;
            border:none;
        }

        .no-preview{
            height:100%;
            display:flex;
            justify-content:center;
            align-items:center;
            color:#888;
            text-align:center;
        }

        .form-col{
            height:100%;
            padding:18px;
            overflow-y:auto;
        }

        .form-col .card{
            height:100%;
            border-radius:10px;
            overflow:hidden;
            display:flex;
            flex-direction:column;
            padding: 20px;
        }

        #detailView{
            flex:1;
            overflow-y:auto;
            overflow-x:hidden;
            padding-right:10px;
        }

        #detailView::-webkit-scrollbar{
            width:7px;
        }

        #detailView::-webkit-scrollbar-thumb{
            background:#b5b5b5;
            border-radius:20px;
        }

        .file-link {
            color: #03346E;
            text-decoration: underline;
            word-break: break-all;
        }

        @media(max-width:991px){
            .py-4{
                height:auto;
                overflow:visible;
            }
            .bg-white{
                height:auto;
            }
            .preview-col,
            .form-col{
                height:auto;
            }
            .preview-box{
                height:400px;
            }
            #detailView{
                overflow:visible;
            }
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        @media(max-width:768px){
            .two-col {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>

    <div class="py-4">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="row mx-0">

                    {{-- ===================== LEFT: DOCUMENT PREVIEW ===================== --}}
                    <div class="col-lg-7 col-8 preview-col">
                        <h5 class="mb-2" style="color:#03346E;">Attached Document Preview</h5>

                        <div class="preview-toolbar" id="previewToolbar" style="display:none;">
                            <button type="button" id="zoomOutBtn" title="Zoom Out">−</button>
                            <span id="zoomLevel">100%</span>
                            <button type="button" id="zoomInBtn" title="Zoom In">+</button>
                            <button type="button" id="zoomResetBtn" title="Reset">Reset</button>
                        </div>

                        <div class="preview-box" id="previewBox">
                            @if(!empty($property->attachment->property_document))
                                <div class="pdf-scroll-outer" id="pdfScrollOuter">
                                    <div id="pdfViewerContainer" class="pdf-viewer-container"></div>
                                </div>
                            @else
                                <div class="no-preview">No complete property file has been uploaded yet.</div>
                            @endif
                        </div>
                    </div>

                    {{-- ===================== RIGHT: DETAIL VIEW ===================== --}}
                    <div class="col-lg-5 col-12 form-col">
                        <div class="card shadow-sm">
                            <h2 id="heading" class="text-center">Mirpur Development Authority - Property Detail</h2>
                            <p class="text-center">View complete property information</p>

                            <div id="detailView">

                                {{-- ===== SUCCESS / ERROR MESSAGES ===== --}}
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fa fa-times-circle"></i> {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul style="margin:0; padding-left:18px;">
                                            @foreach($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                @endif

                                {{-- ===== PROPERTY DETAIL SECTION ===== --}}
                                <div class="section-title">📋 Property Detail</div>
                                <div class="two-col">
                                    <div>
                                        <label class="detail-label">Application No.</label>
                                        <div class="detail-subheading">{{ $property->application_no ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Application Date</label>
                                        <div class="detail-subheading">{{ $property->application_date ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Plot No.</label>
                                        <div class="detail-subheading">{{ $property->plot_no ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Sector</label>
                                        <div class="detail-subheading">{{ $property->sector->name ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Block</label>
                                        <div class="detail-subheading">{{ $property->block->name ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Approved Scheme</label>
                                        <div class="detail-subheading">{{ $property->approved_scheme ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Kanal</label>
                                        <div class="detail-subheading">{{ $property->kanal ?? '0' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Marla</label>
                                        <div class="detail-subheading">{{ $property->marla ?? '0' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Sq Ft</label>
                                        <div class="detail-subheading">{{ $property->sqrft ?? '0' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Size</label>
                                        <div class="detail-subheading">{{ $property->size ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Form No.</label>
                                        <div class="detail-subheading">{{ $property->form_no ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Initial Draft Amount</label>
                                        <div class="detail-subheading">{{ number_format($property->initial_draft_amount ?? 0, 0) }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Initial Draft Date</label>
                                        <div class="detail-subheading">{{ $property->initial_draft_date ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Name Applicant/Allottee</label>
                                        <div class="detail-subheading">{{ $property->applicant_name ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Father/Husband Name</label>
                                        <div class="detail-subheading">{{ $property->father_husband_name ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Old NIC</label>
                                        <div class="detail-subheading">{{ $property->old_nic ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">CNIC</label>
                                        <div class="detail-subheading">{{ $property->cnic ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Category</label>
                                        <div class="detail-subheading">{{ $property->category ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Mode of Allottment</label>
                                        <div class="detail-subheading">{{ $property->mode_allottment ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Allotment Date</label>
                                        <div class="detail-subheading">{{ $property->allotment_date ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Serial No of Balloting</label>
                                        <div class="detail-subheading">{{ $property->balloting_serial_no ?? '-' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="detail-label">Address (Temporary)</label>
                                    <div class="detail-subheading">{{ $property->address_temporary ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="detail-label">Address (Permanent)</label>
                                    <div class="detail-subheading">{{ $property->address_permanent ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="detail-label">Remarks</label>
                                    <div class="detail-subheading">{{ $property->remarks ?? '-' }}</div>
                                </div>

                                {{-- ===== PAYMENT DETAIL SECTION ===== --}}
                                <div class="section-title" style="margin-top:25px;">💰 Payment Detail</div>
                                <div class="two-col">
                                    <div>
                                        <label class="detail-label">Price</label>
                                        <div class="detail-subheading">{{ number_format($property->payment->total_price ?? 0, 0) }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Received Amount</label>
                                        <div class="detail-subheading">{{ number_format($property->payment->amount_deposited ?? 0, 0) }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Receivable Amount</label>
                                        <div class="detail-subheading">{{ number_format($property->payment->remaining_amount ?? 0, 0) }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Down payment</label>
                                        <div class="detail-subheading">{{ number_format($property->payment->down_payment ?? 0, 0) }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Initial Notice No.</label>
                                        <div class="detail-subheading">{{ $property->payment->initial_notice_no ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Initial Notice Date</label>
                                        <div class="detail-subheading">{{ $property->payment->initial_notice_date ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Total Received Amount</label>
                                        <div class="detail-subheading">{{ number_format($property->payment->total_received_amount ?? 0, 0) }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Received Amount Date</label>
                                        <div class="detail-subheading">{{ $property->payment->received_amount_date ?? '-' }}</div>
                                    </div>
                                </div>

                                <div style="margin-top:15px;">
                                    <label class="detail-label" style="font-size:16px;color:#03346E;font-weight:600;border-bottom:1px solid #ddd;padding-bottom:5px;">Allotment / Possession</label>
                                    <div class="two-col" style="margin-top:10px;">
                                        <div>
                                            <label class="detail-label">Allotment Chit No.</label>
                                            <div class="detail-subheading">{{ $property->payment->allotment_order_no ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="detail-label">Allotment Chit Date</label>
                                            <div class="detail-subheading">{{ $property->payment->allotment_order_date ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="detail-label">Qabza Chit No.</label>
                                            <div class="detail-subheading">{{ $property->payment->possession_slip_no ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="detail-label">Qabza Chit Date</label>
                                            <div class="detail-subheading">{{ $property->payment->possession_slip_date ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="detail-label">Approval of Boundary Wall</label>
                                            <div class="detail-subheading">{{ $property->payment->boundary_wall_approval ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="detail-label">Approval Date of Maps</label>
                                            <div class="detail-subheading">{{ $property->payment->map_approval_date ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="detail-label">Transfer Order No.</label>
                                            <div class="detail-subheading">{{ $property->payment->transfer_order_no ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===== PLOT HISTORY SECTION ===== --}}
                                <div class="section-title" style="margin-top:25px;">👤 Detail of Transferees</div>
                                @forelse($property->plotHistories as $index => $transferee)
                                    <div class="transferee-block">
                                        <div class="two-col">
                                            <div>
                                                <label class="detail-label">Transferee Name</label>
                                                <div class="detail-subheading">{{ $transferee->name ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <label class="detail-label">Father Name</label>
                                                <div class="detail-subheading">{{ $transferee->father_name ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <label class="detail-label">ID Card</label>
                                                <div class="detail-subheading">{{ $transferee->id_card ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <label class="detail-label">Challan No.</label>
                                                <div class="detail-subheading">{{ $transferee->challan_no ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="detail-subheading detail-subheading-empty">No transferees added</div>
                                @endforelse

                                {{-- ===== ATTACHMENTS SECTION ===== --}}
                                <div class="section-title" style="margin-top:25px;">📎 Attachments</div>
                                <div class="two-col">
                                    <div>
                                        <label class="detail-label">Alternate Allotment</label>
                                        <div class="detail-subheading">{{ $property->attachment->alternate_allotment ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="detail-label">Complete File Pages</label>
                                        <div class="detail-subheading">{{ $property->attachment->complete_file_pages ?? '-' }}</div>
                                    </div>
                                </div>

                                <div style="margin-top:10px;">
                                    <label class="detail-label" style="margin-bottom: 10px; display: block;">Complete Property File</label>
                                    @if(!empty($property->attachment->property_document))
                                        <div class="current-file-box">
                                            <span class="current-file-label">Current File:</span>
                                            <a href="{{ route('file.viewer', ['path' => $property->attachment->property_document]) }}" target="_blank">
                                                {{ basename($property->attachment->property_document) }}
                                            </a>
                                            @if(isset($property->attachment->status) && $property->attachment->status)
                                                <span class="badge-success ml-2">✓ Confirmed</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="detail-subheading detail-subheading-empty">No file uploaded</div>
                                    @endif
                                </div>

                                <div>
                                    <label class="detail-label">Adjacent Area Allotment</label>
                                    @if(!empty($property->attachment->adjacent_area_allotment))
                                        <div class="current-file-box">
                                            <span class="current-file-label">Current File:</span>
                                            <a href="{{ route('file.viewer', ['path' => $property->attachment->adjacent_area_allotment]) }}" target="_blank">
                                                {{ basename($property->attachment->adjacent_area_allotment) }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="detail-subheading detail-subheading-empty">No file uploaded</div>
                                    @endif
                                </div>

                                <div>
                                    <label class="detail-label">Division of Plots</label>
                                    @if(!empty($property->attachment->division_of_plots))
                                        <div class="current-file-box">
                                            <span class="current-file-label">Current File:</span>
                                            <a href="{{ route('file.viewer', ['path' => $property->attachment->division_of_plots]) }}" target="_blank">
                                                {{ basename($property->attachment->division_of_plots) }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="detail-subheading detail-subheading-empty">No file uploaded</div>
                                    @endif
                                </div>

                                <div>
                                    <label class="detail-label">Decision of Courts Against Plot</label>
                                    @if(!empty($property->attachment->decision_courts))
                                        <div class="current-file-box">
                                            <span class="current-file-label">Current File:</span>
                                            <a href="{{ route('file.viewer', ['path' => $property->attachment->decision_courts]) }}" target="_blank">
                                                {{ basename($property->attachment->decision_courts) }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="detail-subheading detail-subheading-empty">No file uploaded</div>
                                    @endif
                                </div>

                                <div>
                                    <label class="detail-label">Decision of Allotment Committee</label>
                                    @if(!empty($property->attachment->decision_allotment_committee))
                                        <div class="current-file-box">
                                            <span class="current-file-label">Current File:</span>
                                            <a href="{{ route('file.viewer', ['path' => $property->attachment->decision_allotment_committee]) }}" target="_blank">
                                                {{ basename($property->attachment->decision_allotment_committee) }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="detail-subheading detail-subheading-empty">No file uploaded</div>
                                    @endif
                                </div>

                                <div>
                                    <label class="detail-label">Decision of MDA Board</label>
                                    @if(!empty($property->attachment->decision_mda_board))
                                        <div class="current-file-box">
                                            <span class="current-file-label">Current File:</span>
                                            <a href="{{ route('file.viewer', ['path' => $property->attachment->decision_mda_board]) }}" target="_blank">
                                                {{ basename($property->attachment->decision_mda_board) }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="detail-subheading detail-subheading-empty">No file uploaded</div>
                                    @endif
                                </div>

                                <div>
                                    <label class="detail-label">Decision of Revising Authority</label>
                                    @if(!empty($property->attachment->decision_revising_authority))
                                        <div class="current-file-box">
                                            <span class="current-file-label">Current File:</span>
                                            <a href="{{ route('file.viewer', ['path' => $property->attachment->decision_revising_authority]) }}" target="_blank">
                                                {{ basename($property->attachment->decision_revising_authority) }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="detail-subheading detail-subheading-empty">No file uploaded</div>
                                    @endif
                                </div>

                                {{-- ================= QA VERIFICATION ================= --}}
                                <div class="section-title" style="margin-top:25px;">
                                    🔍 QA Verification
                                </div>

                                <form method="POST" action="{{ route('qa.store') }}" id="qaForm">
                                    @csrf
                                    <input type="hidden" name="property_id" value="{{ $property->id }}">

                                    <div style="margin-top:15px;">
                                        <label class="detail-label">
                                            QA Status <span style="color:red;">*</span>
                                        </label>

                                        <div style="display:flex; gap:30px; margin-top:10px;">
                                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                                <input type="radio" name="qa_status" value="qa_done" required
                                                    {{ optional($property->qaStatus)->status == 1 ? 'checked' : '' }}>
                                                <span>QA Done</span>
                                            </label>

                                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                                <input type="radio" name="qa_status" value="having_issue" required
                                                    {{ $property->qaStatus && $property->qaStatus->status == 0 ? 'checked' : '' }}>
                                                <span>Having Issue</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div id="qaIssueFields"
                                         style="{{ ($property->qaStatus && $property->qaStatus->status == 0) ? '' : 'display:none;' }} margin-top:20px;">

                                        <div>
                                            <label class="detail-label">Issue <span style="color:red;">*</span></label>
                                            <select name="value" id="qaValue" class="form-control">
                                                <option value="">Select Issue</option>
                                                <option value="Missing Document" {{ optional($property->qaStatus)->issue == 'Missing Document' ? 'selected' : '' }}>Missing Document</option>
                                                <option value="Incorrect Information" {{ optional($property->qaStatus)->issue == 'Incorrect Information' ? 'selected' : '' }}>Incorrect Information</option>
                                                <option value="Incomplete File" {{ optional($property->qaStatus)->issue == 'Incomplete File' ? 'selected' : '' }}>Incomplete File</option>
                                                <option value="Payment Issue" {{ optional($property->qaStatus)->issue == 'Payment Issue' ? 'selected' : '' }}>Payment Issue</option>
                                                <option value="Other" {{ optional($property->qaStatus)->issue == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>

                                        <div style="margin-top:15px;">
                                            <label class="detail-label">Description</label>
                                            <textarea name="remarks" id="qaRemarks" class="form-control" rows="4"
                                                placeholder="Enter issue description...">{{ optional($property->qaStatus)->remarks }}</textarea>
                                        </div>
                                    </div>

                                    <div style="margin-top:20px; margin-bottom:20px;">
                                        <button type="submit"
                                                style="width:100%; background:#03346E; color:white; border:none; padding:11px; border-radius:5px; cursor:pointer;">
                                            Submit
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // ================= ZOOM SETUP =================
            var currentZoom = 1;
            var ZOOM_STEP = 0.15;
            var ZOOM_MIN = 0.5;
            var ZOOM_MAX = 5;

            function applyZoom() {
                $('#pdfViewerContainer').css('transform', 'scale(' + currentZoom + ')');
                $('#zoomLevel').text(Math.round(currentZoom * 100) + '%');
            }

            function showZoomToolbar() {
                $('#previewToolbar').show();
            }

            function resetZoom() {
                currentZoom = 1;
                applyZoom();
            }

            $('#zoomInBtn').on('click', function () {
                currentZoom = Math.min(ZOOM_MAX, currentZoom + ZOOM_STEP);
                applyZoom();
            });

            $('#zoomOutBtn').on('click', function () {
                currentZoom = Math.max(ZOOM_MIN, currentZoom - ZOOM_STEP);
                applyZoom();
            });

            $('#zoomResetBtn').on('click', function () {
                resetZoom();
            });

            $('#previewBox').on('wheel', function (e) {
                if (e.ctrlKey) {
                    e.preventDefault();
                    if (e.originalEvent.deltaY < 0) {
                        currentZoom = Math.min(ZOOM_MAX, currentZoom + 0.1);
                    } else {
                        currentZoom = Math.max(ZOOM_MIN, currentZoom - 0.1);
                    }
                    applyZoom();
                }
            });

            // ================= RIGHT-CLICK / SHORTCUT BLOCK =================
            $('#previewBox').on('contextmenu', function (e) {
                e.preventDefault();
                return false;
            });

            $(document).on('keydown', function (e) {
                if (
                    (e.ctrlKey && (e.key === 's' || e.key === 'S')) ||
                    (e.ctrlKey && (e.key === 'p' || e.key === 'P')) ||
                    (e.ctrlKey && (e.key === 'u' || e.key === 'U')) ||
                    (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) ||
                    (e.ctrlKey && e.shiftKey && (e.key === 'J' || e.key === 'j')) ||
                    e.key === 'F12'
                ) {
                    if ($('#previewBox').length) {
                        e.preventDefault();
                        return false;
                    }
                }
            });

            // ================= PDF PROGRESSIVE RENDER =================
            function renderPdfProgressive(url, containerSelector) {
                var $container = $(containerSelector);
                $container.empty();
                $container.html('<div class="pdf-page-loading" style="padding:20px;">Loading document…</div>');

                pdfjsLib.getDocument(url).promise.then(function (pdf) {
                    $container.empty();
                    showZoomToolbar();
                    resetZoom();

                    var numPages = pdf.numPages;
                    var pageWraps = [];

                    for (var i = 1; i <= numPages; i++) {
                        var $wrap = $('<div class="pdf-page-wrap" data-page="' + i + '">' +
                            '<div class="pdf-page-loading">Page ' + i + ' loading…</div>' +
                            '<span class="pdf-page-number">' + i + ' / ' + numPages + '</span>' +
                            '</div>');
                        $container.append($wrap);
                        pageWraps.push($wrap[0]);
                    }

                    function renderPage(pageNum, wrapEl) {
                        if ($(wrapEl).data('rendered')) return;
                        $(wrapEl).data('rendered', true);

                        pdf.getPage(pageNum).then(function (page) {
                            var scale = 1.2;
                            var viewport = page.getViewport({ scale: scale });

                            var canvas = document.createElement('canvas');
                            canvas.width = viewport.width;
                            canvas.height = viewport.height;

                            $(wrapEl).find('.pdf-page-loading').remove();
                            $(wrapEl).prepend(canvas);

                            var ctx = canvas.getContext('2d');
                            page.render({ canvasContext: ctx, viewport: viewport });
                        });
                    }

                    renderPage(1, pageWraps[0]);

                    if ('IntersectionObserver' in window) {
                        var observer = new IntersectionObserver(function (entries) {
                            entries.forEach(function (entry) {
                                if (entry.isIntersecting) {
                                    var pageNum = parseInt($(entry.target).data('page'));
                                    renderPage(pageNum, entry.target);
                                }
                            });
                        }, { root: $container[0], rootMargin: '400px 0px', threshold: 0.01 });

                        pageWraps.forEach(function (el) { observer.observe(el); });
                    } else {
                        pageWraps.forEach(function (el, idx) { renderPage(idx + 1, el); });
                    }
                }).catch(function (err) {
                    $container.html('<div class="no-preview" style="padding:40px;">Preview could not be loaded. <br>' + err.message + '</div>');
                });
            }

            // ================= QA STATUS RADIO TOGGLE =================
            $('input[name="qa_status"]').on('change', function () {
                let selectedStatus = $(this).val();

                if (selectedStatus === 'having_issue') {
                    $('#qaIssueFields').slideDown();
                    $('#qaValue').prop('required', true);
                } else {
                    $('#qaIssueFields').slideUp();
                    $('#qaValue').prop('required', false);
                    $('#qaValue').val('');
                    $('#qaRemarks').val('');
                }
            });

            // ================= QA FORM AJAX SUBMIT =================
            $('#qaForm').on('submit', function (e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var originalBtnText = $btn.text();

                $btn.prop('disabled', true).text('Submitting...');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            showQaAlert('success', res.message);
                            setTimeout(function () {
                                window.location.href = res.redirect;
                            }, 1200);
                        } else {
                            showQaAlert('danger', res.message || 'Something went wrong.');
                            $btn.prop('disabled', false).text(originalBtnText);
                        }
                    },
                    error: function (xhr) {
                        $btn.prop('disabled', false).text(originalBtnText);

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var msg = '';
                            $.each(errors, function (field, messages) {
                                msg += messages[0] + '<br>';
                            });
                            showQaAlert('danger', msg);
                        } else {
                            showQaAlert('danger', 'Something went wrong. Please try again.');
                        }
                    }
                });
            });

            function showQaAlert(type, message) {
                $('#qaAjaxAlert').remove();

                var alertHtml = '<div id="qaAjaxAlert" class="alert alert-' + type + ' alert-dismissible fade show" role="alert" style="margin-top:15px;">' +
                    message +
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '</div>';

                $('#qaForm').before(alertHtml);

                $('#detailView').animate({
                    scrollTop: $('#qaAjaxAlert').position().top + $('#detailView').scrollTop() - 20
                }, 300);
            }

            // ================= PAGE LOAD: EXISTING FILE RENDER =================
            @if(!empty($property->attachment->property_document))
                var filePath = "{{ asset('storage/' . $property->attachment->property_document) }}";
                $.ajax({
                    url: filePath,
                    type: 'HEAD',
                    error: function() {
                        filePath = "{{ asset('uploads/complete/' . $property->attachment->property_document) }}";
                        renderPdfProgressive(filePath, '#pdfViewerContainer');
                    },
                    success: function() {
                        renderPdfProgressive(filePath, '#pdfViewerContainer');
                    }
                });
            @endif
        });
    </script>
</x-app-layout>
