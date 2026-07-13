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
                        <div class="row">
                            <div class="col-md-4">
                                <label class="info-label">Seller Name:</label>
                                <div class="info-value">{{$property->declarer_name}}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="info-label">Seller's Father Name:</label>
                                <div class="info-value">{{$property->declarer_fname}}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="info-label">Seller's CNIC:</label>
                                <div class="info-value">{{$property->declarer_cnic}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="info-label">Transferee Name:</label>
                                <div class="info-value">{{$property->transferee_name}}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="info-label">Transferee's Father Name:</label>
                                <div class="info-value">{{$property->transferee_fname}}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="info-label">Transferee's CNIC:</label>
                                <div class="info-value">{{$property->tranferee_cnic}}</</div>
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
                                <div class="info-value">{{$property->property->town}}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="info-label">Sector:</label>
                                <div class="info-value">{{$property->property->sector}}</div>
                            </div>
                            <div class=" col-md-3">
                                <label for="name">Area Measurement</label>
                                <div class="row">
                                    <div class="col">
                                        <label for="name">Acre</label>
                                        <input type="text" id="dm_acre" placeholder="acre" name="dm_acre" class="form-control"
                                        value="{{  $property->property->dm_acre ?? ''}}">
                                    </div>
                                    <div class="col">
                                        <label for="name">Kanal</label>
                                        <input type="text" id="dm_kanal" placeholder="kanal" name="dm_kanal" class="form-control"
                                        value="{{  $property->property->dm_kanal ?? ''}}">
                                    </div>
                                    <div class="col">
                                        <label for="name">Marla</label>
                                        <input type="text" id="dm_marla" placeholder="marla" name="dm_marla" class="form-control"
                                        value="{{  $property->property->dm_marla ?? ''}}">
                                    </div>
                                    <div class="col">
                                        <label for="name">Squarefeet</label>
                                        <input type="text" id="dm_sqrft" placeholder="sqrft" name="dm_sqrft" class="form-control"
                                        value="{{  $property->property->dm_sqrft ?? ''}}">
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
                                <label class="info-label">CNIC Front:</label>
                                @if($property->cnic_front != null)
                                <a href="{{asset('/uploads/user/cnic/'.$property->cnic_front)}}">View Attached File</a>
                                @else
                                <p>No File Attached</p>
                                @endif
                            </div>
                            <div class=" detail-item col-md-4">
                                <label class="info-label">CNIC Back:</label>
                                @if($property->cnic_front != null)
                                <a href="{{asset('/uploads/user/cnic/'.$property->cnic_back)}}">View Attached File</a>
                                @else
                                <p>No File Attached</p>
                                @endif
                            </div>
                            <div class=" detail-item col-md-4">
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

            <form action="/transferfile-action/{{$property->id}}" method="POST">
                @csrf
                <div class="form-row p-4">
                    <div class="col-md-4">
                        <label for="verify_status">Verify Status</label>
                        <select name="verify_status" id="" class="form-control">
                            <option>Select Verify</option>
                            <option value="Yes">Verify</option>
                            <option value="No">Not Verify</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="remarks">Remarks</label>
                        <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks">
                    </div>
                    <div class="col-md-4">
                        <label for="date">Date</label>
                        <input type="date" name="date" class="form-control">
                    </div>
                </div>
                <div class="form-row mb-3 mt-2">
                    <div class="col text-center">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>

            <!-- Property Details -->
            

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</x-app-layout>
