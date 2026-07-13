<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400..700&display=swap" rel="stylesheet">
    <style>
        /* Container & Card Styling */
        .container {
            background: #fdfdfd;
            border: 1px solid #F4F6F9;
            margin-top: 20px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }

        h2#heading {
            text-transform: uppercase;
            color: #03346E;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: 1.5px;
        }

        p#subheading {
            font-size: 1rem;
            text-align: center;
            color: #555;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* File Upload Styles */
        .file-drop-area {
            border: 2px dashed #7da2d9;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            border-radius: 8px;
            background-color: #f9fbff;
            transition: background 0.25s ease-in-out, border-color 0.25s ease-in-out;
            position: relative;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .file-drop-area:hover {
            background-color: #e6f0ff;
            border-color: #5b8def;
        }

        .file-drop-area.dragover {
            background-color: #cce0ff;
            border-color: #3a65d8;
        }

        .file-drop-area span {
            font-size: 0.8rem;
            color: #3a3a3a;
            user-select: none;
        }

        input[type="file"] {
            display: none;
        }
        input:not([type="file"], [type="number"]),textarea {
  direction: rtl;
  font-family: "Noto Nastaliq Urdu", serif;
}


        .img-preview {
            max-height: 120px;
            max-width: 100%;
            margin-top: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            object-fit: contain;
        }

        label {
            font-weight: 600;
            color: #03346E;
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        button[type="submit"] {
            background-color: #03346E;
            border: none;
            color: white;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            font-weight: 600;
        }

        button[type="submit"]:hover {
            background-color: #021f4a;
        }

        /* Layout for 4 columns */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .card {
            border: none !important;
            box-shadow: none;

        }

        .col-md-3 {
            flex: 1 1 calc(25% - 30px);
            /* 4 columns minus gap */
            max-width: calc(25% - 30px);
            box-sizing: border-box;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .col-md-3 {
                flex: 1 1 calc(50% - 30px);
                max-width: calc(50% - 30px);
            }
        }

        @media (max-width: 575px) {
            .col-md-3 {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }


        .fs-title {
            font-size: 25px;
            color: #03346E;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }
        .form-control{
            border-radius:5px;
        }
        .delete-btn {
    position: absolute;
    top: 0px;
    right: 10px;
    background: #ff4d4d;
    color: white;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    text-align: center;
    line-height: 26px;
    cursor: pointer !important;
    z-index:222;
    font-weight: bold;
    font-size: 16px;
}
.delete-btn:hover {
    background: #e60000;
}





    .custom-abs-address {
        position: absolute !important;
        top: 30px;
        left: 15px;
        width: calc(100% - 30px);
        z-index: 10;
        background: white;
        resize: none;
        transition: all 0.2s ease;
        border: 1px solid #ced4da;
    }


    .custom-abs-address:focus {
        z-index: 100;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        height: auto;
    }
</style>



    <div class="py-2">
        <div class="max-w-7xl mx-2 sm:px-4 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="card">
                        <form action="{{route('receiverDetailDone',$id)}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <h2 id="heading">Property Request Details</h2>
                            <p id="subheading">Fill The Required Data</p>
                            <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Requester Details:</h2>
                                        </div>
                                    </div>
                            <div class="card shadow-sm" style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                            <div class="card-body">
@foreach($owner->participants as $key => $value)
                               <div class="row">
                                <!-- Left Side: Owner Details -->
                                <div class="col-md-7">

        <div class="row  mt-2">
            <div class="col-md-4">
                <label>Requester Name</label>
                <input type="text"  readonly
                       class="form-control"
                       name="requester[{{ $key }}][name]"
                       value="{{ $value->owner->name }}"
                       >
            </div>
            <div class="col-md-4">
                <label>Requester's Father Name</label>
                <input type="text" readonly
                       class="form-control"
                       name="requester[{{ $key }}][father_name]"
                       value="{{ $value->owner->father_name }}"
                       >
            </div>
            <div class="col-md-3">
                <label>CNIC</label>
                <input type="text" readonly
                       class="form-control"
                       name="requester[{{ $key }}][cnic]"
                       value="{{ $value->owner->cnic }}"
                       >
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Requester's Area</label>
                <input type="text" readonly
                       class="form-control"
                       name="requester[{{ $key }}][area]"
                       value="{{ $value->owner->area . ' Marla' }}"
                       >
                    </div>
            <div class="col-md-7">
                                            <label>Reqester Address</label>
                                            <textarea name="requester[{{$key}}][address]" id="receiver_cnic_${receiverIndex}" class="form-control" {{ $value->owner->area . ' Marla' }} rows="5" placeholder="Enter Address"></textarea>
                                        </div>
            <input type="hidden" name="requester[{{$key}}][id]" value="{{$value->owner->id}}">
            <input type="hidden" name="requester[{{$key}}][cnic_front]" value="{{$value->owner->cnic_front}}">
            <input type="hidden" name="requester[{{$key}}][cnic_back]" value="{{$value->owner->cnic_back}}">
        </div>

</div>


                                <!-- Right Side: CNIC Images -->
                                <div class="col-md-4">


                                    <div class="row m-0 p-0">
                                        <div class="col-md-5">
                                            <label for="">CNIC(Front)</label>
                                            <div class="file-drop-area" ondrop="handleDrop(event, 'rerquester-cnic_front_{{$key}}')"
                                        ondragover="handleDragOver(event, 'rerquester-cnic_front_{{$key}}')"
                                        ondragleave="handleDragLeave(event, 'rerquester-cnic_front_{{$key}}')"
                                        onclick="triggerFileInput('rerquester-cnic_front_{{$key}}')" id="drop-area-rerquester-cnic_front_{{$key}}">
                                        <input type="file" name="requester[{{$key}}][cnic_front]" id="rerquester-cnic_front_{{$key}}" value="" accept="image/*"
                                            onchange="previewImage(event, 'rerquester-cnic_front_{{$key}}')" />
                                        <span>Drag & Drop or Click to Upload</span>
                                        <img id="preview-rerquester-cnic_front_{{$key}}" class="img-preview"
                                            alt="Preview"    src="/uploads/user/cnics/{{ $value->owner->cnic_front }}" />
                                        </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="">CNIC(Back)</label>
                                     <div class="file-drop-area" ondrop="handleDrop(event, 'rerquester-cnic_back_{{$key}}')"
                                        ondragover="handleDragOver(event, 'rerquester-cnic_back_{{$key}}')"
                                        ondragleave="handleDragLeave(event, 'rerquester-cnic_back_{{$key}}')"
                                        onclick="triggerFileInput('rerquester-cnic_back_{{$key}}')" id="drop-area-rerquester-cnic_back_{{$key}}">
                                        <input type="file" name="requester[{{$key}}][cnic_back]" id="rerquester-cnic_back_{{$key}}" value="" accept="image/*"
                                        onchange="previewImage(event, 'rerquester-cnic_back_{{$key}}')" />
                                        <span>Drag & Drop or Click to Upload</span>
                                        <img id="preview-rerquester-cnic_back_{{$key}}" class="img-preview"
                                        alt="Preview" src="/uploads/user/cnics/{{ $value->owner->cnic_back }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                        </div>
                            </div>
                            <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Receiver Details:</h2>
                                        </div>
                                    </div>
                            <div class="card shadow-sm mb-4" style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                            <div class="card-body" id="receiver-wrapper">
                                @forelse($owner->dummyreceiver as $key => $value)
                                <div class="row receiver-item mb-3" dat-index="{{ $key }}">


                                    <div class="col-md-4">
                                    <label for="">Receiver  Name</label>
                                    <input type="text"  name="receivers[{{$key}}][name]" id="receiver_name_{{ $key }}" class="form-control" value="{{$value->name}}" placeholder="Enter receiver name" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Receiver's Father Name</label>
                                        <input type="text"  name="receivers[{{$key}}][father_name]" id="receiver_father_name_{{ $key }}" class="form-control" value="{{$value->father_name}}" placeholder="Enter father's name" />
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Receiver Cnic</label>
                                        <input type="number"  name="receivers[{{$key}}][cnic]" id="receiver_cnic_{{ $key }}" class="form-control" value="{{$value->cnic}}" placeholder="Enter CNIC" maxlength="13" />
                                    </div>
                                    <div class="col-md-4" >
                                                <label>Receiver Address</label>
                                                <textarea name="receivers[{{$key}}][address]" class="form-control custom-abs-address" style="direction: rtl;" value="{{$value->address}}" rows="5" placeholder="Enter Address"></textarea>
                                            </div>
                                    <div class="col-md-3" style="position: relative;">
                                        <label for="">Receiver Area</label>
                                        <input type="number" name="receivers[{{$key}}][area]" id="receiver_area_{{ $key }}" class="form-control " placeholder="Enter Area"  />
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">CNIC(Front)</label>
                                        <div class="file-drop-area" ondrop="handleDrop(event, 'cnic_front_{{ $key }}')"
                                            ondragover="handleDragOver(event, 'cnic_front_{{ $key }}')"
                                            ondragleave="handleDragLeave(event, 'cnic_front_{{ $key }}')"
                                            onclick="triggerFileInput('cnic_front_{{ $key }}')" id="drop-area-cnic_front_{{ $key }}">
                                            <input type="hidden" name="receivers[{{$key}}][cnic_front]" value="{{$value->cnic_front}}">
                                            <input type="file" name="receivers[{{$key}}][cnic_front]" id="cnic_front_{{ $key }}" value="" accept="image/*"
                                                onchange="previewImage(event, 'cnic_front_{{ $key }}')" />
                                            <span>Drag & Drop or Click to Upload</span>
                                            <img id="preview-cnic_front_{{ $key }}" class="img-preview" src="{{asset('/uploads/user/cnics/'.$value->cnic_front)}}"
                                                alt="Preview" />
                                                {{$value->cnicfront}}
                                            </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">CNIC(Back)</label>
                                        <div class="file-drop-area" ondrop="handleDrop(event, 'cnic_back_{{$key}}')"
                                            ondragover="handleDragOver(event, 'cnic_back_{{$key}}')"
                                            ondragleave="handleDragLeave(event, 'cnic_back_{{$key}}')"
                                            onclick="triggerFileInput('cnic_back_{{ $key }}')" id="drop-area-cnic_back_{{ $key }}">
                                            <input type="hidden" name="receivers[{{$key}}][cnic_back]" value="{{$value->cnic_back}}">
                                            <input type="file" name="receivers[{{$key}}][cnic_back]" id="cnic_back_{{ $key }}" value="" accept="image/*"
                                            onchange="previewImage(event, 'cnic_back_{{ $key }}')" />
                                            <span>Drag & Drop or Click to Upload</span>
                                            <img id="preview-cnic_back_{{$key}}" class="img-preview" src="{{asset('/uploads/user/cnics/'.$value->cnic_back)}}"
                                                alt="Preview" />
                                            </div>
                                    </div>
                                    <input type="hidden" name="receivers[{{$key}}][id]" value="{{$value->id}}">
                                </div>
                                    @empty
                                    <div class="row receiver-item mb-3" dat-index="{{ $key }}">


                                    <div class="col-md-4">
                                    <label for="">Receiver  Name</label>
                                    <input type="text"  name="receivers[0][name]" id="receiver_name_0" class="form-control" value="{{$owner->transfer->buyer_name}}" placeholder="Enter receiver name" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Receiver's Father Name</label>
                                        <input type="text"  name="receivers[0][father_name]" id="receiver_father_name_0" class="form-control" value="{{$owner->transfer->buyer_fname}}" placeholder="Enter father's name" />
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Receiver Cnic</label>
                                        <input type="number"  name="receivers[0][cnic]" id="receiver_cnic_0" class="form-control" value="{{$owner->transfer->buyer_cnic}}" placeholder="Enter CNIC" maxlength="13" />
                                    </div>
                                    <div class="col-md-4" >
                                                <label>Receiver Address</label>
                                                <textarea name="receivers[0][address]" class="form-control custom-abs-address" style="direction: rtl;" value="" rows="5" placeholder="Enter Address"></textarea>
                                            </div>
                                    <div class="col-md-3" style="position: relative;">
                                        <label for="">Receiver Area</label>
                                        <input type="number" name="receivers[0][area]" id="receiver_area_0" class="form-control " placeholder="Enter Area"  />
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">CNIC(Front)</label>
                                        <div class="file-drop-area" ondrop="handleDrop(event, 'cnic_front_0')"
                                            ondragover="handleDragOver(event, 'cnic_front_0')"
                                            ondragleave="handleDragLeave(event, 'cnic_front_0')"
                                            onclick="triggerFileInput('cnic_front_0')" id="drop-area-cnic_front_0">
                                            <input type="hidden" name="receivers[0][cnic_front]" value="">
                                            <input type="file" name="receivers[0][cnic_front]" id="cnic_front_0" value="" accept="image/*"
                                                onchange="previewImage(event, 'cnic_front_0')" />
                                            <span>Drag & Drop or Click to Upload</span>
                                            <img id="preview-cnic_front_0" class="img-preview" src="{{asset('/uploads/user/cnics/'.$value->cnic_front)}}"
                                                alt="Preview" />
                                                {{$value->cnicfront}}
                                            </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">CNIC(Back)</label>
                                        <div class="file-drop-area" ondrop="handleDrop(event, 'cnic_back_0')"
                                            ondragover="handleDragOver(event, 'cnic_back_0')"
                                            ondragleave="handleDragLeave(event, 'cnic_back_0')"
                                            onclick="triggerFileInput('cnic_back_0')" id="drop-area-cnic_back_0">
                                            <input type="hidden" name="receivers[0][cnic_back]" value="">
                                            <input type="file" name="receivers[0][cnic_back]" id="cnic_back_0" value="" accept="image/*"
                                            onchange="previewImage(event, 'cnic_back_0')" />
                                            <span>Drag & Drop or Click to Upload</span>
                                            <img id="preview-cnic_back_0" class="img-preview" src="{{asset('/uploads/user/cnics/'.$value->cnic_back)}}"
                                                alt="Preview" />
                                            </div>
                                    </div>
                                    <input type="hidden" name="receivers[0][id]" value="">
                                </div>
                                    @endforelse
                        </div>
                        <div class="card-footer rounded-md" style="background-color: #eeeeee00 !important; border: none; border-radius: 10px;">
                            <button type="button" id="add-receiver" class="btn btn-primary">Add Receiver</button>
                        </div>
                            </div>
                        <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Witnesses Details:</h2>
                                        </div>
                                    </div>
                            <div class="card shadow-sm mb-4" style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                            <div class="card-body" id="receiver-wrapper">

                                <div class="row receiver-item mb-3" dat-index="0">


                                    <div class="col-md-4">
                                    <label for="">Witness  Name</label>
                                    <input type="text" name="witness[0][name]" id="receiver_name_0" class="form-control" placeholder="Enter  name" />
                                    </div>
                                <div class="col-md-4">
                                    <label for="">Witness's Father Name</label>
                                     <input type="text" name="witness[0][father_name]" id="receiver_father_name_0" class="form-control" placeholder="Enter father's name" />
                                </div>
                                <div class="col-md-2">
                                    <label for="">Witness Cnic</label>
                                    <input type="number" name="witness[0][cnic]" id="receiver_cnic_${receiverIndex}" class="form-control" placeholder="Enter CNIC" maxlength="13" />
                                </div>
                                <div class="col-md-4" style="position: relative;">
                                            <label>Witness Address</label>
                                            <textarea name="witness[0][address]" id="receiver_cnic_${receiverIndex}" class="form-control custom-abs-address" style="direction: rtl;" placeholder="Enter Address" rows="5"></textarea>
                                        </div>
                                <div class="col-md-2">
                                    <label for="">CNIC(Front)</label>
                                     <div class="file-drop-area" ondrop="handleDrop(event, 'wcnic_front_0')"
                                        ondragover="handleDragOver(event, 'wcnic_front_0')"
                                        ondragleave="handleDragLeave(event, 'wcnic_front_0')"
                                        onclick="triggerFileInput('wcnic_front_0')" id="drop-area-wcnic_front_0">
                                        <input type="file" name="witness[0][cnic_front]" id="wcnic_front_0" value="" accept="image/*"
                                            onchange="previewImage(event, 'wcnic_front_0')" />
                                        <span>Drag & Drop or Click to Upload</span>
                                        <img id="preview-wcnic_front_0" class="img-preview d-none" src="#"
                                            alt="Preview" />
                                        </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="">CNIC(Back)</label>
                                     <div class="file-drop-area" ondrop="handleDrop(event, 'wnic_back_0')"
                                        ondragover="handleDragOver(event, 'wcnic_back_0')"
                                        ondragleave="handleDragLeave(event, 'wcnic_back_0')"
                                        onclick="triggerFileInput('wcnic_back_0')" id="drop-area-wcnic_back_0">
                                        <input type="file" name="witness[0][cnic_back]" id="wcnic_back_0" value="" accept="image/*"
                                        onchange="previewImage(event, 'wcnic_back_0')" />
                                        <span>Drag & Drop or Click to Upload</span>
                                        <img id="preview-wcnic_back_0" class="img-preview d-none" src="#"
                                            alt="Preview" />
                                        </div>
                                </div>
                                <div class="row receiver-item mb-3" dat-index="1">


                                    <div class="col-md-4">
                                    <label for="">Witness  Name</label>
                                    <input type="text" name="witness[1][name]" id="receiver_name_0" class="form-control" placeholder="Enter  name" />
                                    </div>
                                <div class="col-md-4">
                                    <label for="">Witness's Father Name</label>
                                     <input type="text" name="witness[1][father_name]" id="receiver_father_name_0" class="form-control" placeholder="Enter father's name" />
                                </div>
                                <div class="col-md-2">
                                    <label for="">Witness Cnic</label>
                                    <input type="number" name="witness[1][cnic]" id="receiver_cnic_${receiverIndex}" class="form-control" placeholder="Enter CNIC" maxlength="13" />
                                </div>

                                <div class="col-md-4" style="position: relative;">
                                            <label>Witness Address</label>
                                            <textarea name="witness[1][address]" id="receiver_cnic_${receiverIndex}" class="form-control custom-abs-address" placeholder="Enter Address" rows="5"></textarea>
                                        </div>
                                <div class="col-md-2">
                                    <label for="">CNIC(Front)</label>
                                     <div class="file-drop-area" ondrop="handleDrop(event, 'wcnic_front_1')"
                                        ondragover="handleDragOver(event, 'wcnic_front_1')"
                                        ondragleave="handleDragLeave(event, 'wcnic_front_1')"
                                        onclick="triggerFileInput('wcnic_front_1')" id="drop-area-wcnic_front_1">
                                        <input type="file" name="witness[1][cnic_front]" id="wcnic_front_1" value="" accept="image/*"
                                            onchange="previewImage(event, 'wcnic_front_1')" />
                                        <span>Drag & Drop or Click to Upload</span>
                                        <img id="preview-wcnic_front_1" class="img-preview d-none" src="#"
                                            alt="Preview" />
                                        </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="">CNIC(Back)</label>
                                     <div class="file-drop-area" ondrop="handleDrop(event, 'wcnic_back_1')"
                                        ondragover="handleDragOver(event, 'wcnic_back_1')"
                                        ondragleave="handleDragLeave(event, 'wcnic_back_1')"
                                        onclick="triggerFileInput('wcnic_back_1')" id="drop-area-wcnic_back_1">
                                        <input type="file" name="witness[1][cnic_back]" id="wcnic_back_1" value="" accept="image/*"
                                        onchange="previewImage(event, 'wcnic_back_1')" />
                                        <span>Drag & Drop or Click to Upload</span>
                                        <img id="preview-wcnic_back_1" class="img-preview d-none" src="#"
                                            alt="Preview" />
                                        </div>
                                </div>
                            </div>
                        </div>
                            </div>
                             <div class="row mb-3" style="">
                                <!-- Status radios -->
                                <div class="col-md-3 pl-5">
                                    <label for="status" class="d-block mb-1 font-weight-bold">Status</label>
                                    <div style="display: flex; gap: 20px; align-items: center;">
                                        <label style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                            <input type="radio" name="head_status" value="accept" />
                                            Accept
                                        </label>
                                        <label style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                            <input type="radio" name="head_status" value="reject" />
                                            Reject
                                        </label>
                                    </div>
                                </div>

                                <!-- Remarks -->
                                <div class="col-md-6">
                                    <label for="remarks" class="d-block mb-1 font-weight-bold">Remarks</label>
                                    <textarea type="text" name="head_remarks" id="head_remarks" class="form-control"
                                        placeholder="Enter remarks"></textarea>
                                </div>

                                <!-- Date -->
                                <div class="col-md-3">
                                    <label for="date" class="d-block mb-1 font-weight-bold">Date</label>
                                    <input type="date" name="head_date" id="date" class="form-control" />
                                </div>
                            </div>
                        </div>
                            <button type="submit">Submit</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

        <script>
            function triggerFileInput(id) {

            document.getElementById(id).click();
        }

        function previewImage(event, id) {
           console.log('#drop-area-' + id + ' span');
            const fileInput = event.target;
            const file = fileInput.files[0];
            const preview = document.getElementById('preview-' + id);
            const dropArea = document.getElementById('drop-area-' + id);
            const span = document.querySelector('#drop-area-' + id + ' span');


            span.innerHTML = '';

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
                dropArea.classList.remove('dragover');
            } else {
                preview.src = '#';
                preview.classList.add('d-none');
            }
        }

        function handleDrop(event, id) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = document.getElementById(id);
                fileInput.files = files;
                previewImage({ target: fileInput }, id);
            }
            event.currentTarget.classList.remove('dragover');
        }

        function handleDragOver(event, id) {
            event.preventDefault();
            event.currentTarget.classList.add('dragover');
        }

        function handleDragLeave(event, id) {
            event.currentTarget.classList.remove('dragover');
        }
        </script>

<script>

    let receiverIndex = 1;
    document.getElementById('add-receiver').addEventListener('click', function () {
        const wrapper = document.getElementById('receiver-wrapper');

        const newRow = document.createElement('div');
        newRow.classList.add('row', 'receiver-item', 'mb-3');
        newRow.setAttribute('data-index', receiverIndex);

        newRow.innerHTML = `

    <div class="row mb-3" id="receiver_row_${receiverIndex}" style="position:relative;">
        <button class="delete-btn" onclick="removeRow(${receiverIndex})">×</button>
        <div class="col-md-4">
            <label>Receiver Name</label>
            <input type="text" name="receivers[${receiverIndex}][name]" id="receiver_name_${receiverIndex}" class="form-control" placeholder="Enter receiver name" />
        </div>
        <div class="col-md-4">
            <label>Receiver's Father Name</label>
            <input type="text" name="receivers[${receiverIndex}][father_name]" id="receiver_father_name_${receiverIndex}" class="form-control" placeholder="Enter father's name" />
        </div>
        <div class="col-md-2">
            <label>Receiver CNIC</label>
            <input type="number" name="receivers[${receiverIndex}][cnic]" id="receiver_cnic_${receiverIndex}" class="form-control" placeholder="Enter CNIC" maxlength="13" />
        </div>
        <div class="col-md-4" style="position: relative;">
            <label>Receiver Address</label>
            <textarea type="text" style="direction:rtl;" name="receivers[${receiverIndex}][address]" id="receiver_cnic_${receiverIndex}" class="form-control custom-abs-address" rows='5'  placeholder="Enter Address"></textarea>
        </div>
        <div class="col-md-3">
            <label>Receiver Area</label>
            <input type="number" name="receivers[${receiverIndex}][area]" id="receiver_cnic_${receiverIndex}" class="form-control" placeholder="Enter Area"  />
        </div>
        <div class="col-md-2">
            <label>CNIC (Front)</label>
            <div class="file-drop-area"
                ondrop="handleDrop(event, 'cnic_front_${receiverIndex}')"
                ondragover="handleDragOver(event, 'cnic_front_${receiverIndex}')"
                ondragleave="handleDragLeave(event, 'cnic_front_${receiverIndex}')"
                onclick="triggerFileInput('cnic_front_${receiverIndex}')"
                id="drop-area-cnic_front_${receiverIndex}">
                <input type="file" name="receivers[${receiverIndex}][cnic_front]" id="cnic_front_${receiverIndex}" accept="image/*"
                    onchange="previewImage(event, 'cnic_front_${receiverIndex}')" />
                <span>Drag & Drop or Click to Upload</span>
                <img id="preview-cnic_front_${receiverIndex}" class="img-preview d-none" src="#" alt="Preview" />
            </div>
        </div>
        <div class="col-md-2">
            <label>CNIC (Back)</label>
            <div class="file-drop-area"
                ondrop="handleDrop(event, 'cnic_back_${receiverIndex}')"
                ondragover="handleDragOver(event, 'cnic_back_${receiverIndex}')"
                ondragleave="handleDragLeave(event, 'cnic_back_${receiverIndex}')"
                onclick="triggerFileInput('cnic_back_${receiverIndex}')"
                id="drop-area-cnic_back_${receiverIndex}">
                <input type="file" name="receivers[${receiverIndex}][cnic_back]" id="cnic_back_${receiverIndex}" accept="image/*"
                    onchange="previewImage(event, 'cnic_back_${receiverIndex}')" />
                <span>Drag & Drop or Click to Upload</span>
                <img id="preview-cnic_back_${receiverIndex}" class="img-preview d-none" src="#" alt="Preview" />
            </div>
        </div>
    </div>
        `;

        wrapper.appendChild(newRow);
        receiverIndex++;
    });

    function removeRow(id) {
    document.getElementById('receiver_row_' + id).remove();
}
    </script>
</x-app-layout>
