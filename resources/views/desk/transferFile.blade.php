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
                                        <input type="file" class="form-control" name="owners[{{$owner->id}}][cnic_front]" id="">
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
                                        <input type="file" class="form-control" name="owners[{{$owner->id}}][cnic_back]" id="">
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

                            {{-- Options Block --}}
                            <div id="seller-options-{{ $owner->id }}" class="hidden mt-2">
                                <label>Who is making the request?</label><br>
                                <input type="radio" name="seller_mode[{{ $owner->id }}]" value="self"
                                    onchange="toggleAttorneySection({{ $owner->id }}, false)"> Self
                                <input type="radio" name="seller_mode[{{ $owner->id }}]" value="attorney"
                                    onchange="toggleAttorneySection({{ $owner->id }}, true)"> Attorney

                                {{-- Individual Attorney Section --}}
                                <div id="attorney-section-{{ $owner->id }}" class="hidden mt-3 border p-3">
                                    <h6>Attorney Details (on behalf of {{ $owner->name }})</h6>

                                    <div class="row" id="attorney-fields-{{ $owner->id }}">
                                        <div class="col-md-3">
                                            <label>Attorney Name</label>
                                            <input type="text" name="attorney[{{ $owner->id }}][name]" class="form-control"
                                                placeholder="Enter Name">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Attorney's Father Name</label>
                                            <input type="text" name="attorney[{{ $owner->id }}][father_name]"
                                                class="form-control" placeholder="Enter Father Name">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Attorney CNIC</label>
                                            <input type="text" name="attorney[{{ $owner->id }}][cnic]" class="form-control"
                                                placeholder="Enter cnic">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Phone No</label>
                                            <input type="text" name="attorney[{{ $owner->id }}][phone]" class="form-control"
                                                placeholder="Enter Phone No">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Address</label>
                                            <input type="text" name="attorney[{{ $owner->id }}][address]"
                                                class="form-control" placeholder="Ente Address">
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <label>Attorney Letter</label>
                                            <input type="file" name="attorney[{{ $owner->id }}][attorney_letter]"
                                                class="form-control" accept="">
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <label>CNIC Front</label>
                                            <input type="file" name="attorney[{{ $owner->id }}][cnic_front]"
                                                class="form-control" accept="image/*">
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <label>CNIC Back</label>
                                            <input type="file" name="attorney[{{ $owner->id }}][cnic_back]"
                                                class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        {{-- Shared Attorney Section --}}
                        <div class="form-check mb-3 ml-1">

                            <input type="checkbox" class="form-check-input" id="use-shared-attorney" name="shared_attorney_check" value="1"
                                onchange="toggleSharedAttorney()">
                            <label class="form-check-label" for="use-shared-attorney">
                                Use Shared Attorney for all sellers
                            </label>
                        </div>

                        <!-- Shared Attorney Block -->
                        <div id="shared-attorney-block" class="hidden border p-3 mb-4">
                            <h5>Shared Attorney Details</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Attorney Name</label>
                                    <input type="text" name="shared_attorney[name]" class="form-control"
                                        placeholder="Enter Name">
                                </div>
                                <div class="col-md-3">
                                    <label>Attorney's Father Name</label>
                                    <input type="text" name="shared_attorney[father_name]" class="form-control"
                                        placeholder="Enter Father Name">
                                </div>
                                <div class="col-md-3">
                                    <label>Attorney CNIC</label>
                                    <input type="text" name="shared_attorney[cnic]" class="form-control"
                                        placeholder="Enter cnic">
                                </div>
                                <div class="col-md-3">
                                    <label>Phone No</label>
                                    <input type="text" name="shared_attorney[phone]" class="form-control"
                                        placeholder="Enter Phone No">
                                </div>
                                <div class="col-md-3">
                                    <label>Address</label>
                                    <input type="text" name="shared_attorney[address]" class="form-control"
                                        placeholder="Ente Address">
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label>Attorney Letter</label>
                                    <input type="file" name="shared_attorney[attorney_letter]" class="form-control"
                                        accept="">
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label>CNIC Front</label>
                                    <input type="file" name="shared_attorney[cnic_front]" class="form-control"
                                        accept="image/*">
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label>CNIC Back</label>
                                    <input type="file" name="shared_attorney[cnic_back]" class="form-control"
                                        accept="image/*">
                                </div>
                            </div>
                        </div>
                        <h3 class="fs-title">{{$type == 1 ? 'Buyer Details' : 'Receiver Details'}}</h3>
                      <div id="buyer-outer-container">
                        <!-- First Buyer Block -->
                        <div class="buyer-item border p-3 mb-4" id="buyer-0">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">{{$type == 1 ? 'Buyer #1' : 'Receiver Details #1'}}</h5>
                            </div>

                            <!-- Buyer Basic Info -->
                            <div class="row">
                                 <div class="col-md-4">
                                <label>{{$type == 1 ? 'Buyer Name' : 'Receiver Name'}}</label>
                                <input type="text" name="buyers[0][name]" class="form-control" placeholder="Enter Name">
                            </div>
                            <div class="col-md-4">
                                <label>{{$type == 1 ? 'Buyer Father Name' : "Receiver's Father Name"}}</label>
                                <input type="text" name="buyers[0][fname]" class="form-control"
                                    placeholder="Enter Father Name">
                            </div>
                            <div class="col-md-4">
                                <label>{{$type == 1 ? 'Buyer CNIC' : 'Receiver CNIC'}}</label>
                                <input type="text" name="buyers[0][cnic]" class="form-control" placeholder="Enter CNIC">
                            </div>
                            <input type="hidden" name="sold_price" value="0">
                            @if($type == 1)
                            <div class="col-md-4">
                                <label>Sold Price</label>
                                <input type="text" name="sold_price" class="form-control" placeholder="Enter Sold Price">
                            </div>
                            @endif
                            <div class="col-md-4">
                                <label>CNIC Front</label>
                                <input type="file" name="buyers[0][cnic_front]" class="form-control" placeholder="Enter Sold Price">
                            </div>
                            <div class="col-md-4">
                                <label>CNIC Back</label>
                                <input type="file" name="buyers[0][cnic_back]" class="form-control" placeholder="Enter Sold Price">
                            </div>
                            </div>

                            <!-- Toggle for Representative -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="buyers[0][mode]" value="self" id="self-0"
                                            class="form-check-input" onchange="toggleRep(0, false)" checked>
                                        <label for="self-0" class="form-check-label">Self</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="buyers[0][mode]" value="representative" id="rep-0"
                                            class="form-check-input" onchange="toggleRep(0, true)">
                                        <label for="rep-0" class="form-check-label">Representative</label>
                                    </div>
                                </div>
                            </div>

                            <!-- FULL REPRESENTATIVE FIELDS (Initially Hidden) -->
                            <div id="rep-fields-0" class="d-none mt-3 p-3 bg-light border shadow-sm">
                                <h6 class="text-primary font-weight-bold">Representative Details</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Representative Name</label>
                                        <input type="text" name="buyers[0][rep_name]" class="form-control" placeholder="Enter Name">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Father Name</label>
                                        <input type="text" name="buyers[0][rep_fname]" class="form-control" placeholder="Enter Father Name">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Representative CNIC</label>
                                        <input type="text" name="buyers[0][rep_cnic]" class="form-control" placeholder="Enter CNIC">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Phone No</label>
                                        <input type="text" name="buyers[0][rep_phone]" class="form-control" placeholder="Enter Phone No">
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label>Address</label>
                                        <input type="text" name="buyers[0][rep_address]" class="form-control" placeholder="Enter Address">
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label>Attorney Letter/Document</label>
                                        <input type="file" name="buyers[0][rep_attorney_letter]" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label>CNIC Front</label>
                                        <input type="file" name="buyers[0][rep_cnic_front]" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label>CNIC Back</label>
                                        <input type="file" name="buyers[0][rep_cnic_back]" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 offset-md-10">
                        <button type="button" class="btn btn-primary" onclick="addBuyer()">+ Add Another Buyer</button>
                    </div>
                    {{-- Shared Buyer Representative Section --}}
