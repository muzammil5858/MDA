<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

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

.required-star {
    color: red;
    font-weight: bold;
    margin-left: 2px;
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

/* preview-box ab scroll container hai, transform ke liye */
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

        .pdf-viewer-container{
    width:100%;
    height:100%;
    overflow-y:auto;
    background:#525659;
    padding:10px 0;
        user-select:none;
    -webkit-user-select:none;
    -moz-user-select:none;
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
    cursor: pointer;
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
    opacity: 0.6;
    cursor: not-allowed;
}

.complete-file-check label {
    margin: 0 !important;
    font-size: 14px;
    color: #333;
    cursor: pointer;
}

.current-file-box a {
    color: #03346E;
    word-break: break-all;
    text-decoration: underline;
}
        p { color: grey }
        .select2-container{ width:100% !important; margin-bottom:15px; }
        .select2-container--default .select2-selection--single{
            background:#ECEFF1 !important; border:1px solid #ccc !important;
            border-radius:0 !important; height:42px !important; padding:0 15px;
            display:flex; align-items:center;
        }
        .select2-container--default .select2-selection__rendered{
            color:#2C3E50 !important; line-height:40px !important; padding-left:0 !important;
            font-size:16px; letter-spacing:1px;
        }
        .select2-container--default .select2-selection__arrow{ height:40px !important; right:10px !important; }
        .select2-container--default.select2-container--focus .select2-selection--single{ border:1px solid #03346E !important; box-shadow:none !important; }
        .select2-dropdown{ border:1px solid #03346E !important; }
        .select2-search__field{ border:none !important; outline:none !important; box-shadow:none !important; }

        #heading { text-transform: uppercase; color: #03346E; font-weight: bolder; font-size: 1.5rem; }
        #msform { text-align: center; position: relative; margin-top: 20px }
        #msform fieldset {
            background: white; border: 0 none; border-radius: 0.5rem;
            box-sizing: border-box; width: 100%; margin: 0; padding-bottom: 20px; position: relative
        }
        .form-card { text-align: left }
        #msform fieldset:not(:first-of-type) { display: none }
        #msform input, #msform textarea, #msform select {
            padding: 8px 15px 8px 15px; border: 1px solid #ccc; border-radius: 0px;
            margin-bottom: 15px; margin-top: 2px; width: 100%; box-sizing: border-box;
            font-family: montserrat; color: #2C3E50; background-color: #ECEFF1;
            font-size: 16px; letter-spacing: 1px
        }
        #msform input:focus, #msform textarea:focus {
            -moz-box-shadow: none !important; -webkit-box-shadow: none !important;
            box-shadow: none !important; border: 1px solid #03346E; outline-width: 0
        }
        #msform .action-button {
            width: 100px; background: #03346E; font-weight: bold; color: white;
            border: 0 none; border-radius: 0px; cursor: pointer; padding: 10px 5px;
            margin: 10px 0px 10px 5px; float: right
        }
        #msform .action-button:hover, #msform .action-button:focus { background-color: #311B92 }
        #msform .action-button:disabled { background-color: #9aa5b1; cursor: not-allowed; }
        #msform .action-button-previous {
            width: 100px; background: #616161; font-weight: bold; color: white;
            border: 0 none; border-radius: 0px; cursor: pointer; padding: 10px 5px;
            margin: 10px 5px 10px 0px; float: right
        }
        #msform .action-button-previous:hover, #msform .action-button-previous:focus { background-color: #000000 }
        .card { z-index: 0; border: none; position: relative }
        .fs-title { font-size: 25px; color: #03346E; margin-bottom: 15px; font-weight: normal; text-align: left }
        .steps { font-size: 25px; color: gray; margin-bottom: 10px; font-weight: normal; text-align: right }
        #progressbar { margin-bottom: 30px; overflow: hidden; color: lightgrey }
        #progressbar .active { color: #03346E }
        #progressbar li {
            list-style-type: none; font-size: 14px; width: 25%; float: left;
            position: relative; font-weight: 400; cursor: pointer;
        }
        #progressbar li:before {
            width: 50px; height: 50px; line-height: 45px; display: block; font-size: 20px;
            color: #ffffff; background: lightgray; border-radius: 50%; margin: 0 auto 10px auto; padding: 2px
        }
        #progressbar #detail:before { content: "1"; font-family: FontAwesome; }
        #progressbar #price:before { content: "2"; font-family: FontAwesome; }
        #progressbar #transferees:before { content: "3"; font-family: FontAwesome; }
        #progressbar #attachments:before { content: "4"; font-family: FontAwesome; }
        #progressbar li:after {
            content: ''; width: 100%; height: 2px; background: lightgray;
            position: absolute; left: 0; top: 25px; z-index: -1
        }
        #progressbar li.active:before, #progressbar li.active:after { background: #03346E }
        .progress { height: 20px }
        .progress-bar { background-color: #03346E }

        .transferee-block, .current-owner-block {
            border: 1px dashed #03346E; border-radius: 6px; padding: 20px;
            margin-bottom: 15px; position: relative; background-color: #f8f9fa;
        }
        .remove-transferee, .remove-owner {
            position: absolute; top: 8px; right: 8px; background: #c0392b; color: #fff;
            border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;
            font-size: 14px; z-index: 9999; width: auto;
        }
        #add-transferee, #add-owner {
            background: #03346E; color: #fff; border: none; border-radius: 4px;
            padding: 8px 18px; cursor: pointer; margin-bottom: 20px; width: auto;
        }
        .existing-file-link { font-size: 13px; margin-top: -10px; margin-bottom: 15px; display:block; color:#03346E; }
        #form-alert-box { display: none; text-align: left; }

        /* ===== Split layout: preview + form ===== */
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


/* ================= LEFT SIDE ================= */

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


/* ================= RIGHT SIDE ================= */

.form-col{
    height:100%;
    padding:18px;
}

.form-col .card{
    height:100%;
    border-radius:10px;
    overflow:hidden;
    display:flex;
    flex-direction:column;
}


/* sirf form scroll hogi */

#msform{
    flex:1;
    overflow-y:auto;
    overflow-x:hidden;
    padding-right:10px;
}


