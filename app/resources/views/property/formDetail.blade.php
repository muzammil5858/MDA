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
        .detail-item {
            /* margin-bottom: rem; */
        }
        .detail-item label {
            font-weight: bold;
        }
        .detail-item p {
            margin: 0;
        }
        </style>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-7">
                        <iframe style="width:100%;height:800px;" src="{{ asset('uploads/complete/' . $property->attachment->complete_file) }}" hight="500" frameborder="0"></iframe>
                    </div>
                    <div class="col-5">
                        <div class="card px-4 pt-4 pb-0 mt-3 mb-3">
                            <h2 id="heading">Mangla Dam Housing Authority</h2>
                            <p class="text-center">Property Detail</p>
                            {{-- <form id="msform" action="{{route('formUpdate',$id)}}" method="POST" enctype="multipart/form-data"> --}}
                                {{-- @csrf   --}}
                                
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
                                            
                                        </div>
                                        
        
                                        <div class="form-row">
        
                                            <div class="detail-item col-md-4">
                                                <label for="name">District:</label>
                                                <p id="name">{{$property->district}}</p>
                        
                                            </div>
                                            <div class="detail-item col-md-4">
                                                <label for="address">Centre:</label>
                                                <p id="address">{{$property->center}}</p>
                                            </div>
                                            <div class="detail-item col-md-4">
                                                <label for="phone">Locality/Revenue Village:</label>
                                                <p id="phone">{{$property->locality}}</p>
                                            </div>
                                            <div class="detail-item col-md-4">
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
                                                        <p id="phone">{{$property->dm_acre}}</p>
                                                    </div>
                                                    <div class="detail-item col">
                                                        <label class="">Kanal</label>
                                                        <p id="phone">{{$property->dm_kanal}}</p>
                                                    </div>
                                                    <div class="detail-item col">
                                                        <label class="">Marla</label>
                                                        <p id="phone">{{$property->dm_marla}}</p>
                                                    </div>
                                                    <div class="detail-item col">
                                                        <label class="">Squarefeet</label>
                                                        <p id="phone">{{$property->dm_sqrft}}</p>
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
                                                        <p id="phone">{{$property->acre}}</p>
                                                    </div>
                                                    <div class="detail-item col">
                                                        <label class="">Kanal</label>
                                                        <p id="phone">{{$property->kanal}}</p>
                                                    </div>
                                                    <div class="detail-item col">
                                                        <label class="">Marla</label>
                                                        <p id="phone">{{$property->marla}}</p>
                                                    </div>
                                                    <div class="detail-item col">
                                                        <label class="">Squarefeet</label>
                                                        <p id="phone">{{$property->dm_sqrft}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
        
                                            <div class="detail-item col-md-4  ">
                                                <label for="name">Allotment Order No</label>
                                               <p id="phone">{{$property->allotment_order}}</p>
                                                
                                            </div>
                                           
                                            <div class="detail-item col-md-4">
                                                <label for="name">Town/City</label>
                                                @php
                                                    $town = DB::table('towns')->where('id',$property->town)->first()
                                                @endphp
                                               <p id="phone">{{$town->name}}</p>
                                             
                                            </div>
                                            <div class="detail-item col-md-4 " >
                                                <label for="name">Sector</label>
                                                <p id="phone">{{$property->sector}}</p>
                                              
                                            </div>
        
                                            <div class="detail-item col-md-4  ">
                                                <label for="name">Plot No</label>
                                                <p id="phone">{{$property->plot_no}}</p>
                                              
                                            </div>
                                        
        
                                            <div class="detail-item col-md-4  ">
                                                <label for="name">Allottee Name</label>
                                                <p id="phone">{{$property->allotee_name}}</p>
                                                
                                            </div>
                                            <div class=" detail-item col-md-4">
                                                <label for="name">Son of/Daughter of/Wife of</label>
                                               <p id="phone">{{$property->relation}}</p>
                                                
                                            </div>
                                            <div class=" detail-item col-md-4 " id="bps">
                                                <label for="name">CNIC</label>
                                                
                                                <p id="phone">{{$property->cnic}}</p>
                                                
                                            </div>
        
                                        </div>
                                        
        
        
                                    </div> 
                                
                                    
                                    {{-- < class="form-card"> --}}
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Related Attachements:</h2>
                                            </div>
                                           
                                        </div>
                                        <div class="form-row">
                                            <div class="detail-item col-md-6 text-left">
                                                <label class="d-flex" for="name">Complete File <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="complete_file_done"></label>
                                                @if($property->attachment->complete_file != null)
                                                <a href="{{asset('/uploads/complete/'.$property->attachment->complete_file)}}">View Attached File</a>
                                                @endif
                                            </div>
                                            <div class="detail-item col-md-6 text-left">
                                                <label class="d-flex" for="name">Code of Affected House <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="affected_house_done"></label>
                                                @if($property->attachment->affected_house != null)
                                                <a href="{{asset('/uploads/affected_house/'.$property->attachment->affected_house)}}">View Attached File</a>
                                                @endif
                                            </div>
                                            <div class="detail-item col-md-6  text-left">
                                                <label class="d-flex" for="name">Award of Built-up Property <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="builtup_property_done"></label>
            
                                                    @if($property->attachment->builtup_property != null)
                                                <a href="{{asset('/uploads/builtup/'.$property->attachment->builtup_property)}}">View Attached File</a>
                                                @endif
                                            </div>
                                       
        
                                            <div class="detail-item col-md-6 text-left">
                                                <label class="d-flex" for="name">Entitlement <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="entitlement_done"></label>
                                              
                                                    @if($property->attachment->entitlement != null)
                                                <a href="{{asset('/uploads/entitlement/'.$property->attachment->entitlement)}}">View Attached File</a>
                                                @endif
                                                
        
                                            </div>
                                            <div class="detail-item col-md-6 text-left">
                                                <label class="d-flex" for="name">Allotment by Allotment Committee <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="allot_com_done"></label>
                                                
                                                    @if($property->attachment->allot_com != null)
                                                    <a href="{{asset('/uploads/allotment_committee/'.$property->attachment->allot_com)}}">View Attached File</a>
                                                    @endif
        
                                            </div>
                                   
        
                                            <div class="detail-item col-md-6 text-left">
                                                <label class="d-flex" for="name">Allotment Order <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="allot_order_done"></label>
                                                
                                                    @if($property->attachment->allot_order != null)
                                                    <a href="{{asset('/uploads/allotment_order/'.$property->attachment->allot_order)}}">View Attached File</a>
                                                    @endif
                                               
        
                                            </div>
                                            <div class="detail-item col-md-6  text-left">
                                                <label  class="d-flex" for="name">Possession Chit With Mapping <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="chit_mapping_done"></label>
                                               
                                                    @if($property->attachment->chit_mapping != null)
                                                    <a href="{{asset('/uploads/chit_mapping/'.$property->attachment->chit_mapping)}}">View Attached File</a>
                                                    @endif
        
                                            </div>
                                            <div class="detail-item col-md-6 text-left" >
                                                <label class="d-flex" for="name">Order Attachement <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="order_attach_done"></label>
                                               
                                                @if($property->attachment->order_attach != null)
                                                    <a href="{{asset('/uploads/order_attchement/'.$property->attachment->order_attach)}}">View Attached File</a>
                                                    @endif
                                               
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-7">
                                                <h2 class="fs-title">QA :</h2>
                                            </div>
                                        </div>   
                                         <form method="POST" id="msform" action="{{route('QAstore')}}" >
                                            @csrf
                                        <div class="form-row">
                                                <input type="hidden" name="property" value="{{$property->id}}">
                                                <div class="col-md-6">
                                                    <label for="">Status</label>
                                                    <select name="status" id="" class="form-control">
                                                        <option value="">Select a status</option>
                                                    <option {{$property->status == 'Document Missing' ? 'selected' : ''}} value="Document Missing">Document Missing</option>
                                                    <option {{$property->status == 'Blur Document' ? 'selected' : ''}} value="Blur Document">Blur Document</option>
                                                    <option {{$property->status == 'Wrong Attachement' ? 'selected' : ''}} value="Wrong Attachement">Wrong Attachement</option>
                                                    <option {{$property->status == 'Wrong Center' ? 'selected' : ''}} value="Wrong Center">Wrong Center</option>
                                                    <option {{$property->status == 'No Error' ? 'selected' : ''}} value="No Error">No Error</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Remarks</label>
                                                <input type="text" value="{{$property->remarks}}" name="remarks" class="form-control" placeholder="Remarks if any">
                                            </div>
                                            <button class="btn btn-primary form-control">Save</button>
                                        </form>
                                            
                                        </div>
                                        
                                </fieldset>
                                
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            // Check if body already has the sidebar-collapse class
            if (!document.body.classList.contains('sidebar-collapse')) {
                document.body.classList.add('sidebar-collapse');
            }
        });
        </script>

</x-app-layout>
