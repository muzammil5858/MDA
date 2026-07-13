<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-pwhbDJ5Erf0klsYt4Ma8em1K...==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap" rel="stylesheet">
    <style>
        p {
            color: grey;
            font-family: 'Noto Nastaliq Urdu', serif;
            font-weight: 500 !important;
        }
        .form-control.address{
            font-family: 'Noto Nastaliq Urdu', serif !important;
            font-weight: 500;
            font-size:14px;
            direction: rtl;
        }

        .icon-check {
            color: green;
            font-size: 3rem;
        }

        .icon-cross {
            color: red;
            font-size: 3rem;
        }

        .thumb-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            background-color: #f8f9fa;
            margin-left: auto;
            margin-right: auto;
        }

        #heading {
            text-transform: uppercase;
            color: #03346E;
            font-weight: bolder;
            font-size: 1.5rem;
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative
        }

        .form-card {
            text-align: left
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        #msform input,
        #msform textarea,
        #msform select {
            padding: 8px 15px 8px 15px;
            border: 1px solid #ccc;
            border-radius: 0px;
            margin-bottom: 15px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            background-color: #ffffff;
            font-size: 16px;
            letter-spacing: 1px;

        }

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #03346E;
            outline-width: 0
        }

        #msform .action-button {
            width: 100px;
            background: #03346E;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 0px 10px 5px;
            float: right
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            background-color: #311B92
        }

        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px 10px 0px;
            float: right
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            background-color: #000000
        }

        .card {
            z-index: 0;
            border: none;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #03346E;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }

        .purple-text {
            color: #03346E;
            font-weight: normal
        }

        .steps {
            font-size: 25px;
            color: gray;
            margin-bottom: 10px;
            font-weight: normal;
            text-align: right
        }

        .fieldlabels {
            color: gray;
            text-align: left
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey
        }


        #progressbar .active {
            color: #03346E
        }

        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f13e"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f030"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #03346E
        }

        .fingerprint img {
            object-fit: contain;
            width: 150px;
            height: 150px;
        }

        .progress {
            height: 20px
        }

        .progress-bar {
            background-color: #03346E
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }

        /* Loader CSS */
        #loader {
            position: fixed;
            left: 15%;
            top: 0;
            width: 85%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 8px solid #f3f3f3;
            /* Light grey */
            border-top: 8px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .profile-pic {


            display: block;

            content: " *";
            color: red;

        }

        .form-valid {
            opacity: 0.5;
        }

        .form-control-label abbr {
            text-decoration: none;
            font-weight: normal;
        }

        .file-upload {
            display: none;
        }

        .circle {
            border-radius: 1000px !important;
            overflow: hidden;
            padding-top: 1px;
            margin-top: 10px;
            margin-bottom: 10px;
            width: 128px;
            height: 128px;
            margin-left: 17px;
            border: 3px solid #3634b5;
            position: relative;

        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .p-image {
            position: relative;
            display: block;
            top: 100px;

            color: #202933;
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .Mcf-image {
            position: relative;
            top: 100px;
            left: 400px;
            color: #202933;
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .p-image:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .upload-button {
            font-size: 1.2em;
            cursor: pointer;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }


        .upload-button:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
            color: #999;
        }

        @media screen and (max-width: 640px) {

            .ed {
                display: none;
            }

            .circle {
                width: 100px;
                height: 100px;
            }

            .pic {
                display: flex;
                justify-content: center;
            }
        }

        #progressBar {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 10px;
        }

        #progressBarFill {
            height: 30px;
            width: 0;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
        }

        .progress-container {
            display: inline-block;
            text-align: center;
            margin: 10px;
            position: relative;
        }

        .progress-circle {
            position: relative;
            width: 120px;
            height: 120px;
        }

        circle {
            fill: none;
        }

        circle.bg {
            stroke: #e6e6e6;
        }

        circle.progress {
            stroke: #4caf50;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.3s ease;
            transform: rotate(-90deg);
            /* Start from the top */
            transform-origin: 50% 50%;
        }

        .percent-text {
            position: absolute;
            top: 60%;
            left: 46%;
            transform: translate(-50%, -50%);
            font-size: 17px;
            font-weight: bold;
        }

        .document-container {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #000;
            padding: 20px;
            position: relative;
        }

        .header {

            border-bottom: 1px dashed #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
            text-align: right;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .header .head {
            width: 75%;
        }

        h1 {
            font-weight: bold;
            margin-bottom: 30px !important;
            font-size: 20px;
            margin: 0;
            text-align: center;
        }

        .header .head h1 {
            font-weight: bold;
            margin-bottom: 30px !important;
            font-size: 20px;
            margin: 0;
            text-align: center;
        }

        .head p,
        td {
            font-weight: bold;
        }

        .photo-section {
            position: relative;
            width: 150px;
            height: 150px;
            border: 1px solid #000;
        }

        .photo-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .document-container .content p {
            text-align: right;
            margin: 10px 0;
            line-height: 1.6;
            font-weight: bold;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .signature div {
            text-align: center;
        }

        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
        }

        .fingerprint {
            text-align: center;
            margin-top: 20px;
        }

        .fingerprint img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .attachment img,
        .thumb img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }

        .modal-backdrop.show {
            display: none !important;
        }

        .attachment button {
            background: #054468;
            color: white;
        }

        .attachment button:hover {
            background: white;
            color: #054468;
        }

        .file-drop-area {
            border: 2px dashed #7da2d9;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            border-radius: 8px;
            background-color: #f9fbff;
            transition: background 0.25s ease-in-out, border-color 0.25s ease-in-out;
            position: relative;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .file-drop-area:hover {
            background-color: #e6f0ff;
            border-color: #5b8def;
        }

        .file-drop-area.dragover {
            background-color: #cce0ff;
            border-color: #3a65d8;
        }

        .file-drop-area span {
            font-size: 0.8rem;
            color: #3a3a3a;
            user-select: none;
        }

        input[type="file"] {
            display: none;
        }

        .img-preview {
            max-height: 120px;
            max-width: 100%;
            margin-top: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            object-fit: contain;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .modal-backdrop.show {
            background-color: rgba(0, 0, 0, 0.8) !important;
        }

        .fingerprint {
            display: flex;
            gap: 10px;
            /* optional spacing */
        }

        .fingerprint>* {
            flex: 1;
            /* default: equal share */
        }

        /* If there are 4 or more children → force 25% width */
        .fingerprint>*:nth-child(n+4),
        .fingerprint:has(> :nth-child(4))>* {
            flex: 0 0 25%;
        }

        .name {
            /* font-size:1px; */
            font-weight: 900;
            color: black;
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 text-center p-0 mt-3 mb-2">
                <div class="card px-4 pt-4 pb-0 mt-3 mb-3">
                    <h2 id="heading">Mangla Dam Housing Authority</h2>
                    <p>Fill all form's fields to proceed</p>
                    @if ($errors->any())
                    <div class="error">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form id="msform" action="{{route('DDverification',1)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Progressbar -->
                        <ul id="progressbar">
                            <li class="active" id="account"><strong>Property Details</strong></li>
                            <li id="payment"><strong>Attachments</strong></li>
                            <li id="payment"><strong>Seller Statements</strong></li>
                            <li id="payment"><strong>Buyer Statement</strong></li>
                        </ul>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <br>
                        <!-- Step 1 -->
                        <fieldset id="first-step">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7 d-flex">
                                        <h2 class="fs-title">Owner Details:</h2>
                                        <button type="button" class="btn btn-primary ml-3" data-bs-toggle="modal"
                                            data-bs-target="#allOwnersModal">
                                            View Owner
                                        </button>
                                    </div>
                                </div>

                                <!-- Input 1 -->
                                <div class="modal fade ml-5 mt-5" id="allOwnersModal" tabindex="-1"
                                    aria-labelledby="allOwnersModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Owner Details:</h2>
                                                    </div>
                                                </div>
                                                <div class="card shadow-sm mb-4"
                                                    style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                                    <div class="card-body">
                                                        @foreach($property->owners as $key => $value)
                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <label>Owner Name</label>
                                                                <input type="text" class="form-control address"
                                                                    name="owner[{{$key}}][name]" readonly
                                                                    placeholder="Enter Seller Name"
                                                                    value="{{$value->name}}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Owner's Father Name</label>
                                                                <input type="text" class="form-control address"
                                                                    name="owner[{{$key}}][father_name]" readonly
                                                                    placeholder="Enter Seller's Father Name"
                                                                    value="{{$value->father_name}}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Owner's CNIC</label>
                                                                <input type="text" class="form-control"
                                                                    id="owner_cnic_{{$key}}"
                                                                    name="owner[{{$key}}][cnic]" readonly
                                                                    placeholder="Enter Seller's CNIC"
                                                                    value="{{$value->cnic}}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Owner's Address</label>
                                                                <input type="text" class="form-control address"
                                                                    name="owner[{{$key}}][address]"
                                                                    placeholder="Enter Seller's Address"
                                                                    value="{{$value->address}}"
                                                                    onchange="change(this);"
                                                                    id="address">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Owner's Area</label>
                                                                <input type="text" class="form-control"
                                                                    name="owner[{{$key}}][area]"
                                                                    placeholder="Enter Seller's Area"
                                                                    value="{{$value->area}} Marla"
                                                                    onchange="change(this);">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="owner[{{$key}}][cnic_front]"
                                                            value="{{$value->cnic_front}}">
                                                        <input type="hidden" name="owner[{{$key}}][cnic_back]"
                                                            value="{{$value->cnic_back}}">
                                                        <input type="hidden" name="owner[{{$key}}][id]"
                                                            value="{{$value->id}}">

                                                        @endforeach



                                                    </div>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="shared_attorney_check"
                                    value="{{!is_null($data->shared_attorney) ? 1 : 0}}">
                                <input type="hidden" name="shared_representative_check"
                                    value="{{$data->shared_representative ? 1 : 0}}">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Requester Details:</h2>
                                    </div>
                                </div>
                                <div class="card shadow-sm mb-4 "
                                    style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                        @foreach($request->participants as $key => $value)

                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>Requester Name</label>
                                                <input type="text" class="form-control address" name="requester[{{$key}}][name]"
                                                    readonly placeholder="Enter Seller Name"
                                                    value="{{$value->owner->name}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Requester's Father Name</label>
                                                <input type="text" class="form-control address"
                                                    name="requester[{{$key}}][father_name]" readonly
                                                    placeholder="Enter Seller's Father Name"
                                                    value="{{$value->owner->father_name}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Requester's CNIC</label>
                                                <input type="text" class="form-control" id="requester_cnic_{{$key}}"
                                                    name="requester[{{$key}}][cnic]" readonly
                                                    placeholder="Enter Seller's CNIC" value="{{$value->owner->cnic}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Requester's Address</label>
                                                <input type="text" class="form-control address"
                                                    name="requester[{{$key}}][address]"
                                                    placeholder="Enter Seller's Address"
                                                    value="{{$value->owner->address}}" onchange="change(this);" id="address">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Requester's Area</label>
                                                <input type="text" class="form-control" name="requester[{{$key}}][area]"
                                                    placeholder="Enter Seller's Area"
                                                    value="{{$value->owner->area}} Marla" onchange="change(this);">
                                            </div>
                                            @if(is_null($data->shared_attorney))
                                            @if($value->representative)

                                            <div class="card shadow-sm mb-4 mx-4"
                                                style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                                <div class="card-body">
                                                    <label>Attorney on behalf of {{$value->owner->name}}</label>
                                                    <div class="form-row">
                                                        <div class="col-md-4">
                                                            <label>Attorney Name</label>
                                                            <input type="text" class="form-control address"
                                                                name="attorney[{{$key}}][name]" readonly
                                                                placeholder="Enter Seller Name"
                                                                value="{{$value->representative->name}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Attorney's Father Name</label>
                                                            <input type="text" class="form-control address"
                                                                name="attorney[{{$key}}][father_name]" readonly
                                                                placeholder="Enter Seller's Father Name"
                                                                value="{{$value->representative->father_name}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Attorney's CNIC</label>
                                                            <input type="text" class="form-control"
                                                                id="attorney_cnic_{{$key}}"
                                                                name="attorney[{{$key}}][cnic]" readonly
                                                                placeholder="Enter Seller's CNIC"
                                                                value="{{$value->representative->cnic}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Attorney's Address</label>
                                                            <input type="text" class="form-control address"
                                                                name="attorney[{{$key}}][address]"
                                                                placeholder="Enter Seller's Address"
                                                                value="{{$value->representative->address}}"
                                                                onchange="change(this);"
                                                                id="address">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Requester's Letter</label>
                                                            <a
                                                                href={{asset('uploads/user/representative/letter/'.$value->representative->attorney_letter)}}>Click
                                                                to View Letter</a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Attorney's CNIC Attachements</label>
                                                            <br>
                                                            @if(!empty($value->representative->cnic_front))
                                                            <a href="{{ asset('uploads/user/representative/cnic/'.$value->representative->cnic_front) }}"
                                                                target="_blank">Click to View CNIC Front Attachement</a>
                                                            @else
                                                            <div class="info-value">No CNIC Front </div>
                                                            @endif
                                                            <br>
                                                            @if(!empty($value->representative->cnic_back))
                                                            <a href="{{ asset('uploads/user/representative/cnic/'.$value->representative->cnic_back) }}"
                                                                target="_blank">Click to View CNIC Back Attachement</a>
                                                            @else
                                                            <div class="info-value">No CNIC Back</div>
                                                            @endif
                                                        </div>
                                                        <input type="hidden" name="attorney[{{$key}}][id]"
                                                            value="{{$value->representative->id}}">
                                                        <input type="hidden" name="attorney[{{$key}}][owner_id]"
                                                            value="{{$value->owner_id}}">

                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endif




                                        </div>
                                        <input type="hidden" name="requester[{{$key}}][cnic_front]"
                                            value="{{$value->owner->cnic_front}}">
                                        <input type="hidden" name="requester[{{$key}}][cnic_back]"
                                            value="{{$value->owner->cnic_back}}">
                                        <input type="hidden" name="requester[{{$key}}][id]"
                                            value="{{$value->owner->id}}">
                                        <input type="hidden" name="requester[{{$key}}][mode]" value="{{$value->mode}}">

                                        @endforeach
                                        @if(!is_null($data->shared_attorney))
                                        <div class="card shadow-sm mb-4 mx-4"
                                            style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                            <div class="card-body">
                                                <label>Attorney on behalf of {{ $request->participants->map(fn($p) =>
                                                    $p->owner->name)->implode(',') }}</label>
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label>Attorney Name</label>
                                                        <input type="text" class="form-control address" name="attorney[0][name]"
                                                            readonly placeholder="Enter Seller Name"
                                                            value="{{$data->callAttorney->name}}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Attorney's Father Name</label>
                                                        <input type="text" class="form-control address"
                                                            name="attorney[0][father_name]" readonly
                                                            placeholder="Enter Seller's Father Name"
                                                            value="{{$data->callAttorney->father_name}}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Attorney's CNIC</label>
                                                        <input type="text" class="form-control" id="attorney_cnic_0"
                                                            name="attorney[0][cnic]" readonly
                                                            placeholder="Enter Seller's CNIC"
                                                            value="{{$data->callAttorney->cnic}}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Attorney's Address</label>
                                                        <input type="text" class="form-control address"
                                                            name="attorney[0][address]"
                                                            placeholder="Enter Seller's Address"
                                                            value="{{$data->callAttorney->address}}"
                                                            onchange="change(this);"
                                                            id="address">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Attorney's Letter</label>
                                                        <a href={{asset('uploads/user/representative/letter/'.$data->callAttorney->attorney_letter)}}>Click
                                                            to View Letter</a>
                                                    </div>
                                                    <input type="hidden" name="attorney[0][id]"
                                                        value="{{$data->callAttorney->id}}">
                                                    <input type="hidden" name="attorney[0][owner_id]"
                                                        value="{{$data->callAttorney->owner_id}}">

                                                </div>
                                            </div>
                                        </div>

                                        @endif
                                        @if($request->request_type == 1)
                                        <div class="col-md-4">
                                            <label>Sold Price</label>
                                            <input type="text" class="form-control" readonly value="{{$data->amount}}"
                                                placeholder="">
                                        </div>
                                        @endif


                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">{{$type == 1 ? 'Buyer Details' : 'Receiver Details'}}</h2>
                                    </div>
                                </div>
                                <!-- Input 1 -->
                                <div class="card shadow-sm mb-4"
                                    style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                        @foreach($request->dummyreceiver as $key => $value)

                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>{{$type == 1 ? 'Buyer Name' : 'Receiver Name'}}</label>
                                                <input type="text" class="form-control address" name="receiver[{{$key}}][name]"
                                                    readonly placeholder="Enter Buyer Name" value="{{$value->name}}"
                                                    onchange="change(this)">
                                            </div>
                                            <div class="col-md-4">
                                                <label>{{$type == 1 ? 'Buyer Father Name' : 'Receiver Father
                                                    Name'}}</label>
                                                <input type="text" class="form-control address"
                                                    name="receiver[{{$key}}][father_name]" readonly
                                                    placeholder="Enter Buyer's Father Name"
                                                    value="{{$value->father_name}}" onchange="change(this)">
                                            </div>
                                            <div class="col-md-4">
                                                <label>{{$type == 1 ? 'Buyer CNIC' : 'Receiver CNIC'}}</label>
                                                <input type="text" class="form-control" id="receiver_cnic_{{$key}}"
                                                    name="receiver[{{$key}}][cnic]" readonly
                                                    placeholder="Enter Buyer's CNIC" value="{{$value->cnic}}"
                                                    onchange="change(this)">
                                            </div>

                                            <div class="col-md-4">
                                                <label>{{$type == 1 ? 'Buyer Address' : 'Receiver Address'}}</label>
                                                <input type="text" class="form-control address"
                                                    name="receiver[{{$key}}][address]"
                                                    placeholder="Enter Buyer's Address" onchange="change(this)"
                                                    value="{{$value->address}}"
                                                    id="address">

                                            </div>
                                            <div class="col-md-4">
                                                <label>{{$type == 1 ? 'Buyer Area' : 'Receiver Area'}}</label>
                                                <input type="text" class="form-control" name="receiver[{{$key}}][area]"
                                                    readonly placeholder="Enter Buyer's Area" onchange="change(this)"
                                                    value="{{$value->area}}">

                                            </div>

                                            <input type="hidden" name="receiver[{{$key}}][cnic_front]"
                                                value="{{$value->cnic_front}}">
                                            <input type="hidden" name="receiver[{{$key}}][cnic_back]"
                                                value="{{$value->cnic_back}}">
                                            <input type="hidden" name="receiver[{{$key}}][mode]"
                                                value="{{$value->receiver_type}}">
                                                <input type="hidden" name="receiver[{{$key}}][id]" value="{{$value->id}}">

                                            <div class="col-md-4">
                                                <label>{{$type == 1 ? 'Buyer CNIC' : 'Receiver CNIC'}}</label>
                                                <p>
                                                    <a href="#" class="view-cnic text-primary"
                                                        data-front="/uploads/user/cnics/{{$value->cnic_front}}"
                                                        data-back="/uploads/user/cnics/{{$value->cnic_back}}"
                                                        data-bs-toggle="modal" data-bs-target="#cnicModal">
                                                        Click to view Attachment
                                                    </a>
                                                </p>
                                            </div>

                                            @if($value->receiver_type == 'representative')

                                            <div class="card shadow-sm mb-4 mx-4"
                                                style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                                <div class="card-body">
                                                    <label>Representative on behalf of {{$value->name}}</label>
                                                    <div class="form-row">
                                                        <div class="col-md-4">
                                                            <label>Representative Name</label>
                                                            <input type="text" class="form-control address"
                                                                name="representative[{{$key}}][name]" readonly
                                                                placeholder="Enter Seller Name"
                                                                value="{{$value->representative->name}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Representative's Father Name</label>
                                                            <input type="text" class="form-control address"
                                                                name="representative[{{$key}}][father_name]" readonly
                                                                placeholder="Enter Seller's Father Name"
                                                                value="{{$value->representative->father_name}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Representative's CNIC</label>
                                                            <input type="text" class="form-control"
                                                                id="representative_cnic_{{$key}}"
                                                                name="representative[{{$key}}][cnic]" readonly
                                                                placeholder="Enter Seller's CNIC"
                                                                value="{{$value->representative->cnic}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Representative's Address</label>
                                                            <input type="text" class="form-control address"
                                                                name="representative[{{$key}}][address]"
                                                                placeholder="Enter Seller's Address"
                                                                value="{{$value->representative->address}}"
                                                                onchange="change(this);"
                                                                id="address">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Representative's Letter</label>
                                                            <a
                                                                href={{asset('uploads/user/representative/letter/'.$value->representative->attorney_letter)}}>Click
                                                                to View Letter</a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Representater's CNIC Attachements</label>
                                                            <br>
                                                            @if(!empty($value->representative->cnic_front))
                                                            <a href="{{ asset('uploads/user/representative/cnic/'.$value->representative->cnic_front) }}"
                                                                target="_blank">Click to View CNIC Front Attachement</a>
                                                            @else
                                                            <div class="info-value">No CNIC Front </div>
                                                            @endif
                                                            <br>
                                                            @if(!empty($value->representative->cnic_back))
                                                            <a href="{{ asset('uploads/user/representative/cnic/'.$value->representative->cnic_back) }}"
                                                                target="_blank">Click to View CNIC Back Attachement</a>
                                                            @else
                                                            <div class="info-value">No CNIC Back</div>
                                                            @endif
                                                        </div>
                                                        <input type="hidden" name="representative[{{$key}}][id]"
                                                            value="{{$value->representative->id}}">
                                                        <input type="hidden" name="representative[{{$key}}][receiver_id]"
                                                            value="{{$value->id}}">


                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <hr class="my-4">
                                        @endforeach
                                        @if($data->shared_representative)
                                        <div class="card shadow-sm mb-4 mx-4"
                                            style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                            <div class="card-body">
                                                <label>Attorney on behalf of {{ $request->dummyreceiver->map(fn($p) =>
                                                    $p->name)->implode(',') }}</label>
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label>Attorney Name</label>
                                                        <input type="text" class="form-control address" name="representative[0][name]"
                                                            readonly placeholder="Enter Seller Name"
                                                            value="{{$data->callSharedRepresentative->name}}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Attorney's Father Name</label>
                                                        <input type="text" class="form-control address"
                                                            name="representative[0][father_name]" readonly
                                                            placeholder="Enter Seller's Father Name"
                                                            value="{{$data->callSharedRepresentative->father_name}}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Attorney's CNIC</label>
                                                        <input type="text" class="form-control" id="attorney_cnic_0"
                                                            name="representative[0][cnic]" readonly
                                                            placeholder="Enter Seller's CNIC"
                                                            value="{{$data->callSharedRepresentative->cnic}}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Attorney's Address</label>
                                                        <input type="text" class="form-control address"
                                                            name="representative[0][address]"
                                                            placeholder="Enter Seller's Address"
                                                            value="{{$data->callSharedRepresentative->address}}"
                                                            onchange="change(this);"
                                                            id="address">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Attorney's Letter</label>
                                                        <a href={{asset('uploads/user/representative/letter/'.$data->callSharedRepresentative->attorney_letter)}}>Click
                                                            to View Letter</a>
                                                    </div>

                                                    <input type="hidden" name="representative[0][id]"
                                                        value="{{$data->callSharedRepresentative->id}}">
                                                    <input type="hidden" name="representative[0][receiver_id]"
                                                        value="{{$data->callSharedRepresentative->id}}">

                                                </div>
                                            </div>
                                        </div>

                                        @endif
                                    </div>
                                </div>
                                <!-- Your Modal -->
                                <div class="modal fade" id="cnicModal" tabindex="-1" aria-labelledby="cnicModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-3">
                                            <div class="modal-header border-bottom-0"
                                                style="background:#054468;color:white;">
                                                <h6 class="modal-title fw-semibold " id="cnicModalLabel">Buyer's CNIC
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-3 pb-4 text-center">
                                                <!-- CNIC Front -->
                                                <div class="mb-3 flex justify-center flex-col">
                                                    <img id="cnic-front" src="" alt="CNIC Front"
                                                        class="img-fluid rounded border">
                                                    <div class="small text-muted mt-1">Front Side</div>
                                                </div>
                                                <!-- CNIC Back -->
                                                <div class="flex justify-center flex-col">
                                                    <img id="cnic-back" src="" alt="CNIC Back"
                                                        class="img-fluid rounded border">
                                                    <div class="small text-muted mt-1">Back Side</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Witness Details:</h2>
                                    </div>
                                </div>
                                <div class="card shadow-sm mb-4"
                                    style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                        @foreach($request->dummywitness as $key => $value)

                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>Witness Name</label>
                                                <input type="text" class="form-control address" name="witness[{{$key}}][name]"
                                                    placeholder="Enter Witness Name" onchange="change(this)"
                                                    value="{{$value->name}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Witness's Father Name</label>
                                                <input type="text" class="form-control address"
                                                    name="witness[{{$key}}][father_name]"
                                                    placeholder="Enter Witness's Father Name" onchange="change(this)"
                                                    value="{{$value->father_name}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Witness's CNIC</label>
                                                <input type="number" class="form-control" id="witness_cnic_{{$key}}"
                                                    name="witness[{{$key}}][cnic]" placeholder="Enter Witness's CNIC"
                                                    onchange="change(this)" value="{{$value->cnic}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Witness's Address</label>
                                                <input type="text" class="form-control address" id="first_witness_cnic"
                                                    name="witness[{{$key}}][address]" placeholder="Enter Witness's CNIC"
                                                    onchange="change(this)" value="{{$value->address}}" id="address">
                                            </div>
                                            <input type="hidden" name="witness[{{$key}}][cnic_front]"
                                                value="{{$value->cnic_front}}">
                                            <input type="hidden" name="witness[{{$key}}][cnic_back]"
                                                value="{{$value->cnic_back}}">
                                            <div class="col-md-4">
                                                <label>Witness's CNIC</label>
                                                <p>

                                                    <a href="#" class="view-cnic text-primary"
                                                        data-front="/uploads/user/cnics/{{$value->cnic_front}}"
                                                        data-back="/uploads/user/cnics/{{$value->cnic_back}}"
                                                        data-bs-toggle="modal" data-bs-target="#cnicModal">
                                                        Click to view Attachment
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        @endforeach
                                        <hr class="my-4">


                                    </div>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Next" />
                        </fieldset>
                        <!-- Step 2 -->
                        <fieldset id="second-step">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Requester Attachements:</h2>
                                    </div>
                                </div>
                                <!-- Input 1 -->
                                <div class="card shadow-sm mb-4"
                                    style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                        @if(!is_null($data->shared_attorney))
                                        <input type="hidden" name="shared_attorney_id"
                                            value="{{$data->shared_attorney_id}}">
                                        <label>Attorney on behalf of {{ $request->participants->map(fn($p) =>
                                            $p->owner->name)->implode(',') }}</label>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>
                                                    Attorney Name
                                                </label>
                                                <input type="text" disabled class="form-control" readonly
                                                    value="{{$data->callAttorney->name }}">
                                            </div>

                                            {{-- Picture Field --}}
                                            <div class="col-md-3">
                                                <label for="">
                                                    Attorney Picture
                                                </label>

                                                <div class="file-drop-area open-camera"
                                                    data-target-img="preview-attorney-0"
                                                    data-target-input="input-attorney-0" data-role="attorney"
                                                    data-user-id="0" data-statement="statement-attorney-0"
                                                    data-bs-toggle="modal" data-bs-target="#cameraModal">

                                                    <input type="hidden" id="input-attorney-0"
                                                        name="attorney[0][picture]">

                                                    <span>Click to add or update Picture</span>
                                                    <img id="preview-attorney-0" class="img-preview" src="">
                                                </div>
                                            </div>

                                            {{-- Biometric Field --}}
                                            <div class="col-md-3">
                                                <label for="">
                                                    Attorney Biometric
                                                </label>

                                                <div class="file-drop-area pasteButton"
                                                    data-target-img="biometric-attorney-0"
                                                    data-target-input="biometric-attorney-0"
                                                    data-target="biometricImg-attorney-0" data-user="attorney"
                                                    data-index="0" data-thumb="thumb-attorney-0">

                                                    <span>Click to add or update Biometric</span>
                                                    <img id="biometricImg-attorney-0" class="img-preview" src="">
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @foreach($request->participants as $key => $value)
                                        @if($value->mode == 'attorney')
                                        <label>Attorney on behalf of {{$value->owner->name}}</label>
                                        @endif

                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>
                                                    {{ $value->mode === 'attorney' ? 'Attorney Name' : 'Requester Name'
                                                    }}
                                                </label>
                                                <input type="text" disabled class="form-control address" readonly
                                                    value="{{ $value->mode === 'attorney' ? $value->representative->name ?? '' : $value->owner->name }}">
                                            </div>

                                            {{-- Picture Field --}}
                                            <div class="col-md-3">
                                                <label for="">
                                                    {{ $value->mode === 'attorney' ? 'Attorney Picture' : 'Requester
                                                    Picture' }}
                                                </label>

                                                <div class="file-drop-area open-camera"
                                                    data-target-img="{{ $value->mode === 'attorney' ? 'preview-attorney-'.$key : 'preview-seller-'.$key }}"
                                                    data-target-input="{{ $value->mode === 'attorney' ? 'input-attorney-'.$key : 'input-seller-'.$key }}"
                                                    data-role="{{ $value->mode === 'attorney' ? 'attorney' : 'requester' }}"
                                                    data-user-id="{{$key}}"
                                                    data-statement="{{ $value->mode === 'attorney' ? 'statement-attorney-'.$key : 'statement-seller-'.$key }}"
                                                    data-bs-toggle="modal" data-bs-target="#cameraModal">

                                                    <input type="hidden"
                                                        id="{{ $value->mode === 'attorney' ? 'input-attorney-'.$key : 'input-seller-'.$key }}"
                                                        name="{{ $value->mode === 'attorney' ? 'attorney['.$key.'][picture]' : 'requester['.$key.'][picture]' }}">

                                                    <span>Click to add or update Picture</span>
                                                    <img id="{{ $value->mode === 'attorney' ? 'preview-attorney-'.$key : 'preview-seller-'.$key }}"
                                                        class="img-preview" src="">
                                                </div>
                                            </div>

                                            {{-- Biometric Field --}}
                                            <div class="col-md-3">
                                                <label for="">
                                                    {{ $value->mode === 'attorney' ? 'Attorney Biometric' : 'Requester
                                                    Biometric' }}
                                                </label>

                                                <div class="file-drop-area pasteButton"
                                                    data-target-img="{{ $value->mode === 'attorney' ? 'biometric-attorney-'.$key : 'biometric-requester-'.$key }}"
                                                    data-target-input="{{ $value->mode === 'attorney' ? 'biometric-attorney-'.$key : 'biometric-requester-'.$key }}"
                                                    data-target="{{ $value->mode === 'attorney' ? 'biometricImg-attorney-'.$key : 'biometricImg-requester-'.$key }}"
                                                    data-user="{{ $value->mode === 'attorney' ? 'attorney' : 'requester' }}"
                                                    data-index="{{$key}}"
                                                    data-thumb="{{ $value->mode === 'attorney' ? 'thumb-attorney-'.$key : 'thumb-requester-'.$key }}">

                                                    <span>Click to add or update Biometric</span>
                                                    <img id="{{ $value->mode === 'attorney' ? 'biometricImg-attorney-'.$key : 'biometricImg-requester-'.$key }}"
                                                        class="img-preview"
                                                        src="{{ $value->mode === 'attorney' ? asset($value->representative->biometric ?? '') : asset($value->biometric ?? '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">{{$request->request_type == 1 ? 'Buyer Attachements' :
                                            'Receiver Attachements'}}</h2>
                                    </div>
                                </div>
                                <!-- Input 1 -->
                                <div class="card shadow-sm mb-4"
                                    style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                         @if($data->shared_representative)
                                        <input type="hidden" name="shared_representative_id"
                                            value="{{$data->shared_representative_id}}">
                                        <label>Representative on behalf of {{ $request->dummyreceiver->map(fn($p) =>
                                            $p->name)->implode(',') }}</label>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>
                                                    Attorney Name
                                                </label>
                                                <input type="text" disabled class="form-control" readonly
                                                    value="{{$data->callSharedRepresentative->name }}">
                                            </div>

                                            {{-- Picture Field --}}
                                            <div class="col-md-3">
                                                <label for="">
                                                    Attorney Picture
                                                </label>

                                                <div class="file-drop-area open-camera"
                                                    data-target-img="preview-representative-0"
                                                    data-target-input="input-representative-0" data-role="representative"
                                                    data-user-id="0" data-statement="statement-representative-0"
                                                    data-bs-toggle="modal" data-bs-target="#cameraModal">

                                                    <input type="hidden" id="input-representative-0"
                                                        name="representative[0][picture]">

                                                    <span>Click to add or update Picture</span>
                                                    <img id="preview-representative-0" class="img-preview" src="">
                                                </div>
                                            </div>

                                            {{-- Biometric Field --}}
                                            <div class="col-md-3">
                                                <label for="">
                                                    Attorney Biometric
                                                </label>

                                                <div class="file-drop-area pasteButton"
                                                    data-target-img="biometric-representative-0"
                                                    data-target-input="biometric-representative-0"
                                                    data-target="biometricImg-representative-0" data-user="representative"
                                                    data-index="0" data-thumb="thumb-representative-0">

                                                    <span>Click to add or update Biometric</span>
                                                    <img id="biometricImg-representative-0" class="img-preview" src="">
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @foreach($request->dummyreceiver as $key => $value)

                                        @if($value->receiver_type == 'representative')
                                        <label>Representative on behalf of {{$value->name}}</label>
                                        @endif
                                        <div class="form-row">

                                            <div class="col-md-4">
                                                <label>
                                                    @if($value->receiver_type == 'representative')
                                                    Representative Name
                                                    @else
                                                    {{$request->request_type == 1 ? 'Buyer Name' : 'Receiver Name'}}
                                                    @endif
                                                </label>
                                                <input type="text" disabled class="form-control address" readonly
                                                    value="{{ $value->receiver_type == 'representative'?  $value->representative->name : $value->name }}"
                                                    placeholder="Enter Buyer Name">
                                            </div>

                                            {{-- Picture Upload --}}
                                            <div class="col-md-3">
                                                <label for="">
                                                    @if($value->receiver_type == 'representative')
                                                    Representative Picture
                                                    @else
                                                    {{$request->request_type == 1 ? 'Buyer Picture' : 'Receiver
                                                    Picture'}}
                                                    @endif
                                                </label>
                                                <div class="file-drop-area open-camera"
                                                    data-target-img="{{ $value->receiver_type == 'representative' ? 'preview-representative-'.$key : 'preview-buyer-'.$key }}"
                                                    data-target-input="{{ $value->receiver_type == 'representative' ? 'input-representative-'.$key : 'input-buyer-'.$key }}"
                                                    data-role="{{ $value->receiver_type == 'representative' ? 'representative' : 'buyer' }}"
                                                    data-user-id="{{ $key }}"
                                                    data-statement="{{ $value->receiver_type === 'representative' ? 'statement-representative-'.$key : 'statement-buyer-'.$key }}"
                                                    data-bs-toggle="modal" data-bs-target="#cameraModal">

                                                    <input type="hidden"
                                                        id="{{ $value->receiver_type == 'representative' ? 'input-representative-'.$key : 'input-buyer-'.$key }}"
                                                        name="{{ $value->receiver_type == 'representative' ? "representative[$key][picture]" : "receiver[$key][picture]" }}">

                                                    <span>Click to add or update Picture</span>
                                                    <img id="{{ $value->receiver_type == 'representative' ? 'preview-representative-'.$key : 'preview-buyer-'.$key }}"
                                                        class="img-preview" src="{{ $value->picture ?? '#' }}" />
                                                </div>
                                            </div>

                                            {{-- Biometric Upload --}}
                                            <div class="col-md-3">
                                                <label for="">
                                                    @if($value->receiver_type == 'representative')
                                                    Representative Biometric
                                                    @else
                                                    {{$request->request_type == 1 ? 'Buyer Biometric' : 'Receiver
                                                    biometric'}}
                                                    @endif
                                                </label>
                                                <div class="file-drop-area pasteButton"
                                                    data-target-img="{{ $value->receiver_type == 'representative' ? 'biometricImg-representative-'.$key : 'biometric-buyer-'.$key }}"
                                                    data-target-input="{{ $value->receiver_type == 'representative' ? 'biometric-representative-'.$key : 'biometric-buyer-'.$key }}"
                                                    data-target="{{ $value->receiver_type == 'representative' ? 'biometricImg-representative-'.$key : 'biometricImg-buyer-'.$key }}"
                                                    data-user="{{ $value->receiver_type ==  'representative' ? 'representative' : 'receiver' }}"
                                                    data-thumb="{{ $value->receiver_type === 'representative' ? 'thumb-representative-'.$key : 'thumb-buyer-'.$key }}"
                                                    data-index="{{ $key }}">


                                                    <span>Click to add or update Biometric</span>
                                                    <img id="{{ $value->receiver_type ==  'representative' ? 'biometricImg-representative-'.$key : 'biometricImg-buyer-'.$key }}"
                                                        class="img-preview" src="{{ $value->biometric ?? '#' }}" />
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Witness Attachements:</h2>
                                    </div>
                                </div>
                                <!-- Input 1 -->
                                <div class="card shadow-sm mb-4"
                                    style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                        @foreach($request->dummywitness as $key => $value)
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>Witness Name</label>
                                                <input type="text" disabled class="form-control address" name="buyer_name"
                                                    readonly placeholder="Enter Buyer Name" value="{{$value->name}}"
                                                    onchange="change(this)">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Picture</label>
                                                <div class="file-drop-area open-camera"
                                                    data-target-img="preview-witness-{{$key}}"
                                                    data-target-input="input-witness-{{$key}}" data-role="witness"
                                                    data-user-id="{{$key}}" data-statement="statement_witness_{{$key}}"
                                                    data-bs-toggle="modal" data-bs-target="#cameraModal">
                                                    <input type="hidden" id="input-witness-{{$key}}"
                                                        name="witness[{{$key}}][picture]">
                                                    <span>CLick to add or update Picture</span>
                                                    <img id="preview-witness-{{$key}}" class="img-preview" src="#" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Biometric</label>
                                                <div class="file-drop-area pasteButton"
                                                    data-target-img="biometric-witness-{{$key}}"
                                                    data-target-input="biometric-witness-{{$key}}"
                                                    data-target="biometric-witness-{{$key}}" data-user="witness"
                                                    data-index="{{$key}}" data-thumb="thumb-witness-{{$key}}">
                                                    <span>CLick to add or update Picture</span>
                                                    <img id="biometric-witness-{{$key}}" class="img-preview" src="#" />
                                                </div>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <input type="hidden" id="biometric" name="biometrics" value="">
                                <input type="hidden" id="transfer_file_id" name="id" value="{{$data->id}}">
                                <input type="hidden" id="property_id" name="property_id" value="{{$data->property_id}}">
                            </div>
                            <div class="modal fade" id="thumbModal" tabindex="-1" aria-labelledby="thumbModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-center p-4">
                                        <div id="modalIcon" class="mb-3">
                                            <!-- Icons will be injected here -->
                                            <div class="spinner-border text-primary" role="status"
                                                style="width: 3rem; height: 3rem;"></div>
                                        </div>
                                        <div id="modalMessage" class="fs-5 fw-semibold">Please place thumb on device...
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Next" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                        </fieldset>
                        <fieldset id="third-step">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Seller's and Witnesses Statements:</h2>
                                    </div>
                                    <div class="col-5">

                                    </div>
                                </div>

                                @if(!is_null($data->any_attorney) && is_null($data->shared_attorney))

                                @include('DD.drafts.multipleSellerWithAttorey', [
                                'request' => $request,
                                'property' => $property,
                                'data' => $data
                                ])
                                @elseif(!is_null($data->any_attorney) && !is_null($data->shared_attorney))


                                @include('DD.drafts.shareAttorney', [
                                'request' => $request,
                                'property' => $property,
                                'data' => $data
                                ])
                                @elseif(is_null($data->any_attorney) && is_null($data->shared_attorney))
                                @include('DD.drafts.oneSeller', [
                                'request' => $request,
                                'property' => $property,
                                'data' => $data,
                                'previous' => $previous
                                ])
                                @endif



                            </div>
                            <input type="button" name="next" class="next action-button" value="Next" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                        </fieldset>
                        <fieldset id="fourth-step">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Buyer Statements:</h2>
                                    </div>
                                    <div class="col-5">

                                    </div>
                                </div>
                                <!-- Input 1 -->

                                @include('DD.drafts.oneBuyer',['property'=>$property,'data'=>$data,'request'=>$request])


                            </div>
                            <input type="submit" name="" class="action-button submit " value="Submit" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                        </fieldset>
                        <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow rounded-3">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">Capture Photo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <video id="camera" autoplay playsinline width="100%"
                                            class="rounded border mb-3"></video>
                                        <button id="capture-btn" type="button" class="btn btn-success">Capture</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="snapshot_step3" id="snapshot_step3">
                        <input type="hidden" name="snapshot_step4" id="snapshot_step4">
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    </script>
    <script>
        document.querySelectorAll('.pasteButton').forEach((e,i) => {

           e.addEventListener('click', async (el) => {
               try {
        // Read clipboard items
        const clipboardItems = await navigator.clipboard.read();
        for (const item of clipboardItems) {
            for (const type of item.types) {
                if (type.startsWith('image/')) {
                    const blob = await item.getType(type);
                    const file = new File([blob], 'screenshot.png', { type: blob.type });

                    // Assign file to input
                    // const dataTransfer = new DataTransfer();
                    // dataTransfer.items.add(file);
                    // document.querySelectorAll('.imgthumb')[0].files = dataTransfer.files;

                    // Read file and show preview
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const preview = document.querySelectorAll('.img-thumb')[i];

                        preview.src = event.target.result; // Corrected this line
                    };

                    reader.onerror = function (error) {
                        console.error("Error reading file:", error);
                    };

                    reader.readAsDataURL(file); // Convert file to Base64 URL
                }
            }
        }
    } catch (error) {
        console.error("Failed to access clipboard:", error);
        alert("Clipboard access failed. Please allow clipboard permissions.");
    }
});
});

    </script>

    <script>
        const video = document.getElementById('camera');
  const captureBtn = document.getElementById('capture-btn');


  // Store dynamic target references
  let currentTargetImg = null;
  let currentTargetInput = null;
  let currentTargetRole = null;
  let currentTargetStatement = null;

  // Open camera when any "open-camera" button is clicked
  document.querySelectorAll('.open-camera').forEach(button => {

    button.addEventListener('click', () => {


      currentTargetImg = document.getElementById(button.dataset.targetImg);

      currentTargetInput = document.getElementById(button.dataset.targetInput);
      currentTargetStatement = document.getElementById(button.dataset.statement);
        console.log(button.dataset.statement,currentTargetStatement);
      // Start camera
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
          video.srcObject = stream;
        })
        .catch(err => {
          console.error("Camera access error:", err);
        });
    });
  });

  // Stop camera when modal is closed
  document.getElementById('cameraModal').addEventListener('hidden.bs.modal', () => {
    const stream = video.srcObject;
    if (stream) {
      stream.getTracks().forEach(track => track.stop());
      video.srcObject = null;
    }

    currentTargetImg = null;
    currentTargetInput = null;
  });

  // Capture image
  captureBtn.addEventListener('click', () => {
    if (!currentTargetImg || !currentTargetInput) return;

    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    const imgData = canvas.toDataURL('image/png');

    // Assign to target image and input
    currentTargetImg.src = imgData;
    console.log(currentTargetStatement,currentTargetImg);
    currentTargetInput.value = imgData;
    currentTargetStatement.src = imgData;

    // Close modal
    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('cameraModal'));
    modalInstance.hide();
  });

    </script>

    <script>
        $(document).ready(function(){

    var current_fs, next_fs, previous_fs; // fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;



    // Handle next button clicks
    $(".next").click(function () {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        let isValid = true;
        // ✅ initialize progress bar
    setProgressBar(current);
    if (current === 3) {
        const elements = document.getElementsByClassName('name');
        Array.from(elements).forEach(el => {
            el.classList.toggle('move-line');
        });
        takeSnapshot("document-container1", "snapshot_step3");
}

// Take snapshot for step 4
if (current === 4) {
    takeSnapshot("document-container2", "snapshot_step4");
}



        // Mark the next step as active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        // Show the next fieldset
        next_fs.show();

        // Hide the current fieldset with animation
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                var opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({ 'opacity': opacity });
            },
            duration: 500
        });

        // ✅ increment current step
        setProgressBar(++current);
        // Take snapshot for step 3



    });
    $(".submit").click(function (e) {
    e.preventDefault(); // Stop normal submit
const elements = document.getElementsByClassName('name');
    Array.from(elements).forEach(el => {
      el.classList.toggle('move-line');
    });
    // ✅ Take snapshot of the final div before submitting
    takeSnapshot('document-container2', 'snapshot_step4', function () {
        // After snapshot is ready, submit the form
        $("#msform").submit();
    });
});

    function takeSnapshot(divId, hiddenInputId,callback) {
    const element = document.getElementById(divId);

    html2canvas(element, {
        useCORS: true,        // Allow cross-origin images
        logging: true,        // Debugging
        scale: 2              // Better quality
    }).then(canvas => {
        const dataURL = canvas.toDataURL('image/png');
        document.getElementById(hiddenInputId).value = dataURL;
        console.log("Snapshot saved to hidden input", hiddenInputId);
        if (typeof callback === "function") callback(); // Call after done
    }).catch(err => {
        console.error("Snapshot failed:", err);
    });

    const elements = document.getElementsByClassName('name');
        Array.from(elements).forEach(el => {
            el.classList.remove('move-line');
        });
}
    // Handle previous button clicks
    $(".previous").click(function(){
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        // Remove active class from current step
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        // Show previous fieldset
        previous_fs.show();

        // Hide current fieldset with animation
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            },
            duration: 500
        });

        // ✅ decrement current step
        setProgressBar(--current);
    });

    function setProgressBar(curStep){
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar").css("width",percent+"%");
    }


});
    </script>
    <script>
        // ✅ Preload thumbData structure
    let thumbData = {
        requester: {},
        witness: {},
        receiver: {},
        representative: {},
        attorney: {},
    };

    document.getElementById('biometric').value = JSON.stringify(thumbData);
    </script>
    <script>
        document.querySelectorAll('.pasteButton').forEach(button => {
    button.addEventListener('click', function () {
        const imgId = this.getAttribute('data-target');
        const userType = this.getAttribute('data-user'); // seller, buyer, witness, receiver
        const index = this.getAttribute('data-index'); // 0,1,2...
        const thumb = this.getAttribute('data-thumb');

        // Build dynamic IDs for CNIC and thumb
        const cnicInput = document.getElementById(`${userType}_cnic_${index}`);
        const thumbImg = document.getElementById(imgId);
        const statementElement = document.getElementById(thumb);
        console.log(thumb,statementElement);


        const cnic = cnicInput ? cnicInput.value : '';
        const imgElement = document.getElementById(imgId);

        // Bootstrap modal
        const modal = new bootstrap.Modal(document.getElementById('thumbModal'));
        const modalIcon = document.getElementById('modalIcon');
        const modalMessage = document.getElementById('modalMessage');

        // Show modal loading state
        modalIcon.innerHTML = `<div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>`;
        modalMessage.textContent = 'Please place thumb on device...';
        modal.show();

        this.disabled = true;
        this.querySelector('span').textContent = 'Processing...';

        fetch('http://localhost:9099/api/GetImage', { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.Status && data.ImgBase64) {
                // ✅ Display captured thumb
                imgElement.src = `data:image/bmp;base64,${data.ImgBase64}`;
                thumbImg.src = `data:image/bmp;base64,${data.ImgBase64}`;
                statementElement.src = `data:image/bmp;base64,${data.ImgBase64}`;


                // ✅ Store data dynamically in thumbData
                if (!thumbData[userType]) {
                    thumbData[userType] = []; // make it an array
                }

                thumbData[userType][index] = {
                    image: data.ImgBase64,
                    cnic: cnic,
                    code: data.Code,
                    template: data.TemplateBase64 || null,
                    deviceType: data.DeviceType || 'Unknown',
                    status: true,
                    timestamp: new Date().toISOString()
                };

                console.log(`Stored for ${userType}[${index}]`, thumbData[userType][index]);


                // Update hidden input for backend
                document.getElementById('biometric').value = JSON.stringify(thumbData);

                // ✅ Success UI
                modalIcon.innerHTML = `<i class="fas fa-check-circle icon-check"></i>`;
                modalMessage.textContent = 'Thumb captured successfully!';
            } else {
                modalIcon.innerHTML = `<i class="fas fa-times-circle icon-cross"></i>`;
                modalMessage.textContent = data.Message || 'Failed to capture thumb';
            }
        })
        .catch(error => {
            modalIcon.innerHTML = `<i class="fas fa-times-circle icon-cross"></i>`;
            modalMessage.textContent = 'Device not responding ❌';
            console.error('AJAX Error:', error);
        })
        .finally(() => {
            setTimeout(() => {
                modal.hide();
                this.disabled = false;
                this.querySelector('span').textContent = 'Click to update Picture';
            }, 1500);
            console.log(thumbData);
        });
    });
});






    </script>

    <script>
        function change(that){

        if(that.name== 'buyer_address'){
            document.getElementById('buyer_statement_address').innerHTML = `${that.value}:سکونت`;
        }
        if(that.name== 'seller_address'){
            document.getElementById('seller_statement_address').innerHTML = `${that.value}:سکونت`;
        }
        if(that.name== 'first_witness_name'){
            document.getElementById('witness1_declare').innerHTML = `${that.value}`;
        }
        if(that.name== 'first_witness_father_name'){
            document.getElementById('witness1_father').innerHTML = that.value;
        }
        if(that.name== 'first_witness_cnic'){
            document.getElementById('witness1_dcnic').innerHTML = `${that.value}`;
        }
        if(that.name== 'first_witness_address'){
            document.getElementById('witness1_address').innerHTML = `${that.value}`;
        } if(that.name== 'second_witness_name'){
            document.getElementById('witness2_declare').innerHTML = `${that.value}`;
        }
        if(that.name== 'second_witness_father_name'){
            document.getElementById('witness2_father').innerHTML = that.value;
        }
        if(that.name== 'second_witness_cnic'){
            document.getElementById('witness2_dcnic').innerHTML = `${that.value}`;
        }
        if(that.name== 'second_witness_address'){
            document.getElementById('witness2_address').innerHTML = `${that.value}`;
        }

    }
    </script>
    <script>
        document.querySelectorAll('.view-cnic').forEach(link => {
    link.addEventListener('click', function () {
      const front = this.getAttribute('data-front');
      const back = this.getAttribute('data-back');
      document.getElementById('cnic-front').src = front;
      document.getElementById('cnic-back').src = back;
    });
  });
    </script>
    <script>
        const names = document.querySelectorAll('.name');
    const container = document.getElementById('names');
    let isDown = false;

    container.style.cursor = 'crosshair';

    names.forEach(el => {
      el.addEventListener('click', ()=>{
        el.classList.toggle('strike');
      });
    });

    container.addEventListener('mousedown', (e)=>{
      if(e.button!==0) return;
      isDown = true;
      e.preventDefault();
    });

    document.addEventListener('mouseup', ()=> isDown = false);

    names.forEach(el=>{
      el.addEventListener('mouseenter', ()=>{
        if(!isDown) return;
        el.classList.toggle('strike');
      });
    });
    </script>






</x-app-layout>
