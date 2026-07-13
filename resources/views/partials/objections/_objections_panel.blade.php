@php
    $user = auth()->user();
    $isRecordClerk = $user->hasRole('record-clerk');
    $isSubEngineer = $user->hasRole('sub-engineer') || $user->hasRole('HDM');

    // Unified: any role that can edit/delete
    $canManage = $isRecordClerk || $isSubEngineer;

    // Role-specific objection scoping
    if ($isRecordClerk) {
        $allObjections = $request->deoObjections ?? collect();
    } elseif ($isSubEngineer) {
        $allObjections = $request->engineerObjections ?? collect();
    } else {
        $allObjections = $request->objections ?? collect();
    }

    $allResolved = $allObjections->isNotEmpty() && $allObjections->every(fn($obj) => strtolower($obj->status ?? 'pending') === 'resolved');
    $hasPending  = $allObjections->contains(fn($obj) => strtolower($obj->status ?? 'pending') === 'pending');
@endphp

<div class="accordion-item">
    <h2 class="accordion-header" id="headingAllObjections_{{ $request->id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseAllObjections_{{ $request->id }}" aria-expanded="false"
            aria-controls="collapseAllObjections_{{ $request->id }}">
            <span class="text-danger">
                All Objections ({{ $allObjections->count() }})
            </span>
        </button>
    </h2>

    <div id="collapseAllObjections_{{ $request->id }}" class="accordion-collapse collapse"
        aria-labelledby="headingAllObjections_{{ $request->id }}">
        <div class="accordion-body">

            @if($allObjections->count() > 0)
                @foreach($allObjections as $obj)
                <div class="objection-item">

                    {{-- ── Objection Header ──────────────────────────────── --}}
                    <div class="objection-header">
                        <div>
                            <strong>{{ $obj->objection_type ?? 'N/A' }}</strong>
                            <span class="objection-badge badge-{{ strtolower($obj->status ?? 'pending') }}">
                                {{ $obj->status ?? 'Pending' }}
                            </span>
                        </div>

                        {{-- Action buttons: any managing role --}}
                        @if($canManage)
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#editForm_{{ $obj->id }}"
                                aria-expanded="false">
                                ✏️ Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="confirmDeleteObjection({{ $obj->id }})">
                                🗑️ Delete
                            </button>
                        </div>
                        @endif
                    </div>

                    {{-- ── Objection Meta ────────────────────────────────── --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="info-label">Objection Status</label>
                            <div class="info-value">{{ $obj->status }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="info-label">Raised By</label>
                            <div class="info-value">{{ $obj->raisedBy->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="info-label">Raised Date</label>
                            <div class="info-value">
                                {{ $obj->objection_date ? \Carbon\Carbon::parse($obj->objection_date)->format('d-m-Y') : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="info-label">Remarks</label>
                            <div class="info-value">{{ $obj->remarks ?? 'No remarks' }}</div>
                        </div>
                    </div>

                    {{-- ── Response Status Badge ─────────────────────────── --}}
                    @if($obj->responses->isEmpty())
                        <div class="response-status-badge badge-awaiting-response">
                            ⏳ Awaiting User Response
                        </div>
                    @else
                        <div class="response-status-badge badge-response-received">
                            ✓ Response Received
                        </div>
                    @endif

                    {{-- ── User Responses ────────────────────────────────── --}}
                    @if($obj->responses->isNotEmpty())
                        @foreach($obj->responses as $response)
                        @php
                            $responseStatus  = $response->status ?? 'pending';
                            $objectionStatus = strtolower($obj->status ?? 'pending');
                            $isResolved      = $objectionStatus === 'resolved';
                        @endphp
                        <div class="reply-section">
                            <label class="info-label">User Response</label>
                            <div class="info-value">
                                <strong>Response Date:</strong>
                                {{ $response->created_at ? \Carbon\Carbon::parse($response->created_at)->format('d-m-Y') : 'N/A' }}
                            </div>
                            <div class="info-value">
                                <strong>Response:</strong> {{ $response->response_text ?? 'No response' }}
                            </div>

                            {{-- Attachments --}}
                            @if($response->attachments && $response->attachments->count() > 0)
                            <div class="info-value">
                                <strong>Attachments:</strong>
                                <div style="margin-top:8px;display:flex;flex-wrap:wrap;gap:8px;">
                                    @foreach($response->attachments as $attachment)
                                    <div style="padding:8px 12px;background:#f5f5f5;border-radius:4px;border-left:3px solid #007bff;white-space:nowrap;display:inline-block;">
                                        <a href="{{ asset($attachment->file_path ?? '') }}" target="_blank"
                                            class="text-primary" style="text-decoration:none;">
                                            📎 {{ $attachment->document_type ?? 'Attachment' }}
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="info-value"><strong>Attachments:</strong> No attachments</div>
                            @endif

                            {{-- Response Status Action --}}
                            <div class="info-value">
                                <strong>Response Status:</strong>
                                <div style="margin-top:8px;">

                                    @if($isResolved)
                                        <span class="badge" style="background-color:
                                            @if($responseStatus==='satisfactory') #28a745
                                            @elseif($responseStatus==='not-satisfactory') #dc3545
                                            @else #6c757d @endif;
                                            color:white;padding:6px 10px;">
                                            @if($responseStatus==='satisfactory') Satisfactory ✓
                                            @elseif($responseStatus==='not-satisfactory') Not Satisfactory ✗
                                            @else {{ ucfirst($responseStatus) }}
                                            @endif
                                        </span>
                                        @if($response->authority_remarks)
                                        <div style="margin-top:8px;padding:8px;background:#f8f9fa;border-left:3px solid #6c757d;border-radius:3px;">
                                            <small class="text-muted"><strong>Remarks:</strong> {{ $response->authority_remarks }}</small>
                                        </div>
                                        @endif
                                        <div style="margin-top:10px;padding:8px;background:#fff3cd;border-radius:3px;">
                                            <small class="text-warning"><strong>Note:</strong> This objection is resolved. Response status cannot be changed.</small>
                                        </div>

                                    @elseif($responseStatus === 'pending' && $canManage)
                                        {{-- Pending + managing role: inline dropdown --}}
                                        <select class="form-select form-select-sm" style="width:auto;display:inline-block;"
                                            id="responseStatus_{{ $response->id }}"
                                            onchange="handleResponseStatusChange(this, {{ $response->id }})">
                                            <option value="pending" selected>Pending Review</option>
                                            <option value="satisfactory">Satisfactory ✓</option>
                                            <option value="not-satisfactory">Not Satisfactory ✗</option>
                                        </select>

                                    @elseif($responseStatus === 'pending')
                                        <span class="badge" style="background-color:#6c757d;color:white;padding:6px 10px;">
                                            Pending Review
                                        </span>

                                    @else
                                        <span class="badge" id="badge_{{ $response->id }}" style="background-color:
                                            @if($responseStatus==='satisfactory') #28a745
                                            @elseif($responseStatus==='not-satisfactory') #dc3545
                                            @else #6c757d @endif;
                                            color:white;padding:6px 10px;">
                                            @if($responseStatus==='satisfactory') Satisfactory ✓
                                            @elseif($responseStatus==='not-satisfactory') Not Satisfactory ✗
                                            @else {{ ucfirst($responseStatus) }}
                                            @endif
                                        </span>

                                        @if($response->authority_remarks)
                                        <div style="margin-top:8px;padding:8px;background:#f8f9fa;border-left:3px solid #6c757d;border-radius:3px;">
                                            <small class="text-muted"><strong>Remarks:</strong> {{ $response->authority_remarks }}</small>
                                        </div>
                                        @endif

                                        @if($canManage)
                                        <button class="btn btn-sm btn-outline-secondary ms-2" type="button"
                                            onclick="toggleResponseEditForm({{ $response->id }})">
                                            Edit
                                        </button>

                                        <div id="editResponseForm_{{ $response->id }}"
                                            style="display:none;margin-top:15px;padding:12px;background:#f0f8ff;border-radius:4px;border-left:3px solid #007bff;">
                                            <form method="POST" action="/objection-response/{{ $response->id }}/status">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label class="info-label">Change Response Status</label>
                                                        <select name="status" class="form-select form-select-sm"
                                                            id="editStatus_{{ $response->id }}"
                                                            onchange="toggleRemarksField(this, {{ $response->id }})">
                                                            <option value="pending"          @if($responseStatus==='pending')          selected @endif>Pending Review</option>
                                                            <option value="satisfactory"     @if($responseStatus==='satisfactory')     selected @endif>Satisfactory ✓</option>
                                                            <option value="not-satisfactory" @if($responseStatus==='not-satisfactory') selected @endif>Not Satisfactory ✗</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3" id="remarksField_{{ $response->id }}"
                                                    style="display:@if($responseStatus==='not-satisfactory') block @else none @endif;">
                                                    <div class="col-md-12">
                                                        <label for="editRemarks_{{ $response->id }}" class="info-label">Remarks</label>
                                                        <textarea name="authority_remarks" id="editRemarks_{{ $response->id }}"
                                                            class="form-control" rows="3"
                                                            placeholder="Enter remarks for why the response is not satisfactory...">{{ $response->authority_remarks ?? '' }}</textarea>
                                                        <small class="text-muted">Explain why the response is not satisfactory.</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            onclick="toggleResponseEditForm({{ $response->id }})">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        @endif {{-- end canManage edit form --}}
                                    @endif

                                </div>
                            </div>
                        </div>{{-- end reply-section --}}
                        @endforeach
                    @endif {{-- end responses --}}

                    {{-- ── Clerk Reply to rejected response (managing roles only) ── --}}
                    @if($canManage && strtolower($obj->status) === 'pending' && $obj->responses->isNotEmpty())
                        @php
                            $lastResponse         = $obj->responses->last();
                            $shouldShowClerkReply = in_array($lastResponse->status ?? 'pending', ['rejected', 'dismissed']);
                        @endphp
                        @if($shouldShowClerkReply)
                        <div class="reply-section" style="background:#f0f8ff;border-left:4px solid #28a745;margin-top:15px;">
                            <label class="info-label">Your Response to User</label>

                            @if($obj->clerkResponse)
                            <div class="info-value" style="background:#e8f5e9;padding:10px;border-radius:4px;margin-bottom:15px;">
                                <strong>Response Date:</strong>
                                {{ $obj->clerkResponse->created_at ? \Carbon\Carbon::parse($obj->clerkResponse->created_at)->format('d-m-Y') : 'N/A' }}
                                <br>
                                <strong>Your Response:</strong> {{ $obj->clerkResponse->response_text ?? 'No response' }}
                                @if($obj->clerkResponse->attachment)
                                <br><strong>Attachment:</strong> {{ $obj->clerkResponse->attachment }}
                                @endif
                            </div>
                            @endif

                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse"
                                data-bs-target="#clerkReplyForm_{{ $obj->id }}" aria-expanded="false">
                                {{ $obj->clerkResponse ? 'Edit Response' : 'Add Response' }}
                            </button>

                            <div class="collapse mt-3" id="clerkReplyForm_{{ $obj->id }}">
                                <form action="/objection-request-detail/{{ $obj->id }}/clerk-response"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="clerk_response_{{ $obj->id }}" class="info-label">Your Response</label>
                                            <textarea name="response_text" id="clerk_response_{{ $obj->id }}"
                                                class="form-control" rows="4" required
                                                placeholder="Enter your response to the user's objection">{{ $obj->clerkResponse->response_text ?? '' }}</textarea>
                                            <small class="text-muted">Provide a detailed response addressing the user's concerns.</small>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label for="clerk_attachment_{{ $obj->id }}" class="info-label">Attachment (Optional)</label>
                                            <input type="file" name="attachment" id="clerk_attachment_{{ $obj->id }}" class="form-control">
                                            <small class="text-muted">Upload any supporting documents if needed.</small>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success btn-sm">Submit Response</button>
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#clerkReplyForm_{{ $obj->id }}">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endif {{-- end clerk reply --}}

                    {{-- ── Edit Objection Form (all managing roles, single shared form) ── --}}
                    @if($canManage)
                    <div class="collapse edit-form-section" id="editForm_{{ $obj->id }}">
                        <form action="/objection-request-detail/{{ $obj->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="objection_type_{{ $obj->id }}" class="info-label">Objection Type</label>
                                    <select name="objection_type" id="objection_type_{{ $obj->id }}" class="form-control" required>
                                        <option value="">Select Objection Type</option>
                                        <option value="Missing File"           {{ $obj->objection_type == 'Missing File'           ? 'selected' : '' }}>Missing File</option>
                                        <option value="Chit map not available" {{ $obj->objection_type == 'Chit map not available' ? 'selected' : '' }}>Chit map not available</option>
                                        <option value="Incomplete Information"  {{ $obj->objection_type == 'Incomplete Information'  ? 'selected' : '' }}>Incomplete Information</option>
                                        <option value="Other"                  {{ $obj->objection_type == 'Other'                  ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="objection_date_{{ $obj->id }}" class="info-label">Objection Date</label>
                                    <input type="date" name="objection_date" id="objection_date_{{ $obj->id }}"
                                        class="form-control" value="{{ $obj->objection_date ?? date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="status_{{ $obj->id }}" class="info-label">Status</label>
                                    <select name="status" id="status_{{ $obj->id }}" class="form-control">
                                        <option value="Pending"  {{ $obj->status == 'Pending'  ? 'selected' : '' }}>Pending</option>
                                        <option value="Resolved" {{ $obj->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="Rejected" {{ $obj->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="remarks_{{ $obj->id }}" class="info-label">Remarks</label>
                                    <textarea name="remarks" id="remarks_{{ $obj->id }}" class="form-control"
                                        placeholder="Enter Objection Remarks" rows="3">{{ $obj->remarks ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Update Objection</button>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#editForm_{{ $obj->id }}">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif {{-- end edit form --}}

                </div>{{-- end objection-item --}}
                @endforeach

            @else
                <p class="text-muted">No objections yet.</p>
            @endif

            {{-- ── Add New Objection (managing roles only) ─────────────── --}}
            @if($canManage)
            <div class="mt-4">
                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target="#addObjection_{{ $request->id }}" aria-expanded="false">
                    + Add New Objection
                </button>

                <div class="collapse edit-form-section mt-3" id="addObjection_{{ $request->id }}">
                    <h6 class="mb-3">Add New Objection</h6>
                    <form action="/objection-request-detail" method="POST">
                        @csrf
                        <input type="hidden" name="request_id" value="{{ $request->id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="new_objection_type_{{ $request->id }}" class="info-label">Objection Type</label>
                                <select name="objection_type" id="new_objection_type_{{ $request->id }}" class="form-control" required>
                                    <option value="">Select Objection Type</option>
                                    <option value="Missing File">Missing File</option>
                                    <option value="Chit map not available">Chit map not available</option>
                                    <option value="Incomplete Information">Incomplete Information</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="new_objection_date_{{ $request->id }}" class="info-label">Objection Date</label>
                                <input type="date" name="objection_date" id="new_objection_date_{{ $request->id }}"
                                    class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="new_status_{{ $request->id }}" class="info-label">Status</label>
                                <select name="status" id="new_status_{{ $request->id }}" class="form-control">
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Resolved">Resolved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="new_remarks_{{ $request->id }}" class="info-label">Remarks</label>
                                <textarea name="remarks" id="new_remarks_{{ $request->id }}"
                                    class="form-control" placeholder="Enter Objection Remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-sm">Create Objection</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="collapse"
                                    data-bs-target="#addObjection_{{ $request->id }}">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif {{-- end add new --}}

        </div>{{-- end accordion-body --}}
    </div>{{-- end collapse --}}
</div>
