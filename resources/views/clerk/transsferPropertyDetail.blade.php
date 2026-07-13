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

        p.subheading{
            font-size: 1rem;
            text-align: center;
            color: #555;
            margin-bottom: 30px;
            font-weight: 500;
            font-family: "Noto Nastaliq Urdu", serif;
            direction: ltr !important;
        }
        textarea{
            font-family: "Noto Nastaliq Urdu", serif;

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
            width: 100%;
            font-size: 1rem;
            direction: rtl !important;
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
/* Spinner styles */
.loader {
    border: 3px solid #f3f3f3;   /* Light grey background */
    border-top: 3px solid #3498db; /* Blue spinning part */
    border-radius: 50%;
    width: 16px;
    height: 16px;
    animation: spin 0.8s linear infinite;
}

/* Spin animation */
@keyframes spin {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Tick styling */
.tick {
    color: #28a745; /* Bootstrap success green */
    font-size: 18px;
    font-weight: bold;
}

.status-modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 9999;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
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
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* Loader animation */
.loader {
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db;
    border-radius: 50%;
    width: 50px; height: 50px;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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
                        <form action="{{route('receiverDetailUpdate',$id)}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <h2 id="heading">Property Request Details</h2>
                            <p id="subheading">Fill The Required Data</p>
                            <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Owner Details:</h2>
                                        </div>
                                    </div>
                            <div class="card shadow-sm" style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                            <div class="card-body">

                                <div class="row ">
                                    
                                    <div class="col-md-3">
                                    <label for="">Owner Name</label>
                                    <p class="subheading">{{$owner->propertyowner->name}}</p>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Owner's Father Name</label>
                                    <p class="subheading">{{$owner->propertyowner->father_name}}</p>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Cnic</label>
                                    <p class="subheading">{{$owner->propertyowner->cnic}}</p>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Address</label>
                                    <p class="subheading">{{$owner->propertyowner->address}}</p>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Area</label>
                                    <p class="subheading">{{$owner->propertyowner->area}}</p>
                                </div>
                                <div class="col-md-2">
                                    <label for="">CNIC(Front)</label>
                                     <div class="file-drop-area">
                                        
                                        <img id="preview-name" class="img-preview" 
                                            alt="Preview" src="/uploads/user/cnics/{{$owner->propertyowner->cnic_front}}"/>
                                        </div> 
                                </div>
                                <div class="col-md-2">
                                    <label for="">CNIC(Back)</label>
                                     <div class="file-drop-area" >
                                        
                                        
                                        <img id="preview-name" class="img-preview" 
                                            alt="Preview" src="/uploads/user/cnics/{{$owner->propertyowner->cnic_back}}" />
                                        </div> 
                                </div>
                            </div>
                        </div>
                            </div>
                            <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Receiver Details:</h2>
                                        </div>
                                    </div>
                            <div class="card shadow-sm mb-4" style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                            <div class="card-body" id="receiver-wrapper">
                                @foreach($owner->dummyreceiver as $key => $value)
                                
                                @php
                                    $receiverIndex = $key;
                                @endphp
                                <div class="row receiver-item mb-3" dat-index="{{$key}}" style="position: relative;" id="row-{{$value->id}}">
                                    <div class="col-md-3">
                                        <label for="">Receiver  Name</label>
                                     <p class="subheading">{{$value->name}}</p>
                                    </div>
                                <div class="col-md-3">
                                    <label for="">Receiver's Father Name</label>
                                    <p class="subheading">{{$value->father_name}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Receiver Cnic</label>
                                    <p class="subheading">{{$value->cnic}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Receiver Address</label>
                                    <p class="subheading">{{$value->address}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Receiver Area</label>
                                    <p class="subheading">{{$value->area}}</p>
                                </div>
                                <input readonly type="hidden" name="receivers[{{$key}}][cnic_front]" value="{{$value->cnic_front}}">
                                <input readonly type="hidden" name="receivers[{{$key}}][id]" value="{{$value->id}}">
                                <input readonly type="hidden" name="receivers[{{$key}}][cnic_back]" value="{{$value->cnic_back}}">
                                <div class="col-md-2">
                                    <label for="">CNIC(Front)</label>
                                     <div class="file-drop-area">
                                        
                                        <img id="preview-cnic_front_{{$key}}" src="/uploads/user/cnics/{{$value->cnic_front}}" class="img-preview" 
                                            alt="Preview" />
                                        </div> 
                                </div>
                                <div class="col-md-2">
                                    <label for="">CNIC(Back)</label>
                                    <div class="file-drop-area">
                                        
                                        <img id="preview-cnic_back_{{$key}}" src="/uploads/user/cnics/{{$value->cnic_back}}" class="img-preview" 
                                            alt="Preview" />
                                        </div> 
                                    </div>
                                </div>
                                @endforeach
                        </div>
                       
                            </div>
                        <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Witnesses Details:</h2>
                                        </div>
                                    </div>
                            <div class="card shadow-sm mb-4" style="background-color: #eeeeee63; border: none; border-radius: 10px;">
                            <div class="card-body" id="receiver-wrapper">

                                @foreach($owner->dummywitness as $key => $value)
                                
                                <div class="row receiver-item mb-3" dat-index="{{$key}}" style="position:relative;">
                                   
                                    
                                    <div class="col-md-3">
                                    <label for="">Witness  Name</label>
                                    <p class="subheading">{{$value->name}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Witness's Father Name</label>
                                    <p class="subheading">{{$value->father_name}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Witness Cnic</label>
                                   <p class="subheading">{{$value->cnic}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Witness Address</label>
                                   <p class="subheading">{{$value->address}}</p>
                                </div>
                               
                                <div class="col-md-2">
                                    <label for="">CNIC(Front)</label>
                                     <div class="file-drop-area">
                                        
                                        <img id="preview-wcnic_front_{{$key}}" src="/uploads/user/cnics/{{$value->cnic_front}}" class="img-preview" src="#"
                                        alt="Preview" />
                                    </div> 
                                </div>
                                <div class="col-md-2">
                                    <label for="">CNIC(Back)</label>
                                    <div class="file-drop-area" >
                                    
                                    <img id="preview-wcnic_back_{{$key}}" src="/uploads/user/cnics/{{$value->cnic_back}}" class="img-preview " src="#"
                                    alt="Preview" />
                                </div> 
                            </div>
                        </div>
                        @endforeach
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
                        </div>     
                           
                        </form>
                        
                    </div>
                </div>

            </div>
        </div>


</x-app-layout>