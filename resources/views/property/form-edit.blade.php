<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        p {
            color: grey
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
            input[type="radio"] {
                padding: 0 !important;

            margin-bottom: 0 !important;
            margin-top: 0 !important;

                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                width: 18px !important;
                height: 18px !important;
                border: 2px solid #007bff !important;
                border-radius: 50% !important;
                outline: none !important;
                cursor: pointer !important;
                position: relative !important;
                background-color: #fff  !important;
                transition: 0.2s ease-in-out !important;
            }

            /* Add inner dot when checked */
            .form-check-input[type="radio"]:checked::before {
                content: "";
                width: 10px;
                height: 10px;
                background-color: #007bff;
                border-radius: 50%;
                position: absolute;
                top: 3px;
                left: 3px;
            }

            /* Optional: hover effect */
            .form-check-input[type="radio"]:hover {
                border-color: #0056b3;
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
        fieldset a{
            color:#3498db !important;
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
    transform: rotate(-90deg); /* Start from the top */
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
.entry-form{
    height:90vh;
    overflow-x:auto;

}
        </style>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-7">
                        <iframe style="width:100%;height:90vh;" src="{{ asset('uploads/complete/' . $property->attachment->complete_file) }}" hight="500" frameborder="0"></iframe>
                    </div>
                    <div class="col-5 entry-form">
                        <div class="card px-4 pt-4 pb-0 mt-3 mb-3">
                            <h2 id="heading">Mirpur Dam Housing Authority </h2>
                            <p class="text-center">Fill all form's fields to go to next step</p>
                            <form id="msform" action="{{route('formUpdate',$id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="active" id="account"><strong>Property Details</strong></li>
                                    <li id="payment"><strong>Attachements</strong></li>

                                </ul>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div> <br> <!-- fieldsets -->
                                <fieldset id="first-step">
                                    <div class="form-card">
                                        <div class="form-row">
                                            <div class="col-md-12">

                                                @if(session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
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




                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Location:</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">Step 1 - 2</h2>
                                            </div>
                                        </div>


                                        <div class="form-row">

                                            <div class=" col-md-4 ">
                                                <label class="">District</label>
                                                <select name="district" class="form-control" id="district">
                                                    <option value="Mirpur" selected  >Mirpur</option>
                                                </select>


                                            </div>
                                            <div class="col-md-4">
                                                <label class="">Tehsil</label>
                                                <select name="center" class="form-control" id="">
                                                    <option value="" disabled selected  >Select Center</option>
                                                    <option {{$property && $property->center == 'Mirpur' ? 'selected' : ''}} value="Mirpur"  >Mirpur</option>
                                                    <option {{$property && $property->center == 'Islam Garh' ? 'selected' : ''}} value="Islam Garh"  >Islam Garh</option>
                                                    <option {{$property && $property->center == 'Dudyal' ? 'selected' : ''}} value="Dudyal"  >Dudyal</option>
                                                </select>

                                            </div>
                                            <div class="col-md-4">
                                                <label class="">Locality/Revenue Village</label>
                                                <input type="text" class="form-control" name="locality"

                                                value="{{$property->locality ?? ''}}" />

                                            </div>
                                            <div class="col-md-4">
                                                <label class="">Code</label>
                                                <input type="text" class="form-control" name="code"
                                                    placeholder="Enter Code"
                                                    value="{{  $property->code ?? ''}}" />
                                                <div class="invalid-feedback" id="error-paddress"></div>
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
                                                    <div class="col">
                                                        <label for="name">Acre</label>
                                                        <input type="text" id="dm_acre" placeholder="acre" name="dm_acre" class="form-control"
                                                        value="{{  $property->dm_acre ?? ''}}">
                                                    </div>
                                                    <div class="col">
                                                        <label for="name">Kanal</label>
                                                        <input type="text" id="dm_kanal" placeholder="kanal" name="dm_kanal" class="form-control"
                                                        value="{{  $property->dm_kanal ?? ''}}">
                                                    </div>
                                                    <div class="col">
                                                        <label for="name">Marla</label>
                                                        <input type="text" id="dm_marla" placeholder="marla" name="dm_marla" class="form-control"
                                                        value="{{  $property->dm_marla ?? ''}}">
                                                    </div>
                                                    <div class="col">
                                                        <label for="name">Squarefeet</label>
                                                        <input type="text" id="dm_sqrft" placeholder="sqrft" name="dm_sqrft" class="form-control"
                                                        value="{{  $property->dm_sqrft ?? ''}}">
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

                                            <div class="col-md-4">
                                                <label for="name" style="margin-top:33px;">Category</label>
                                                <select name="category" id="" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <option {{$property && $property->category == 'Plot' ? 'selected' : ''}} value="Plot">Plot</option>
                                                    <option {{$property && $property->category == 'House' ? 'selected' : ''}} value="House">House</option>
                                                    <option {{$property && $property->category == 'Commercial' ? 'selected' : ''}} value="Commercial">Commercial</option>
                                                </select>

                                            </div>
                                            <div class=" col-md-8">
                                                <label for="name">Area Measurement</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="name">Acre</label>
                                                        <input type="text" id="acre" placeholder="acre" name="acre" class="form-control"
                                                        value="{{  $property->acre ?? ''}}">
                                                    </div>
                                                    <div class="col">
                                                        <label for="name">Kanal</label>
                                                        <input type="text" id="kanal" placeholder="kanal" name="kanal" class="form-control"
                                                        value="{{  $property->kanal ?? ''}}">
                                                    </div>
                                                    <div class="col">
                                                        <label for="name">Marla</label>
                                                        <input type="text" id="marla" placeholder="marla" name="marla" class="form-control"
                                                        value="{{  $property->marla ?? ''}}">
                                                    </div>
                                                    <div class="col">
                                                        <label for="name">Squarefeet</label>
                                                        <input type="text" id="sqrft" placeholder="sqrft" name="sqrft" class="form-control"
                                                        value="{{  $property->sqrft ?? ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">

                                            <div class="col-md-4  ">
                                                <label for="name">Allotment Order No</label>
                                                <input type="text" name="alotment_order" placeholder="Enter Allotment Order No"
                                                    class="form-control" value="{{  $property->alotment_order ?? ''}}">

                                            </div>

                                            <div class=" col-md-4">
                                                <label for="name">Town/City</label>

                                               <select name="town" class="form-control" id="">
                                                <option value="" disabled selected  >Select Town/City</option>
                                                <option {{$property && $property->town == '3' ? 'selected' : ''}} value="3"  >New City Mirpur</option>
                                                <option {{$property && $property->town == '4' ? 'selected' : ''}} value="4"  >New Small Town Islamgarh</option>
                                                <option {{$property && $property->town == '5' ? 'selected' : ''}} value="5"  >New Small Town Chaksawari</option>
                                                <option {{$property && $property->town == '2' ? 'selected' : ''}} value="2"  >New Small Town Dudyal</option>
                                                <option {{$property && $property->town == '1' ? 'selected' : ''}} value="1"  >New Small Town Siakh</option>
                                            </select>

                                            </div>
                                            <div class=" col-md-4 " >
                                                <label for="name">Sector</label>
                                                <input type="text" name="sector" class="form-control"
                                                value="{{  $property->sector ?? ''}}">

                                            </div>

                                            <div class="col-md-4  ">
                                                <label for="name">Plot No</label>
                                                <input type="text" name="plot_no" placeholder="Enter Plot Number"
                                                    class="form-control" value="{{  $property->plot_no ?? ''}}">

                                            </div>
                                            <div class="col-md-6">
                                            <label class="form-label d-block">Allotment Type</label>
                                            <div class="form-check form-check-inline mt-2">
                                                <input class="form-check-input" type="radio" name="allotment_type" id="originalAllote" value="original_allotee" {{$property->allotment_type == 'original_allotee' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="originalAllote">Original Allottee</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-2">
                                                <input class="form-check-input" type="radio" name="allotment_type" id="transferred" value="transferred" {{$property->allotment_type == 'transferred' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="transferred">Transferred</label>
                                            </div>
                                        </div>

                                        <!-- Number Input -->
                                        <div class="col-md-2">
                                            <label for="count" class="form-label">Transfer Count</label>
                                            <input type="number" name="transfer_count" id="count" class="form-control" value="{{$property->transfer_count}}" min="0" max="100" maxlength="3">
                                        </div>
                                        <div class="col-md-4" id="transferDetails" style="display: none;">
                                                <label class="form-label d-block">Transfer Type Counts</label>

                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="warasat_count" class="form-label">Warasat</label>
                                                        <input type="number" name="warasat_count" id="warasat_count" class="form-control"
                                                            value="{{ old('warasat_count', $property->warasat_count ?? 0) }}" min="0">
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="sale_count" class="form-label">Sale</label>
                                                        <input type="number" name="sale_count" id="sale_count" class="form-control"
                                                            value="{{ old('sale_count', $property->sale_count ?? 0) }}" min="0">
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="hiba_count" class="form-label">Hiba</label>
                                                        <input type="number" name="hiba_count" id="hiba_count" class="form-control"
                                                            value="{{ old('hiba_count', $property->hiba_count ?? 0) }}" min="0">
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Qabza Chit Issued -->
    <!-- Qabza Chit Issued -->
<div class="col-md-4 mb-3">
    <label class="form-label d-block">Qabza Chit Issued</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="qabza_chit" id="qabza_chit_yes" value="yes"
               {{ old('qabza_chit', $property->qabza_chit ?? '') == 'yes' ? 'checked' : '' }}>
        <label class="form-check-label" for="qabza_chit_yes">Yes</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="qabza_chit" id="qabza_chit_no" value="no"
               {{ old('qabza_chit', $property->qabza_chit ?? '') == 'no' ? 'checked' : '' }}>
        <label class="form-check-label" for="qabza_chit_no">No</label>
    </div>
</div>

<!-- Map Approval -->
<div class="col-md-4 mb-3">
    <label class="form-label d-block">Map Approval</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="map_approval" id="map_approval_yes" value="yes"
               {{ old('map_approval', $property->map_approval ?? '') == 'yes' ? 'checked' : '' }}>
        <label class="form-check-label" for="map_approval_yes">Yes</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="map_approval" id="map_approval_no" value="no"
               {{ old('map_approval', $property->map_approval ?? '') == 'no' ? 'checked' : '' }}>
        <label class="form-check-label" for="map_approval_no">No</label>
    </div>
</div>

<!-- House Constructed -->
<div class="col-md-4 mb-3">
    <label class="form-label d-block">House Constructed</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="house_constructed" id="house_constructed_yes" value="yes"
               {{ old('house_constructed', $property->house_constructed ?? '') == 'yes' ? 'checked' : '' }}>
        <label class="form-check-label" for="house_constructed_yes">Yes</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="house_constructed" id="house_constructed_no" value="no"
               {{ old('house_constructed', $property->house_constructed ?? '') == 'no' ? 'checked' : '' }}>
        <label class="form-check-label" for="house_constructed_no">No</label>
    </div>
</div>

<!-- Single / Multiple Owner -->
<div class="col-md-4 mb-3">
    <label class="form-label d-block">Single Owner / Multiple Owner</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="owner_type" id="single_seller" value="single"
               {{ old('owner_type', $property->owner_type ?? '') == 'single' ? 'checked' : '' }}>
        <label class="form-check-label" for="single_seller">Single</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="owner_type" id="multiple_seller" value="multiple"
               {{ old('owner_type', $property->owner_type ?? '') == 'multiple' ? 'checked' : '' }}>
        <label class="form-check-label" for="multiple_seller">Multiple</label>
    </div>
</div>
<div class="col-md-8 mb-3">
    <label class="form-label d-block">Boundary Wall Construction Permission</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="boundary_wall" id="single_seller" value="Yes"
               {{ old('boundary_wall', $property->boundary_wall ?? '') == 'Yes' ? 'checked' : '' }}>
        <label class="form-check-label" for="single_seller">Yes</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="boundary_wall" id="multiple_seller" value="No"
               {{ old('boundary_wall', $property->boundary_wall ?? '') == 'No' ? 'checked' : '' }}>
        <label class="form-check-label" for="multiple_seller">No</label>
    </div>
</div>
<div class="col-md-4">

    <label for="latest_transfer">Latest Transfer:</label>
    <select name="latest_transfer" id="latest_transfer" class="form-control">
        <option value="">-- Select Transfer Type --</option>

            <option {{$property->latest_transfer == 1 ? 'selected' : ''}} value="1">Property Transfer</option>
            <option {{$property->latest_transfer == 2 ? 'selected' : ''}} value="2">Warassat Transfer</option>
            <option {{$property->latest_transfer == 3 ? 'selected' : ''}} value="3">Hiba Transfer</option>

    </select>

</div>





                                            <div class="container mt-4">
    <h5>Allottee Details</h5>
    <div id="allottee-wrapper">
        <!-- Single Allottee Entry Template -->
        @if($inherit->isEmpty())
        <input type="hidden" name="inheritance_null" value ="">
        <div class="row allottee-item mb-3" data-id="0">
            <input type="hidden" name="inheritance[0][id]" value ="">

            <div class="col-md-3">
                <label>Allottee Name</label>
                <input type="text" name="inheritance[0][name]" class="form-control" placeholder="Enter Name" value="{{$property->allotee_name}}">
            </div>
            <div class="col-md-3">
                <label>Relation</label>
                <input type="text" name="inheritance[0][father_name]" class="form-control" placeholder="S/O D/O W/O"  value="{{$property->relation}}">
            </div>
            <div class="col-md-3">
                <label>CNIC</label>
                <input type="text" name="inheritance[0][cnic]" class="form-control" placeholder="XXXXXXXXXXXXX"  value="{{$property->cnic}}">
            </div>
            <div class="col-md-2">
                <label>Area </label>
                <input type="text" name="inheritance[0][area]" class="form-control" placeholder="Enter Area">
            </div>
            <div class="col-md-1 d-flex align-items-center mt-3">
                <button type="button" class="btn btn-danger remove-btn"> <i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
        @else
        @foreach($inherit as $key => $value)
    @php
        $inheritanceKey = $key;
    @endphp

<div class="row allottee-item mb-3" data-id="{{ $value->id }}">
    <input type="hidden" name="inheritance[{{$key}}][id]" value="{{$value->id}}">
        <div class="col-md-3">
            <label>Name</label>
            <input type="text" name="inheritance[{{ $inheritanceKey }}][name]" class="form-control"
                   value="{{ $value->name }}">
        </div>
        <div class="col-md-3">
            <label>Relation</label>
            <input type="text" name="inheritance[{{ $inheritanceKey }}][father_name]" class="form-control"
                   value="{{ $value->father_name }}">
        </div>
        <div class="col-md-3">
            <label>CNIC</label>
            <input type="text" name="inheritance[{{ $inheritanceKey }}][cnic]" class="form-control"
                   value="{{ $value->cnic }}">
        </div>
        <div class="col-md-2">
            <label>Area</label>
            <input type="text" name="inheritance[{{ $inheritanceKey }}][area]" class="form-control"
                   value="{{ $value->area }}">
        </div>
        <div class="col-md-1 d-flex align-items-center mt-3">
            <button type="button" class="btn btn-danger remove-btn">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>
@endforeach
        @endif
    </div>

    <button type="button" class="btn btn-primary mt-2" id="add-more">Add More</button>
</div>

                                        </div>



                                    </div> <input type="button" name="next" class="next action-button" value="Next" />
                                </fieldset>

                                <fieldset id="second-step">
                                    <input type="hidden" name="affected_house" value="{{$property->attachment->affected_house}}">
                               <input type="hidden" name="complete_file" value="{{$property->attachment->complete_file}}">
                               <input type="hidden" name="builtup_property" value="{{$property->attachment->builtup_property}}">
                               <input type="hidden" name="entitlement" value="{{$property->attachment->entitlement}}">
                               <input type="hidden" name="allot_com" value="{{$property->attachment->allot_com}}">
                               <input type="hidden" name="chit_mapping" value="{{$property->attachment->chit_mapping}}">
                               <input type="hidden" name="order_attach" value="{{$property->attachment->order_attach}}">
                               <input type="hidden" name="allot_order" value="{{$property->attachment->allot_order}}">
                                    {{-- < class="form-card"> --}}
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Related Attachements:</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">Step 2 - 2</h2>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 text-left">
                                                <label class="d-flex" for="name">Complete File <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="complete_file_done"></label>
                                                <input type="file" placeholder="Enter Name" name="complete_file" >
                                                <p class="size-complete_file"></p>
                                                @if($property->attachment->complete_file != null)
                                                <a href="{{asset('/uploads/complete/'.$property->attachment->complete_file)}}">View Attached File</a>
                                                @endif
                                            </div>
                                            <div class="col-md-6 text-left">
                                                <label class="d-flex" for="name">Code of Affected House <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="affected_house_done"></label>
                                                <input type="file" placeholder="Enter Name" name="affected_house" >
                                                <p class="size-affected_house"></p>
                                                @if($property->attachment->affected_house != null)
                                                <a href="{{asset('/uploads/affected_house/'.$property->attachment->affected_house)}}">View Attached File</a>
                                                @endif
                                            </div>
                                            <div class=" col-md-6  text-left">
                                                <label class="d-flex" for="name">Award of Built-up Property <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="builtup_property_done"></label>
                                                <input type="file" name="builtup_property" placeholder="Enter Designation"
                                                    >
                                                    <p class="size-builtup_property"></p>
                                                    @if($property->attachment->builtup_property != null)
                                                <a href="{{asset('/uploads/builtup/'.$property->attachment->builtup_property)}}">View Attached File</a>
                                                @endif
                                            </div>


                                            <div class="col-md-6 text-left">
                                                <label class="d-flex" for="name">Entitlement <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="entitlement_done"></label>
                                                <input type="file" placeholder="Enter Department" name="entitlement"
                                                    >
                                                    <p class="size-entitlement"></p>
                                                    @if($property->attachment->entitlement != null)
                                                <a href="{{asset('/uploads/entitlement/'.$property->attachment->entitlement)}}">View Attached File</a>
                                                @endif


                                            </div>
                                            <div class=" col-md-6 text-left">
                                                <label class="d-flex" for="name">Allotment by Allotment Committee <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="allot_com_done"></label>
                                                <input type="file" name="allot_com" placeholder="Enter Address"
                                                    >
                                                    <p class="size-allot_com"></p>
                                                    @if($property->attachment->allot_com != null)
                                                    <a href="{{asset('/uploads/allotment_committee/'.$property->attachment->allot_com)}}">View Attached File</a>
                                                    @endif

                                            </div>


                                            <div class="col-md-6 text-left">
                                                <label class="d-flex" for="name">Allotment Order <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="allot_order_done"></label>
                                                <input type="file" placeholder="Enter Mobile No" name="allot_order"
                                                    >
                                                    <p class="size-allot_order"></p>
                                                    @if($property->attachment->allot_order != null)
                                                    <a href="{{asset('/uploads/allotment_order/'.$property->attachment->allot_order)}}">View Attached File</a>
                                                    @endif


                                            </div>
                                            <div class=" col-md-6  text-left">
                                                <label  class="d-flex" for="name">Possession Chit With Mapping <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="chit_mapping_done"></label>
                                                <input type="file" name="chit_mapping" placeholder="Enter Email"
                                                    >
                                                    <p class="size-chit_mapping"></p>
                                                    @if($property->attachment->chit_mapping != null)
                                                    <a href="{{asset('/uploads/chit_mapping/'.$property->attachment->chit_mapping)}}">View Attached File</a>
                                                    @endif

                                            </div>
                                            <div class="col-md-6 text-left" >
                                                <label class="d-flex" for="name">Order Attachement <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="order_attach_done"></label>
                                                <input type="file" name="order_attach">
                                                <p class="size-order_attach"></p>
                                                @if($property->attachment->order_attach != null)
                                                    <a href="{{asset('/uploads/order_attchement/'.$property->attachment->order_attach)}}">View Attached File</a>
                                                    @endif

                                            </div>
                                        </div>
                                        <input type="submit" name="" class=" action-button" value="Submit" /> <input
                                            type="button" name="previous" class="previous action-button-previous"
                                            value="Previous" />
                                </fieldset>
                                <div id="loader" style="display:none;" >
                                    <img src="{{asset('/done.png')}}" alt="" id="done">
                                    <div id="spinner">
                                        <div id="progressWrapper"></div>
                                        <div id="loader-percent" style="font-weight:bold;margin-top:10px;">Please Wait</div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/compressorjs@1.1.1/dist/compressor.min.js"></script>
    <script src="https://unpkg.com/pdf-lib"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const transferredRadio = document.getElementById('transferred');
        const originalRadio = document.getElementById('originalAllote');
        const transferDetails = document.getElementById('transferDetails');

        function toggleTransferDetails() {
            if (transferredRadio.checked) {
                transferDetails.style.display = 'block';
            } else {
                transferDetails.style.display = 'none';
                // Optionally reset values
                document.getElementById('warasat_count').value = 0;
                document.getElementById('sale_count').value = 0;
                document.getElementById('hiba_count').value = 0;
            }
        }

        toggleTransferDetails(); // Run on page load
        transferredRadio.addEventListener('change', toggleTransferDetails);
        originalRadio.addEventListener('change', toggleTransferDetails);
    });
</script>
<script>
    let allotteeIndex = 1; // Start from 1 because 0 is already used in the initial HTML

    document.getElementById('add-more').addEventListener('click', function () {
        const wrapper = document.getElementById('allottee-wrapper');
        const original = document.querySelector('.allottee-item');
        const clone = original.cloneNode(true);

        // Clear input values and update name attributes
        clone.querySelectorAll('input').forEach(input => {
            const nameAttr = input.getAttribute('name');
            const updatedName = nameAttr.replace(/\[\d+\]/, `[${allotteeIndex}]`);
            input.setAttribute('name', updatedName);
            input.value = '';
        });

        wrapper.appendChild(clone);
        allotteeIndex++;
    });

    // Remove button functionality (for dynamically added and existing rows)
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-btn')) {
            const allItems = document.querySelectorAll('.allottee-item');
            if (allItems.length > 1) {
                e.target.closest('.allottee-item').remove();
            }
        }
    });
</script>

    <script>

        document.addEventListener("DOMContentLoaded", function() {
            // Check if body already has the sidebar-collapse class
            if (!document.body.classList.contains('sidebar-collapse')) {
                document.body.classList.add('sidebar-collapse');
            }
        });
        </script>
        <script>
            $(document).ready(function(){
                document.querySelectorAll('#second-step input[type="file"]').forEach((fileInput) => {
                fileInput.addEventListener('change', async function () {
                 if (fileInput.files.length > 0) {
                const originalFile = fileInput.files[0];

                if (originalFile.type.startsWith("image/")) {
                    // Image Compression using Compressor.js
                    console.log("Original image file size: ", originalFile.size / 1024, "KB");

                    new Compressor(originalFile, {
                        quality: 0.6, // Adjust compression quality
                        success(compressedBlob) {
                            const compressedFile = new File([compressedBlob], originalFile.name, {
                                type: originalFile.type,
                                lastModified: Date.now(),
                            });

                            console.log("Compressed image file size: ", compressedFile.size / 1024, "KB");

                            // Replace the file in the input with the compressed file
                            let dataTransfer = new DataTransfer();
                            dataTransfer.items.add(compressedFile);
                            fileInput.files = dataTransfer.files; // Set the compressed file as the new file
                            document.querySelector('.size-' + fileInput.name).textContent = "File Size : " + (compressedFile.size / 1024).toFixed(2) + " KB";
                        },
                        error(err) {
                            console.error("Image compression failed:", err.message);
                        }
                    });
                } else if (originalFile.type === "application/pdf") {
                    // PDF Optimization using pdf-lib
                    console.log("Original PDF file size: ", originalFile.size / 1024, "KB");

                    try {
                        const arrayBuffer = await originalFile.arrayBuffer();
                        const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);

                        // Save the compressed/optimized PDF
                        const compressedPdfBytes = await pdfDoc.save({ useObjectStreams: true });

                        const compressedBlob = new Blob([compressedPdfBytes], { type: 'application/pdf' });
                        const compressedFile = new File([compressedBlob], originalFile.name, {
                            type: 'application/pdf',
                            lastModified: Date.now()
                        });

                        console.log("Compressed PDF file size: ", compressedFile.size / 1024, "KB");

                        // Replace the file in the input with the compressed file
                        let dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        fileInput.files = dataTransfer.files; // Set the compressed file as the new file
                        document.querySelector('.size-' + fileInput.name).textContent = "File Size : " + (compressedFile.size / 1024).toFixed(2) + " KB";

                    } catch (err) {
                        console.error("PDF optimization failed:", err.message);
                    }
                } else {
                    console.log("Unsupported file type:", originalFile.type);
                }
            }
        });
    });

                var current_fs, next_fs, previous_fs; // fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    function callAjax(current,name, value) {

        const progressWrapper = document.getElementById('progressWrapper');
        progressWrapper.innerHTML = '';
        let formData = new FormData();
        formData.append('id',@json($id));
        formData.append('current', current);
        formData.append('name', name);
        formData.append('value', value);
        formData.append('_token', '{{ csrf_token() }}'); // Add CSRF token

        let xhr = new XMLHttpRequest();

        // Create progress bar for the file
        let progressBar = createCircularProgressBar(name, current);
        document.getElementById('progressWrapper').appendChild(progressBar);

        xhr.upload.addEventListener('progress', function (e) {
            if (e.lengthComputable) {
                let percentComplete = (e.loaded / e.total) * 100;
                let circle = document.querySelector(`#progressCircle${current} circle.progress`);
                let radius = circle.r.baseVal.value;
                let circumference = 2 * Math.PI * radius;
                let offset = circumference - (percentComplete / 100) * circumference;

                circle.style.strokeDashoffset = offset;
                document.querySelector(`#percentText${current}`).innerText = Math.round(percentComplete) + '%';
            }
        });

        xhr.addEventListener('load', function () {
            // let circle = document.querySelector(`#progressCircle${current} circle`);
            // circle.style.stroke = '#28a745'; // Success color
            // document.querySelector(`#percentText${current}`).innerText = '100%';
            $('#spinner').hide();
                        $('#done').show();
                        $('#' + name + '_done').show();
                        setTimeout(function() {
                            $('#loader').hide();
                        }, 300);
        });

        xhr.addEventListener('error', function () {
            let circle = document.querySelector(`#progressCircle${current} circle`);
            circle.style.stroke = '#dc3545'; // Error color
            document.querySelector(`#percentText${current}`).innerText = 'Error';
        });

        xhr.open('POST', '{{ route('tempFileStore') }}', true); // Use Laravel route for file upload
        xhr.send(formData);
    }

    function createCircularProgressBar(fileName, index) {
        let div = document.createElement('div');
        div.classList.add('progress-container');
        div.id = `progressCircle${index}`;
        div.innerHTML = `
                <svg class="progress-circle" width="100" height="100">
                <circle class="progress" cx="50" cy="50" r="45" stroke-width="10" stroke-dasharray="283" stroke-dashoffset="283"></circle>
            </svg>
            <div class="percent-text" id="percentText${index}">0%</div>
        `;
        return div;
    }



    // Set up event listeners for the second step
    $('#second-step input[type="file"]').on('change', function (e) {
        $('#done').hide();
                    $('#spinner').show();
                    $('#loader').show();
        callAjax(2, e.target.name, e.target.files[0]);
    });

    // Handle next button clicks
    $(".next").click(function () {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        let isValid = true;


        // Update progress bar
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

        setProgressBar(current);
    });



                $(".previous").click(function(){

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                //show the previous fieldset
                previous_fs.show();

                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                'display': 'none',
                'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
                },
                duration: 500
                });
                setProgressBar(--current);
                });

                function setProgressBar(curStep){
                var percent = parseFloat(100 / steps) * curStep;
                percent = percent.toFixed();
                $(".progress-bar")
                .css("width",percent+"%")
                }

                $(".submit").click(function(){
                return false;
                });

                });


        </script>
        <script>
            $(document).on('click', '.remove-btn', function() {
    const row = $(this).closest('.allottee-item');
    const recordId = row.data('id');
    console.log(recordId,row);

    if(recordId) {
        if (!confirm('Are you sure you want to delete this record?')) {
            return;
        }

        $.ajax({
            url: '/inheritances-delete/' + recordId,  // your delete route here
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                row.remove();
                alert('Record deleted successfully.');
            },
            error: function(xhr) {
                alert('Failed to delete record.');
            }
        });
    } else {
        // For new rows (not saved yet), just remove from DOM
        row.remove();
    }
});

        </script>
</x-app-layout>
