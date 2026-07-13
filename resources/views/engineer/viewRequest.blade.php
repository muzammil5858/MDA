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

    <div class="container ">
        <h3 class="text-center mt-5 mb-4">Map Approval Request Information</h2>
            <div class="accordion" id="propertyAccordion">

                <!-- Personal Information -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPersonal">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsePersonal" aria-expanded="true" aria-controls="collapsePersonal">
                            Map Approval Request Details
                        </button>
                    </h2>
                    <div id="collapsePersonal" class="accordion-collapse collapse show"
                        aria-labelledby="headingPersonal">
                        <div class="accordion-body">
                            <h2 class="label-h2" >
                            Map Approval Requester Details
                            </h2>
                            @foreach($request->participants as $key => $value)
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label>Requester Name</label>
                                    <div class="info-value">{{ $value->owner->name ?? 'N/A' }}</div>
                                </div>

                                <div class="col-md-4">
                                    <label>Requester's Father Name</label>
                                    <div class="info-value">{{ $value->owner->father_name ?? 'N/A' }}</div>
                                </div>

                                <div class="col-md-4">
                                    <label>Requester's CNIC</label>
                                    <div class="info-value">{{ $value->owner->cnic ?? 'N/A' }}</div>
                                </div>

                                <div class="col-md-4">
                                    <label>Requester's Address</label>
                                    <div class="info-value">{{ $value->owner->address ?? 'N/A' }}</div>
                                </div>

                                <div class="col-md-4">
                                    <label>Requester's Area</label>
                                    <div class="info-value">{{ $value->owner->area ? $value->owner->area . ' Marla' :
                                        'N/A' }}</div>
                                </div>
                                <div class="col-md-4">
                                    <label>Requester's CNIC Attachements</label>
                                    <br>
                                    @if(!empty($value->owner->cnic_front))
                                    <a href="{{ asset('uploads/user/cnics/'.$value->owner->cnic_front) }}"
                                        target="_blank">Click to View CNIC Front Attachement</a>
                                    @else
                                    <div class="info-value">No CNIC Front </div>
                                    @endif
                                    <br>
                                    @if(!empty($value->owner->cnic_back))
                                    <a href="{{ asset('uploads/user/cnics/'.$value->owner->cnic_back) }}"
                                        target="_blank">Click to View CNIC Back Attachement</a>
                                    @else
                                    <div class="info-value">No CNIC Back</div>
                                    @endif
                                </div>



                                @if($value->representative)
                                <div class="col-md-12">
                                    <div class="card shadow-sm mb-4 mx-4"
                                        style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                        <div class="card-body">
                                            <label>Attorney on behalf of {{ $value->owner->name ?? 'N/A' }}</label>
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label>Attorney Name</label>
                                                    <div class="info-value">{{ $value->representative->name ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Attorney's Father Name</label>
                                                    <div class="info-value">{{ $value->representative->father_name ??
                                                        'N/A' }}</div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Attorney's CNIC</label>
                                                    <div class="info-value">{{ $value->representative->cnic ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Attorney's Address</label>
                                                    <div class="info-value">{{ $value->representative->address ?? 'N/A'
                                                        }}</div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Attorney's Letter</label>
                                                    <br>
                                                    @if(!empty($value->representative->attorney_letter))
                                                    <a href="{{ asset('uploads/user/representative/letter/'.$value->representative->attorney_letter) }}"
                                                        target="_blank">Click to View Letter</a>
                                                    @else
                                                    <div class="info-value">No Letter</div>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Attorney's CNIC Attachements</label>
                                                    <br>
                                                    @if(!empty($value->representative->cnic_front))
                                                    <a href="{{ asset('uploads/user/representative/cnic/'.$value->representative->cnic_front) }}"
                                                        target="_blank">Click to View CNIC Front Attachement</a>
                                                    @else
                                                    <div class="info-value">No CNIC Front </div>
                                                    @endif
                                                    <br>
                                                    @if(!empty($value->representative->cnic_back))
                                                    <a href="{{ asset('uploads/user/representative/cnic/'.$value->representative->cnic_back) }}"
                                                        target="_blank">Click to View CNIC Back Attachement</a>
                                                    @else
                                                    <div class="info-value">No CNIC Back</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                            @endforeach

                            <h2 class="label-h2" >
                            Engineer and Architect Details
                            </h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row" style="border: 2px solid lightgray;padding: 5px;border-radius: 15px;">
                                        <div class="col-md-6" >
                                            <label>Engineer Name</label>
                                            <div class="info-value">{{ $smallRequest->engineer_name ?? 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Engineer Address</label>
                                            <div class="info-value">{{ $smallRequest->engineer_address ?? 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Engineer Stamp & Signature</label>
                                            <div class="info-value"><a href="{{ asset('uploads/engineer/'.$smallRequest->engineer_stamp_signature) }}" target="_blank">View Engineer Stamp & Signature</a></div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row" style="border: 2px solid lightgray;padding: 5px;border-radius: 15px;">
                                        <div class="col-md-6">
                                            <label>Architect Name</label>
                                            <div class="info-value">{{ $smallRequest->architect_name ?? 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Architect Address</label>
                                            <div class="info-value">{{ $smallRequest->architect_address ?? 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Architect Stamp & Signature</label>
                                            <div class="info-value"><a href="{{ asset('uploads/architecture/'.$smallRequest->architect_stamp_signature) }}" target="_blank">View Architect Stamp & Signature</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="label-h2 mt-2" >
                            Uploaded Maps
                            </h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Uploaded Maps Content -->
                                     <label class="info-label">Uploaded Map (PNG)</label>
                                    @if($smallRequest->map_attachment)
                                    <a href="{{ asset('uploads/maps/'.$smallRequest->map_attachment) }}" target="_blank">View Uploaded Map</a>
                                    @else
                                    <div class="info-value">No Map Uploaded</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <!-- Uploaded Maps Content -->
                                     <label class="info-label">Uploaded Map (PDF)</label>
                                    @if($smallRequest->map_attachment)
                                    <a href="{{ asset('uploads/maps/'.$smallRequest->map_attachment) }}" target="_blank">View Uploaded Map</a>
                                    @else
                                    <div class="info-value">No Map Uploaded</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <!-- Uploaded Maps Content -->
                                     <label class="info-label">Uploaded Map (AutoCAD)</label>
                                    @if($smallRequest->map_attachment)
                                    <a href="{{ asset('uploads/maps/'.$smallRequest->map_attachment) }}" target="_blank">View Uploaded Map</a>
                                    @else
                                    <div class="info-value">No Map Uploaded</div>
                                    @endif
                                </div>
                            </div>
                            <h2 class="label-h2 mt-2" >
                            Record Clerk Remarks
                            </h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Uploaded Maps Content -->
                                     <label class="info-label">Record Clerk Status</label>
                                    <div class="info-value">{{ $request->deo_action == 1 ? 'Approved' :  'N/A' }}</div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Uploaded Maps Content -->
                                     <label class="info-label">Record Clerk Remarks</label>
                                     <div class="info-value">{{ $request->deo_remarks ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Uploaded Maps Content -->
                                     <label class="info-label">Record Clerk Approval Date</label>
                                     <div class="info-value">{{ $request->deo_date ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Attachments -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingProperty">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseProperty" aria-expanded="false" aria-controls="collapseProperty">
                            Property Details
                        </button>
                    </h2>
                    <div id="collapseProperty" class="accordion-collapse collapse" aria-labelledby="headingProperty">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="info-label">District:</label>
                                    <div class="info-value">Mirpur</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="info-label">Center:</label>
                                    <div class="info-value">{{$property->center}}</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="info-label">Locality:</label>
                                    <div class="info-value">{{$property->locality}}</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="info-label">Code:</label>
                                    <div class="info-value">{{$property->code}}</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="info-label">Plot No:</label>
                                    <div class="info-value">{{$property->plot_no}}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="info-label">Town:</label>
                                    <div class="info-value">{{$property->township->name}}</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="info-label">Sector:</label>
                                    <div class="info-value">{{$property->sector}}</div>
                                </div>
                                <div class=" col-md-3">
                                    <label for="name">Area Measurement</label>
                                    <div class="row">

                                        <div class="col">
                                            <label for="name">Kanal</label>
                                            <input type="text" id="dm_kanal" placeholder="kanal" name="dm_kanal"
                                                class="form-control" value="{{  $property->kanal ?? ''}}">
                                        </div>
                                        <div class="col">
                                            <label for="name">Marla</label>
                                            <input type="text" id="dm_marla" placeholder="marla" name="dm_marla"
                                                class="form-control" value="{{  $property->marla ?? ''}}">
                                        </div>
                                        <div class="col">
                                            <label for="name">Squarefeet</label>
                                            <input type="text" id="dm_sqrft" placeholder="sqrft" name="dm_sqrft"
                                                class="form-control" value="{{  $property->sqrft ?? ''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingAttachments">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseAttachments" aria-expanded="false"
                            aria-controls="collapseAttachments">
                            Attachments
                        </button>
                    </h2>
                    <div id="collapseAttachments" class="accordion-collapse collapse"
                        aria-labelledby="headingAttachments">
                        <div class="accordion-body">
                            <div class="form-row">
                                <div class=" detail-item col-md-4">
                                    <label class="info-label">CNIC Front:</label>
                                    @if($property->cnic_front != null)
                                    <a href="{{asset('/uploads/user/cnic/'.$property->cnic_front)}}">View Attached
                                        File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class=" detail-item col-md-4">
                                    <label class="info-label">CNIC Back:</label>
                                    @if($property->cnic_front != null)
                                    <a href="{{asset('/uploads/user/cnic/'.$property->cnic_back)}}">View Attached
                                        File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class=" detail-item col-md-4">
                                    <label class="info-label">Allotment Order:</label>
                                    @if($property->alotment_order != null)
                                    <a href="{{asset('/uploads/user/alotment_order/'.$property->alotment_order)}}">View
                                        Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Complete File <img class="ml-1"
                                            style="display: none;" src="{{asset('/double-check.png')}}" width="20"
                                            height="20" alt="" id="complete_file_done"></label>
                                    @if($property->attachment->complete_file != null)
                                    <a href="{{asset('/uploads/complete/'.$property->attachment->complete_file)}}">View
                                        Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Code of Affected House <img class="ml-1"
                                            style="display: none;" src="{{asset('/double-check.png')}}" width="20"
                                            height="20" alt="" id="affected_house_done"></label>
                                    @if($property->attachment->affected_house != null)
                                    <a
                                        href="{{asset('/uploads/affected_house/'.$property->attachment->affected_house)}}">View
                                        Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4  text-left">
                                    <label class="d-flex" for="name">Award of Built-up Property <img class="ml-1"
                                            style="display: none;" src="{{asset('/double-check.png')}}" width="20"
                                            height="20" alt="" id="builtup_property_done"></label>

                                    @if($property->attachment->builtup_property != null)
                                    <a href="{{asset('/uploads/builtup/'.$property->attachment->builtup_property)}}">View
                                        Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>


                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Entitlement <img class="ml-1"
                                            style="display: none;" src="{{asset('/double-check.png')}}" width="20"
                                            height="20" alt="" id="entitlement_done"></label>

                                    @if($property->attachment->entitlement != null)
                                    <a href="{{asset('/uploads/entitlement/'.$property->attachment->entitlement)}}">View
                                        Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif


                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Allotment by Allotment Committee <img class="ml-1"
                                            style="display: none;" src="{{asset('/double-check.png')}}" width="20"
                                            height="20" alt="" id="allot_com_done"></label>

                                    @if($property->attachment->allot_com != null)
                                    <a
                                        href="{{asset('/uploads/allotment_committee/'.$property->attachment->allot_com)}}">View
                                        Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif

                                </div>


                                {{-- <div class="detail-item col-md-6 text-left">
                                    <label class="d-flex" for="name">Allotment Order <img class="ml-1"
                                            style="display: none;" src="{{asset('/double-check.png')}}" width="20"
                                            height="20" alt="" id="allot_order_done"></label>

                                    @if($property->attachment->allot_order != null)
                                    <a href="{{asset('/uploads/allotment_order/'.$property->attachment->allot_order)}}">View
                                        Attached File</a>
                                    @endif


                                </div> --}}
                                <div class="detail-item col-md-4  text-left">
                                    <label class="d-flex" for="name">Possession Chit With Mapping <img class="ml-1"
                                            style="display: none;" src="{{asset('/double-check.png')}}" width="20"
                                            height="20" alt="" id="chit_mapping_done"></label>

                                    @if($property->attachment->chit_mapping != null)
                                    <a href="{{asset('/uploads/chit_mapping/'.$property->attachment->chit_mapping)}}">View
                                        Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif

                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Order Attachement <img class="ml-1"
                                            style="display: none;" src="{{asset('/double-check.png')}}" width="20"
                                            height="20" alt="" id="order_attach_done"></label>

                                    @if($property->attachment->order_attach != null)
                                    <a
                                        href="{{asset('/uploads/order_attchement/'.$property->attachment->order_attach)}}">View
                                        Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@php
    $existingObjections = $request->engineerObjections ?? collect();
    $hasExistingObjections = $existingObjections->count() > 0;
    $hasPendingObjection = $request->hasEngineerPendingObjections();

    // NEW: sub-engineer must have submitted (action is not null) before HDM can act
    $subEngineerResponded = !is_null($request->engineer_status);
@endphp
@if($hasExistingObjections)
@include('partials.objections._objections_panel')
@endif



{{-- ─── HDM Action Form ───────────────────────────────────────────── --}}
{{-- Gate: block HDM action until sub-engineer has responded --}}

    {{-- ─── existing HDM Action Form (your current @if(!$hasExistingObjections)...@endif block goes here) ─── --}}
    @if(!$hasExistingObjections)
    <form action="/transferfile-action/{{ $request->id }}" method="POST" class="mt-3">
    @csrf

    {{-- Objection Checkbox – auto-checked if objections exist --}}
    @if(auth()->user()->hasRole('sub-engineer'))
    <div class="form-row px-4 pt-4">
        <div class="col-md-12 mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="hasObjection" name="has_objection" value="1"
                    {{ $hasExistingObjections ? 'checked' : '' }}>
                <label class="form-check-label info-label" for="hasObjection">
                    Have any objection?
                </label>
            </div>
        </div>
    </div>
    @endif

    {{-- Section: IF YES – Add new objection --}}
    <div id="objectionSection" class="form-row px-4"
        style="display: {{ $hasExistingObjections ? 'flex' : 'none' }};">
        <div class="col-md-3">
            <label for="objection_type">Objection Type</label>
            <select name="objection_type" id="objection_type" class="form-control">
                <option value="">Select Objection Type</option>
                <option value="Missing File">Missing File</option>
                <option value="Chit map not available">Chit map not available</option>
                <option value="Incomplete Information">Incomplete Information</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="objection_remarks">Objection Remarks</label>
            <textarea name="objection_remarks" class="form-control" placeholder="Enter Objection Remarks"></textarea>
        </div>
        <div class="col-md-3">
            <label for="objection_date">Objection Date</label>
            <input type="date" name="objection_date" class="form-control" value="{{ date('Y-m-d') }}">
        </div>
    </div>

    {{-- Section: IF NO – Verify status --}}
    <div id="statusSection" class="form-row px-4"
        style="display: {{ $hasExistingObjections ? 'none' : 'flex' }};">
        <div class="col-md-3">
            <label for="verify_status">Status</label>
            <select name="verify_status" id="verify_status" class="form-control">
                <option value="">Select Status</option>
                <option {{ $request->engineer_status == '1' ? 'selected' : '' }} value="1">Approved</option>
                <option {{ $request->engineer_status == '0' ? 'selected' : '' }} value="0">Disapproved</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" class="form-control"
                placeholder="Enter Remarks">{{ $request->engineer_remarks }}</textarea>
        </div>
        <div class="col-md-3">
            <label for="date">Date</label>
            <input type="date" name="date" value="{{ $request->engineer_date }}" class="form-control">
        </div>
    </div>

    <div class="form-row mb-3 mt-4">
        <div class="col text-center">
            <button class="btn btn-primary px-5">Submit</button>
        </div>
    </div>
</form>
@else

@if($hasPendingObjection)
    {{-- ─── Pending Objection Notice ─────────────────────────────────────────── --}}
    <div class="alert alert-warning mx-3 mt-3" role="alert">
        <strong>⚠ Action Unavailable:</strong> This request has one or more <strong>pending objections</strong>.
        No approval or rejection can be submitted until all objections are resolved.
    </div>

@else
<form action="/transferfile-action/{{ $request->id }}" method="POST" class="mt-3">
    @csrf

    {{-- Section – Verify status --}}
    <div  class="form-row px-4"
        style="display: {{ !$hasExistingObjections ? 'none' : 'flex' }};">
        <div class="col-md-3">
            <label for="verify_status">Status</label>
            <select name="verify_status" id="verify_status" class="form-control">
                <option value="">Select Status</option>
                <option {{ $request->engineer_status == '1' ? 'selected' : '' }} value="1">Approved</option>
                <option {{ $request->engineer_status == '0' ? 'selected' : '' }} value="0">Disapproved</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" class="form-control"
                placeholder="Enter Remarks">{{ $request->engineer_remarks }}</textarea>
        </div>
        <div class="col-md-3">
            <label for="date">Date</label>
            <input type="date" name="date" value="{{ $request->engineer_date }}" class="form-control">
        </div>
    </div>

    <div class="form-row mb-3 mt-4">
        <div class="col text-center">
            <button class="btn btn-primary px-5">Submit</button>
        </div>
    </div>
</form>

@endif
@endif

            </div>{{-- end accordion --}}
    </div>{{-- end container --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const objCheckbox = document.getElementById('hasObjection');
    if (objCheckbox) {
        objCheckbox.addEventListener('change', function () {
            const objectionSection = document.getElementById('objectionSection');
            const statusSection    = document.getElementById('statusSection');
            if (this.checked) {
                objectionSection.style.display = 'flex';
                statusSection.style.display    = 'none';
            } else {
                objectionSection.style.display = 'none';
                statusSection.style.display    = 'flex';
            }
        });
    }
    </script>
</x-app-layout>