/* scrollbar */

#msform::-webkit-scrollbar{
    width:7px;
}

#msform::-webkit-scrollbar-thumb{
    background:#b5b5b5;
    border-radius:20px;
}


/* bottom buttons */

.action-button,
.action-button-previous{
    margin-bottom:15px;
}


/* MOBILE */

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

#msform{
    overflow:visible;
}

}
    </style>

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
            <div class="no-preview">No property document has been uploaded yet.<br>Please upload the file from the Attachments step.</div>
        @endif
    </div>
</div>

                    {{-- ===================== RIGHT: FORM ===================== --}}
                    <div class="col-lg-5 col-12 form-col">
                        <div class="card px-4 pt-4 pb-3 shadow-sm">
                            <h2 id="heading">Mirpur Development Authority - Edit Property</h2>
                            <p class="text-center">Fill form fields as needed (all fields are optional)</p>

                            <form id="msform" action="{{ route('formUpdate', $property->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="active" id="detail"><strong>Property Detail</strong></li>
                                    <li id="price"><strong>Payment</strong></li>
                                    <li id="transferees"><strong>Plot History</strong></li>
                                    <li id="attachments"><strong>Attachments</strong></li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="form-alert-box" class="alert"></div>

                                        @if(session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif
                                        @if($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- ===================== STEP 1 : PROPERTY DETAIL ===================== --}}
                                <fieldset id="step-1">
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7"><h2 class="fs-title">Property Detail:</h2></div>
                                            <div class="col-5"><h2 class="steps">Step 1 - 4</h2></div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label>Application No. <span class="required-star">*</span></label>
                                                <input type="text" class="form-control" name="application_no"
                                                    placeholder="Application No."
                                                    value="{{ old('application_no', $property->application_no ?? '') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Application Date</label>
                                                <input type="date" class="form-control datepicker" name="application_date"
                                                    placeholder="Application Date"
                                                    value="{{ old('application_date', $property->application_date ?? '') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Plot No. <span class="required-star">*</span></label>
                                                <input type="text" class="form-control" name="plot_no"
                                                    placeholder="Plot No."
                                                    value="{{ old('plot_no', $property->plot_no ?? '') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Sector <span class="required-star">*</span></label>
                                                <select name="sector_id" id="sector" class="form-control">
                                                    <option value="">Select Sector</option>
                                                    @foreach($sectors as $sector)
                                                        <option value="{{ $sector->id }}"
                                                            {{ old('sector_id', $property->sector_id ?? '') == $sector->id ? 'selected' : '' }}>
                                                            {{ $sector->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

<!-- Block Dropdown -->
<div class="col-md-6">
    <label>Block <span class="required-star">*</span></label>
    <select name="block_id" id="block" class="form-control">
        <option value="">Select Block</option>
        @if($blocks->count() > 0)
            @foreach($blocks as $block)
                <option value="{{ $block->id }}"
                    {{ old('block_id', $property->block_id ?? '') == $block->id ? 'selected' : '' }}>
                    {{ $block->name }}
                </option>
            @endforeach
        @endif
    </select>
</div>

                                            <div class="col-md-6">
                                                <div class="row mx-0">
                                                    <div class="col-4 px-0">
                                                        <label>Kanal</label>
                                                        <input type="number" class="form-control" name="kanal"  min="0"
                                                            placeholder="Kanal" value="{{ old('kanal', $property->kanal ?? '') }}">
                                                    </div>
                                                    <div class="col-4 px-0">
                                                        <label>Marla</label>
                                                        <input type="number" class="form-control" name="marla"  min="0"
                                                            placeholder="Marla" value="{{ old('marla', $property->marla ?? '') }}">
                                                    </div>
                                                    <div class="col-4 px-0">
                                                        <label>Sq Ft</label>
                                                        <input type="number" class="form-control" name="sqrft"  min="0"
                                                            placeholder="Sq Ft" value="{{ old('sqrft', $property->sqrft ?? '') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="approved_scheme">Approved Scheme</label>
                                                <select name="approved_scheme" id="approved_scheme" class="form-control">
                                                    <option value="" disabled>Select Scheme</option>
                                                    <option value="Scheme 1" {{ old('approved_scheme', $property->approved_scheme ?? '') == 'Scheme 1' ? 'selected' : '' }}>Scheme 1</option>
                                                    <option value="Scheme 2" {{ old('approved_scheme', $property->approved_scheme ?? '') == 'Scheme 2' ? 'selected' : '' }}>Scheme 2</option>
                                                    <option value="Scheme 3" {{ old('approved_scheme', $property->approved_scheme ?? '') == 'Scheme 3' ? 'selected' : '' }}>Scheme 3</option>
                                                </select>
                                            </div>
                                              <div class="col-md-3">
                                        <label>Size</label>
                                        <input type="text" class="form-control" name="size"
                                        placeholder="Enter Size"
                                            value="{{ old('size', $property->size ?? '') }}">
                                    </div>
                                      <div class="col-md-3">
                                        <label>Form_no.</label>
                                        <input type="text" class="form-control" name="form_no"
                                        placeholder="Enter Form_no."
                                            value="{{ old('form_no', $property->form_no ?? '') }}">
                                    </div>


                                            <div class="col-md-6">
                                                <label>Initial Draft Amount</label>
                                                <input type="number" class="form-control" name="initial_draft_amount"  min="0"
                                                    placeholder="Initial Draft Amount"
                                                    value="{{ old('initial_draft_amount', number_format($property->initial_draft_amount ?? 0, 0, '.', '')) }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Initial Draft Date</label>
                                                <input type="date" class="form-control datepicker" name="initial_draft_date"
                                                    placeholder="Initial Draft Date"
                                                    value="{{ old('initial_draft_date', $property->initial_draft_date ?? '') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Name Applicant/Allottee</label>
                                                <input type="text" class="form-control" name="applicant_name"
                                                    placeholder="Name Applicant"
                                                    value="{{ old('applicant_name', $property->applicant_name ?? '') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Father/Husband Name</label>
                                                <input type="text" class="form-control" name="father_husband_name"
                                                    placeholder="Father/Husband Name"
                                                    value="{{ old('father_husband_name', $property->father_husband_name ?? '') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Old NIC</label>
                                                <input type="text" class="form-control cnic-input" name="old_nic"
                                                    maxlength="15" placeholder="12345-1234567-1"
                                                    value="{{ old('old_nic', $property->old_nic ?? '') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>CNIC</label>
                                                <input type="text" class="form-control cnic-input" name="cnic"
                                                    maxlength="15" placeholder="12345-1234567-1"
                                                    value="{{ old('cnic', $property->cnic ?? '') }}">
                                            </div>

                                            <div class="col-md-12">
                                                <label>Address (Temporary)</label>
                                                <textarea class="form-control" placeholder="Address (Temporary)"
                                                    name="address_temporary" rows="1">{{ old('address_temporary', $property->address_temporary ?? '') }}</textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Address (Permanent)</label>
                                                <textarea class="form-control" placeholder="Address (Permanent)"
                                                    name="address_permanent" rows="1">{{ old('address_permanent', $property->address_permanent ?? '') }}</textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Category</label>
                                                <select name="category" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <option value="House" {{ old('category', $property->category ?? '') == 'House' ? 'selected' : '' }}>House</option>
                                                    <option value="Commercial" {{ old('category', $property->category ?? '') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                                    <option value="Plot" {{ old('category', $property->category ?? '') == 'Plot' ? 'selected' : '' }}>Plot</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="mode_allottment">Mode of Allottment</label>
                                                <select name="mode_allottment" id="mode_allottment" class="form-control">
                                                    <option value="">Select Allottment</option>
                                                    <option value="Balloting" {{ old('mode_allottment', $property->mode_allottment ?? '') == 'Balloting' ? 'selected' : '' }}>Balloting</option>
                                                    <option value="Auction" {{ old('mode_allottment', $property->mode_allottment ?? '') == 'Auction' ? 'selected' : '' }}>Auction</option>
                                                    <option value="By_Chairman" {{ old('mode_allottment', $property->mode_allottment ?? '') == 'By_Chairman' ? 'selected' : '' }}>By Chairman</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Allotment Date</label>
                                                <input type="date" class="form-control datepicker" name="allotment_date"
                                                    placeholder="Allotment Date"
                                                    value="{{ old('allotment_date', $property->allotment_date ?? '') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Serial No of Balloting</label>
                                                <input type="text" class="form-control" name="balloting_serial_no"
                                                    placeholder="Serial No of Balloting"
                                                    value="{{ old('balloting_serial_no', $property->balloting_serial_no ?? '') }}">
                                            </div>
                                                        <div class="col-md-6">
                <label>Transfer Count</label>
                <input type="number"
                       class="form-control"
                       name="transfer_count"
                       id="transfer_count"
                       placeholder="Number of Transfers"
                       min="0"
                       value="{{ old('transfer_count', $property->transfer_count ?? '') }}">
            </div>

            <div class="col-md-6">
                <label>Ownership Type</label>
                <select name="ownership_type" id="ownership_type" class="form-control">
                    <option value="">Select Ownership Type</option>
                    <option value="single"
                        {{ old('ownership_type', $property->ownership_type ?? '') == 'single' ? 'selected' : '' }}>
                        Single Owner
                    </option>
                    <option value="multiple"
                        {{ old('ownership_type', $property->ownership_type ?? '') == 'multiple' ? 'selected' : '' }}>
                        Multiple Owner
                    </option>
                </select>
            </div>
<div class="col-md-6">
    <label>Allotment Type</label>
    <select name="allotment_type" id="allotment_type" class="form-control">
        <option value="">Select Allotment</option>
        <option value="original"
            {{ old('allotment_type', $property->allotment_type ?? '') == 'original' ? 'selected' : '' }}>
            Original Allottee
        </option>
        <option value="transferee"
            {{ old('allotment_type', $property->allotment_type ?? '') == 'transferee' ? 'selected' : '' }}>
            Transferee
        </option>
    </select>
</div>

                                        </div>

                                        {{-- Current Owner Section --}}
                                        <div class="row mt-4">
                                            <div class="col-7"><h2 class="fs-title">Current Owner:</h2></div>
                                        </div>

                                        <div id="current-owners-wrapper">
                                            @if($property->currentOwners && $property->currentOwners->count() > 0)
                                                @foreach($property->currentOwners as $index => $owner)
                                                    <div class="current-owner-block" data-index="{{ $index }}">
                                                        @if($index > 0)
                                                            <button type="button" class="btn btn-danger remove-owner" onclick="removeOwner(this)">Remove</button>
                                                        @endif
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <label>Name Applicant/Allottee</label>
                                                                <input type="text" class="form-control" name="current_owners[{{ $index }}][applicant_name]"
                                                                    placeholder="Name Applicant" value="{{ $owner->applicant_name }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Father/Husband Name</label>
                                                                <input type="text" class="form-control" name="current_owners[{{ $index }}][father_husband_name]"
                                                                    placeholder="Father/Husband Name" value="{{ $owner->father_husband_name }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Old NIC</label>
                                                                <input type="text" class="form-control cnic-input" name="current_owners[{{ $index }}][old_nic]"
                                                                    maxlength="15" placeholder="12345-1234567-1" value="{{ $owner->old_nic }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>CNIC</label>
                                                                <input type="text" class="form-control cnic-input" name="current_owners[{{ $index }}][cnic]"
                                                                    maxlength="15" placeholder="12345-1234567-1" value="{{ $owner->cnic }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <label>Address (Temporary)</label>
                                                                <textarea class="form-control" placeholder="Address (Temporary)"
                                                                    name="current_owners[{{ $index }}][address_temporary]" rows="1">{{ $owner->address_temporary }}</textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Address (Permanent)</label>
                                                                <textarea class="form-control" placeholder="Address (Permanent)"
                                                                    name="current_owners[{{ $index }}][address_permanent]" rows="1">{{ $owner->address_permanent }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="current-owner-block" data-index="0">
                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <label>Name Applicant/Allottee</label>
                                                            <input type="text" class="form-control" name="current_owners[0][applicant_name]"
                                                                placeholder="Name Applicant">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Father/Husband Name</label>
                                                            <input type="text" class="form-control" name="current_owners[0][father_husband_name]"
                                                                placeholder="Father/Husband Name">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Old NIC</label>
                                                            <input type="text" class="form-control cnic-input" name="current_owners[0][old_nic]"
                                                                 maxlength="15" placeholder="12345-1234567-1">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>CNIC</label>
                                                            <input type="text" class="form-control cnic-input" name="current_owners[0][cnic]"
                                                                maxlength="15" placeholder="12345-1234567-1">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <label>Address (Temporary)</label>
                                                            <textarea class="form-control" placeholder="Address (Temporary)"
                                                                name="current_owners[0][address_temporary]" rows="1"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Address (Permanent)</label>
                                                            <textarea class="form-control" placeholder="Address (Permanent)"
                                                                name="current_owners[0][address_permanent]" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <button type="button" id="add-owner" onclick="addOwner()">+ Add Current Owner</button>

                                        <div class="col-md-12">
                                            <label>Remarks</label>
                                            <textarea class="form-control" name="remarks" rows="3"
                                                placeholder="Enter Remarks">{{ old('remarks', $property->remarks ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <input type="button" class="next action-button" value="Next">
                                </fieldset>

                                {{-- ===================== STEP 2 : PAYMENT ===================== --}}
<fieldset id="step-2">
    <div class="form-card">
        <div class="row">
            <div class="col-7"><h2 class="fs-title">Payment Detail:</h2></div>
            <div class="col-5"><h2 class="steps">Step 2 - 4</h2></div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <label>Price</label>
                <input type="number" step="any" class="form-control" placeholder="Enter Price"  min="0"
                    name="total_price" value="{{ old('total_price', number_format($property->payment->total_price ?? 0, 0, '.', '')) }}">
            </div>
            <div class="col-md-6">
                <label>Recieved Amount</label>
                <input type="number" step="any" class="form-control" placeholder="Enter Amount"  min="0"
                    name="amount_deposited" value="{{ old('amount_deposited', number_format($property->payment->amount_deposited ?? 0, 0, '.', '')) }}">
            </div>
            <div class="col-md-6">
                <label>Recievable Amount</label>
                <input type="number" step="any" class="form-control" placeholder="Enter Amount"  min="0"
                    name="remaining_amount" value="{{ old('remaining_amount', number_format($property->payment->remaining_amount ?? 0, 0, '.', '')) }}">
            </div>
            <div class="col-md-6">
                <label>Down payment</label>
                <input type="number" step="any" class="form-control" placeholder="Down payment"  min="0"
                    name="down_payment" value="{{ old('down_payment', number_format($property->payment->down_payment ?? 0, 0, '.', '')) }}">
            </div>

            <div class="col-md-6">
                <label>Initial Notice No. (Allotment Letter)</label>
                <input type="text" class="form-control" name="initial_notice_no"
                    placeholder="Initial Notice No."
                    value="{{ old('initial_notice_no', $property->payment->initial_notice_no ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>Initial Notice Date</label>
                <input type="text" class="form-control datepicker" placeholder="Select Date"
                    name="initial_notice_date"
                    value="{{ old('initial_notice_date', $property->payment->initial_notice_date ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>Total Received Amount</label>
                <input type="number" step="any" class="form-control" placeholder="Total Received Amount"  min="0"
                    name="total_received_amount"
                    value="{{ old('total_received_amount', number_format($property->payment->total_received_amount ?? 0, 0, '.', '')) }}">
            </div>
            <div class="col-md-6">
                <label>Received Amount Date</label>
                <input type="text" class="form-control datepicker" placeholder="Select Date"
                    name="received_amount_date"
                    value="{{ old('received_amount_date', $property->payment->received_amount_date ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-7"><h2 class="fs-title">Allotment / Possession:</h2></div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <label>Allotment Chit No.</label>
                <input type="text" class="form-control" placeholder="Allotment Chit No."
                    name="allotment_order_no"
                    value="{{ old('allotment_order_no', $property->payment->allotment_order_no ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>Allotment Chit Date</label>
                <input type="date" class="form-control datepicker" placeholder="Select Date"
                    name="allotment_order_date"
                    value="{{ old('allotment_order_date', $property->payment->allotment_order_date ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>Qabza Chit  No.</label>
                <input type="text" class="form-control" placeholder="Qabza Chit No."
                    name="possession_slip_no"
                    value="{{ old('possession_slip_no', $property->payment->possession_slip_no ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>Qabza Chit Date</label>
                <input type="date" class="form-control datepicker" placeholder="Select Date"
                    name="possession_slip_date"
                    value="{{ old('possession_slip_date', $property->payment->possession_slip_date ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>Approval of Boundary Wall</label>
                <input type="text" class="form-control" name="boundary_wall_approval"
                    placeholder="Approval of Boundary Wall"
                    value="{{ old('boundary_wall_approval', $property->payment->boundary_wall_approval ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>Approval Date of Maps</label>
                <input type="date" class="form-control datepicker" name="map_approval_date"
                    placeholder="Approval Date of Maps"
                    value="{{ old('map_approval_date', $property->payment->map_approval_date ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>Transfer Order No.</label>
                <input type="text" class="form-control" placeholder="Transfer Order No."
                    name="transfer_order_no"
                    value="{{ old('transfer_order_no', $property->payment->transfer_order_no ?? '') }}">
            </div>
        </div>
    </div>
    <input type="button" class="next action-button" value="Next">
    <input type="button" class="previous action-button-previous" value="Previous">
</fieldset>

                                {{-- ===================== STEP 3 : DETAIL OF TRANSFEREES ===================== --}}
                                <fieldset id="step-3">
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7"><h2 class="fs-title">Detail of Transferees:</h2></div>
                                            <div class="col-5"><h2 class="steps">Step 3 - 4</h2></div>
                                        </div>

                                        <div id="transferees-wrapper">
                                            @forelse($property->plotHistories as $index => $transferee)
                                                <div class="transferee-block" data-index="{{ $index }}">
                                                    @if($index > 0)
                                                        <button type="button" class="remove-transferee" onclick="removeTransferee(this)">Remove</button>
                                                    @endif
                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <label>Transferee Name</label>
                                                            <input type="text" class="form-control" placeholder="Transferee Name"
                                                                name="transferees[{{ $index }}][name]" value="{{ $transferee->name }}">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Father Name</label>
                                                            <input type="text" class="form-control" placeholder="Father Name"
                                                                name="transferees[{{ $index }}][father_name]" value="{{ $transferee->father_name }}">
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label>ID Card</label>
                                                            <input type="text" class="form-control cnic-input" placeholder="12345-1234567-1" maxlength="15"
                                                                name="transferees[{{ $index }}][id_card]" value="{{ $transferee->id_card }}">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Challan No.</label>
                                                            <input type="text" class="form-control" placeholder="Challan No."
                                                                name="transferees[{{ $index }}][challan_no]" value="{{ $transferee->challan_no }}">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Address</label>
                                                            <input type="text" class="form-control" placeholder="Address"
                                                                name="transferees[{{ $index }}][address]" value="{{ $transferee->address ?? '' }}">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Allottee Date</label>
                                                            <input type="date" class="form-control datepicker" placeholder="Allottee Date"
                                                                name="transferees[{{ $index }}][allottee_date]" value="{{ $transferee->allottee_date ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="transferee-block" data-index="0">
                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <label>Transferee Name</label>
                                                            <input type="text" class="form-control" placeholder="Transferee Name" name="transferees[0][name]">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Father Name</label>
                                                            <input type="text" class="form-control" placeholder="Father Name" name="transferees[0][father_name]">
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label>ID Card</label>
                                                            <input type="text" class="form-control cnic-input" placeholder="12345-1234567-1" maxlength="15" name="transferees[0][id_card]">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Challan No.</label>
                                                            <input type="text" class="form-control" placeholder="Challan No." name="transferees[0][challan_no]">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Address</label>
                                                            <input type="text" class="form-control" placeholder="Address" name="transferees[0][address]">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Allottee Date</label>
                                                            <input type="date" class="form-control datepicker" placeholder="Allottee Date" name="transferees[0][allottee_date]">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>

                                        <button type="button" id="add-transferee" onclick="addTransferee()">+ Add Transferee</button>
                                    </div>
                                    <input type="button" class="next action-button" value="Next">
                                    <input type="button" class="previous action-button-previous" value="Previous">
                                </fieldset>

                                {{-- ===================== STEP 4 : ATTACHMENTS ===================== --}}
<fieldset id="step-4">
    <div class="form-row">
        <div class="col-md-6 text-left">
            <label>Alternate Allotment</label>
            <input type="text" class="form-control" name="alternate_allotment"
                placeholder="Alternate Allotment"
                value="{{ old('alternate_allotment', $property->attachment->alternate_allotment ?? '') }}">
        </div>

        <div class="col-md-6 text-left">
            <label>Complete File Pages <span class="required-star">*</span></label>
            <input type="number"
                   class="form-control"
                   name="complete_file_pages"
                   id="complete_file_pages"
                   placeholder="Total Pages"
                   value="{{ old('complete_file_pages', $property->attachment->complete_file_pages ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-7"><h2 class="fs-title">Attachments:</h2></div>
        <div class="col-5"><h2 class="steps">Step 4 - 4</h2></div>
    </div>

    <div class="form-row">
        <div class="col-md-12 text-left">
            <label>Property Document <span class="required-star">*</span></label>
            <input type="file" name="property_document" id="complete_property_file_input" accept=".pdf,.jpg,.jpeg,.png">
            @if(!empty($property->attachment->property_document))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->property_document]) }}" target="_blank">
                        {{ basename($property->attachment->property_document) }}
                    </a>
                </div>
            @endif
        </div>
                <div class="col-md-12 text-left">
            <label>Noting File</label>
            <input type="file" name="noting_file">
            @if(!empty($property->attachment->noting_file))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->noting_file]) }}" target="_blank">
                        {{ basename($property->attachment->noting_file) }}
                    </a>
                </div>
            @endif
        </div>



        <div class="col-md-12 text-left">
            <label>Allotment Order</label>
            <input type="file" name="allotment_order">
            @if(!empty($property->attachment->allotment_order))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->allotment_order]) }}" target="_blank">
                        {{ basename($property->attachment->allotment_order) }}
                    </a>
                </div>
            @endif
        </div>

        <div class="col-md-12 text-left">
            <label>Decision of Courts Against Plot</label>
            <input type="file" name="decision_courts">
            @if(!empty($property->attachment->decision_courts))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->decision_courts]) }}" target="_blank">
                        {{ basename($property->attachment->decision_courts) }}
                    </a>
                </div>
            @endif
        </div>

        <div class="col-md-12 text-left">
            <label>Decision of Allotment Committee</label>
            <input type="file" name="decision_allotment_committee">
            @if(!empty($property->attachment->decision_allotment_committee))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->decision_allotment_committee]) }}" target="_blank">
                        {{ basename($property->attachment->decision_allotment_committee) }}
                    </a>
                </div>
            @endif
        </div>

        <div class="col-md-12 text-left">
            <label>Decision of MDA Board</label>
            <input type="file" name="decision_mda_board">
            @if(!empty($property->attachment->decision_mda_board))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->decision_mda_board]) }}" target="_blank">
                        {{ basename($property->attachment->decision_mda_board) }}
                    </a>
                </div>
            @endif
        </div>

        <div class="col-md-12 text-left">
            <label>Decision of Revising Authority (Cancel/Restore etc)</label>
            <input type="file" name="decision_revising_authority">
            @if(!empty($property->attachment->decision_revising_authority))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->decision_revising_authority]) }}" target="_blank">
                        {{ basename($property->attachment->decision_revising_authority) }}
                    </a>
                </div>
            @endif
        </div>
    <div class="col-md-12 text-left">
            <label>Adjacent Area Allotment</label>
            <input type="file" name="adjacent_area_allotment">
            @if(!empty($property->attachment->adjacent_area_allotment))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->adjacent_area_allotment]) }}" target="_blank">
                        {{ basename($property->attachment->adjacent_area_allotment) }}
                    </a>
                </div>
            @endif
        </div>

        <div class="col-md-12 text-left">
            <label>CNIC (front-side)</label>
            <input type="file" name="cnic_front">
            @if(!empty($property->attachment->cnic_front))
                <div class="current-file-box">
                    <span class="current-file-label">Current File:</span>
                    <a href="{{ route('file.viewer', ['path' => $property->attachment->cnic_front]) }}" target="_blank">
                        {{ basename($property->attachment->cnic_front) }}
                    </a>
                </div>
            @endif
        </div>
    </div>

