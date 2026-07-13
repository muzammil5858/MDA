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
                <form action="/transfer-property/{{$property->id}}" method="POST" enctype="multipart/form-data">
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
                                <option {{$property->town == 'New City Mirpur' ? 'selected' : '' }} value="New City Mirpur">New City Mirpur</option>
                                <option {{$property->town == 'New Small Town Islamgarh' ? 'selected' : '' }} value="New Small Town Islamgarh">New Small Town Islamgarh</option>
                                <option {{$property->town == 'New Small Town Chaksawari' ? 'selected' : '' }} value="New Small Town Chaksawari">New Small Town Chaksawari</option>
                                <option {{$property->town == 'New Small Town Dudyal' ? 'selected' : '' }} value="New Small Town Dudyal">New Small Town Dudyal</option>
                                <option {{$property->town == 'New Small Town Siakh' ? 'selected' : '' }} value="New Small Town Siakh">New Small Town Siakh</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="sector">Sector</label>
                            <input type="text" name="sector" readonly value="{{$property->sector}}" id="sector" class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <h2 class="fs-title">Current Owner:</h2>
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="col-md-4">
                            <label class="">Name</label>
                            <input type="text" class="form-control" id="declarer_name" name="declarer_name"
                            placeholder="Enter Current Owner"
                            value="{{  $property->allotee_name ?? ''}}" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="">Father's Name</label>
                            <input type="text" class="form-control" id="declarer_father1" name="declarer_fname"
                            placeholder="Enter Father Name"
                            value="" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
            
                        <div class="col-md-4">
                            <label class="">CNIC</label>
                            <input type="text" class="form-control" name="declarer_cnic"
                            placeholder="Enter CNIC"
                            value="{{  $property->cnic ?? ''}}" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
                    </div>
            
                
                    <div class="row">
                        <div class="col-7">
                            <h2 class="fs-title">Transfer To:</h2>
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
                            <input type="text" class="form-control" name="tranferee_cnic"
                            placeholder="Enter CNIC"
                            value="" />
                            <div class="invalid-feedback" id="error-paddress"></div>
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
                                I, <span id="declarer-name">{{$property->allotee_name}}</span>, SO/DO <span id="declarer-fname">[Declarer's Father]</span>, hereby declare that I am the lawful owner of <span>Plot No </span><span id="plot-no">{{$property->plot_no}}</span>, situated at <span id="town-name">{{$property->town}}</span><span id="sector1">,Sector {{$property->sector}}</span>, and I willingly transfer the said plot to <span id="transferee-name">[Recipient Name]</span>, son of <span id="transferee-fname">[Recipient's Father]</span>, without any pressure, coercion, or undue influence.

                                I further affirm that there is no financial liability, mortgage, or encumbrance on the said plot. All dues, if any, have been cleared, and I assume full responsibility for the accuracy of this declaration.

                                This transfer is carried out entirely of my own free will and with mutual understanding.
                            </p>
                        </div>
                    </div>
                    <div class="form-row">
                       
                        <div class="col-md-4">
                            <label class="">Alotment Order </label>
                            <input type="file" class="form-control" id="" name="alotment_order"
                            placeholder="Enter Tranferee Name"
                            value="" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="">CNIC Front</label>
                            <input type="file" class="form-control" id="" name="cnic_front"
                            placeholder="Enter Father Name"
                            value="" />
                            <div class="invalid-feedback" id="error-paddress"></div>
                        </div>
            
                        <div class="col-md-4">
                            <label class="">CNIC Back</label>
                            <input type="file" class="form-control" name="cnic_back"
                            placeholder="Enter CNIC"
                            value="" />
                            <div class="invalid-feedback" id="error-paddress"></div>
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
</x-app-layout>
