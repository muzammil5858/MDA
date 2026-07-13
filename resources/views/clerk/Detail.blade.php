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
    </style>

    <div class="container ">
        <h3 class="text-center mt-5 mb-4">Property Information</h2>
            <div class="accordion" id="propertyAccordion">

                <!-- Personal Information -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPersonal">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsePersonal" aria-expanded="true" aria-controls="collapsePersonal">
                            {{$property->request_type == 1 ? 'Property Transfer Request Information' : 'Hiba Transfer
                            Request Information'}}
                        </button>
                    </h2>
                    <div id="collapsePersonal" class="accordion-collapse collapse show"
                        aria-labelledby="headingPersonal">
                        <div class="accordion-body">
                            @foreach($property->participants as $key => $value)
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


                                @if(is_null($property->transfer->shared_attorney))
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
                                @endif
                            </div>
                            @endforeach

                            @if(!is_null($property->transfer->shared_attorney))
                            <div class="form-row">
                                <div class="card shadow-sm mb-4 mx-2"
                                    style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                        <label>Attorney on behalf of {{ $property->participants->map(fn($p) =>
                                            $p->owner->name)->implode(', ') }}</label>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>Attorney Name</label>
                                                <div class="info-value">{{ $property->transfer->callAttorney->name ??
                                                    'N/A' }}</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Attorney's Father Name</label>
                                                <div class="info-value">{{
                                                    $property->transfer->callAttorney->father_name ?? 'N/A' }}</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Attorney's CNIC</label>
                                                <div class="info-value">{{ $property->transfer->callAttorney->cnic ??
                                                    'N/A' }}</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Attorney's Address</label>
                                                <div class="info-value">{{ $property->transfer->callAttorney->address ??
                                                    'N/A' }}</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Attorney's Letter</label>
                                                <br>
                                                @if(!empty($property->transfer->callAttorney->attorney_letter))
                                                <a href="{{ asset('uploads/user/representative/letter/'.$property->transfer->callAttorney->attorney_letter) }}"
                                                    target="_blank">Click to View Letter</a>
                                                @else
                                                <div class="info-value">No Letter</div>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <label>Attorney's CNIC Attachements</label>
                                                <br>
                                                @if(!empty($property->transfer->callAttorney->cnic_front))
                                                <a href="{{ asset('uploads/user/representative/cnic/'.$property->transfer->callAttorney->cnic_front) }}"
                                                    target="_blank">Click to View CNIC Front Attachement</a>
                                                @else
                                                <div class="info-value">No CNIC Front </div>
                                                @endif
                                                <br>
                                                @if(!empty($property->transfer->callAttorney->cnic_back))
                                                <a href="{{ asset('uploads/user/representative/cnic/'.$property->transfer->callAttorney->cnic_back) }}"
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

                            @foreach($property->dummyreceiver as $key => $value)
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="info-label">Transferee Name:</label>
                                    <div class="info-value">{{$value->name ?? 'N/A'}}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Transferee's Father Name:</label>
                                    <div class="info-value">{{$value->father_name ?? 'N/A'}}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Transferee's CNIC:</label>
                                    <div class="info-value">{{$value->cnic ?? 'N/A'}}</div>
                                </div>
                                <div class="col-md-4">
                                    <label>Transferee's CNIC Attachements</label>
                                    <br>
                                    @if(!empty($value->cnic_front))
                                    <a href="{{ asset('uploads/user/cnics/'.$value->cnic_front) }}"
                                        target="_blank">Click to View CNIC Front Attachement</a>
                                    @else
                                    <div class="info-value">No CNIC Front </div>
                                    @endif
                                    <br>
                                    @if(!empty($value->cnic_back))
                                    <a href="{{ asset('uploads/user/cnics/'.$value->cnic_back) }}"
                                        target="_blank">Click to View CNIC Back Attachement</a>
                                    @else
                                    <div class="info-value">No CNIC Back</div>
                                    @endif
                                </div>
                                @if($property->request_type == 1)
                                <div class="col-md-4">
                                    <label class="info-label">Sold Price:</label>
                                    <div class="info-value">{{$property->transfer->amount}}</div>
                                </div>
                                @endif

                                @if($value->receiver_type == 'representative')
                                <div class="col-md-12">
                                    <div class="card shadow-sm mb-4 mx-4"
                                        style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                        <div class="card-body">
                                            <label>Representative on behalf of {{ $value->name ?? 'N/A' }}</label>
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label>Representative Name</label>
                                                    <div class="info-value">{{
                                                        $value->representative->name ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Representative's Father Name</label>
                                                    <div class="info-value">{{
                                                        $value->representative->father_name ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Representative's CNIC</label>
                                                    <div class="info-value">{{
                                                        $value->representative->cnic ?? 'N/A' }}</div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Representative's Address</label>
                                                    <div class="info-value">{{
                                                        $value->representative->address ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Representater's Letter</label>
                                                    <br>
                                                    @if(!empty($value->representative->attorney_letter))
                                                    <a href="{{ asset('uploads/user/representative/letter/'.$value->representative->attorney_letter) }}"
                                                        target="_blank">Click to View Letter</a>
                                                    @else
                                                    <div class="info-value">No Letter</div>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Representater's CNIC Attachements</label>
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
                            @if($property->transfer->shared_representative)
                            <div class="form-row">
                                <div class="card shadow-sm mb-4 mx-2"
                                    style="background-color: #f5f5f5; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                        <label>Representative on behalf of {{ $property->dummyreceiver->map(fn($p) =>
                                            $p->name)->implode(', ') }}</label>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label>Representative Name</label>
                                                <div class="info-value">{{ $property->transfer->callSharedRepresentative->name ??
                                                    'N/A' }}</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Attorney's Father Name</label>
                                                <div class="info-value">{{
                                                    $property->transfer->callSharedRepresentative->father_name ?? 'N/A' }}</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Attorney's CNIC</label>
                                                <div class="info-value">{{ $property->transfer->callSharedRepresentative->cnic ??
                                                    'N/A' }}</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Attorney's Address</label>
                                                <div class="info-value">{{ $property->transfer->callSharedRepresentative->address ??
                                                    'N/A' }}</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Attorney's Letter</label>
                                                <br>
                                                @if(!empty($property->transfer->callSharedRepresentative->attorney_letter))
                                                <a href="{{ asset('uploads/user/representative/letter/'.$property->transfer->callSharedRepresentative->attorney_letter) }}"
                                                    target="_blank">Click to View Letter</a>
                                                @else
                                                <div class="info-value">No Letter</div>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <label>Attorney's CNIC Attachements</label>
                                                <br>
                                                @if(!empty($property->transfer->callSharedRepresentative->cnic_front))
                                                <a href="{{ asset('uploads/user/representative/cnic/'.$property->transfer->callSharedRepresentative->cnic_front) }}"
                                                    target="_blank">Click to View CNIC Front Attachement</a>
                                                @else
                                                <div class="info-value">No CNIC Front </div>
                                                @endif
                                                <br>
                                                @if(!empty($property->transfer->callSharedRepresentative->cnic_back))
                                                <a href="{{ asset('uploads/user/representative/cnic/'.$property->transfer->callSharedRepresentative->cnic_back) }}"
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
                                            <input type="text" id="dm_kanal" placeholder="kanal" name="dm_kanal"
                                                class="form-control" value="{{  $property->property->kanal ?? ''}}">
                                        </div>
                                        <div class="col">
                                            <label for="name">Marla</label>
                                            <input type="text" id="dm_marla" placeholder="marla" name="dm_marla"
                                                class="form-control" value="{{  $property->property->marla ?? ''}}">
                                        </div>
                                        <div class="col">
                                            <label for="name">Squarefeet</label>
                                            <input type="text" id="dm_sqrft" placeholder="sqrft" name="dm_sqrft"
                                                class="form-control" value="{{  $property->property->sqrft ?? ''}}">
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
                @if(auth()->user()->hasRole('record-clerk'))
                <form action="/transferfile-action/{{$property->id}}" method="POST">
                    @csrf
                    <div class="form-row p-4">
                        <div class="col-md-3">
                            <label for="verify_status">Status</label>
                            <select name="verify_status" id="" class="form-control">
                                <option>Select Status</option>
                                <option {{$property->deo_action == '1' ? 'selected' : ''}} value="Yes">Approved</option>
                                <option {{$property->deo_action == '0' ? 'selected' : ''}} value="No">Disapproved
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks">Remarks</label>
                            <textarea type="text" name="remarks" class="form-control"
                                placeholder="Enter Remarks">{{$property->deo_remarks}}</textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="date">Date</label>
                            <input type="date" name="date" value="{{$property->deo_date}}" class="form-control">
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
