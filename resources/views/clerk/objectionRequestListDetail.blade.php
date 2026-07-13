<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .info-label {
            font-weight: bold;
            color: #0f151d;
        }

        .info-value {
            margin-bottom: 15px;
        }

        .container {
            border: 1px solid lightgray;
            margin-bottom: 30px;
        }

        span {
            font-weight: bolder;
        }

        .objection-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge-resolved {
            background-color: #28a745;
            color: #fff;
        }

        .badge-rejected {
            background-color: #dc3545;
            color: #fff;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @forelse($properties as $property)
            <div class="container">
                <h4 class="text-center mt-4 mb-4">
                    Request #{{ $property->id }} -
                    {{ $property->participants->map(fn($owner) => $owner->owner->name ?? 'N/A')->implode(', ') }}
                </h4>

                <div class="accordion" id="propertyAccordion-{{ $property->id }}">
                    <!-- Request Information -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingRequest-{{ $property->id }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseRequest-{{ $property->id }}" aria-expanded="true"
                                aria-controls="collapseRequest-{{ $property->id }}">
                                Request Information
                            </button>
                        </h2>
                        <div id="collapseRequest-{{ $property->id }}" class="accordion-collapse collapse show"
                            aria-labelledby="headingRequest-{{ $property->id }}">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="info-label">Applicant Name</label>
                                        <div class="info-value">
                                            {{ $property->participants->map(fn($owner) => $owner->owner->name ?? 'N/A')->implode(', ') ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Applicant CNIC</label>
                                        <div class="info-value">
                                            {{ $property->participants->map(fn($owner) => $owner->owner->cnic ?? 'N/A')->implode(', ') ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Request Type</label>
                                        <div class="info-value">
                                            @php
                                                $requestType = DB::table('request_types')->where('id', $property->request_type)->first();
                                            @endphp
                                            {{ $requestType->name ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Applicant Address</label>
                                        <div class="info-value">
                                            {{ $property->participants->first()?->owner->address ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Applicant Area</label>
                                        <div class="info-value">
                                            {{ $property->participants->first()?->owner->area ? $property->participants->first()->owner->area . ' Marla' : 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Request Date</label>
                                        <div class="info-value">
                                            {{ $property->created_at ? $property->created_at->format('d-m-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProperty-{{ $property->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseProperty-{{ $property->id }}" aria-expanded="false"
                                aria-controls="collapseProperty-{{ $property->id }}">
                                Property Details
                            </button>
                        </h2>
                        <div id="collapseProperty-{{ $property->id }}" class="accordion-collapse collapse"
                            aria-labelledby="headingProperty-{{ $property->id }}">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="info-label">District:</label>
                                        <div class="info-value">Mirpur</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Code:</label>
                                        <div class="info-value">{{ $property->property->code ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Plot No:</label>
                                        <div class="info-value">{{ $property->property->plot_no ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Town:</label>
                                        <div class="info-value">{{ $property->property->township->name ?? 'N/A' }}</div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="info-label">Center:</label>
                                        <div class="info-value">{{ $property->property->center ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Locality:</label>
                                        <div class="info-value">{{ $property->property->locality ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Sector:</label>
                                        <div class="info-value">{{ $property->property->sector ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Area (Marla):</label>
                                        <div class="info-value">{{ $property->property->marla ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Objections Section -->
                    @if($property->objections && $property->objections->count() > 0)
                    <div class="accordion-item" style="background-color: #fff3cd;">
                        <h2 class="accordion-header" id="headingObjections-{{ $property->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseObjections-{{ $property->id }}" aria-expanded="false"
                                aria-controls="collapseObjections-{{ $property->id }}">
                                <span class="text-danger">
                                    Objections ({{ $property->objections->count() }})
                                </span>
                            </button>
                        </h2>
                        <div id="collapseObjections-{{ $property->id }}" class="accordion-collapse collapse"
                            aria-labelledby="headingObjections-{{ $property->id }}">
                            <div class="accordion-body">
                                @foreach($property->objections as $objection)
                                <div class="card mb-3" style="border: 2px solid #ffc107;">
                                    <div class="card-header" style="background-color: #fff3cd;">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong>Objection Type:</strong> {{ $objection->objection_type ?? 'N/A' }}
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="objection-badge badge-{{ strtolower($objection->status ?? 'pending') }}">
                                                    {{ $objection->status ?? 'Pending' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="info-label">Objection Date</label>
                                                <div class="info-value">
                                                    {{ $objection->objection_date ? \Carbon\Carbon::parse($objection->objection_date)->format('d-m-Y') : 'N/A' }}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="info-label">Raised By</label>
                                                <div class="info-value">
                                                    {{ $objection->raisedBy->name ?? 'N/A' }}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="info-label">Raised Date</label>
                                                <div class="info-value">
                                                    {{ $objection->created_at ? $objection->created_at->format('d-m-Y') : 'N/A' }}
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="info-label">Remarks</label>
                                                <div class="info-value">
                                                    {{ $objection->remarks ?? 'No remarks' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col text-end">
                                                <a href="/objection-request-detail/{{ $objection->id }}" class="btn btn-primary btn-sm">
                                                    Edit Objection
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingObjections-{{ $property->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseObjections-{{ $property->id }}" aria-expanded="false"
                                aria-controls="collapseObjections-{{ $property->id }}">
                                Objections (No objections)
                            </button>
                        </h2>
                        <div id="collapseObjections-{{ $property->id }}" class="accordion-collapse collapse"
                            aria-labelledby="headingObjections-{{ $property->id }}">
                            <div class="accordion-body">
                                <p class="text-success mb-0">No objections have been raised for this request.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-center text-muted">No objection requests found.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
