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
        }

        span {
            font-weight: bolder;
        }
        .label-h2 {
            color: rgb(5, 68, 104);
            font-size: 18px;
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

        .request-card {
            margin-bottom: 20px;
            border: 2px solid #007bff;
            border-radius: 8px;
        }

        .objection-item {
            border: 2px solid #ffc107;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #fffbf0;
        }

        .objection-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .reply-section {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-top: 15px;
            border-radius: 4px;
        }

        .edit-form-section {
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 4px;
            margin-top: 15px;
        }

        .response-status-badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            margin-top: 10px;
        }

        .badge-awaiting-response {
            background-color: #ff6b6b;
            color: #fff;
            border: 2px solid #d32f2f;
        }

        .badge-response-received {
            background-color: #51cf66;
            color: #fff;
            border: 2px solid #2f9e44;
        }
    </style>

    <div class="container">
        <h3 class="text-center mt-5 mb-4">Objection Requests</h3>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Errors:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @forelse($request as $request)
        <div class="card request-card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Request #{{ $request->id }} - Applicant: {{ $request->participants->map(fn($owner) => $owner->owner->name ?? 'N/A')->first() ?? 'N/A' }}</h5>
            </div>

            <div class="card-body">
                <div class="accordion" id="propertyAccordion_{{ $request->id }}">
                    <!-- Request Information -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingRequest_{{ $request->id }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseRequest_{{ $request->id }}" aria-expanded="true" aria-controls="collapseRequest_{{ $request->id }}">
                                Request Information
                            </button>
                        </h2>
                        <div id="collapseRequest_{{ $request->id }}" class="accordion-collapse collapse show"
                            aria-labelledby="headingRequest_{{ $request->id }}">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="info-label">Request ID</label>
                                        <div class="info-value">{{ $request->id ?? 'N/A' }}</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Applicant Name</label>
                                        <div class="info-value">
                                            {{ $request->participants->map(fn($owner) => $owner->owner->name ?? 'N/A')->implode(', ') ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Applicant CNIC</label>
                                        <div class="info-value">
                                            {{ $request->participants->map(fn($owner) => $owner->owner->cnic ?? 'N/A')->implode(', ') ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Applicant Address</label>
                                        <div class="info-value">
                                            {{ $request->participants->first()?->owner->address ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Applicant Area</label>
                                        <div class="info-value">
                                            {{ $request->participants->first()?->owner->area ? $request->participants->first()->owner->area . ' Marla' : 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Request Type</label>
                                        <div class="info-value">
                                            @php
                                                $requestType = DB::table('request_types')->where('id', $request->request_type)->first();
                                            @endphp
                                            {{ $requestType->name ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="info-label">Request Date</label>
                                        <div class="info-value">
                                            {{ $request->created_at ? $request->created_at->format('d-m-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProperty_{{ $request->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseProperty_{{ $request->id }}" aria-expanded="false" aria-controls="collapseProperty_{{ $request->id }}">
                                Property Details
                            </button>
                        </h2>
                        <div id="collapseProperty_{{ $request->id }}" class="accordion-collapse collapse" aria-labelledby="headingProperty_{{ $request->id }}">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="info-label">District:</label>
                                        <div class="info-value">Mirpur</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Center:</label>
                                        <div class="info-value">{{ $request->property->center ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Locality:</label>
                                        <div class="info-value">{{ $request->property->locality ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Code:</label>
                                        <div class="info-value">{{ $request->property->code ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Plot No:</label>
                                        <div class="info-value">{{ $request->property->plot_no ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Town:</label>
                                        <div class="info-value">{{ $request->property->township->name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Sector:</label>
                                        <div class="info-value">{{ $request->property->sector ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="info-label">Area (Marla):</label>
                                        <div class="info-value">{{ $request->property->marla ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requester Details -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingRequester_{{ $request->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseRequester_{{ $request->id }}" aria-expanded="false" aria-controls="collapseRequester_{{ $request->id }}">
                                Requester Details
                            </button>
                        </h2>
                        <div id="collapseRequester_{{ $request->id }}" class="accordion-collapse collapse" aria-labelledby="headingRequester_{{ $request->id }}">
                            <div class="accordion-body">
                                @foreach($request->participants as $key => $participant)
                                <div class="card mb-3" style="background-color: #f9f9f9;">
                                    <div class="card-body">
                                        <h6 class="card-title">Requester {{ $key + 1 }}: {{ $participant->owner->name ?? 'N/A' }}</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="info-label">Name</label>
                                                <div class="info-value">{{ $participant->owner->name ?? 'N/A' }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="info-label">Father's Name</label>
                                                <div class="info-value">{{ $participant->owner->father_name ?? 'N/A' }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="info-label">CNIC</label>
                                                <div class="info-value">{{ $participant->owner->cnic ?? 'N/A' }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="info-label">Address</label>
                                                <div class="info-value">{{ $participant->owner->address ?? 'N/A' }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="info-label">Area</label>
                                                <div class="info-value">{{ $participant->owner->area ? $participant->owner->area . ' Marla' : 'N/A' }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="info-label">CNIC Attachments</label>
                                                <div class="info-value">
                                                    @if($participant->owner->cnic_front)
                                                        <a href="{{ asset('uploads/user/cnics/'.$participant->owner->cnic_front) }}" target="_blank" class="badge bg-primary">📄 CNIC Front</a>
                                                    @endif
                                                    @if($participant->owner->cnic_back)
                                                        <a href="{{ asset('uploads/user/cnics/'.$participant->owner->cnic_back) }}" target="_blank" class="badge bg-primary">📄 CNIC Back</a>
                                                    @endif
                                                    @if(!$participant->owner->cnic_front && !$participant->owner->cnic_back)
                                                        <span class="text-muted">No attachments</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Attorney Details -->
                    @if($request->participants->some(fn($p) => $p->representative))
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingAttorney_{{ $request->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseAttorney_{{ $request->id }}" aria-expanded="false" aria-controls="collapseAttorney_{{ $request->id }}">
                                Attorney Details
                            </button>
                        </h2>
                        <div id="collapseAttorney_{{ $request->id }}" class="accordion-collapse collapse" aria-labelledby="headingAttorney_{{ $request->id }}">
                            <div class="accordion-body">
                                @foreach($request->participants as $key => $participant)
                                    @if($participant->representative)
                                    <div class="card mb-3" style="background-color: #e8f4f8;">
                                        <div class="card-body">
                                            <h6 class="card-title">Attorney for {{ $participant->owner->name ?? 'N/A' }}</h6>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="info-label">Name</label>
                                                    <div class="info-value">{{ $participant->representative->name ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="info-label">Father's Name</label>
                                                    <div class="info-value">{{ $participant->representative->father_name ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="info-label">CNIC</label>
                                                    <div class="info-value">{{ $participant->representative->cnic ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="info-label">Address</label>
                                                    <div class="info-value">{{ $participant->representative->address ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="info-label">Attorney Letter</label>
                                                    <div class="info-value">
                                                        @if($participant->representative->attorney_letter)
                                                            <a href="{{ asset('uploads/user/representative/letter/'.$participant->representative->attorney_letter) }}" target="_blank" class="badge bg-success">📄 View Letter</a>
                                                        @else
                                                            <span class="text-muted">No letter</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="info-label">CNIC Attachments</label>
                                                    <div class="info-value">
                                                        @if($participant->representative->cnic_front)
                                                            <a href="{{ asset('uploads/user/representative/cnic/'.$participant->representative->cnic_front) }}" target="_blank" class="badge bg-primary">📄 CNIC Front</a>
                                                        @endif
                                                        @if($participant->representative->cnic_back)
                                                            <a href="{{ asset('uploads/user/representative/cnic/'.$participant->representative->cnic_back) }}" target="_blank" class="badge bg-primary">📄 CNIC Back</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Property Documents -->
                    @if($request->attachment)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDocs_{{ $request->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDocs_{{ $request->id }}" aria-expanded="false" aria-controls="collapseDocs_{{ $request->id }}">
                                Property Documents & Maps
                            </button>
                        </h2>
                        <div id="collapseDocs_{{ $request->id }}" class="accordion-collapse collapse" aria-labelledby="headingDocs_{{ $request->id }}">
                            <div class="accordion-body">
                                <div class="row">
                                    @php
                                        $documents = [
                                            'complete_file' => 'Complete File',
                                            'affected_house' => 'Code of Affected House',
                                            'builtup_property' => 'Award of Built-up Property',
                                            'entitlement' => 'Entitlement',
                                            'allot_com' => 'Allotment by Committee',
                                            'chit_mapping' => 'Possession Chit With Mapping',
                                            'order_attach' => 'Order Attachment'
                                        ];
                                    @endphp
                                    @foreach($documents as $key => $label)
                                        <div class="col-md-4 mb-3">
                                            <label class="info-label">{{ $label }}</label>
                                            @if($request->attachment->$key)
                                                <a href="{{ asset('/uploads/' . str_replace('_', '', $key) . '/' . $request->attachment->$key) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    📄 View Document
                                                </a>
                                            @else
                                                <div class="info-value text-muted">Not uploaded</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Objections Panel (role-aware) --}}
                    @include('partials.objections._objections_panel', ['request' => $request])

                </div><!-- end accordion -->
            </div><!-- end card-body -->
        </div><!-- end card -->
        @empty
            <div class="alert alert-info">No objection requests found.</div>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to handle response status changes from initial dropdown
        function handleResponseStatusChange(selectElement, responseId) {
            const status = selectElement.value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/objection-response/' + responseId + '/status';

            let remarksValue = '';
            if (status === 'not-satisfactory') {
                remarksValue = prompt('Please enter remarks for why the response is not satisfactory:');
                if (!remarksValue) {
                    selectElement.value = 'pending';
                    return;
                }
            }

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="status" value="${status}">
                <input type="hidden" name="authority_remarks" value="${remarksValue}">
            `;

            document.body.appendChild(form);
            form.submit();
        }

        // Function to toggle response edit form - uses dynamic response ID
        function toggleResponseEditForm(responseId) {
            const form = document.getElementById('editResponseForm_' + responseId);
            if (form) {
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        }

        // Function to toggle remarks field visibility
        function toggleRemarksField(selectElement, responseId) {
            const remarksField = document.getElementById('remarksField_' + responseId);
            if (selectElement.value === 'not-satisfactory') {
                remarksField.style.display = 'block';
                const textarea = document.getElementById('editRemarks_' + responseId);
                if (textarea) {
                    textarea.focus();
                }
            } else {
                remarksField.style.display = 'none';
            }
        }

        // Function to confirm deletion of objection
        function confirmDeleteObjection(objectionId) {
            const confirmMessage = 'Are you sure you want to delete this objection? This will also delete all responses and attachments associated with this objection. This action cannot be undone.';

            if (confirm(confirmMessage)) {
                const deleteConfirm = confirm('This is your final confirmation. Click OK to delete the objection, or Cancel to keep it.');
                if (deleteConfirm) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/objection-request-detail/' + objectionId;

                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                    `;

                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }

        // Function to toggle final remarks visibility
        function toggleFinalRemarks(requestId) {
            const statusSelect = document.getElementById('final_status_' + requestId);
            const descriptionField = document.getElementById('final_description_' + requestId);

            if (statusSelect && descriptionField) {
                if (statusSelect.value === 'rejected') {
                    descriptionField.setAttribute('required', 'required');
                } else {
                    descriptionField.removeAttribute('required');
                }
            }
        }
    </script>
</x-app-layout>