<div class="form-check mb-3 ml-1">
    <input type="checkbox" class="form-check-input" id="use-shared-rep" name="shared_rep_check" value="1"
        onchange="toggleSharedRepresentative()">
    <label class="form-check-label" for="use-shared-rep">
        Use Shared Representative for all buyers/receivers
    </label>
</div>

<div id="shared-rep-block" class="hidden border p-3 mb-4 bg-light">
    <h5 class="text-primary">Shared Representative Details</h5>
    <div class="row">
        <div class="col-md-3">
            <label>Representative Name</label>
            <input type="text" name="shared_representative[name]" class="form-control" placeholder="Enter Name">
        </div>
        <div class="col-md-3">
            <label>Father Name</label>
            <input type="text" name="shared_representative[father_name]" class="form-control" placeholder="Enter Father Name">
        </div>
        <div class="col-md-3">
            <label>CNIC</label>
            <input type="text" name="shared_representative[cnic]" class="form-control" placeholder="Enter CNIC">
        </div>
        <div class="col-md-3">
            <label>Phone No</label>
            <input type="text" name="shared_representative[phone]" class="form-control" placeholder="Enter Phone No">
        </div>
        <div class="col-md-4 mt-2">
            <label>Address</label>
            <input type="text" name="shared_representative[address]" class="form-control" placeholder="Enter Address">
        </div>
        <div class="col-md-4 mt-2">
            <label>Attorney Letter</label>
            <input type="file" name="shared_representative[rep_attorney_letter]" class="form-control">
        </div>
        <div class="col-md-2 mt-2">
            <label>CNIC Front</label>
            <input type="file" name="shared_representative[rep_cnic_front]" class="form-control">
        </div>
        <div class="col-md-2 mt-2">
            <label>CNIC Back</label>
            <input type="file" name="shared_representative[rep_cnic_back]" class="form-control">
        </div>
    </div>
