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
        .container{
            border:1px solid lightgray;
        }
        span{
            font-weight: bolder;
        }
    </style>

    <div class="container ">
        <h3 class="text-center mt-5 mb-4">Property Information</h2>
        <div class="accordion" id="propertyAccordion">

            <!-- Personal Information -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPersonal">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="true" aria-controls="collapsePersonal">
                        Property Transfer Request Information
                    </button>
                </h2>
                <div id="collapsePersonal" class="accordion-collapse collapse show" aria-labelledby="headingPersonal">
                    <div class="accordion-body">
                        @foreach($property->participants as $key => $value)
                        <div class="form-row">
                            <div class="col-md-4">
                                <label>Owner Name</label>
                                <div class="info-value">{{ $value->owner->name ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-4">
                                <label>Owner's Father Name</label>
                                <div class="info-value">{{ $value->owner->father_name ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-4">
                                <label>Owner's CNIC</label>
                                <div class="info-value">{{ $value->owner->cnic ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-4">
                                <label>Owner's Address</label>
                                <div class="info-value">{{ $value->owner->address ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-4">
                                <label>Owner's Area</label>
                                <div class="info-value">{{ $value->owner->area ? $value->owner->area . ' Marla' : 'N/A' }}</div>
                            </div>
                            <div>
                                <label>Death Certificate</label>
                                <br><a target="_blank" href="{{asset('uploads/user/death_certificates/'.$property->transfer->death_certificate)}}">Click To view Death Certificate</a>
                            </div>
                        </div>
                            @endforeach
                        <div class="row">
                            <div class="col-md-4">
                                <label class="info-label">Requester Name:</label>
                                <div class="info-value">{{$property->transfer->buyer_name}}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="info-label">Requester's Father Name:</label>
                                <div class="info-value">{{$property->transfer->buyer_fname}}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="info-label">Requester's CNIC:</label>
                                <div class="info-value">{{$property->transfer->buyer_cnic}}</</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Attachments -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingProperty">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProperty" aria-expanded="false" aria-controls="collapseProperty">
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
                                <div class="info-value">{{$property->property->center}}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="info-label">Locality:</label>
                                <div class="info-value">{{$property->property->locality}}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="info-label">Code:</label>
                                <div class="info-value">{{$property->property->code}}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="info-label">Plot No:</label>
                                <div class="info-value">{{$property->property->plot_no}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="info-label">Town:</label>
                                <div class="info-value">{{$property->property->township->name}}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="info-label">Sector:</label>
                                <div class="info-value">{{$property->property->sector}}</div>
                            </div>
                            <div class=" col-md-3">
                                <label for="name">Area Measurement</label>
                                <div class="row">
                                    
                                    <div class="col">
                                        <label for="name">Kanal</label>
                                        <input type="text" id="dm_kanal" placeholder="kanal" name="dm_kanal" class="form-control"
                                        value="{{  $property->property->kanal ?? ''}}">
                                    </div>
                                    <div class="col">
                                        <label for="name">Marla</label>
                                        <input type="text" id="dm_marla" placeholder="marla" name="dm_marla" class="form-control"
                                        value="{{  $property->property->marla ?? ''}}">
                                    </div>
                                    <div class="col">
                                        <label for="name">Squarefeet</label>
                                        <input type="text" id="dm_sqrft" placeholder="sqrft" name="dm_sqrft" class="form-control"
                                        value="{{  $property->property->sqrft ?? ''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAttachments">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAttachments" aria-expanded="false" aria-controls="collapseAttachments">
                        Attachments
                    </button>
                </h2>
                <div id="collapseAttachments" class="accordion-collapse collapse" aria-labelledby="headingAttachments">
                    <div class="accordion-body">
                        <div class="form-row">
                            <div class=" detail-item col-md-4">
                                <label class="info-label">Death Certificate:</label>
                                @if($property->transfer->death_certificate != null)
                                <a href="{{asset('/uploads/user/death_certificate/'.$property->transfer->death_certificate)}}">View Attached File</a>
                                @else
                                <p>No File Attached</p>
                                @endif
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="detail-item col-md-4 text-left">
                                <label class="d-flex" for="name">Complete File <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="complete_file_done"></label>
                                @if($property->attachment->complete_file != null)
                                <a href="{{asset('/uploads/complete/'.$property->attachment->complete_file)}}">View Attached File</a>
                                @else
                                <p>No File Attached</p>
                                @endif
                            </div>
                            <div class="detail-item col-md-4 text-left">
                                <label class="d-flex" for="name">Code of Affected House <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="affected_house_done"></label>
                                @if($property->attachment->affected_house != null)
                                <a href="{{asset('/uploads/affected_house/'.$property->attachment->affected_house)}}">View Attached File</a>
                                @else
                                <p>No File Attached</p>
                                @endif
                            </div>
                            <div class="detail-item col-md-4  text-left">
                                <label class="d-flex" for="name">Award of Built-up Property <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="builtup_property_done"></label>

                                    @if($property->attachment->builtup_property != null)
                                <a href="{{asset('/uploads/builtup/'.$property->attachment->builtup_property)}}">View Attached File</a>
                                @else
                                <p>No File Attached</p>
                                @endif
                            </div>
                       

                            <div class="detail-item col-md-4 text-left">
                                <label class="d-flex" for="name">Entitlement <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="entitlement_done"></label>
                              
                                    @if($property->attachment->entitlement != null)
                                <a href="{{asset('/uploads/entitlement/'.$property->attachment->entitlement)}}">View Attached File</a>
                                @else
                                <p>No File Attached</p>
                                @endif
                                

                            </div>
                            <div class="detail-item col-md-4 text-left">
                                <label class="d-flex" for="name">Allotment by Allotment Committee <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="allot_com_done"></label>
                                
                                    @if($property->attachment->allot_com != null)
                                    <a href="{{asset('/uploads/allotment_committee/'.$property->attachment->allot_com)}}">View Attached File</a>
                                    @else
                                <p>No File Attached</p>
                                    @endif

                            </div>
                   

                            {{-- <div class="detail-item col-md-6 text-left">
                                <label class="d-flex" for="name">Allotment Order <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="allot_order_done"></label>
                                
                                    @if($property->attachment->allot_order != null)
                                    <a href="{{asset('/uploads/allotment_order/'.$property->attachment->allot_order)}}">View Attached File</a>
                                    @endif
                               

                            </div> --}}
                            <div class="detail-item col-md-4  text-left">
                                <label  class="d-flex" for="name">Possession Chit With Mapping <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="chit_mapping_done"></label>
                               
                                    @if($property->attachment->chit_mapping != null)
                                    <a href="{{asset('/uploads/chit_mapping/'.$property->attachment->chit_mapping)}}">View Attached File</a>
                                    @else
                                <p>No File Attached</p>
                                    @endif

                            </div>
                            <div class="detail-item col-md-4 text-left" >
                                <label class="d-flex" for="name">Order Attachement <img class="ml-1" style="display: none;" src="{{asset('/double-check.png')}}" width="20" height="20" alt="" id="order_attach_done"></label>
                               
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
            @if(auth()->user()->hasRole('record-clerk'))
            <form action="/transferfile-action/{{$property->id}}" method="POST">
                @csrf
                <div class="form-row p-4">
                    <div class="col-md-4">
                        <label for="verify_status">Status</label>
                        <select name="verify_status" id="" class="form-control">
                            <option>Select Status</option>
                            <option {{$property->verify_status == 'Yes' ? 'selected' : ''}} value="Yes">Approved</option>
                            <option {{$property->verify_status == 'No' ? 'selected' : ''}} value="No">Disapproved</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="remarks">Remarks</label>
                        <textarea type="text" name="remarks"  class="form-control" placeholder="Enter Remarks">{{$property->deo_remarks}}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="date">Date</label>
                        <input type="date" name="date" value="{{$property->date}}" class="form-control">
                    </div>
                </div>
                <div class="form-row mb-3 mt-2">
                    <div class="col text-center">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            @endif
            <!-- Property Details -->
            

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</x-app-layout>
