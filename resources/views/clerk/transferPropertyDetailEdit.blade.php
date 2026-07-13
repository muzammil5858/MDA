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

        .form-control {
            border-radius: 5px;
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
            z-index: 222;
            font-weight: bold;
            font-size: 16px;
        }

        .delete-btn:hover {
            background: #e60000;
        }

        /* Spinner styles */
        .loader {
            border: 3px solid #f3f3f3;
            /* Light grey background */
            border-top: 3px solid #3498db;
            /* Blue spinning part */
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 0.8s linear infinite;
        }

        /* Spin animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Tick styling */
        .tick {
            color: #28a745;
            /* Bootstrap success green */
            font-size: 18px;
            font-weight: bold;
        }

        .status-modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        /* Content box */
        .status-content {
            background: white;
            padding: 30px 50px;
            border-radius: 15px;
            text-align: center;
            min-width: 250px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Loader animation */
        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Success tick */
        .success-icon {
            color: #28a745;
            font-size: 50px;
            margin-bottom: 15px;
        }

        /* Failure cross */
        .error-icon {
            color: #dc3545;
            font-size: 50px;
            margin-bottom: 15px;
        }
    </style>

    <style>
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: auto;
        }
    </style>

    <div class="py-2">
        <div class="max-w-7xl mx-2 sm:px-4 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Loader / Status Modal -->
                    <div id="statusModal" class="status-modal">
                        <div class="status-content" id="statusContent">
                            <div class="loader"></div>
                            <p id="statusMessage">Processing...</p>
                        </div>
                    </div>

                    <div class="card">
                        <form action="{{route('receiverDetailUpdate',$id)}}" method="POST" enctype="multipart/form-data"
                            novalidate>
                            @csrf
                            <h2 id="heading">Property Request Details</h2>
                            <p id="subheading">Fill The Required Data</p>
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Owner Details:</h2>
                                </div>
                            </div>
                            <div class="card shadow-sm"
                                style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                                <div class="card-body">

                                    @foreach($owner->participants as $key => $value)
                                    <div class="row">
                                        <!-- Left Side: Owner Details -->
                                        <div class="col-md-7">

                                            <div class="row  mt-2">
                                                <div class="col-md-4">
                                                    <label>Requester Name</label>
                                                    <input type="text" readonly class="form-control"
                                                        name="requester[{{ $key }}][name]"
                                                        value="{{ $value->owner->name }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Requester's Father Name</label>
                                                    <input type="text" readonly class="form-control"
                                                        name="requester[{{ $key }}][father_name]"
                                                        value="{{ $value->owner->father_name }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>CNIC</label>
                                                    <input type="text" readonly class="form-control"
                                                        name="requester[{{ $key }}][cnic]"
                                                        value="{{ $value->owner->cnic }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Requester's Area</label>
                                                    <input type="text" readonly class="form-control"
                                                        name="requester[{{ $key }}][area]"
                                                        value="{{ $value->owner->area . ' Marla' }}">
                                                </div>
                                                <div class="col-md-7" style="position: relative;">
                                                    <label>Requester Address</label>

                                                    <textarea name="requester[{{ $key }}][address]"
                                                        class="form-control " placeholder="Enter Requester Address"
                                                        rows="5">{{ $value->owner->address }}</textarea>
                                                </div>
                                                <input type="hidden" name="requester[{{$key}}][id]"
                                                    value="{{$value->owner->id}}">
                                                <input type="hidden" name="requester[{{$key}}][cnic_front]"
                                                    value="{{$value->owner->cnic_front}}">
                                                <input type="hidden" name="requester[{{$key}}][cnic_back]"
                                                    value="{{$value->owner->cnic_back}}">
                                            </div>

                                        </div>


                                        <!-- Right Side: CNIC Images -->
                                        <div class="col-md-4">


                                            <div class="row m-0 p-0">
                                                <div class="col-md-5">
                                                    <label for="">CNIC(Front)</label>
                                                    <div class="file-drop-area"
                                                        ondrop="handleDrop(event, 'rerquester-cnic_front_{{$key}}')"
                                                        ondragover="handleDragOver(event, 'rerquester-cnic_front_{{$key}}')"
                                                        ondragleave="handleDragLeave(event, 'rerquester-cnic_front_{{$key}}')"
                                                        onclick="triggerFileInput('rerquester-cnic_front_{{$key}}')"
                                                        id="drop-area-rerquester-cnic_front_{{$key}}">
                                                        <input type="file" name="requester[{{$key}}][cnic_front]"
                                                            id="rerquester-cnic_front_{{$key}}" value=""
                                                            accept="image/*"
                                                            onchange="previewImage(event, 'rerquester-cnic_front_{{$key}}')" />
                                                        <span>Drag & Drop or Click to Upload</span>
                                                        <img id="preview-rerquester-cnic_front_{{$key}}"
                                                            class="img-preview" alt="Preview"
                                                            src="/uploads/user/cnics/{{ $value->owner->cnic_front }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="">CNIC(Back)</label>
                                                    <div class="file-drop-area"
                                                        ondrop="handleDrop(event, 'rerquester-cnic_back_{{$key}}')"
                                                        ondragover="handleDragOver(event, 'rerquester-cnic_back_{{$key}}')"
                                                        ondragleave="handleDragLeave(event, 'rerquester-cnic_back_{{$key}}')"
                                                        onclick="triggerFileInput('rerquester-cnic_back_{{$key}}')"
                                                        id="drop-area-rerquester-cnic_back_{{$key}}">
                                                        <input type="file" name="requester[{{$key}}][cnic_back]"
                                                            id="rerquester-cnic_back_{{$key}}" value="" accept="image/*"
                                                            onchange="previewImage(event, 'rerquester-cnic_back_{{$key}}')" />
                                                        <span>Drag & Drop or Click to Upload</span>
                                                        <img id="preview-rerquester-cnic_back_{{$key}}"
                                                            class="img-preview" alt="Preview"
                                                            src="/uploads/user/cnics/{{ $value->owner->cnic_back }}" />
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
                            <div class="card shadow-sm mb-4"
                                style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                                <div class="card-body" id="receiver-wrapper">
                                    @foreach($owner->dummyreceiver as $key => $value)

                                    @php
                                    $receiverIndex = $key;
                                    @endphp
                                    <div class="row receiver-item mb-3" dat-index="{{$key}}" style="position: relative;"
                                        id="row-{{$value->id}}">
                                        <button type="button" class="delete-btn"
                                            onclick="removeEntry({{$value->id}},1)">×</button>


                                        <div class="col-md-4">
                                            <label for="">Receiver Name</label>
                                            <input type="text" name="receivers[{{$key}}][name]" value="{{$value->name}}"
                                                id="receiver_name_{{$key}}" class="form-control"
                                                placeholder="Enter receiver name" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Receiver's Father Name</label>
                                            <input type="text" name="receivers[{{$key}}][father_name]"
                                                value="{{$value->father_name}}" id="receiver_father_name_{{$key}}"
                                                class="form-control" placeholder="Enter father's name" />
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Receiver Cnic</label>
                                            <input type="number" name="receivers[{{$key}}][cnic]"
                                                id="receiver_cnic_{{$key}}" class="form-control"
                                                placeholder="Enter CNIC" maxlength="13" value="{{$value->cnic}}" />
                                        </div>
                                        <div class="col-md-4" style="position: relative; ">
                                            <label for="">Receiver Address</label>

                                            <textarea name="receivers[{{$key}}][address]" id="receiver_address_{{$key}}"
                                                class="form-control custom-abs-address" placeholder="Enter Address"
                                                rows="5">{{$value->address}}</textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Receiver Area</label>
                                            <input type="number" name="receivers[{{$key}}][area]"
                                                id="receiver_area_{{$key}}" class="form-control"
                                                placeholder="Enter Area" value="{{$value->area}}" />
                                        </div>
                                        <input type="hidden" name="receivers[{{$key}}][cnic_front]"
                                            value="{{$value->cnic_front}}">
                                        <input type="hidden" name="receivers[{{$key}}][id]" value="{{$value->id}}">
                                        <input type="hidden" name="receivers[{{$key}}][cnic_back]"
                                            value="{{$value->cnic_back}}">
                                        <div class="col-md-2">
                                            <label for="">CNIC(Front)</label>
                                            <div class="file-drop-area"
                                                ondrop="handleDrop(event, 'cnic_front_{{$key}}')"
                                                ondragover="handleDragOver(event, 'cnic_front_{{$key}}')"
                                                ondragleave="handleDragLeave(event, 'cnic_front_{{$key}}')"
                                                onclick="triggerFileInput('cnic_front_{{$key}}')"
                                                id="drop-area-cnic_front_{{$key}}">
                                                <input type="file" name="receivers[{{$key}}][cnic_front]"
                                                    id="cnic_front_{{$key}}" value="" accept="image/*"
                                                    onchange="previewImage(event, 'cnic_front_{{$key}}')"
                                                    value="{{$value->cnic_front}}" />

                                                <img id="preview-cnic_front_{{$key}}"
                                                    src="/uploads/user/cnics/{{$value->cnic_front}}" class="img-preview"
                                                    alt="Preview" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">CNIC(Back)</label>
                                            <div class="file-drop-area" ondrop="handleDrop(event, 'cnic_back_{{$key}}')"
                                                ondragover="handleDragOver(event, 'cnic_back_{{$key}}')"
                                                ondragleave="handleDragLeave(event, 'cnic_back_{{$key}}')"
                                                onclick="triggerFileInput('cnic_back_{{$key}}')"
                                                id="drop-area-cnic_back_{{$key}}">
                                                <input type="file" name="receivers[{{$key}}][cnic_back]"
                                                    id="cnic_back_{{$key}}" value="" accept="image/*"
                                                    onchange="previewImage(event, 'cnic_back_{{$key}}')"
                                                    value="{{$value->cnic_back}}" />

                                                <img id="preview-cnic_back_{{$key}}"
                                                    src="/uploads/user/cnics/{{$value->cnic_back}}" class="img-preview"
                                                    alt="Preview" />
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="card-footer rounded-md"
                                    style="background-color: #eeeeee00 !important; border: none; border-radius: 10px;">
                                    <button type="button" id="add-receiver" class="btn btn-primary">Add
                                        Receiver</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Witnesses Details:</h2>
                                </div>
                            </div>
                            <div class="card shadow-sm mb-4"
                                style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                                <div class="card-body" id="receiver-wrapper">

                                    @foreach($owner->dummywitness as $key => $value)

                                    <div class="row receiver-item mb-3" dat-index="{{$key}}" style="position:relative;">


                                        <div class="col-md-4">
                                            <label for="">Witness Name</label>
                                            <input type="text" name="witness[{{$key}}][name]" value="{{$value->name}}"
                                                id="receiver_name_{{$key}}" class="form-control"
                                                placeholder="Enter receiver name" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Witness's Father Name</label>
                                            <input type="text" name="witness[{{$key}}][father_name]"
                                                value="{{$value->father_name}}" id="receiver_father_name_{{$key}}"
                                                class="form-control" placeholder="Enter father's name" />
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Witness Cnic</label>
                                            <input type="number" name="witness[{{$key}}][cnic]" value="{{$value->cnic}}"
                                                id="receiver_cnic_{{$key}}" class="form-control"
                                                placeholder="Enter CNIC" maxlength="13" />
                                        </div>
                                        <div class="col-md-4" style="position: relative;">
                                            <label for="">Witness Address</label>

                                            <textarea name="witness[{{$key}}][address]" id="witness_address_{{$key}}"
                                                class="form-control custom-abs-address"
                                                placeholder="Enter Witness Address"
                                                rows="5">{{$value->address}}</textarea>
                                        </div>
                                        <input type="hidden" name="witness[{{$key}}][cnic_front]"
                                            value="{{$value->cnic_front}}">
                                        <input type="hidden" name="witness[{{$key}}][id]" value="{{$value->id}}">
                                        <input type="hidden" name="witness[{{$key}}][cnic_back]"
                                            value="{{$value->cnic_back}}">
                                        <div class="col-md-2">
                                            <label for="">CNIC(Front)</label>
                                            <div class="file-drop-area"
                                                ondrop="handleDrop(event, 'wcnic_front_{{$key}}')"
                                                ondragover="handleDragOver(event, 'wcnic_front_{{$key}}')"
                                                ondragleave="handleDragLeave(event, 'wcnic_front_{{$key}}')"
                                                onclick="triggerFileInput('wcnic_front_{{$key}}')"
                                                id="drop-area-wcnic_front_{{$key}}">
                                                <input type="file" name="witness[{{$key}}][cnic_front]"
                                                    id="wcnic_front_{{$key}}" value="" accept="image/*"
                                                    onchange="previewImage(event, 'wcnic_front_{{$key}}')" />

                                                <img id="preview-wcnic_front_{{$key}}"
                                                    src="/uploads/user/cnics/{{$value->cnic_front}}" class="img-preview"
                                                    src="#" alt="Preview" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">CNIC(Back)</label>
                                            <div class="file-drop-area" ondrop="handleDrop(event, 'wcnic_back_')"
                                                ondragover="handleDragOver(event, 'wcnic_back_{{$key}}')"
                                                ondragleave="handleDragLeave(event, 'wcnic_back_{{$key}}')"
                                                onclick="triggerFileInput('wcnic_back_{{$key}}')"
                                                id="drop-area-wcnic_back_{{$key}}">
                                                <input type="file" name="witness[{{$key}}][cnic_back]"
                                                    id="wcnic_back_{{$key}}" value="" accept="image/*"
                                                    onchange="previewImage(event, 'wcnic_back_{{$key}}')" />

                                                <img id="preview-wcnic_back_{{$key}}"
                                                    src="/uploads/user/cnics/{{$value->cnic_back}}" class="img-preview "
                                                    src="#" alt="Preview" />
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-3">
    <div class="col-md-3 pl-5">
        <label for="status" class="d-block mb-1 font-weight-bold">Status</label>
        <div style="display: flex; gap: 20px; align-items: center;">
            <label style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                <input type="radio" name="head_status" value="accept" 
                    {{ isset($owner->head_status) && $owner->head_status == 'accept' ? 'checked' : '' }} />
                Accept
            </label>
            <label style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                <input type="radio" name="head_status" value="reject" 
                    {{ isset($owner->head_status) && $owner->head_status == 'reject' ? 'checked' : '' }} />
                Reject
            </label>
        </div>
    </div>

    <div class="col-md-6">
        <label for="remarks" class="d-block mb-1 font-weight-bold">Remarks</label>
        <textarea name="head_remarks" id="head_remarks" class="form-control" rows="5"
            placeholder="Enter remarks">{{ $owner->head_remarks ?? '' }}</textarea>
    </div>

    <div class="col-md-3">
        <label for="date" class="d-block mb-1 font-weight-bold">Date</label>
        <input type="date" name="head_date" id="date" class="form-control" 
            value="{{ isset($owner->head_date) ? \Carbon\Carbon::parse($owner->head_date)->format('Y-m-d') : '' }}" />
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
        let receiverIndex = @json($receiverIndex) + 1;
    console.log(receiverIndex);
    document.getElementById('add-receiver').addEventListener('click', function () {
        const wrapper = document.getElementById('receiver-wrapper');

        const newRow = document.createElement('div');
        newRow.classList.add('row', 'receiver-item', 'mb-3');
        newRow.setAttribute('data-index', receiverIndex);

        newRow.innerHTML = `<div class="row mb-4 p-3 border-bottom" id="receiver_row_${receiverIndex}" style="position:relative;">
    <button class="delete-btn" onclick="removeRow(${receiverIndex})" style="position: absolute; right: 10px; top: 0; z-index: 10;">×</button>
    
    <div class="col-md-4 ">
        <label>Receiver Name</label>
        <input type="text" name="receivers[${receiverIndex}][name]" id="receiver_name_${receiverIndex}" class="form-control" placeholder="Enter Name" />
    </div>

    <div class="col-md-4 ">
        <label>Father Name</label>
        <input type="text" name="receivers[${receiverIndex}][father_name]" id="receiver_father_name_${receiverIndex}" class="form-control" placeholder="Enter Father Name" />
    </div>

    <div class="col-md-2 ">
        <label>Receiver CNIC</label>
        <input type="number" name="receivers[${receiverIndex}][cnic]" id="receiver_cnic_${receiverIndex}" class="form-control" placeholder="Enter CNIC" maxlength="13" />
    </div>

    <div class="col-md-4 " style="position: relative; height: 85px;">
        <label>Receiver Address</label>
        <textarea name="receivers[${receiverIndex}][address]" id="receiver_address_${receiverIndex}" 
            class="form-control custom-abs-address" placeholder="Enter Address" rows="5"></textarea>
    </div>

    <div class="col-md-3 ">
        <label>Receiver Area </label>
        <input type="number" name="receivers[${receiverIndex}][area]" id="receiver_area_${receiverIndex}" class="form-control" placeholder="e.g. 5 Marla" />
    </div>

    <div class="col-md-2 ">
        <label>CNIC (Front)</label>
        <div class="file-drop-area" onclick="triggerFileInput('cnic_front_${receiverIndex}')" id="drop-area-cnic_front_${receiverIndex}">
            <input type="file" name="receivers[${receiverIndex}][cnic_front]" id="cnic_front_${receiverIndex}" accept="image/*" onchange="previewImage(event, 'cnic_front_${receiverIndex}')" class="d-none" />
            <span>Click to Upload Front</span>
            <img id="preview-cnic_front_${receiverIndex}" class="img-preview d-none" src="#" alt="Preview" style="max-height: 50px;" />
        </div>
    </div>

    <div class="col-md-2 ">
        <label>CNIC (Back)</label>
        <div class="file-drop-area" onclick="triggerFileInput('cnic_back_${receiverIndex}')" id="drop-area-cnic_back_${receiverIndex}">
            <input type="file" name="receivers[${receiverIndex}][cnic_back]" id="cnic_back_${receiverIndex}" accept="image/*" onchange="previewImage(event, 'cnic_back_${receiverIndex}')" class="d-none" />
            <span>Click to Upload Back</span>
            <img id="preview-cnic_back_${receiverIndex}" class="img-preview d-none" src="#" alt="Preview" style="max-height: 50px;" />
        </div>
    </div>
</div>`

        wrapper.appendChild(newRow);
        receiverIndex++;
    });

    function removeRow(id) {
    document.getElementById('receiver_row_' + id).remove();
}

function openModal(htmlContent) {
    const modal = document.getElementById("statusModal");
    document.getElementById("statusContent").innerHTML = htmlContent;
    modal.style.display = "flex";
}

function closeModal(delay = 0) {
    setTimeout(() => {
        document.getElementById("statusModal").style.display = "none";
    }, delay);
}

function showModalLoader(message = "Processing...") {
    openModal(`
        <div class="loader"></div>
        <p>${message}</p>
    `);
}

function showModalSuccess(message = "Success!") {
    openModal(`
        <div class="success-icon">✔</div>
        <p>${message}</p>
    `);
    closeModal(1500);
}

function showModalError(message = "Failed!") {
    openModal(`
        <div class="error-icon">✖</div>
        <p>${message}</p>
    `);
    closeModal(2000);
}

function removeEntry(id,type) {
    showModalLoader("Deleting entry...");


    fetch(`/delete-dummy-user/${id}/${type}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showModalSuccess("Entry deleted successfully!");
            document.querySelector(`#row-${id}`).remove();
        } else {
            showModalError("Deletion failed!");
        }
    })
    .catch(() => {
        showModalError("Server error occurred!");
    });
}

    </script>
</x-app-layout>