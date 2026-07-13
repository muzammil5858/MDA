<x-app-layout>
    <style>
        .fs-title {
            font-size: 25px;
            color: #03346E;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left;
        }

        .container {
            background: #F4F6F9;
            border: 1px solid #F4F6F9;
        }

        .card {
            margin-top: 40px;
        }

        .card-body {
            padding-top: 30px;
            background: white;
        }

        #heading {
            text-transform: uppercase;
            color: #03346E;
            font-weight: bolder;
            font-size: 1.5rem;
            text-align: center;
        }

        #subheading {
            font-size: 1.2rem;
            padding: 5px 0;
            text-align: center;
        }

        #declare {
            font-size: 1.2rem;
            padding: 5px 0;
        }

        span {
            font-weight: bold;
        }

        input[type='text'] {
            /* border:1px solid lightgra */
        }

        .custom-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .custom-modal-content {
            background-color: #fff;
            margin: 1% auto;
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            text-align: center;
            position: relative;
        }

        .custom-modal-img {
            max-width: 100%;
            border-radius: 5px;
            height: auto;
        }

        .custom-close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            cursor: pointer;
        }

        .hidden {
            display: none !important;
        }
    </style>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">

                <form action="/fd-property-transfer/{{$property->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    ` <h2 id="heading">Mangla Dam Housing Authority</h2>
                    <p id="subheading">File Transfer Request</p>
                    <div class="row">
                        <div class="col-12">

                            @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                            <h5><i class="fa fa-exclamation-circle"></i> Please fix the following errors:</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-4">
                            <label class="">District</label>
                            <select name="district" class="form-control" id="district">
                                <option value="Mirpur" selected>Mirpur</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="">Tehsil</label>
                            <select name="center" class="form-control" id="tehsil" disabled>
                                <option value="" disabled selected>Select Center</option>
                                <option {{$property->center == 'Mirpur' ? 'selected' : '' }} value="Mirpur">Mirpur
                                </option>
                                <option {{$property->center == 'Islam Garh' ? 'selected' : '' }} value="Islam
                                    Garh">Islam Garh</option>
                                <option {{$property->center == 'Dudyal' ? 'selected' : '' }} value="Dudyal">Dudyal
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="">Locality/Revenue Village</label>
                            <input type="text" class="form-control" readonly name="locality"
                                value="{{$property->locality}}" id="locality" value="" />
                        </div>
                        <div class="col-md-4">
                            <label class="">Code</label>
                            <input type="text" class="form-control" readonly name="code" value="{{$property->code}}"
                                id="code" placeholder="Enter Code" />
                        </div>
                        <div class="col-md-4">
                            <label class="">Plot No</label>
                            <input type="text" class="form-control" readonly name="plot_no" id="plot_no"
                                value="{{$property->plot_no}}" placeholder="Enter Plot No" />
                        </div>
                        <div class="col-md-4">
                            <label for="name">Town/City</label>
                            <select name="town" class="form-control" id="town" disabled>
                                <option value="" disabled selected>Select Town/City</option>
                                <option {{$property->town == '1' ? 'selected' : '' }} value="1">New City Mirpur</option>
                                <option {{$property->town == '2' ? 'selected' : '' }} value="2">New Small Town Islamgarh
                                </option>
                                <option {{$property->town == '3' ? 'selected' : '' }} value="3">New Small Town
                                    Chaksawari</option>
                                <option {{$property->town == '4' ? 'selected' : '' }} value="4">New Small Town Dudyal
                                </option>
                                <option {{$property->town == '5' ? 'selected' : '' }} value="5">New Small Town Siakh
                                </option>
                            </select>
                        </div>
                        <input type="hidden" name="town" value="{{$property->town}}">
                        <input type="hidden" name="sector" value="{{$property->sector}}">
                        <input type="hidden" name="request_type" value="{{$type}}">
                        
                        <div class="col-md-4">
                            <label for="sector">Sector</label>
                            <input type="text" name="sector" readonly value="{{$property->sector}}" id="sector"
                                class="form-control" />
                        </div>
                    </div>
                    <h3 class="fs-title">Current Owners (Sellers)</h3>
                    @foreach($property->owners as $key => $owner)
                    <div class="border p-3 mb-3">
                        <h5>Owner {{ $key+1 }}</h5>

                        {{-- Seller Details --}}
                        <div class="row">
                            <div class="col-md-3">
                                <label>Owner Name</label>
                                <p class="subheading">{{ $owner->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <label>Owner's Father Name</label>
                                <p class="subheading">{{ $owner->father_name }}</p>
                            </div>
                            <div class="col-md-2">
                                <label>CNIC</label>
                                <p class="subheading">{{ $owner->cnic }}</p>
                            </div>
                            <div class="col-md-2">
                                <label>CNIC(Front)</label>
                                <div class="file-drop-area">
                                    @if($owner->cnic_front)
                                    <img class="img-preview" alt="Preview"
                                        src="/uploads/user/cnics/{{ $owner->cnic_front }}" />
                                    @else
                                    No Attachement Attached
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>CNIC(Back)</label>
                                <div class="file-drop-area">
                                    @if($owner->cnic_back)
                                    <img class="img-preview" alt="Preview"
                                        src="/uploads/user/cnics/{{ $owner->cnic_back }}" />
                                    @else
                                    No Attachement Attached
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox to Participate --}}
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="seller-request-{{ $owner->id }}"
                                name="seller_request[]" value="{{$owner->id}}"
                                onchange="toggleSellerOptions({{ $owner->id }})">
                            <label class="form-check-label" for="seller-request-{{ $owner->id }}">
                                Send Request
                            </label>
                        </div>
                    </div>
                    @endforeach

                    
                    <h3 class="fs-title">Recevier Detail</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Receiver Name</label>
                            <input type="text" name="buyer_name" class="form-control" placeholder="Enter Receiver Name" id="buyer_name">
                        </div>
                        <div class="col-md-4">
                            <label>Receiver's Father Name</label>
                            <input type="text" name="buyer_fname" class="form-control" id="buyer_fname"
                                placeholder="Enter Receiver's Father Name">
                        </div>
                        <div class="col-md-4">
                            <label>Receiver CNIC</label>
                            <input type="text" name="buyer_cnic" class="form-control" placeholder="Enter Receiver's CNIC">
                        </div>
                        <div class="col-md-4">
                            <label>Date of Death</label>
                            <input type="date" id="death_date" name="death_date" class="form-control" placeholder="Enter Receiver's CNIC">
                        </div>
                        <div class="col-md-4">
                            <label>Death Certificate</label>
                            <input type="file" name="death_certificate" class="form-control" placeholder="Enter Buyer's CNIC">
                        </div>
                         <div class="col-md-4">
                            <label>Death Place</label>
                            <input type="text" name="death_place" class="form-control" placeholder="Enter Place of death">
                        </div>
                    </div>
                    

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</x-app-layout>