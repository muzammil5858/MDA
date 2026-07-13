<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap');

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

        /* ── Map Approval Detail View ── */
        .map-approval-detail {
            font-family: 'Noto Nastaliq Urdu', 'Segoe UI', serif;
            direction: rtl;
        }

        .map-approval-detail .ma-header {
            background: #0f2e3f;
            padding: 16px 24px 12px 24px;
            border-radius: 12px 12px 0 0;
            margin-bottom: 0;
        }

        .map-approval-detail .ma-badge-title {
            display: inline-block;
            background: #e9c46a;
            color: #1e3a2f;
            font-weight: 700;
            font-size: 0.7rem;
            padding: 4px 14px;
            border-radius: 30px;
            margin-bottom: 6px;
        }

        .map-approval-detail .ma-header h2 {
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 4px 0 2px 0;
        }

        .map-approval-detail .ma-header p {
            color: #cfdfe9;
            font-size: 0.72rem;
            margin: 0;
        }

        .map-approval-detail .ma-body {
            border: 1px solid #e2ddd0;
            border-top: none;
            border-radius: 0 0 12px 12px;
            padding: 18px 20px;
            background: #fff;
        }

        .map-approval-detail .ma-row {
            background: #fefcf7;
            border-radius: 12px;
            padding: 10px 16px;
            border: 1px solid #ece5d8;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            flex-wrap: wrap;
        }

        .map-approval-detail .ma-row-num {
            font-weight: 800;
            font-size: 0.85rem;
            background: #e9edf2;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 30px;
            color: #1e4660;
            flex-shrink: 0;
        }

        .map-approval-detail .ma-row-text {
            flex: 1;
            font-size: 0.88rem;
            font-weight: 500;
            color: #1f2d3d;
            line-height: 1.8;
        }

        .map-approval-detail .ma-value {
            display: inline-block;
            background: #fff;
            border: 1px solid #d4cbb8;
            border-radius: 8px;
            padding: 3px 12px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #1f3b4a;
            min-width: 60px;
            text-align: center;
            font-family: 'Courier New', monospace;
        }

        .map-approval-detail .ma-value.wide {
            min-width: 200px;
            text-align: right;
        }

        .map-approval-detail .ma-toggle {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .map-approval-detail .ma-toggle.yes {
            background: #1e5e3c;
            color: white;
        }

        .map-approval-detail .ma-toggle.no {
            background: #9b3c2a;
            color: white;
        }

        .map-approval-detail .ma-toggle.na {
            background: #ccc;
            color: #444;
        }

        .map-approval-detail .ma-empty {
            text-align: center;
            color: #999;
            padding: 20px;
            font-size: 0.9rem;
            direction: ltr;
        }
    </style>

    <div class="container ">
        <h3 class="text-center mt-5 mb-4">Map Approval Request Information</h3>
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
                            <h2 class="label-h2">
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
                                    <div class="info-value">{{ $value->owner->area ? $value->owner->area . ' Marla' : 'N/A' }}</div>
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
                                                    <div class="info-value">{{ $value->representative->name ?? 'N/A' }}</div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Attorney's Father Name</label>
                                                    <div class="info-value">{{ $value->representative->father_name ?? 'N/A' }}</div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Attorney's CNIC</label>
                                                    <div class="info-value">{{ $value->representative->cnic ?? 'N/A' }}</div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Attorney's Address</label>
                                                    <div class="info-value">{{ $value->representative->address ?? 'N/A' }}</div>
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

                            <h2 class="label-h2">
                                Engineer and Architect Details
                            </h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row" style="border: 2px solid lightgray;padding: 5px;border-radius: 15px;">
                                        <div class="col-md-6">
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
                            <h2 class="label-h2 mt-2">
                                Uploaded Maps
                            </h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="info-label">Uploaded Map (PNG)</label>
                                    @if($smallRequest->map_attachment)
                                    <a href="{{ asset('uploads/maps/'.$smallRequest->map_attachment) }}" target="_blank">View Uploaded Map</a>
                                    @else
                                    <div class="info-value">No Map Uploaded</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Uploaded Map (PDF)</label>
                                    @if($smallRequest->map_attachment)
                                    <a href="{{ asset('uploads/maps/'.$smallRequest->map_attachment) }}" target="_blank">View Uploaded Map</a>
                                    @else
                                    <div class="info-value">No Map Uploaded</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Uploaded Map (AutoCAD)</label>
                                    @if($smallRequest->map_attachment)
                                    <a href="{{ asset('uploads/maps/'.$smallRequest->map_attachment) }}" target="_blank">View Uploaded Map</a>
                                    @else
                                    <div class="info-value">No Map Uploaded</div>
                                    @endif
                                </div>
                            </div>
                            <h2 class="label-h2 mt-2">
                                Record Clerk Remarks
                            </h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="info-label">Record Clerk Status</label>
                                    <div class="info-value">{{ $request->deo_action == 1 ? 'Approved' : 'N/A' }}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Record Clerk Remarks</label>
                                    <div class="info-value">{{ $request->deo_remarks ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Record Clerk Approval Date</label>
                                    <div class="info-value">{{ $request->deo_date ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <h2 class="label-h2 mt-2">
                                Sub Engineer Remarks
                            </h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="info-label">Sub Engineer Status</label>
                                    <div class="info-value">
                                        @if($request->engineer_status == 1)
                                            <span class="badge badge-resolved">Approved</span>
                                        @elseif($request->engineer_status == 0)
                                            <span class="badge badge-rejected">Disapproved</span>
                                        @elseif($request->engineer_status == 2)
                                            <span class="badge badge-pending">Objection Raised</span>
                                        @else
                                            <span class="badge badge-pending">Pending</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Sub Engineer Remarks</label>
                                    <div class="info-value">{{ $request->engineer_remarks }}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Sub Engineer Response Date</label>
                                    <div class="info-value">{{ $request->engineer_date }}</div>
                                </div>
                            </div>
                            <h2 class="label-h2 mt-2">
                                HDM Remarks
                            </h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="info-label">HDM Status</label>
                                    <div class="info-value">
                                        @if($request->head_status == 'accept')
                                            <span class="badge badge-resolved">Approved</span>
                                        @elseif($request->head_status == 'reject')
                                            <span class="badge badge-rejected">Disapproved</span>
                                        @else
                                            <span class="badge badge-pending">Pending</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">HDM Remarks</label>
                                    <div class="info-value">{{ $request->head_remarks }}</div>
                                </div>
                                <div class="col-md-4" style="position:relative;">
                                    <label class="info-label">HDM Response Date</label>
                                    <div class="info-value">{{ $request->head_date }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Property Details -->
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
                                    <div class="info-value">{{$property->plot_no}}</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="info-label">Town:</label>
                                    <div class="info-value">{{$property->township->name}}</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="info-label">Sector:</label>
                                    <div class="info-value">{{$property->sector}}</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="name">Area Measurement</label>
                                    <div class="row">
                                        <div class="col">
                                            <label for="name">Kanal</label>
                                            <input type="text" id="dm_kanal" placeholder="kanal" name="dm_kanal"
                                                class="form-control" value="{{ $property->kanal ?? '' }}">
                                        </div>
                                        <div class="col">
                                            <label for="name">Marla</label>
                                            <input type="text" id="dm_marla" placeholder="marla" name="dm_marla"
                                                class="form-control" value="{{ $property->marla ?? '' }}">
                                        </div>
                                        <div class="col">
                                            <label for="name">Squarefeet</label>
                                            <input type="text" id="dm_sqrft" placeholder="sqrft" name="dm_sqrft"
                                                class="form-control" value="{{ $property->sqrft ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
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
                                <div class="detail-item col-md-4">
                                    <label class="info-label">CNIC Front:</label>
                                    @if($property->cnic_front != null)
                                    <a href="{{asset('/uploads/user/cnic/'.$property->cnic_front)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4">
                                    <label class="info-label">CNIC Back:</label>
                                    @if($property->cnic_front != null)
                                    <a href="{{asset('/uploads/user/cnic/'.$property->cnic_back)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4">
                                    <label class="info-label">Allotment Order:</label>
                                    @if($property->alotment_order != null)
                                    <a href="{{asset('/uploads/user/alotment_order/'.$property->alotment_order)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Complete File</label>
                                    @if($property->attachment->complete_file != null)
                                    <a href="{{asset('/uploads/complete/'.$property->attachment->complete_file)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Code of Affected House</label>
                                    @if($property->attachment->affected_house != null)
                                    <a href="{{asset('/uploads/affected_house/'.$property->attachment->affected_house)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Award of Built-up Property</label>
                                    @if($property->attachment->builtup_property != null)
                                    <a href="{{asset('/uploads/builtup/'.$property->attachment->builtup_property)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Entitlement</label>
                                    @if($property->attachment->entitlement != null)
                                    <a href="{{asset('/uploads/entitlement/'.$property->attachment->entitlement)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Allotment by Allotment Committee</label>
                                    @if($property->attachment->allot_com != null)
                                    <a href="{{asset('/uploads/allotment_committee/'.$property->attachment->allot_com)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Possession Chit With Mapping</label>
                                    @if($property->attachment->chit_mapping != null)
                                    <a href="{{asset('/uploads/chit_mapping/'.$property->attachment->chit_mapping)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                                <div class="detail-item col-md-4 text-left">
                                    <label class="d-flex" for="name">Order Attachement</label>
                                    @if($property->attachment->order_attach != null)
                                    <a href="{{asset('/uploads/order_attchement/'.$property->attachment->order_attach)}}">View Attached File</a>
                                    @else
                                    <p>No File Attached</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════════════════════ -->
                <!-- Map Approval Details — with embedded Urdu detail view      -->
                <!-- ═══════════════════════════════════════════════════════════ -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMapApproval">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#mapDetails" aria-expanded="false"
                            aria-controls="mapDetails">
                            Map Approval Details
                        </button>
                    </h2>
                    <div id="mapDetails" class="accordion-collapse collapse"
                        aria-labelledby="headingMapApproval">
                        <div class="accordion-body">



                            {{-- ═══════════════════════════════════════════════════════ --}}
                            {{-- Building Control Section — Urdu Detail View           --}}
                            {{-- Shows the saved $mapApproval record in read-only mode --}}
                            {{-- ═══════════════════════════════════════════════════════ --}}
                            <h2 class="label-h2 mt-3 mb-2">بلڈنگ کنٹرول سیکشن — تفصیلی معلومات</h2>

                            <div class="map-approval-detail">
                                <div class="ma-header">
                                    <div class="ma-badge-title">🔖 منگلا ڈیم ہاؤسنگ اتھارٹی | بلڈنگ کنٹرول</div>
                                    <h2>🏛️ اپروول آف بلڈنگ کنٹرول سیکشن</h2>
                                    <p>تعمیراتی نقشہ جات، اضافی رقبہ جات اور منظوری کی مکمل رپورٹ</p>
                                </div>

                                <div class="ma-body">
                                    @if(!$mapApproval)
                                        <div class="ma-empty">
                                            ابھی تک بلڈنگ کنٹرول سیکشن کی کوئی تفصیل درج نہیں کی گئی۔
                                        </div>
                                    @else

                                        {{-- Row 1: Plot / Township / Sector / Count --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">1</div>
                                            <div class="ma-row-text">
                                                پلاٹ
                                                <span class="ma-value">{{ $property->plot_no ?: '—' }}</span>
                                                ٹاؤن شپ
                                                <span class="ma-value wide">{{ $property->township?->urdu_name ?: '—' }}</span>
                                                سیکٹر
                                                <span class="ma-value">{{ $property->sector ?: '—' }}</span>
                                                تعداد
                                                <span class="ma-value">{{ $property->count ?: '—' }}</span>
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 2: Drawing No / Date / Location --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">2</div>
                                            <div class="ma-row-text">
                                                پلاٹ منظور شدہ ابتدائی نقشہ پلان / ڈرائنگ نمبر
                                                <span class="ma-value">{{ $mapApproval->drawing_no ?: '—' }}</span>
                                                مورخہ
                                                <span class="ma-value">{{ $mapApproval->drawing_date ? \Carbon\Carbon::parse($mapApproval->drawing_date)->format('d/m/Y') : '—' }}</span>
                                                میں
                                                <span class="ma-value wide">{{ $mapApproval->drawing_location ?: '—' }}</span>
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 3: Allocated Area --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">3</div>
                                            <div class="ma-row-text">
                                                نمبر 1,2 کی روشنی میں پلاٹ موقع پر کے لئے مختص شدہ رقبہ یا کمرشل
                                                @if($mapApproval->allocated_area === 'yes')
                                                    <span class="ma-toggle yes">✔️ ہاں</span>
                                                @elseif($mapApproval->allocated_area === 'no')
                                                    <span class="ma-toggle no">❌ نہیں</span>
                                                @else
                                                    <span class="ma-toggle na">—</span>
                                                @endif
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 4: Road Location --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">4</div>
                                            <div class="ma-row-text">
                                                پلاٹ میں روڈ پر واقع
                                                @if($mapApproval->road_location === 'yes')
                                                    <span class="ma-toggle yes">✔️ ہاں</span>
                                                @elseif($mapApproval->road_location === 'no')
                                                    <span class="ma-toggle no">❌ نہیں</span>
                                                @else
                                                    <span class="ma-toggle na">—</span>
                                                @endif
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 5: Construction Status --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">5</div>
                                            <div class="ma-row-text">
                                                چار دیواری / مکان تعمیر شدہ
                                                @if($mapApproval->construction_status === 'yes')
                                                    <span class="ma-toggle yes">✔️ ہاں</span>
                                                @elseif($mapApproval->construction_status === 'no')
                                                    <span class="ma-toggle no">❌ نہیں</span>
                                                @else
                                                    <span class="ma-toggle na">—</span>
                                                @endif
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 6: Plot Size After Approval --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">6</div>
                                            <div class="ma-row-text">
                                                پلاٹ ہذا کے ساتھ ملحقہ رقبہ کی منظوری کے بعد پلاٹ کا سائز
                                                <span class="ma-value wide">{{ $mapApproval->plot_size_status ?: '—' }}</span>
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 7: Added Area / Additional Remarks --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">7</div>
                                            <div class="ma-row-text">
                                                پلاٹ ہذا کے رقبہ میں
                                                <span class="ma-value">{{ $mapApproval->added_area_sq_yards ?: '—' }}</span>
                                                مربع گز کا اضافہ ہو چکا
                                                <span class="ma-value wide">{{ $mapApproval->additional_remarks ?: '—' }}</span>
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 8: Impact on Public --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">8</div>
                                            <div class="ma-row-text">
                                                اس زائد رقبہ کی وجہ سے کوئی سرکاری تنصیب / منڈی / کوئی دیگر پلاٹ
                                                @if($mapApproval->impact_on_public === 'yes')
                                                    <span class="ma-toggle yes">✔️ ہاں</span>
                                                @elseif($mapApproval->impact_on_public === 'no')
                                                    <span class="ma-toggle no">❌ نہیں</span>
                                                @else
                                                    <span class="ma-toggle na">—</span>
                                                @endif
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 9: Graveyard Status --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">9</div>
                                            <div class="ma-row-text">
                                                زائد رقبہ کسی مقابر عامہ کے رقبہ میں شامل
                                                @if($mapApproval->graveyard_status === 'yes')
                                                    <span class="ma-toggle yes">✔️ ہاں</span>
                                                @elseif($mapApproval->graveyard_status === 'no')
                                                    <span class="ma-toggle no">❌ نہیں</span>
                                                @else
                                                    <span class="ma-toggle na">—</span>
                                                @endif
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 10: Separate Plot --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">10</div>
                                            <div class="ma-row-text">
                                                زائد رقبہ کا کوئی علیحدہ پلاٹ نہیں
                                                @if($mapApproval->separate_plot === 'yes')
                                                    <span class="ma-toggle yes">✔️ ہاں</span>
                                                @elseif($mapApproval->separate_plot === 'no')
                                                    <span class="ma-toggle no">❌ نہیں</span>
                                                @else
                                                    <span class="ma-toggle na">—</span>
                                                @endif
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 11: TOR Compliance --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">11</div>
                                            <div class="ma-row-text">
                                                نقشہ ہذا کی اور MDHA / TOR کی روشنی میں
                                                @if($mapApproval->tor_compliance === 'yes')
                                                    <span class="ma-toggle yes">✔️ ہاں</span>
                                                @elseif($mapApproval->tor_compliance === 'no')
                                                    <span class="ma-toggle no">❌ نہیں</span>
                                                @else
                                                    <span class="ma-toggle na">—</span>
                                                @endif
                                                ہے۔
                                            </div>
                                        </div>

                                        {{-- Row 12: Covered Area --}}
                                        <div class="ma-row">
                                            <div class="ma-row-num">12</div>
                                            <div class="ma-row-text">
                                                کور ایریا
                                                <span class="ma-value wide">{{ $mapApproval->covered_area ?: '—' }}</span>
                                                ہے۔
                                            </div>
                                        </div>

                                    @endif {{-- end @if($mapApproval) --}}
                                </div>{{-- .ma-body --}}
                            </div>{{-- .map-approval-detail --}}

                        </div>{{-- .accordion-body --}}
                    </div>
                </div>{{-- accordion-item: Map Approval Details --}}

            </div>{{-- end accordion --}}

@php
    $existingObjections = $request->engineerObjections ?? collect();
    $hasExistingObjections = $existingObjections->count() > 0;
    $hasPendingObjection = $request->hasEngineerPendingObjections();
    $subEngineerResponded = !is_null($request->engineer_status);
@endphp
@if($hasExistingObjections)
@include('partials.objections._objections_panel')
@endif

@if(!$subEngineerResponded)
    <div class="alert alert-warning mx-3 mt-3" role="alert">
        <strong>⏳ Awaiting Sub Engineer Response:</strong>
        The sub-engineer has not yet submitted their remarks for this request.
        Approval or rejection is locked until their response is received.
    </div>
@else
    @if(!$hasExistingObjections)
    <form action="/ad-civil/submit-pending-request/{{ $request->id }}" method="POST" class="mt-3">
    @csrf

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

    <div id="statusSection" class="form-row px-4"
        style="display: {{ $hasExistingObjections ? 'none' : 'flex' }};">
        <div class="col-md-3">
            <label for="verify_status">Status</label>
            <select name="verify_status" id="verify_status" class="form-control">
                <option value="">Select Status</option>
                <option {{ $request->ad_status == '1' ? 'selected' : '' }} value="1">Approved</option>
                <option {{ $request->ad_status == '0' ? 'selected' : '' }} value="0">Disapproved</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" class="form-control"
                placeholder="Enter Remarks">{{ $request->ad_remarks }}</textarea>
        </div>
        <div class="col-md-3">
            <label for="date">Date</label>
            <input type="date" name="date" value="{{ $request->ad_date }}" class="form-control">
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
    <div class="alert alert-warning mx-3 mt-3" role="alert">
        <strong>⚠ Action Unavailable:</strong> This request has one or more <strong>pending objections</strong>.
        No approval or rejection can be submitted until all objections are resolved.
    </div>
@else
<form action="/ad-civil/submit-pending-request/{{ $request->id }}" method="POST" class="mt-3">
    @csrf
    <div class="form-row px-4" style="display: {{ !$hasExistingObjections ? 'none' : 'flex' }};">
        <div class="col-md-3">
            <label for="verify_status">Status</label>
            <select name="verify_status" id="verify_status" class="form-control">
                <option value="">Select Status</option>
                <option {{ $request->ad_status == '1' ? 'selected' : '' }} value="1">Approved</option>
                <option {{ $request->ad_status == '0' ? 'selected' : '' }} value="0">Disapproved</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" class="form-control"
                placeholder="Enter Remarks">{{ $request->ad_remarks }}</textarea>
        </div>
        <div class="col-md-3">
            <label for="date">Date</label>
            <input type="date" name="date" value="{{ $request->ad_date }}" class="form-control">
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
@endif

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
