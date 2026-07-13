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
        input[type='text']{
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
    background-color: rgba(0,0,0,0.7);
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
    height:auto;
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

    </style>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col">

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                <form action="/fd-property-transfer/{{$property->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2 id="heading">Mangla Dam Housing Authority</h2>
                    <p id="subheading">File Transfer Request</p>

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
                                <option {{$property->center == 'Mirpur' ? 'selected' : '' }} value="Mirpur">Mirpur</option>
                                <option {{$property->center == 'Islam Garh' ? 'selected' : '' }} value="Islam Garh">Islam Garh</option>
                                <option {{$property->center == 'Dudyal' ? 'selected' : '' }} value="Dudyal">Dudyal</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="">Locality/Revenue Village</label>
                            <input type="text" class="form-control" readonly name="locality" value="{{$property->locality}}" id="locality" value="" />
                        </div>
                        <div class="col-md-4">
                            <label class="">Code</label>
                            <input type="text" class="form-control" readonly name="code" value="{{$property->code}}" id="code" placeholder="Enter Code" />
                        </div>
                        <div class="col-md-4">
                            <label class="">Plot No</label>
                            <input type="text" class="form-control" readonly name="plot_no" id="plot_no" value="{{$property->plot_no}}" placeholder="Enter Plot No" />
                        </div>
                        <div class="col-md-4">
                            <label for="name">Town/City</label>
                            <select name="town" class="form-control" id="town" disabled>
                                <option value="" disabled selected>Select Town/City</option>
                                <option {{$property->town == '1' ? 'selected' : '' }} value="1">New City Mirpur</option>
                                <option {{$property->town == '2' ? 'selected' : '' }} value="2">New Small Town Islamgarh</option>
                                <option {{$property->town == '3' ? 'selected' : '' }} value="3">New Small Town Chaksawari</option>
                                <option {{$property->town == '4' ? 'selected' : '' }} value="4">New Small Town Dudyal</option>
                                <option {{$property->town == '5' ? 'selected' : '' }} value="5">New Small Town Siakh</option>
                            </select>
                        </div>
                        <input type="hidden" name="town" value="{{$property->town}}">
                        <input type="hidden" name="sector" value="{{$property->sector}}">
                        <input type="hidden" name="type" value="{{$type}}">
                        <div class="col-md-4">
                            <label for="sector">Sector</label>
                            <input type="text" name="sector" readonly value="{{$property->sector}}" id="sector" class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                             @if($type == 1)
                            <h2 class="fs-title">Current Owner (Seller):</h2>
                            @elseif($type == 4)
                            <h2 class="fs-title">Current Owner (Transferer):</h2>
                             @endif
                        </div>
                    </div>
                    @foreach($property->owners as $key => $value)
                        
                    <div class="form-row">
                        
                        <div class="col-md-4">
                            <label class="">Name</label>
                            <input type="text" class="form-control" id="declarer_name" readonly name="declarer_name"
                            placeholder="Enter Current Owner"
                            value="{{  $value->name ?? ''}}" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="">Father's Name</label>
                            <input type="text" class="form-control" id="declarer_father1" readonly name="declarer_fname"
                            placeholder="Enter Father Name"
                            value="{{$value->father_name}}" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>

            
                        <div class="col-md-4">
                            <label class="">CNIC</label>
                            <input type="number" class="form-control" readonly name="declarer_cnic"
                            placeholder="Enter CNIC"
                            value="{{  $property->cnic ?? ''}}" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
                        
                        
                        <div class="col-md-4">
                            <label for="name">Area Measurement</label>
                            <div class="row">
                                {{-- <div class="col">
                                    <label for="name">Acre</label>
                                    <input type="text" id="dm_acre" placeholder="acre" name="dm_acre" class="form-control"
                                    value="
                                    ">
                                </div> --}}
                                <div class="col">
                                    <label for="name">Kanal</label>
                                    <input type="text" id="dm_kanal"  placeholder="kanal" name="kanal" class="form-control"
                                    value="{{$property->kanal}}" readonly>
                                </div>
                                            <div class="col">
                                                <label for="name">Marla</label>
                                                <input type="text" id="dm_marla" placeholder="marla" name="marla" class="form-control"
                                                value="{{$value->area}}" readonly>
                                            </div>
                                            <div class="col">
                                                <label for="name">Squarefeet</label>
                                                <input type="text" id="dm_sqrft" placeholder="sqrft" name="sqrft" class="form-control"
                                                value="{{$property->sqrft}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label class="">Phone No</label>
                                        <input type="number" class="form-control"  name="phone_no"
                                        placeholder="Enter Seller Phone No"
                                        />
                                        <div class="invalid-feedback" id="error-paddress"></div>
                                    </div>
                                    
                                    
                                </div>
                                @endforeach
                                
            
                
                    <div class="row">
                        <div class="col-7">
                            @if($type == 1)
                            <h2 class="fs-title">Transfer To (Buyer):</h2>
                            @elseif($type == 4)
                            <h2 class="fs-title">Transfer To (Warassat):</h2>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-row">
                       
                        <div class="col-md-4">
                            <label class="">Name</label>
                            <input type="text" class="form-control" id="transferee_name" name="transferee_name"
                            placeholder="Enter Tranferee Name"
                            value="" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="">Father's Name</label>
                            <input type="text" class="form-control" id="transferee_father1" name="transferee_fname"
                            placeholder="Enter Father Name"
                            value="" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="">CNIC</label>
                            <input type="number" class="form-control" name="tranferee_cnic"
                            placeholder="Enter CNIC"
                            value="" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
                         
                        <div class="col-md-4 ">
                            <label class="">Amount</label>
                            <input type="number" class="form-control"  name="amount"
                            placeholder="Enter Sold Price"
                            value="" />
                        </div>
                       
                    </div>

                    <div class="row mt-4">
                        <div class="col-7">
                            <h2 class="fs-title">Declaration:</h2>
                        </div>
                    </div>

                    <div class="form-row mt-2">
                        <div class="col">
                            <p id="declare">
                                I, <span id="declarer-name">{{$property->allotee_name}}</span>, SO/DO <span id="declarer-fname">{{$property->allotee_name}}</span>, hereby declare that I am the lawful owner of <span>Plot No </span><span id="plot-no">{{$property->plot_no}}</span>, situated at <span id="town-name">@php
                                    $town = DB::table('towns')->where('id',$property->town)->first();
                                    echo $town->name;
                                @endphp</span><span id="sector1">,Sector {{$property->sector}}</span>, and I willingly transfer the said plot to <span id="transferee-name">[Recipient Name]</span>, son of <span id="transferee-fname">[Recipient's Father]</span>, without any pressure, coercion, or undue influence.

                                I further affirm that there is no financial liability, mortgage, or encumbrance on the said plot. All dues, if any, have been cleared, and I assume full responsibility for the accuracy of this declaration.

                                This transfer is carried out entirely of my own free will and with mutual understanding.
                            </p>
                        </div>
                    </div>
                    <div class="form-row">
                        @foreach($property->owners as $key => $value)
                        <input type="hidden" name="cnic_front" value="{{$value->cnic_front}}">
                        <input type="hidden" name="cnic_back" value="{{$value->cnic_back}}">
                        <div class="col-md-4">
                            <label class="">CNIC Front</label><br>
                            @if($value->cnic_front != null)
                            <a href="#" onclick="openModal('cnic-front-modal')">View CNIC Front Attachement</a>
                            @endif
                            <input type="file" class="form-control" name="cnic_front"
                                accept="image/*" capture="environment" />
                            <div class="invalid-feedback" id="error-cnic-front"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="">CNIC Back</label><br>
                            @if($value->cnic_back != null)
                            <a href="#" onclick="openModal('cnic-back-modal')">View CNIC Back Attachement</a>
                             @endif
                            <input type="file" class="form-control" name="cnic_back"
                                accept="image/*" capture="environment" />
                            <div class="invalid-feedback" id="error-cnic-back"></div>
                        </div>
                        @endforeach

                    </div>
                    <div id="cnic-front-modal" class="custom-modal">
                        <div class="custom-modal-content">
                            <span class="custom-close" onclick="closeModal('cnic-front-modal')">&times;</span>
                            <img src="{{ asset('uploads/user/cnic/' . $value->cnic_front) }}" alt="CNIC Front" class="custom-modal-img">
                        </div>
                    </div>

                    <!-- CNIC Back Modal -->
                    <div id="cnic-back-modal" class="custom-modal">
                        <div class="custom-modal-content">
                            <span class="custom-close" onclick="closeModal('cnic-back-modal')">&times;</span>
                            <img src="{{ asset('uploads/user/cnic/' . $value->cnic_back) }}" alt="CNIC Back" class="custom-modal-img">
                        </div>
                    </div>
                    <div class="row text-center">
                        
                        <button type="submit" class="btn btn-primary mt-3 mx-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Update declaration dynamically
    const declarerName = document.getElementById("declarer-name");
    const declarerFather = document.getElementById("declarer-fname");
    const plotNo = document.getElementById("plot-no");
    const townName = document.getElementById("town-name");
    const sector = document.getElementById("sector1");
    const transfereeName = document.getElementById("transferee-name");
    const transfereeFather = document.getElementById("transferee-fname");

    // Map input names to corresponding declaration span IDs
    const fieldMap = {
        "declarer_name": declarerName,
        "declarer_fname": declarerFather, // Fixed underscore
        "plot_no": plotNo,
        "town": townName,
        "sector": sector,
        "transferee_name": transfereeName,
        "transferee_fname": transfereeFather // Fixed underscore
    };

    // Add event listener to all relevant input fields
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const targetSpan = fieldMap[e.target.name]; // Find the corresponding span element
            if (targetSpan) {
                if (e.target.name === 'sector') {
                    targetSpan.innerText = `, Sector ${e.target.value}` || `[${e.target.name}]`; // Custom behavior for sector
                } else {
                    targetSpan.innerText = e.target.value || `[${e.target.name}]`; // Default update for other fields
                }
            }
        });
    });
});



    </script>
    <script>
function openModal(id) {
    document.getElementById(id).style.display = "block";
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
}

// Optional: close modal when clicking outside content
window.onclick = function(event) {
    const modals = document.querySelectorAll('.custom-modal');
    modals.forEach(function(modal) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
};
</script>
</x-app-layout>
