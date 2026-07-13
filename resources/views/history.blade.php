<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        p {
            color: grey
        }

        body {
            background: #F4F6F9;
        }

        #heading {
            text-transform: uppercase;
            color: #03346E;
            font-weight: bolder;
            font-size: 1.5rem;
            text-align: center;
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px;
            /* margin-bottom: 20px */
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px !important;
            position: relative
        }

        #first-step {
            padding-bottom: 20px !important;
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
            background-color: #ECEFF1;
            font-size: 16px;
            letter-spacing: 1px
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

        .fs-titlecopy {
            font-size: 20px;
            font-weight: 600 !important;
            color: #03346E;
            margin-bottom: 10px;
            margin-top: 10px;
            font-weight: normal;
            text-align: left
        }

        .fs-titlecopy.subheading {
            color: #1d5faf;
            font-size: 18px;
            font-weight: 600 !important;
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
            text-align: left;

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
            width: 50%;
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
            left: 0;
            top: 0;
            width: 100%;
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

        fieldset a {
            color: #3498db !important;
        }

        .detail-item {
            /* margin-bottom: rem; */
        }

        .detail-item label {
            font-weight: bold;
            font-size: 1.1em;
        }

        .detail-item p {
            margin: 0;
            font-size: 1.03em;
        }

        .content-wrapper1 {
            display: flex;
            justify-content: center;
            min-height: calc(100vh - 4rem);
            margin-left: 0px;

        }

        .property-container {
            width: 100%;
            max-width: 1000px;
            /* Changed from 2xl to a fixed width */
        }
    </style>
    <style>
        .tabs-header {
            display: flex;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 24px;
        }

        .tab-button {
            padding: 18px 24px;
            background: none;
            border: none;
            font-size: 16px;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-button:hover {
            color: #334155;
            background: rgba(99, 102, 241, 0.05);
        }

        .tab-button.active {
            color: #4338ca;
            font-weight: 600;
        }

        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 3px;
            background: #4338ca;
            border-radius: 3px 3px 0 0;
            animation: slideIn 0.3s ease;
        }

        /* Tab Icon */
        .tab-icon {
            font-size: 18px;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            padding: 32px;
            animation: fadeIn 0.4s ease;
        }

        .tab-content.active {
            display: block;
        }


        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        /* Tab 2 Specific */
        .feature-list {
            list-style: none;
            margin-top: 24px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .feature-item:last-child {
            border-bottom: none;
        }

        .feature-icon {
            color: #4338ca;
            font-size: 20px;
            flex-shrink: 0;
        }

        .feature-text {
            color: #475569;
            line-height: 1.6;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }

        /* Responsive */
        @media (max-width: 640px) {
            .tabs-header {
                padding: 0 16px;
                flex-direction: column;
            }

            .tab-button {
                padding: 16px;
                justify-content: center;
                border-bottom: 1px solid #e2e8f0;
            }

            .tab-button.active::after {
                display: none;
            }

            .tab-button.active {
                background: rgba(99, 102, 241, 0.1);
                border-left: 3px solid #4338ca;
            }

            .tab-content {
                padding: 24px 20px;
            }


        }

        /* Alternative Style - Rounded Tabs */
        .tabs-container.rounded {
            border-radius: 12px;
        }

        .tabs-container.rounded .tabs-header {
            background: white;
            border-bottom: none;
            padding: 8px 8px 0 8px;
        }

        .tabs-container.rounded .tab-button {
            border-radius: 8px 8px 0 0;
            margin-right: 4px;
        }

        .tabs-container.rounded .tab-button.active {
            background: white;
            box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.05);
        }

        .tabs-container.rounded .tab-button.active::after {
            display: none;
        }

        /* Alternative Style - Minimal */
        .tabs-container.minimal .tabs-header {
            background: white;
            justify-content: center;
            gap: 40px;
        }

        .tabs-container.minimal .tab-button {
            padding: 20px 0;
            position: relative;
        }

        .tabs-container.minimal .tab-button.active::after {
            height: 2px;
            background: #4338ca;
        }
    </style>
    <style>
        /* HEADER STYLE */
        .custom-header {
            background: #f3f4f5;
            cursor: pointer;
            padding: 12px 16px;
        }

        /* REMOVE BUTTON STYLE */
        .custom-header button {
            width: 100%;
            text-align: left;
            text-decoration: none;
            color: #000;
            padding: 0;
        }

        /* ICON */
        .custom-header .icon {
            float: right;
            transition: transform 0.3s ease;
        }

        /* ROTATE WHEN OPEN */
        .custom-header button[aria-expanded="true"] .icon {
            transform: rotate(180deg);
        }

        .attachment-pill {
            margin-top: 15px;
            margin-bottom: 15px;
            display: inline-flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 25px;
            padding: 4px 12px 4px 4px;
            text-decoration: none;
            color: #212529;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.25s ease;
            border: 1px solid #dee2e6;
        }

        .attachment-pill:not(:nth-child(1)) {
            margin-left: 10px;
        }

        /* Icon box */
        .attachment-pill .file-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3A9ADB;
            /* margin-right: 8px; */
            font-size: 16px;
        }

        .attachment-pill .file-name {
            font-size: 15px !important;
        }

        /* Hover effect */
        .attachment-pill:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
            background: #fff;
        }
    </style>
    <div class="py-8 my-4">
        <div class="content-wrapper1">
            <div class="property-container">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                    <div class="row">
                        <div class="col">
                            <div class="tabs-header">
                                <button class="tab-button active" data-tab="tab1">
                                    <i class="fas fa-chart-line tab-icon"></i>
                                    <span>Current Owner</span>
                                </button>
                                <button class="tab-button" data-tab="tab2">
                                    <i class="fas fa-cogs tab-icon"></i>
                                    <span>Property Transactions</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row tab-content active" id="tab1">

                        <div class="col-12">
                            <div class="card px-4 pt-4 pb-0 mt-3 mb-3">
                                <h2 id="heading">Mangla Dam Housing Authority</h2>
                                <p class="text-center">Property Detail</p>
                                {{-- <form id="msform" action="{{route('formUpdate',$id)}}" method="POST"
                                    enctype="multipart/form-data"> --}}
                                    {{-- @csrf --}}

                                    <fieldset id="first-step">
                                        <div class="form-card">

                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">Location:</h2>
                                                </div>

                                            </div>


                                            <div class="form-row">

                                                <div class="detail-item col-md-3">
                                                    <label for="name">District:</label>
                                                    <p id="name">{{$property->district}}</p>

                                                </div>
                                                <div class="detail-item col-md-3">
                                                    <label for="address">Centre:</label>
                                                    <p id="address">{{$property->center}}</p>
                                                </div>
                                                <div class="detail-item col-md-3">
                                                    <label for="phone">Locality/Revenue Village:</label>
                                                    <p id="phone">{{$property->locality}}</p>
                                                </div>
                                                <div class="detail-item col-md-3">
                                                    <label class="">Code</label>
                                                    <p id="phone">{{$property->code}}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">Dwelling House:</h2>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class=" col-md-8">
                                                    <label for="name">Area Measurement</label>
                                                    <div class="row">
                                                        <div class="detail-item col">
                                                            <label class="">Acre</label>
                                                            <p id="phone">{{$property->dm_acre ?? 0}}</p>
                                                        </div>
                                                        <div class="detail-item col">
                                                            <label class="">Kanal</label>
                                                            <p id="phone">{{$property->dm_kanal ?? 0}}</p>
                                                        </div>
                                                        <div class="detail-item col">
                                                            <label class="">Marla</label>
                                                            <p id="phone">{{$property->dm_marla ?? 0}}</p>
                                                        </div>
                                                        <div class="detail-item col">
                                                            <label class="">Squarefeet</label>
                                                            <p id="phone">{{$property->dm_sqrft ?? 0}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">New Allotment:</h2>
                                                </div>
                                            </div>
                                            <div class="form-row">

                                                <div class="detail-item col-md-4">
                                                    <label class="" style="margin-top:33px;">Category</label>
                                                    <p id="phone">{{$property->category}}</p>
                                                </div>
                                                <div class=" col-md-8">
                                                    <label for="name">Area Measurement</label>
                                                    <div class="row">
                                                        <div class="detail-item col">
                                                            <label class="">Acre</label>
                                                            <p id="phone">{{$property->acre ?? 0}}</p>
                                                        </div>
                                                        <div class="detail-item col">
                                                            <label class="">Kanal</label>
                                                            <p id="phone">{{$property->kanal ?? 0}}</p>
                                                        </div>
                                                        <div class="detail-item col">
                                                            <label class="">Marla</label>
                                                            <p id="phone">{{$property->marla ?? 0}}</p>
                                                        </div>
                                                        <div class="detail-item col">
                                                            <label class="">Squarefeet</label>
                                                            <p id="phone">{{$property->dm_sqrft ?? 0}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">

                                                <div class="detail-item col-md-3  ">
                                                    <label for="name">Allotment Order No</label>
                                                    <p id="phone">{{$property->allotment_order ?? 'N/A'}}</p>

                                                </div>

                                                <div class="detail-item col-md-3">
                                                    <label for="name">Town/City</label>
                                                    @php
                                                    $town = DB::table('towns')->where('id',$property->town)->first()
                                                    @endphp
                                                    <p id="phone">{{$town->name}}</p>

                                                </div>
                                                <div class="detail-item col-md-3  ">
                                                    <label for="name">Plot No</label>
                                                    <p id="phone">{{$property->plot_no}}</p>

                                                </div>
                                                <div class="detail-item col-md-3 ">
                                                    <label for="name">Sector</label>
                                                    <p id="phone">{{$property->sector}}</p>

                                                </div>


                                            </div>



                                        </div>


                                        {{-- < class="form-card"> --}}

                                            <div class="form-row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">Current Owner :</h2>
                                                </div>
                                            </div>
                                            @foreach($property->owners as $key => $value)
                                                
                                            <div class="form-row">
                                                
                                                <div class="detail-item col-md-3  ">
                                                    <label for="name">Owner Name</label>
                                                    <p id="phone">{{$value->name}}</p>

                                                </div>
                                                <div class=" detail-item col-md-3">
                                                    <label for="name">Relation</label>
                                                    <p id="phone">{{$value->father_name}}</p>

                                                </div>
                                                <div class=" detail-item col-md-3 " id="bps">
                                                    <label for="name">CNIC</label>
                                                    
                                                    <p id="phone">{{$value->cnic}}</p>
                                                    
                                                </div>
                                                <div class=" detail-item col-md-3 " id="bps">
                                                    <label for="name">Area</label>
                                                    
                                                    <p id="phone">{{$value->area}} Marla</p>
                                                    
                                                </div>
                                                <div class=" detail-item col-md-6 " id="bps">
                                                    <label for="name">Address</label>
                                                    
                                                    <p id="phone">{{$value->address ?? 'N/A'}}</p>
                                                    
                                                </div>
                                                
                                                
                                            </div>
                                            @endforeach
                                            {{-- Check if there is a request at all and if it contains any documents --}}
                                            @if($latestOrder->isNotEmpty() || $latestTransfer->isNotEmpty())
                                                <div class="form-row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Transaction Attachments :</h2>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="d-flex flex-wrap gap-2">
                                                            
                                                            {{-- 1. Transfer Order (from latestOrder) --}}
                                                            @if(isset($latestOrder['file_path']))
                                                                <a href="/view-transfer-order/{{$latestOrder['request_id']}}" target="_blank" class="attachment-pill pdf">
                                                                    <span class="file-icon"><i class="fa-solid fa-file-pdf"></i></span>
                                                                    <span class="file-name">Transfer Order</span>
                                                                </a>
                                                            @endif

                                                            {{-- 2. Seller Statement (from latestTransfer) --}}
                                                            @if(!empty($latestTransfer['seller_declaration']))
                                                                <a href="{{ asset('uploads/user/statement/' . $latestTransfer['seller_declaration']) }}" target="_blank" class="attachment-pill pdf">
                                                                    <span class="file-icon"><i class="fa-solid fa-image"></i></span>
                                                                    <span class="file-name">Seller Statement</span>
                                                                </a>
                                                            @endif

                                                            {{-- 3. Buyer Statement (from latestTransfer) --}}
                                                            {{-- Assuming the key is 'buyer_declaration' based on your logic --}}
                                                            @if(!empty($latestTransfer['buyer_declaration']))
                                                                <a href="{{ asset('uploads/user/statement/' . $latestTransfer['buyer_declaration']) }}" target="_blank" class="attachment-pill pdf">
                                                                    <span class="file-icon"><i class="fa-solid fa-image"></i></span>
                                                                    <span class="file-name">Buyer Statement</span>
                                                                </a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                           
                                            @endif


                                    </fieldset>

                                    {{--
                                </form> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row tab-content" id="tab2">

                        <div class="col-12">
                            <div class="card px-4 pt-4 pb-0 mt-3 mb-3">
                                <h2 id="heading">Mangla Dam Housing Authority</h2>
                                <p class="text-center mb-1">Property Detail</p>


                                <fieldset id="first-step">

                                    <div id="accordion">

                                        <!-- CARD 1 -->
                                        @foreach($requests as $key1 => $request)
                                            
                                        
                                        <div class="card">
                                            <div class="card-header custom-header" id="headingOne">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                    data-target="#collapse{{$key1}}" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    Property Transfer
                                                    <i class="fas fa-chevron-down icon"></i>
                                                </button>
                                            </div>

                                            <div id="collapse{{$key1}}" class="collapse  mx-3"
                                                aria-labelledby="headingOne" data-parent="#accordion">

                                                <div class="form-row ">
                                                    <div class="col-7">
                                                        <h2 class="fs-titlecopy">Front Desk Application :</h2>
                                                    </div>
                                                    <div class="col-span-2 offset-2 col-3">
                                                        <span class="badge badge-primary text-right p-2">
                                                            Akbar ali
                                                        </span>
                                                    </div>

                                                </div>
                                                @foreach($request->participants as $key => $value)
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label>Requester Name</label>
                                                        <div class="info-value">{{ $value->owner->name ?? 'N/A' }}</div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Requester's Father Name</label>
                                                        <div class="info-value">{{ $value->owner->father_name ?? 'N/A'
                                                            }}</div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Requester's CNIC</label>
                                                        <div class="info-value">{{ $value->owner->cnic ?? 'N/A' }}</div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Requester's Address</label>
                                                        <div class="info-value">{{ $value->owner->address ?? 'N/A' }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Requester's Area</label>
                                                        <div class="info-value">{{ $value->owner->area ?
                                                            $value->owner->area . ' Marla' :
                                                            'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label>Requester's Attachements</label>
                                                        <br>

                                                        <div class="d-flex flex-wrap gap-2">
                                                            @if(!empty($value->owner->picture))
                                                            <a href="{{ asset('uploads/user/images/'.$value->owner->picture) }}"
                                                                target="_blank" class="attachment-pill image">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-file-pdf"></i>
                                                                </span>
                                                                <span class="file-name">Person Picture</span>
                                                            </a>
                                                            
                                                            @endif
                                                            @if(!empty($value->owner->cnic_front))
                                                            <a href="{{ asset('uploads/user/cnics/'.$value->owner->cnic_front) }}"
                                                                target="_blank" class="attachment-pill pdf">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-image"></i>
                                                                </span>
                                                                <span class="file-name">Cnic Front</span>
                                                            </a>
                                                            
                                                            
                                                            @endif

                                                            @if(!empty($value->owner->cnic_back))
                                                            <a href="{{ asset('uploads/user/cnics/'.$value->owner->cnic_back) }}"
                                                                target="_blank" class="attachment-pill image">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-file-pdf"></i>
                                                                </span>
                                                                <span class="file-name">Cnic Back</span>
                                                            </a>
                                                            
                                                            @endif
                                                            @if(!empty($value->owner->biometric_id) && !empty($value->owner->biometric->image))
                                                                    <a href="javascript:void(0)" 
                                                                    onclick="openBiometric('{{ $value->owner->biometric->image }}')" 
                                                                    class="attachment-pill image">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-id-card"></i>
                                                                        </span>
                                                                        <span class="file-name">View Biometric</span>
                                                                    </a>
                                                                @endif


                                                        </div>
                                                    </div>


                                                    @if(is_null($request->transfer->shared_attorney))
                                                    @if($value->representative)
                                                    <div class="col-md-12">
                                                        <div class="card shadow-sm mb-4 mx-4"
                                                            style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                                            <div class="card-body">
                                                                <label>Attorney on behalf of {{ $value->owner->name ??
                                                                    'N/A' }}</label>
                                                                <div class="form-row">
                                                                    <div class="col-md-4">
                                                                        <label>Attorney Name</label>
                                                                        <div class="info-value">{{
                                                                            $value->representative->name ?? 'N/A' }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label>Attorney's Father Name</label>
                                                                        <div class="info-value">{{
                                                                            $value->representative->father_name ??
                                                                            'N/A' }}</div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label>Attorney's CNIC</label>
                                                                        <div class="info-value">{{
                                                                            $value->representative->cnic ?? 'N/A' }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label>Attorney's Address</label>
                                                                        <div class="info-value">{{
                                                                            $value->representative->address ?? 'N/A'
                                                                            }}</div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label>Attorney's Letter</label>
                                                                        <br>

                                                                        @if(!empty($value->representative->attorney_letter))
                                                                        <a href="{{ asset('uploads/user/representative/letter/'.$value->representative->attorney_letter) }}"
                                                                            target="_blank" class="attachment-pill pdf">
                                                                            <span class="file-icon">
                                                                                <i class="fa-solid fa-image"></i>
                                                                            </span>
                                                                            <span class="file-name">Attorney
                                                                                Letter</span>
                                                                        </a>
                                                                        @else
                                                                        <div class="info-value">No Attorney Letter</div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Attorney's CNIC Attachements</label>
                                                                        <br>


                                                                        @if(!empty($value->representative->cnic_front))
                                                                        <a href="{{ asset('uploads/user/representative/cnics/'.$value->representative->cnic_front) }}"
                                                                            target="_blank" class="attachment-pill pdf">
                                                                            <span class="file-icon">
                                                                                <i class="fa-solid fa-image"></i>
                                                                            </span>
                                                                            <span class="file-name">Cnic Front</span>
                                                                        </a>
                                                                        @else
                                                                        <div class="info-value">No CNIC Front</div>
                                                                        @endif
                                                                        @if(!empty($value->representative->cnic_back))
                                                                        <a href="{{ asset('uploads/user/representative/cnics/'.$value->representative->cnic_back) }}"
                                                                            target="_blank" class="attachment-pill pdf">
                                                                            <span class="file-icon">
                                                                                <i class="fa-solid fa-image"></i>
                                                                            </span>
                                                                            <span class="file-name">Cnic Back</span>
                                                                        </a>
                                                                        @else
                                                                        <div class="info-value">No CNIC Back</div>
                                                                        @endif


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endif
                                                </div>
                                                @endforeach

                                                @if(!is_null($request->transfer->shared_attorney))
                                                <div class="form-row">
                                                    <div class="card shadow-sm mb-4 mx-2"
                                                        style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                                        <div class="card-body">
                                                            <label>Attorney on behalf of {{
                                                                $request->participants->map(fn($p) =>
                                                                $p->owner->name)->implode(', ') }}</label>
                                                            <div class="form-row">
                                                                <div class="col-md-4">
                                                                    <label>Attorney Name</label>
                                                                    <div class="info-value">{{
                                                                        $request->transfer->callAttorney->name ??
                                                                        'N/A' }}</div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Attorney's Father Name</label>
                                                                    <div class="info-value">{{
                                                                        $request->transfer->callAttorney->father_name
                                                                        ?? 'N/A' }}</div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Attorney's CNIC</label>
                                                                    <div class="info-value">{{
                                                                        $request->transfer->callAttorney->cnic ??
                                                                        'N/A' }}</div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Attorney's Address</label>
                                                                    <div class="info-value">{{
                                                                        $request->transfer->callAttorney->address ??
                                                                        'N/A' }}</div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Attorney's Letter</label>
                                                                    <br>
                                                                    @if(!empty($request->transfer->callAttorney->attorney_letter))
                                                                    <a href="{{ asset('uploads/user/representative/letter/'.$request->transfer->callAttorney->attorney_letter) }}"
                                                                        target="_blank">Click to View Letter</a>
                                                                    @else
                                                                    <div class="info-value">No Letter</div>
                                                                    @endif

                                                                    @if(!empty($request->transfer->callAttorney->attorney_letter))
                                                                    <a href="{{ asset('uploads/user/representative/letter/'.$request->transfer->callAttorney->attorney_letter) }}"
                                                                        target="_blank" class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">Attorney Letter</span>
                                                                    </a>
                                                                    @else
                                                                    <div class="info-value">No Attorney Letter</div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Attorney's CNIC Attachements</label>
                                                                    <br>
                                                                    
                                                                    @if(!empty($request->transfer->callAttorney->cnic_front))
                                                                    <a href="{{ asset('uploads/user/representative/cnics/'.$request->transfer->callAttorney->cnic_back) }}"
                                                                        target="_blank" class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">Cnic Front</span>
                                                                    </a>
                                                                    @else
                                                                    <div class="info-value">No CNIC Front</div>
                                                                    @endif
                                                                    @if(!empty($request->transfer->callAttorney->cnic_back))
                                                                    <a href="{{ asset('uploads/user/representative/cnics/'.$request->transfer->callAttorney->cnic_back) }}"
                                                                        target="_blank" class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">Cnic Back</span>
                                                                    </a>
                                                                    @else
                                                                    <div class="info-value">No CNIC Back</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="info-label">Transferee Name:</label>
                                                        <div class="info-value">{{$request->transfer->buyer_name}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="info-label">Transferee's Father Name:</label>
                                                        <div class="info-value">{{$request->transfer->buyer_fname}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="info-label">Transferee's CNIC:</label>
                                                        <div class="info-value">{{$request->transfer->buyer_cnic}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Transferee's CNIC Attachements</label>
                                                        <br>
                                                        {{-- @if(!empty($value->owner->cnic_front))
                                                        <a href="{{ asset('uploads/user/cnics/'.$request->transfer->buyer_cnicfront) }}"
                                                            target="_blank">Click to View CNIC Front Attachement</a>
                                                        @else
                                                        <div class="info-value">No CNIC Front </div>
                                                        @endif
                                                        <br>
                                                        @if(!empty($value->owner->cnic_back))
                                                        <a href="{{ asset('uploads/user/cnics/'.$request->transfer->buyer_cnicfront) }}"
                                                            target="_blank">Click to View CNIC Back Attachement</a>
                                                        @else
                                                        <div class="info-value">No CNIC Back</div>
                                                        @endif --}}
                                                        @if(!empty($value->owner->cnic_front))
                                                        <a href="" target="_blank" class="attachment-pill pdf">
                                                            <span class="file-icon">
                                                                <i class="fa-solid fa-image"></i>
                                                            </span>
                                                            <span class="file-name">Cnic Front</span>
                                                        </a>
                                                        @else
                                                        <div class="info-value">No CNIC Front</div>
                                                        @endif
                                                        @if(!empty($value->owner->cnic_front))
                                                        <a href="" target="_blank" class="attachment-pill pdf">
                                                            <span class="file-icon">
                                                                <i class="fa-solid fa-image"></i>
                                                            </span>
                                                            <span class="file-name">Cnic Back</span>
                                                        </a>
                                                        @else
                                                        <div class="info-value">No CNIC Back</div>
                                                        @endif

                                                    </div>
                                                    @if($request->request_type == 1)
                                                    <div class="col-md-4">
                                                        <label class="info-label">Sold Price:</label>
                                                        <div class="info-value">{{$request->transfer->amount}}</div>
                                                    </div>
                                                    @endif
                                                    <div class="col-md-4">
                                                        <label class="info-label">Request Date:</label>
                                                        <div class="info-value">
                                                            {{
                                                            $request->transfer->created_at->timezone('Asia/Karachi')->format('d
                                                            M Y, h:i A') }}
                                                        </div>
                                                    </div>


                                                    @if($request->transfer->representative == 'representative')
                                                    <div class="col-md-12">
                                                        <div class="card shadow-sm mb-4 mx-4"
                                                            style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                                            <div class="card-body">
                                                                <label>Representative on behalf of {{ $value->name ??
                                                                    'N/A' }}</label>
                                                                <div class="form-row">
                                                                    <div class="col-md-4">
                                                                        <label>Representative Name</label>
                                                                        <div class="info-value">{{
                                                                            $request->transfer->callRepresentative->buyer_name??
                                                                            'N/A' }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label>Representative's Father Name</label>
                                                                        <div class="info-value">{{
                                                                            $request->transfer->callRepresentative->father_name
                                                                            ?? 'N/A' }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label>Representative's CNIC</label>
                                                                        <div class="info-value">{{
                                                                            $request->transfer->callRepresentative->cnic
                                                                            ?? 'N/A' }}</div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label>Representative's Address</label>
                                                                        <div class="info-value">{{
                                                                            $request->transfer->callRepresentative->address
                                                                            ?? 'N/A' }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label>Representater's Letter</label>
                                                                        <br>
                                                                        @if(!empty($request->transfer->callRepresentative->attorney_letter))
                                                                        <a href="{{ asset('uploads/user/representative/letter/'.$request->transfer->callRepresentative->attorney_letter) }}"
                                                                            target="_blank">Click to View Letter</a>
                                                                        @else
                                                                        <div class="info-value">No Letter</div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Representater's CNIC Attachements</label>
                                                                        <br>
                                                                        @if(!empty($request->transfer->callRepresentative->cnic_front))
                                                                        <a href="{{ asset('uploads/user/representative/cnics/'.$request->transfer->callRepresentative->cnic_front) }}"
                                                                            target="_blank">Click to View CNIC Front
                                                                            Attachement</a>
                                                                        @else
                                                                        <div class="info-value">No CNIC Front </div>
                                                                        @endif
                                                                        <br>
                                                                        @if(!empty($request->transfer->callRepresentative->cnic_back))
                                                                        <a href="{{ asset('uploads/user/representative/cnics/'.$request->transfer->callRepresentative->cnic_back) }}"
                                                                            target="_blank">Click to View CNIC Back
                                                                            Attachement</a>
                                                                        @else
                                                                        <div class="info-value">No CNIC Back</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                </div>
                                                @if($request->deo_action != NULL)
                                                <div class="form-row ">
                                                    <div class="col-7">
                                                        <h2 class="fs-titlecopy">Clerk Action :</h2>
                                                    </div>
                                                    <div class="col-span-2 offset-2 col-3">
                                                        <span class="badge badge-primary text-right p-2">
                                                            Sajid Mehmood
                                                        </span>
                                                    </div>

                                                </div>
                                                <div class="form-row">
                                                    <div class="col-7">
                                                        <h4 class="fs-titlecopy subheading">Application Status:</h4>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label>Application Status</label>
                                                        <div class="info-value">{{ $request->deo_action == 1 ?
                                                            'Accepted' : 'Reject' }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Action Date</label>
                                                        <div class="info-value">{{ $request->deo_date ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Remarks</label>
                                                        <div class="info-value">{{ $request->deo_remarks ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($request->appointment == 1)
                                                <div class="form-row">
                                                    <div class="col-7">
                                                        <h4 class="fs-titlecopy subheading">Appointment and Fee:</h4>
                                                    </div>
                                                </div>
                                                <div class="form-row {{$request->transferAttache ? '' : 'mb-4'}} ">
                                                    <div class="col-md-4">
                                                        <label>Appointment Date</label>
                                                        <div class="info-value">{{
                                                            \Carbon\Carbon::parse($request->appointment_date)
                                                            ->timezone('Asia/Karachi')
                                                            ->format('d M Y, h:i A') }}</div>
                                                    </div>
                                                    @if($request->transferAttaches)
                                                    
                                                    <div class="col-md-4">
                                                        <label>Transfer Fee</label>
                                                        <div class="info-value">{{ $request->transferAttaches->transferfee_paid_amount ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>KLC Fee</label>
                                                        <div class="info-value">{{ $request->transferAttaches->klc_paid_amount ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label>Income Tex</label>
                                                        <div class="info-value">{{ $request->transferAttaches->incometax_paid_amount ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Educatopm Cess</label>
                                                        <div class="info-value">{{ $request->transferAttaches->educess_paid_amount ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Stamp Duty</label>
                                                        <div class="info-value">{{ $request->transferAttaches->stampduty_paid_amount ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @if(!empty($request->transferAttaches->transferfee_attach))
                                                    <a href="/uploads/transferfee_attach/{{$request->transferAttaches->transferfee_attach}}" target="_blank" class="attachment-pill pdf">
                                                        <span class="file-icon">
                                                            <i class="fa-solid fa-image"></i>
                                                        </span>
                                                        <span class="file-name">Transfer Fee</span>
                                                    </a>
                                                    @endif

                                                    @if(!empty($request->transferAttaches->klc_attach))
                                                    <a href="/uploads/klc_attach/{{$request->transferAttaches->klc_attach}}" target="_blank" class="attachment-pill image">
                                                        <span class="file-icon">
                                                            <i class="fa-solid fa-image"></i>
                                                        </span>
                                                        <span class="file-name">KLC Fee</span>
                                                    </a>
                                                    @endif
                                                    @if(!empty($request->transferAttaches->incometax_attach))
                                                    <a href="/uploads/incometax_attach/{{$request->transferAttaches->incometax_attach}}" target="_blank" class="attachment-pill image">
                                                        <span class="file-icon">
                                                            <i class="fa-solid fa-image"></i>
                                                        </span>
                                                        <span class="file-name">Icome Tax</span>
                                                    </a>
                                                    @endif
                                                    @if(!empty($request->transferAttaches->educess_attach))
                                                    <a href="/uploads/educess_attach/{{$request->transferAttaches->educess_attach}}" target="_blank" class="attachment-pill image">
                                                        <span class="file-icon">
                                                            <i class="fa-solid fa-image"></i>
                                                        </span>
                                                        <span class="file-name">Education Cess</span>
                                                    </a>
                                                    @endif
                                                    @if(!empty($request->transferAttaches->stampduty_attach))
                                                    <a href="/uploads/stampduty_attach/{{$request->transferAttaches->stampduty_attach}}" target="_blank" class="attachment-pill image">
                                                        <span class="file-icon">
                                                            <i class="fa-solid fa-image"></i>
                                                        </span>
                                                        <span class="file-name">Stamp Duty</span>
                                                    </a>
                                                    @endif
                                                    @if(!empty($request->transferAttaches->other))
                                                    <a href="/uploads/other/{{$request->transferAttaches->other}}" target="_blank" class="attachment-pill image">
                                                        <span class="file-icon">
                                                            <i class="fa-solid fa-file-pdf"></i>
                                                        </span>
                                                        <span class="file-name">Other Documents</span>
                                                    </a>
                                                    @endif

                                                </div>
                                                @else
                                                    </div>
                                                @endif
                                                @endif

                                                <!-- Receiver Header -->
                                                @if($request->requestGenerationOwner)
                                                <div class="form-row mb-2">
                                                    <div class="col-12" style="border:1px dashed;">
                                                        <div class="d-flex justify-content-between align-items-center"
                                                            data-toggle="collapse" data-target="#receiverDetails{{$key1}}"
                                                            role="button" aria-expanded="false">

                                                            <h4 class="fs-titlecopy subheading pb-1">
                                                                Receiver Details
                                                            </h4>

                                                            <i class="fa-solid fa-chevron-down"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Collapsible Body -->
                                                    
                                                
                                                <div class="collapse" id="receiverDetails{{$key1}}">
                                                    <div class="">
                                                        @foreach($request->requestGenerationOwner as $key => $value)


                                                        <!-- Receiver Info -->
                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <label>Name</label>
                                                                <div class="info-value">{{ $value->name ?? 'N/A'
                                                                    }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Son of / Daughter of / Wife of</label>
                                                                <div class="info-value">{{ $value->father_name ??
                                                                    'N/A' }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>CNIC</label>
                                                                <div class="info-value">{{ $value->cnic ?? 'N/A'
                                                                    }}</div>
                                                            </div>
                                                            <div class="col-md-4 ">
                                                                <label>Address</label>
                                                                <div class="info-value">{{ $value->address ?? 'N/A'
                                                                    }}</div>
                                                            </div>
                                                            <div class="col-md-3 ">
                                                                <label>Received Area</label>
                                                                <div class="info-value">{{ $value->area ?? 'N/A'
                                                                    }}</div>
                                                            </div>
                                                        </div>

                                                        <!-- Attachments (No Styles Applied) -->
                                                        <div class="form-row ">
                                                            <div class="col">
                                                                <div class="d-flex flex-wrap gap-2">

                                                                    <!-- PDF -->
                                                                    <a href="/uploads/user/images/{{$value->picture}}" target="_blank"
                                                                        class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-file-pdf"></i>
                                                                        </span>
                                                                        <span class="file-name">Personal Picture</span>
                                                                    </a>
                                                                    <a href="/uploads/user/cnics/{{$value->cnic_front}}" target="_blank"
                                                                        class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-file-pdf"></i>
                                                                        </span>
                                                                        <span class="file-name">CNIC Front</span>
                                                                    </a>

                                                                    <!-- Image -->
                                                                    <a href="/uploads/user/cnics/{{$value->cnic_back}}" target="_blank"
                                                                        class="attachment-pill image">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">CNIC Back</span>
                                                                    </a>
                                                                    @php
                                                                        $inherit = \App\Models\Inheritance::where('cnic',$value->cnic)->first();
                                                                    @endphp
                                                                    <a href="/uploads/user/biometric/{{$inherit->biometric->image ?? ''}}" target="_blank"
                                                                        class="attachment-pill image">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">Biometric</span>
                                                                    </a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                                @endif
                                                @if($request->dummywitness)
                                                @if($request->witness)
                                                <div class="form-row mb-2">
                                                    <div class="col-12" style="border:1px dashed;">
                                                        <div class="d-flex justify-content-between align-items-center"
                                                            data-toggle="collapse" data-target="#witnessDetails{{$key1}}"
                                                            role="button" aria-expanded="false">

                                                            <h4 class="fs-titlecopy subheading pb-1">
                                                                Winesses's Details
                                                            </h4>

                                                            <i class="fa-solid fa-chevron-down"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse" id="witnessDetails{{$key1}}">
                                                    <div class="">
                                                        @foreach($request->witness as $key => $witness)

                                                        <!-- Receiver Info -->
                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <label>Name</label>
                                                                <div class="info-value">{{ $witness->name ?? 'N/A'
                                                                    }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Son of / Daughter of / Wife of</label>
                                                                <div class="info-value">{{ $witness->father_name ??
                                                                    'N/A' }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>CNIC</label>
                                                                <div class="info-value">{{ $witness->cnic ?? 'N/A'
                                                                    }}</div>
                                                            </div>

                                                            <div class="col-md-4 ">
                                                                <label>Address</label>
                                                                <div class="info-value">{{ $witness->address ?? 'N/A'
                                                                    }}</div>
                                                            </div>
                                                           
                                                        </div>

                                                        <!-- Attachments (No Styles Applied) -->
                                                        <div class="form-row ">
                                                            <div class="col">
                                                                <div class="d-flex flex-wrap gap-2">

                                                                    <!-- PDF -->
                                                                    <a href="/uploads/user/images/{{$witness->picture}}" target="_blank"
                                                                        class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-file-pdf"></i>
                                                                        </span>
                                                                        <span class="file-name">Personal Picture</span>
                                                                    </a>
                                                                    <a href="/uploads/user/cnics/{{$witness->cnic_front}}" target="_blank"
                                                                        class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-file-pdf"></i>
                                                                        </span>
                                                                        <span class="file-name">CNIC Front</span>
                                                                    </a>

                                                                    <!-- Image -->
                                                                    <a href="/uploads/user/cnics/{{$witness->cnic_back}}" target="_blank"
                                                                        class="attachment-pill image">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">CNIC Back</span>
                                                                    </a>
                                                                    <a href="/uploads/user/biometric/{{$witness->biometric->image ?? ''}}" target="_blank"
                                                                        class="attachment-pill image">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">Biometric</span>
                                                                    </a>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        @endforeach
                                                    </div>

                                                </div>
                                                @else
                                                <div class="form-row mb-2">
                                                    <div class="col-12" style="border:1px dashed;">
                                                        <div class="d-flex justify-content-between align-items-center"
                                                            data-toggle="collapse" data-target="#witnessDetails{{$key1}}"
                                                            role="button" aria-expanded="false">

                                                            <h4 class="fs-titlecopy subheading pb-1">
                                                                Winesses's Details
                                                            </h4>

                                                            <i class="fa-solid fa-chevron-down"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse" id="witnessDetails{{$key1}}">
                                                    <div class="">
                                                        @foreach($request->dummywitness as $key => $witness)

                                                        <!-- Receiver Info -->
                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <label>Name</label>
                                                                <div class="info-value">{{ $witness->name ?? 'N/A'
                                                                    }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Son of / Daughter of / Wife of</label>
                                                                <div class="info-value">{{ $witness->father_name ??
                                                                    'N/A' }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>CNIC</label>
                                                                <div class="info-value">{{ $witness->cnic ?? 'N/A'
                                                                    }}</div>
                                                            </div>

                                                            <div class="col-md-4 ">
                                                                <label>Address</label>
                                                                <div class="info-value">{{ $witness->address ?? 'N/A'
                                                                    }}</div>
                                                            </div>
                                                           
                                                        </div>

                                                        <!-- Attachments (No Styles Applied) -->
                                                        <div class="form-row ">
                                                            <div class="col">
                                                                <div class="d-flex flex-wrap gap-2">

                                                                    <!-- PDF -->
                                                                    <a href="/uploads/user/images/{{$witness->picture}}" target="_blank"
                                                                        class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-file-pdf"></i>
                                                                        </span>
                                                                        <span class="file-name">Personal Picture</span>
                                                                    </a>
                                                                    <a href="/uploads/user/cnics/{{$witness->cnic_front}}" target="_blank"
                                                                        class="attachment-pill pdf">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-file-pdf"></i>
                                                                        </span>
                                                                        <span class="file-name">CNIC Front</span>
                                                                    </a>

                                                                    <!-- Image -->
                                                                    <a href="/uploads/user/cnics/{{$witness->cnic_back}}" target="_blank"
                                                                        class="attachment-pill image">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">CNIC Back</span>
                                                                    </a>
                                                                    <a href="/uploads/user/biometric/{{$witness->biometric->image ?? ''}}" target="_blank"
                                                                        class="attachment-pill image">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-image"></i>
                                                                        </span>
                                                                        <span class="file-name">Biometric</span>
                                                                    </a>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        @endforeach
                                                    </div>

                                                </div>
                                                @endif
                                                @endif
                                                @if($request->head_status != NULL)
                                                <div class="form-row">
                                                    <div class="col-7">
                                                        <h4 class="fs-titlecopy subheading">Clerk Remarks:</h4>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label>Status</label>
                                                        <div class="info-value">{{ $request->head_status ??
                                                            'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Date</label>
                                                        <div class="info-value">{{ $request->head_date ? \Carbon\Carbon::parse($request->head_date)->format('d-m-Y') : 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Remrks</label>
                                                        <div class="info-value">{{ $request->head_remarks
                                                            ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($request->dd_action != NULL)
                                                <div class="form-row ">
                                                    <div class="col-7">
                                                        <h2 class="fs-titlecopy">Directer Action :</h2>
                                                    </div>
                                                    <div class="col-span-2 offset-2 col-3">
                                                        <span class="badge badge-primary text-right p-2">
                                                            Akbar ali
                                                        </span>
                                                    </div>

                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label>Status</label>
                                                        <div class="info-value">{{ $request->dd_action == '1' ? 'Approved' : 'Pending' }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Date</label>
                                                        <div class="info-value">{{ $request->head_date ? \Carbon\Carbon::parse($request->dd_action_date)->format('d-m-Y') : 'N/A' }}</div>
                                                    </div>

                                                </div>
                                                
                                                <div class="form-row ">
                                                    <div class="col">
                                                        <div class="d-flex flex-wrap gap-2">

                                                            <!-- PDF -->
                                                            <a href="/view-transfer-order/{{$request->id}}" target="_blank" class="attachment-pill pdf">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-image"></i>
                                                                </span>
                                                                <span class="file-name">Transfer Order</span>
                                                            </a>
                                                            <a href="/view-transfer-order/{{$request->id}}" target="_blank" class="attachment-pill pdf">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-image"></i>
                                                                </span>
                                                                <span class="file-name">Seller Statement</span>
                                                            </a>
                                                            <a href="/uploads/user/statement/{{$request->transfer->buyer_declaration}}" target="_blank" class="attachment-pill pdf">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-image"></i>
                                                                </span>
                                                                <span class="file-name">Buyer Statement</span>
                                                            </a>

                                                            <!-- Image -->

                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                        @endforeach   
                                        <!-- CARD 3 -->

                                        <div class="card">
                                            <div class="card-header custom-header" id="headingThree">
                                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                                    data-target="#collapseThree" aria-expanded="false"
                                                    aria-controls="collapseThree">
                                                    Old Record
                                                    <i class="fas fa-chevron-down icon"></i>
                                                </button>
                                            </div>

                                            <div id="collapseThree" class="collapse mx-3" aria-labelledby="headingThree"
                                                data-parent="#accordion">
                                               <div class="form-row ">
                                                    <div class="col-7">
                                                        <h2 class="fs-titlecopy">Previous Owners :</h2>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-row">

                                                
                                                    <div class="">
                                                        @foreach($property->oldowners as $key => $value)


                                                        <!-- Receiver Info -->
                                                        <div class="form-row mb-4">
                                                            <div class="col-md-4">
                                                                <label>Name</label>
                                                                <div class="info-value">{{ $value->name ?? 'N/A'
                                                                    }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Son of / Daughter of / Wife of</label>
                                                                <div class="info-value">{{ $value->father_name ??
                                                                    'N/A' }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>CNIC</label>
                                                                <div class="info-value">{{ $value->cnic ?? 'N/A'
                                                                    }}</div>
                                                            </div>
                                                            <div class="col-md-4 ">
                                                                <label>Address</label>
                                                                <div class="info-value">{{ $value->address ?? 'N/A'
                                                                    }}</div>
                                                            </div>
                                                            <div class="col-md-3 ">
                                                                <label>Received Area</label>
                                                                <div class="info-value">{{ $value->area ?? 'N/A'
                                                                    }}</div>
                                                            </div>
                                                        </div>

                                                        <!-- Attachments (No Styles Applied) -->
                                                        <div class="form-row ">
                                                            <div class="col">
                                                                <div class="d-flex flex-wrap gap-2">
                                                            @if(!empty($value->picture))
                                                            <a href="{{ asset('uploads/user/images/'.$value->picture) }}"
                                                                target="_blank" class="attachment-pill image">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-file-pdf"></i>
                                                                </span>
                                                                <span class="file-name">Person Picture</span>
                                                            </a>
                                                            
                                                            @endif
                                                            @if(!empty($value->cnic_front))
                                                            <a href="{{ asset('uploads/user/cnics/'.$value->cnic_front) }}"
                                                                target="_blank" class="attachment-pill pdf">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-image"></i>
                                                                </span>
                                                                <span class="file-name">Cnic Front</span>
                                                            </a>
                                                            
                                                            
                                                            @endif

                                                            @if(!empty($value->cnic_back))
                                                            <a href="{{ asset('uploads/user/cnics/'.$value->cnic_back) }}"
                                                                target="_blank" class="attachment-pill image">
                                                                <span class="file-icon">
                                                                    <i class="fa-solid fa-file-pdf"></i>
                                                                </span>
                                                                <span class="file-name">Cnic Back</span>
                                                            </a>
                                                            
                                                            @endif
                                                            @if(!empty($value->biometric_id) && !empty($value->biometric->image))
                                                                    <a href="javascript:void(0)" 
                                                                    onclick="openBiometric('{{ $value->biometric->image }}')" 
                                                                    class="attachment-pill image">
                                                                        <span class="file-icon">
                                                                            <i class="fa-solid fa-id-card"></i>
                                                                        </span>
                                                                        <span class="file-name">View Biometric</span>
                                                                    </a>
                                                                @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    </div>
                                                <div class="form-row">
                                                    <iframe 
                                                        src="{{asset('/uploads/complete/'.$property->attachment->complete_file)}}" 
                                                        width="100%" 
                                                        height="600px" 
                                                        style="border: none; display: block;"
                                                        title="PDF Document"
                                                    >
                                                        Your browser does not support iframes. 
                                                        <a href="/path/to/your/pdf/file.pdf" target="_blank">Click here to view the PDF</a>
                                                    </iframe>
                                                </div>
                                                
                                                
                                            </div>

                                        </div>

                                    </div>

                                </fieldset>

                                {{--
                                </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            
            // Function to switch tabs
            function switchTab(tabId) {
                // Remove active class from all buttons and contents
                tabButtons.forEach(button => {
                    button.classList.remove('active');
                });
                
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });
                
                
                // Add active class to clicked button and corresponding content
                const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
                const activeContent = document.getElementById(tabId);
                
                if (activeButton && activeContent) {
                    activeButton.classList.add('active');
                    activeContent.classList.add('active');
                }
            }
            
            // Add click event to all tab buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    switchTab(tabId);
                });
            });
            
            // Keyboard navigation support
            document.addEventListener('keydown', function(e) {
                const activeTab = document.querySelector('.tab-button.active');
                if (!activeTab) return;
                
                if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                    e.preventDefault();
                    const allTabs = Array.from(tabButtons);
                    const currentIndex = allTabs.indexOf(activeTab);
                    let nextIndex;
                    
                    if (e.key === 'ArrowRight') {
                        nextIndex = (currentIndex + 1) % allTabs.length;
                    } else {
                        nextIndex = (currentIndex - 1 + allTabs.length) % allTabs.length;
                    }
                    
                    const nextTabId = allTabs[nextIndex].getAttribute('data-tab');
                    switchTab(nextTabId);
                    allTabs[nextIndex].focus();
                }
            });
            
            // Initialize first tab as active if none is active
            if (!document.querySelector('.tab-button.active') && tabButtons.length > 0) {
                const firstTabId = tabButtons[0].getAttribute('data-tab');
                switchTab(firstTabId);
            }
        });
    </script>
    <script>
function openBiometric(base64String) {
    const byteString =  base64String;
    const src = "data:image/png;base64," + byteString;
    
    const win = window.open();
    win.document.write(`
        <html>
            <head><title>Biometric View</title></head>
            <body style="margin:0; display:flex; align-items:center; justify-content:center; background:#222;">
                <img src="${src}" style="max-width:100%; height:auto; box-shadow: 0 0 20px rgba(0,0,0,0.5);">
            </body>
        </html>
    `);
    win.document.close();
}
</script>

</x-app-layout>