</div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function toggleSellerOptions(ownerId) {
            const block = document.getElementById('seller-options-' + ownerId);
            const checkbox = document.getElementById('seller-request-' + ownerId);
            block.classList.toggle('hidden', !checkbox.checked);
        }

        function toggleAttorneySection(ownerId, show) {
            const section = document.getElementById('attorney-section-' + ownerId);
            const sharedActive = document.getElementById('use-shared-attorney').checked;

            // if shared attorney is active → hide personal attorney fields
            if (sharedActive) {
                section.classList.add('hidden');
            } else {
                section.classList.toggle('hidden', !show);
            }
        }





        function toggleSharedAttorney() {
            const sharedBlock = document.getElementById('shared-attorney-block');
            const isChecked = document.getElementById('use-shared-attorney').checked;

            // show/hide shared attorney form
            sharedBlock.classList.toggle('hidden', !isChecked);

            // hide all individual attorney sections if shared is checked
            document.querySelectorAll('[id^="attorney-section-"]').forEach(sec => {
                if (isChecked) {
                    sec.classList.add('hidden');
                }
            });
        }
        </script>

<script>
    let buyerIndex = 1;
    let type = @json($type);

    function toggleRep(index, show) {
        const repDiv = document.getElementById(`rep-fields-${index}`);
        if (repDiv) {
            if (show) {
                repDiv.classList.remove('d-none');
            } else {
                repDiv.classList.add('d-none');
            }
        }
    }

    // Function to handle removal
    function removeBuyer(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.remove();
                buyerIndex--; // Decrement index to keep track of buyers, optional based on how you want to handle naming of new buyers after deletion
        }
    }

    function addBuyer() {
        const container = document.getElementById('buyer-outer-container');
        const isTypeOne = @json($type == 1);

        const html = `
            <div class="buyer-item border p-3 mb-4" id="buyer-${buyerIndex}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">${type == 1 ? 'Buyer #' : 'Receiver Details #'}${buyerIndex + 1}</h5>
                    <!-- Updated Remove Button -->
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeBuyer('buyer-${buyerIndex}')">
                        Remove Buyer
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label>${type == 1 ? 'Buyer Name' : 'Receiver Name'}</label>
                        <input type="text" name="buyers[${buyerIndex}][name]" class="form-control" placeholder="Enter Name">
                    </div>
                    <div class="col-md-4">
                        <label>${type == 1 ? 'Buyer Father Name' : "Receiver's Father Name"}</label>
                        <input type="text" name="buyers[${buyerIndex}][fname]" class="form-control" placeholder="Enter Father Name">
                    </div>
                    <div class="col-md-4">
                        <label>${type == 1 ? 'Buyer CNIC' : 'Receiver CNIC'}</label>
                        <input type="text" name="buyers[${buyerIndex}][cnic]" class="form-control" placeholder="Enter CNIC">
                    </div>

                    ${isTypeOne ? `
                    <div class="col-md-4 mt-2">
                        <label>Sold Price</label>
                        <input type="text" name="buyers[${buyerIndex}][sold_price]" class="form-control" placeholder="Enter Sold Price">
                    </div>
                    ` : `<input type="hidden" name="buyers[${buyerIndex}][sold_price]" value="0">`}

                    <div class="col-md-4 mt-2">
                        <label>CNIC Front</label>
                        <input type="file" name="buyers[${buyerIndex}][rep_cnic_front]" class="form-control">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>CNIC Back</label>
                        <input type="file" name="buyers[${buyerIndex}][rep_cnic_back]" class="form-control">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-check form-check-inline">
                            <input type="radio" name="buyers[${buyerIndex}][mode]" value="self" id="self-${buyerIndex}"
                                   class="form-check-input" onchange="toggleRep(${buyerIndex}, false)" checked>
                            <label for="self-${buyerIndex}" class="form-check-label">Self</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="buyers[${buyerIndex}][mode]" value="representative" id="rep-${buyerIndex}"
                                   class="form-check-input" onchange="toggleRep(${buyerIndex}, true)">
                            <label for="rep-${buyerIndex}" class="form-check-label">Representative</label>
                        </div>
                    </div>
                </div>

                <div id="rep-fields-${buyerIndex}" class="d-none mt-3 p-3 bg-light border shadow-sm">
                    <h6 class="text-primary font-weight-bold">Representative Details</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Representative Name</label>
                            <input type="text" name="buyers[${buyerIndex}][rep_name]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Father Name</label>
                            <input type="text" name="buyers[${buyerIndex}][rep_fname]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Representative CNIC</label>
                            <input type="text" name="buyers[${buyerIndex}][rep_cnic]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Phone No</label>
                            <input type="text" name="buyers[${buyerIndex}][rep_phone]" class="form-control">
                        </div>
                        <div class="col-md-3 mt-2">
                            <label>Address</label>
                            <input type="text" name="buyers[${buyerIndex}][rep_address]" class="form-control">
                        </div>
                        <div class="col-md-3 mt-2">
                            <label>Attorney Letter</label>
                            <input type="file" name="buyers[${buyerIndex}][rep_attorney_letter]" class="form-control">
                        </div>
                        <div class="col-md-3 mt-2">
                            <label>CNIC Front</label>
                            <input type="file" name="buyers[${buyerIndex}][rep_cnic_front]" class="form-control">
                        </div>
                        <div class="col-md-3 mt-2">
                            <label>CNIC Back</label>
                            <input type="file" name="buyers[${buyerIndex}][rep_cnic_back]" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        buyerIndex++;
    }

function toggleSharedRepresentative() {
    const sharedBlock = document.getElementById('shared-rep-block');
    const isChecked = document.getElementById('use-shared-rep').checked;

    // Show/Hide shared block
    sharedBlock.classList.toggle('hidden', !isChecked);

    if (isChecked) {
        // 1. Find all individual representative sections
        const individualRepSections = document.querySelectorAll('[id^="rep-fields-"]');

        individualRepSections.forEach(section => {
            // Hide the individual section
            section.classList.add('d-none');

            // 2. Clear all text and file inputs inside that individual section
            const inputs = section.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
            });
        });

        // 3. Uncheck BOTH 'Self' and 'Representative' radio buttons for all buyers
        // This ensures the user must rely on the Shared Representative data
        document.querySelectorAll('input[name^="buyers"][type="radio"]').forEach(radio => {
            radio.checked = false;
        });

        // Optional: If you want to disable them so they can't be clicked while shared is active
        document.querySelectorAll('input[name^="buyers"][type="radio"]').forEach(radio => {
            radio.disabled = true;
        });

    } else {
        // 4. Re-enable radio buttons and default back to 'Self' when shared is unchecked
        document.querySelectorAll('input[name^="buyers"][type="radio"]').forEach(radio => {
            radio.disabled = false;
        });

        // Set all to 'Self' by default when returning to individual mode
        document.querySelectorAll('input[id^="self-"]').forEach(radio => {
            radio.checked = true;
        });
    }
}

// Update your existing toggleRep to prevent opening individual reps
// if the shared representative checkbox is checked
function toggleRep(index, show) {
    const isSharedChecked = document.getElementById('use-shared-rep').checked;
    const repDiv = document.getElementById(`rep-fields-${index}`);

    if (repDiv) {
        if (show && !isSharedChecked) {
            repDiv.classList.remove('d-none');
        } else {
            repDiv.classList.add('d-none');
            // If user tries to click 'Representative' while shared is on, alert them
            if (show && isSharedChecked) {
                alert("Shared Representative is currently active. Uncheck it to set individual representatives.");
                document.getElementById(`self-${index}`).checked = true;
            }
        }
    }
}
</script>



    </x-app-layout>
