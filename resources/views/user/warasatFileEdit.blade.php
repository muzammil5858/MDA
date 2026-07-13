<x-app-layout>
    {{-- Keep the same styles --}}
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
    </style>

    <div class="container">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('transfer_update', $exist->request_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    

                    <h2 id="heading">Mangla Dam Housing Authority</h2>
                    <p id="subheading">Edit File Transfer</p>

                    <div class="form-row mt-2">
                        <div class="col-md-4">
                            <label>District</label>
                            <select name="district" class="form-control" id="district" readonly>
                                <option selected>Mirpur</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Tehsil</label>
                            <select class="form-control" disabled>
                                <option selected>{{ $property->center }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Locality</label>
                            <input type="text" class="form-control" readonly value="{{ $property->locality }}">
                        </div>
                        <div class="col-md-4">
                            <label>Code</label>
                            <input type="text" class="form-control" readonly value="{{ $property->code }}">
                        </div>
                        <div class="col-md-4">
                            <label>Plot No</label>
                            <input type="text" class="form-control" readonly value="{{ $property->plot_no }}">
                        </div>
                        <div class="col-md-4">
                            <label>Town/City</label>
                            <select class="form-control" disabled>
                                <option selected>
                                    {{ DB::table('towns')->where('id', $property->town)->value('name') }}
                                </option>
                            </select>
                        </div>

                        <input type="hidden" name="town" value="{{ $property->town }}">
                        <input type="hidden" name="sector" value="{{ $property->sector }}">
                        

                        <div class="col-md-4">
                            <label>Sector</label>
                            <input type="text" class="form-control" readonly value="{{ $property->sector }}">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-7">
                            <h2 class="fs-title">Current Owner (Transferer):</h2>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label>Name</label>
                            <input type="text" class="form-control" name="declarer_name" readonly value="{{ $property->allotee_name }}">
                        </div>
                        <div class="col-md-4">
                            <label>Father's Name</label>
                            <input type="text" class="form-control" name="declarer_fname" readonly value="{{ $property->relation }}">
                        </div>
                        <div class="col-md-4">
                            <label>CNIC</label>
                            <input type="text" class="form-control" name="declarer_cnic" readonly value="{{ $property->cnic }}">
                        </div>
                        <div class="col-md-4">
                                        <label for="name">Area Measurement</label>
                                        <div class="row">
                                           
                                            <div class="col">
                                                <label for="name">Kanal</label>
                                                <input type="text" id="dm_kanal"  placeholder="kanal" name="kanal" class="form-control"
                                                value="{{$property->kanal}}" readonly>
                                            </div>
                                            <div class="col">
                                                <label for="name">Marla</label>
                                                <input type="text" id="dm_marla" placeholder="marla" name="marla" class="form-control"
                                                value="{{$property->marla}}" readonly>
                                            </div>
                                            <div class="col">
                                                <label for="name">Squarefeet</label>
                                                <input type="text" id="dm_sqrft" placeholder="sqrft" name="sqrft" class="form-control"
                                                value="{{$property->sqrft}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                        <div class="col-md-4 mt-4">
                            <label>Date of Death</label>
                            <input type="date" class="form-control" name="death_date" value="{{\Carbon\Carbon::parse($exist->death_date)->format('Y-m-d')}}">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-7">
                            <h2 class="fs-title">Transfer To (Warassat):</h2>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label>Name</label>
                            <input type="text" class="form-control" name="transferee_name" value="{{ $exist->transferee_name }}">
                        </div>
                        <div class="col-md-4">
                            <label>Father's Name</label>
                            <input type="text" class="form-control" name="transferee_fname" value="{{ $exist->transferee_fname }}">
                        </div>
                        <div class="col-md-4">
                            <label>CNIC</label>
                            <input type="text" class="form-control" name="tranferee_cnic" value="{{ $exist->tranferee_cnic }}">
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
                                It is stated that <span>Plot No</span> <span id="plot-no">{{ $property->plot_no }}</span>, located in
                                <span id="town-name">{{ $property->township->name}}</span><span id="sector1">,Sector {{ $property->sector }}</span>,
                                belongs to {!! $property->owner->map(function($owner) use ($property) {
    return '<span id="declarer-name">' . e($owner->name) . '</span> S/O <span id="declarer-fname">' . e($property->father_name) . '</span>';
})->join(' ، ') !!}. He passed away on
                                <span id="death_date">{{ \Carbon\Carbon::parse($exist->death_date)->format('Y-m-d') ?? '[Date of Death]' }}</span>.<br>

                                Mr. <span id="transferee-name">{{ $exist->transferee_name ?? '[Recipient Name]' }}</span>, son of
                                <span id="transferee-fname">{{ $exist->transferee_fname ?? '[Recipient Father]' }}</span>, has appeared as one of the legal heirs of the deceased for the purpose of transferring the said plot through Warasat.

                                It is confirmed that there is no financial liability, mortgage, or encumbrance on the said plot, and all dues, if any, have been cleared. This Warasat transfer request is made with full mutual understanding among all legal heirs and is being carried out entirely in good faith and accordance with inheritance laws.
                            </p>
                        </div>
                    </div>

                    <div class="form-row">
    <div class="col-md-4">
        <label>Death Certificate</label>
        <input type="file" class="form-control" name="cnic_front" accept="image/*" />

        @if (!empty($exist->cnic_front))
            <div class="mt-2">
                <p class="mb-1">Current Attachment:</p>
                <a href="{{ asset('uploads/certificates/' . $exist->cnic_front) }}" target="_blank">
                    <img src="{{ asset('uploads/certificates/' . $exist->cnic_front) }}"
                         alt="Death Certificate"
                         style="max-width: 100%; height: auto; border: 1px solid #ccc; padding: 4px;">
                </a>
            </div>
        @endif
    </div>
</div>


                    <div class="row text-center">
                        <button type="submit" class="btn btn-primary mt-4 mx-auto">Update Transfer</button>
                    </div>
                </form>
            </div>
        </div>
         <script>
document.addEventListener("DOMContentLoaded", function () {
    // Map form input name attributes to corresponding span IDs
    const fieldMap = {
        "declarer_name": "declarer-name",
        "declarer_fname": "declarer-fname",
        "plot_no": "plot-no",
        "town": "town-name",
        "sector": "sector1",
        "transferee_name": "transferee-name",
        "transferee_fname": "transferee-fname",
        "declarer_ddate": "death_date"
    };

    // Attach input event listeners to all input/select elements
    document.querySelectorAll('input[name], select[name]').forEach(input => {
        input.addEventListener('input', function () {
            const spanId = fieldMap[this.name];
           
            const targetSpan = document.getElementById(spanId);

            if (targetSpan) {
                if (this.name === "sector" && this.value) {
                    targetSpan.innerText = `, Sector ${this.value}`;
                } else {
                    targetSpan.innerText = this.value || `[${this.name}]`;
                }
            }
        });
    });
});
</script>
    </div>
</x-app-layout>