<div class="row mt-3">
    <div class="col-12">
        <div class="complete-file-check">
            <input
                type="checkbox"
                id="check_complete_file"
                name="check_complete_file"
                value="1"
                {{ isset($property->attachment->status) && $property->attachment->status ? 'checked' : '' }}
                {{ isset($property->attachment->status) && $property->attachment->status ? 'disabled' : '' }}
            >
            <label for="check_complete_file">
                Check this box if you have added the Complete File Data.
                @if(isset($property->attachment->status) && $property->attachment->status && isset($property->attachment->entry_date))
                    <span class="text-success">(Confirmed on {{ \Carbon\Carbon::parse($property->attachment->entry_date)->format('Y-m-d H:i') }})</span>
                @endif
            </label>
        </div>
    </div>
</div>

    <button type="submit" id="submit-btn" class="action-button">Update</button>
    <input type="button" class="previous action-button-previous" value="Previous">
</fieldset>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables for Current Owners
        var ownerIndex = {{ $property->currentOwners ? $property->currentOwners->count() : 1 }};
        var transfereeIndex = {{ $property->plotHistories->count() > 0 ? $property->plotHistories->count() : 1 }};

        // Add Current Owner
        function addOwner() {
            var block = `
                <div class="current-owner-block" data-index="${ownerIndex}">
                    <button type="button" class="btn btn-danger remove-owner" onclick="removeOwner(this)">Remove</button>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label>Name Applicant/Allottee</label>
                            <input type="text" class="form-control" name="current_owners[${ownerIndex}][applicant_name]" placeholder="Name Applicant">
                        </div>
                        <div class="col-md-6">
                            <label>Father/Husband Name</label>
                            <input type="text" class="form-control" name="current_owners[${ownerIndex}][father_husband_name]" placeholder="Father/Husband Name">
                        </div>
                        <div class="col-md-6">
                            <label>Old NIC</label>
                            <input type="text" class="form-control cnic-input" name="current_owners[${ownerIndex}][old_nic]" maxlength="15" placeholder="12345-1234567-1">
                        </div>
                        <div class="col-md-6">
                            <label>CNIC</label>
                            <input type="text" class="form-control cnic-input" name="current_owners[${ownerIndex}][cnic]" maxlength="15" placeholder="12345-1234567-1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label>Address (Temporary)</label>
                            <textarea class="form-control" placeholder="Address (Temporary)" name="current_owners[${ownerIndex}][address_temporary]" rows="1"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Address (Permanent)</label>
                            <textarea class="form-control" placeholder="Address (Permanent)" name="current_owners[${ownerIndex}][address_permanent]" rows="1"></textarea>
                        </div>
                    </div>
                </div>`;

            document.getElementById('current-owners-wrapper').insertAdjacentHTML('beforeend', block);
            ownerIndex++;
        }

        // Remove Current Owner
        function removeOwner(btn) {
            var block = btn.closest('.current-owner-block');
            if (block) {
                block.remove();
            }
        }

        // Add Transferee
        function addTransferee() {
            var block = `
                <div class="transferee-block" data-index="${transfereeIndex}">
                    <button type="button" class="btn btn-danger remove-transferee" onclick="removeTransferee(this)">Remove</button>
                    <div class="form-row">
                        <div class="col-md-12">
                            <label>Transferee Name</label>
                            <input type="text" class="form-control" placeholder="Transferee Name" name="transferees[${transfereeIndex}][name]">
                        </div>
                        <div class="col-md-12">
                            <label>Father Name</label>
                            <input type="text" class="form-control" placeholder="Father Name" name="transferees[${transfereeIndex}][father_name]">
                        </div>
                        <div class="col-md-12">
                            <label>ID Card</label>
                            <input type="text" class="form-control cnic-input" placeholder="12345-1234567-1" name="transferees[${transfereeIndex}][id_card]" maxlength="15">
                        </div>
                        <div class="col-md-12">
                            <label>Challan No.</label>
                            <input type="text" class="form-control" placeholder="Challan No." name="transferees[${transfereeIndex}][challan_no]">
                        </div>
                        <div class="col-md-12">
                            <label>Address</label>
                            <input type="text" class="form-control" placeholder="Address" name="transferees[${transfereeIndex}][address]">
                        </div>
                        <div class="col-md-12">
                            <label>Allottee Date</label>
                            <input type="date" class="form-control datepicker" placeholder="Allottee Date" name="transferees[${transfereeIndex}][allottee_date]">
                        </div>
                    </div>
                </div>`;

            document.getElementById('transferees-wrapper').insertAdjacentHTML('beforeend', block);
            transfereeIndex++;
            $('.datepicker').flatpickr({ dateFormat: "Y-m-d" });
        }

        // Remove Transferee
        function removeTransferee(btn) {
            var block = btn.closest('.transferee-block');
            if (block) {
                block.remove();
            }
        }

$(document).ready(function () {
    $('.datepicker').flatpickr({ dateFormat: "Y-m-d" });

    var $submitBtn = $('#submit-btn');
    var $completeFileCheck = $('#check_complete_file');
    var $completeFileInput = $('#complete_property_file_input');
    var hasExistingFile = {{ !empty($property->attachment->property_document) ? 'true' : 'false' }};
    var isStatusConfirmed = {{ isset($property->attachment->status) && $property->attachment->status ? 'true' : 'false' }};

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
            $container.html('<div class="no-preview" style="padding:40px;">Preview could not be loaded.<br>' + err.message + '</div>');
        });
    }

    // ================= AUTO COUNT PDF PAGES + PREVIEW =================
    $('#complete_property_file_input').on('change', function(e) {
        var file = e.target.files[0];
        if (!file) return;

        var $pagesInput = $('#complete_file_pages');

        // Agar PDF file hai
        if (file.type === 'application/pdf') {
            var reader = new FileReader();
            reader.onload = function(e) {
                try {
                    var typedarray = new Uint8Array(e.target.result);
                    pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
                        var totalPages = pdf.numPages;
                        $pagesInput.val(totalPages);


                        // Preview render
                        var fileURL = URL.createObjectURL(file);
                        var $previewBox = $('#previewBox');
                        $previewBox.html('<div class="pdf-scroll-outer" id="pdfScrollOuter"><div id="pdfViewerContainer" class="pdf-viewer-container"></div></div>');
                        renderPdfProgressive(fileURL, '#pdfViewerContainer');
                    }).catch(function(err) {
                        console.error('Error reading PDF:', err);
                        showAlert('warning', 'Could not auto-detect pages. Please enter manually.');
                    });
                } catch(err) {
                    console.error('Error processing file:', err);
                    showAlert('warning', 'Could not process PDF. Please enter pages manually.');
                }
            };
            reader.readAsArrayBuffer(file);
        }
        // Agar image file hai
        else if (file.type.startsWith('image/')) {
            $pagesInput.val(1);
            showAlert('success', 'Image file detected. Pages: 1');

            // Image preview
            var fileURL = URL.createObjectURL(file);
            var $previewBox = $('#previewBox');
            $previewBox.html('<div class="pdf-scroll-outer"><div id="pdfViewerContainer" class="pdf-viewer-container"><img src="' + fileURL + '" style="max-width:100%;display:block;margin:auto;"></div></div>');
            showZoomToolbar();
            resetZoom();
        }
        // Unsupported file type
        else {
            showAlert('warning', 'Unsupported file type. Please enter pages manually.');
            $('#previewToolbar').hide();
            var $previewBox = $('#previewBox');
            $previewBox.html('<div class="no-preview">Preview not available for this file type.<br>(' + file.name + ')</div>');
        }
    });

    // ================= SELECT2 =================
    $('#sector').select2({
        placeholder: "Select Sector",
        allowClear: true,
        width: "100%"
    });

    $('#block').select2({
        placeholder: "Select Block",
        allowClear: true,
        width: "100%"
    });

    var initialSector = $('#sector').val();
    var initialBlock = '{{ old('block_id', $property->block_id ?? '') }}';

    function loadBlocks(sectorId, selectedBlockId) {
        var blockSelect = $('#block');

        blockSelect.empty().append('<option value="">Select Block</option>');
        blockSelect.val('').trigger('change');

        if (!sectorId) {
            blockSelect.prop('disabled', true);
            return;
        }

        blockSelect.prop('disabled', false);
        blockSelect.append('<option value="" disabled>Loading blocks...</option>');

        $.ajax({
            url: '/get-blocks/' + sectorId,
            type: 'GET',
            dataType: 'json',
            success: function(blocks) {
                blockSelect.find('option:disabled').remove();

                if (blocks.length > 0) {
                    $.each(blocks, function(index, block) {
                        var isSelected = (selectedBlockId && String(block.id) === String(selectedBlockId)) ? 'selected' : '';
                        blockSelect.append('<option value="' + block.id + '" ' + isSelected + '>' + block.name + '</option>');
                    });
                } else {
                    blockSelect.append('<option value="" disabled>No blocks available</option>');
                }

                if (selectedBlockId) {
                    blockSelect.val(String(selectedBlockId)).trigger('change');
                } else {
                    blockSelect.trigger('change');
                }
            },
            error: function(xhr) {
                console.error('Error fetching blocks:', xhr);
                blockSelect.find('option:disabled').remove();
                blockSelect.append('<option value="" disabled>Error loading blocks</option>');
            }
        });
    }

    $('#sector').on('change', function() {
        loadBlocks($(this).val(), null);
    });

    if (initialSector) {
        loadBlocks(initialSector, initialBlock);
    } else {
        $('#block').prop('disabled', true);
    }

    // ================= STEPPER =================
    var stepIds = ['#step-1', '#step-2', '#step-3', '#step-4'];
    var current = 0;

    function setProgressBar(stepIndex) {
        var percent = (100 / stepIds.length) * (stepIndex + 1);
        $('.progress-bar').css('width', percent.toFixed() + '%');
    }

    function goToStep(index) {
        if (index < 0 || index >= stepIds.length) return;

        var current_fs = $(stepIds[current]);
        var target_fs = $(stepIds[index]);

        $('#progressbar li').removeClass('active');
        $('#progressbar li').each(function (i) {
            if (i <= index) $(this).addClass('active');
        });

        current_fs.hide();
        target_fs.show();

        current = index;
        setProgressBar(current);
    }

    $(document).off('click', '.next').on('click', '.next', function (e) {
        e.preventDefault();
        goToStep(current + 1);
    });

    $(document).off('click', '.previous').on('click', '.previous', function (e) {
        e.preventDefault();
        goToStep(current - 1);
    });

    $('#progressbar li').on('click', function () {
        var index = $('#progressbar li').index(this);
        goToStep(index);
    });

    // ================= CNIC FORMATTING =================
    $(document).on('input', '.cnic-input', function () {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 13) {
            value = value.substring(0, 13);
        }
        let formatted = value;
        if (value.length > 5) {
            formatted = value.substring(0, 5) + '-' + value.substring(5);
        }
        if (value.length > 12) {
            formatted = value.substring(0, 5) + '-' +
                        value.substring(5, 12) + '-' +
                        value.substring(12);
        }
        $(this).val(formatted);
    });

    // ================= FORM SUBMIT (AJAX) =================
    function showAlert(type, message) {
        var box = $('#form-alert-box');
        box.removeClass('alert-success alert-danger alert-info alert-warning').addClass('alert-' + type);
        box.html(message);
        box.show();
        $('html, body').animate({ scrollTop: box.offset().top - 100 }, 300);
    }

    $('#msform').on('submit', function (e) {
        e.preventDefault();

        // Remove dashes from CNIC fields
        $('.cnic-input').each(function() {
            $(this).val($(this).val().replace(/-/g, ''));
        });

        var form = this;
        var formData = new FormData(form);
        var $submitBtn = $('#submit-btn');

        $submitBtn.prop('disabled', true).text('Saving...');
        $('#form-alert-box').hide();

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function (response) {
    showAlert('success', response.message || 'Data updated successfully.');
    if (response.redirect) {
        setTimeout(function () {
            window.location.href = response.redirect;  // ✅ UNCOMMENT THIS
        }, 1500);
    } else {
        setTimeout(function () {
            location.reload();
        }, 1500);
    }
},
            error: function (xhr) {
                var message = 'Something went wrong. Please try again.';

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var list = '<ul class="mb-0">';
                    $.each(errors, function (field, messages) {
                        list += '<li>' + messages[0] + '</li>';
                    });
                    list += '</ul>';
                    message = list;
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                showAlert('danger', message);
                $submitBtn.prop('disabled', false).text('Update');
            },
            complete: function () {
                if ($submitBtn.prop('disabled')) {
                    $submitBtn.prop('disabled', false).text('Update');
                }
            }
        });
    });

    // ================= PAGE LOAD: EXISTING FILE RENDER =================
    @if(!empty($property->attachment->property_document))
        renderPdfProgressive("{{ asset('storage/' . $property->attachment->property_document) }}", '#pdfViewerContainer');
    @endif

});
    </script>
</x-app-layout>
