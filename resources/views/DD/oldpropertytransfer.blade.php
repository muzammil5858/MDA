<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-pwhbDJ5Erf0klsYt4Ma8em1K...=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        p {
            color: grey
        }
            .icon-check {
        color: green;
        font-size: 3rem;
    }

    .icon-cross {
        color: red;
        font-size: 3rem;
    }

        .thumb-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    background-color: #f8f9fa;
    margin-left:auto;
    margin-right:auto;
}

        #heading {
            text-transform: uppercase;
            color: #03346E;
            font-weight: bolder;
            font-size: 1.5rem;
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative
        }

        .form-card {
            text-align: left
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        #msform input,
        #msform textarea,
        #msform select {
            padding: 8px 15px 8px 15px;
            border: 1px solid #ccc;
            border-radius: 0px;
            margin-bottom: 15px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            background-color: #ffffff;
            font-size: 16px;
            letter-spacing: 1px
        }

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #03346E;
            outline-width: 0
        }

        #msform .action-button {
            width: 100px;
            background: #03346E;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 0px 10px 5px;
            float: right
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            background-color: #311B92
        }

        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px 10px 0px;
            float: right
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            background-color: #000000
        }

        .card {
            z-index: 0;
            border: none;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #03346E;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }

        .purple-text {
            color: #03346E;
            font-weight: normal
        }

        .steps {
            font-size: 25px;
            color: gray;
            margin-bottom: 10px;
            font-weight: normal;
            text-align: right
        }

        .fieldlabels {
            color: gray;
            text-align: left
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey
        }

        #progressbar .active {
            color: #03346E
        }

        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f13e"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f030"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #03346E
        }

        .progress {
            height: 20px
        }

        .progress-bar {
            background-color: #03346E
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }

        /* Loader CSS */
        #loader {
            position: fixed;
            left: 15%;
            top: 0;
            width: 85%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 8px solid #f3f3f3;
            /* Light grey */
            border-top: 8px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .profile-pic {


            display: block;

            content: " *";
            color: red;

        }

        .form-valid {
            opacity: 0.5;
        }

        .form-control-label abbr {
            text-decoration: none;
            font-weight: normal;
        }

        .file-upload {
            display: none;
        }

        .circle {
            border-radius: 1000px !important;
            overflow: hidden;
            padding-top: 1px;
            margin-top: 10px;
            margin-bottom: 10px;
            width: 128px;
            height: 128px;
            margin-left: 17px;
            border: 3px solid #3634b5;
            position: relative;

        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .p-image {
            position: relative;
            display: block;
            top: 100px;

            color: #202933;
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .Mcf-image {
            position: relative;
            top: 100px;
            left: 400px;
            color: #202933;
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .p-image:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .upload-button {
            font-size: 1.2em;
            cursor: pointer;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }


        .upload-button:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
            color: #999;
        }

        @media screen and (max-width: 640px) {

            .ed {
                display: none;
            }

            .circle {
                width: 100px;
                height: 100px;
            }

            .pic {
                display: flex;
                justify-content: center;
            }
        }

        #progressBar {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 10px;
        }

        #progressBarFill {
            height: 30px;
            width: 0;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
        }

        .progress-container {
            display: inline-block;
            text-align: center;
            margin: 10px;
            position: relative;
        }

        .progress-circle {
            position: relative;
            width: 120px;
            height: 120px;
        }

        circle {
            fill: none;
        }

        circle.bg {
            stroke: #e6e6e6;
        }

        circle.progress {
            stroke: #4caf50;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.3s ease;
            transform: rotate(-90deg);
            /* Start from the top */
            transform-origin: 50% 50%;
        }

        .percent-text {
            position: absolute;
            top: 60%;
            left: 46%;
            transform: translate(-50%, -50%);
            font-size: 17px;
            font-weight: bold;
        }

        .document-container {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #000;
            padding: 20px;
            position: relative;
        }

        .header {

            border-bottom: 1px dashed #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
            text-align: right;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .header .head {
            width: 75%;
        }

        .header .head h1 {
            font-weight: bold;
            margin-bottom: 30px !important;
            font-size: 20px;
            margin: 0;
            text-align: center;
        }
        .head p{
            font-weight: bold;
        }

        .photo-section {
            position: relative;
            width: 150px;
            height: 150px;
            border: 1px solid #000;
        }

        .photo-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .document-container .content p {
            text-align: right;
            margin: 10px 0;
            line-height: 1.6;
            font-weight: bold;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .signature div {
            text-align: center;
        }

        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
        }

        .fingerprint {
            text-align: center;
            margin-top: 20px;
        }

        .fingerprint img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        .attachment img,
        .thumb img
         {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }
        .modal-backdrop.show{
            display: none !important;
        }
        .attachment button{
            background: #054468;
            color: white;
        }
        .attachment button:hover{
            background: white;
            color: #054468; 
        }
         .error { color: red; font-size: 14px; }
         label{
            text-align: left !important;
            width:100%;
         }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 text-center p-0 mt-3 mb-2">
                <div class="card px-4 pt-4 pb-0 mt-3 mb-3">
                    <h2 id="heading">Mangla Dam Housing Authority</h2>
                    <p>Fill all form's fields to proceed</p>
                    @if ($errors->any())
                        <div class="error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    <form id="msform" action="{{route('propertyTransferOld',$property->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Step 1 -->
                            <fieldset id="first-step">
                                
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Seller Details:</h2>
                                        </div>
                                    </div>
                                    <!-- Input 1 -->
                                <div class="card shadow-sm mb-4" style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                    <div class="form-row">

                                        <div class="col-md-4">
                                            <label style="text-align: left !important;">Seller Name</label>
                                            <input type="text" class="form-control" name="seller_name" readonly
                                                placeholder="Enter Seller Name" value="{{$property->allotee_name}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Seller's Father Name</label>
                                            <input type="text" class="form-control" name="seller_father_name" readonly
                                                placeholder="Enter Seller's Father Name" value="{{$property->relation}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Seller's CNIC</label>
                                            <input type="number" class="form-control" name="seller_cnic" readonly
                                                placeholder="Enter Seller's CNIC" value="{{$property->cnic}}" >
                                        </div>
                                        <div class="col-md-4">
                                            <label>Seller's Address</label>
                                            <input type="text" class="form-control" name="seller_address" 
                                                placeholder="Enter Seller's Address" >
                                        </div>
                                        <div class="col-md-4">
                                            <label>Sold Price</label>
                                            <input type="number" name="sold_price" class="form-control" 
                                                placeholder="Enter Sold Price" >
                                        </div>
                                        
                                    </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Buyer Details:</h2>
                                        </div>
                                    </div>
                                    <!-- Input 1 -->
                                    <div class="card shadow-sm mb-4" style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>Buyer Name</label>
                                            <input type="text" class="form-control" name="buyer_name" 
                                                placeholder="Enter Buyer Name" >
                                        </div>
                                        <div class="col-md-4">
                                            <label>Buyer's Father Name</label>
                                            <input type="text" class="form-control" name="buyer_father_name" 
                                                placeholder="Enter Buyer's Father Name" >
                                        </div>
                                        <div class="col-md-4">
                                            <label>Buyer's CNIC</label>
                                            <input type="number" class="form-control" name="buyer_cnic" 
                                                placeholder="Enter Buyer's CNIC" >
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label>Buyer's Address</label>
                                            <input type="text" class="form-control" name="buyer_address" 
                                                placeholder="Enter Buyer's Address">
                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">First Witness Details:</h2>
                                        </div>
                                    </div>
                                    <div class="card shadow-sm mb-4" style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>Witness Name</label>
                                            <input type="text" class="form-control" name="first_witness_name"
                                                placeholder="Enter Witness Name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Witness's Father Name</label>
                                            <input type="text" class="form-control" name="first_witness_father_name"
                                                placeholder="Enter Witness's Father Name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Witness's CNIC</label>
                                            <input type="number" class="form-control" name="first_witness_cnic"
                                                placeholder="Enter Witness's CNIC">
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Second Witness Details:</h2>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>Witness Name</label>
                                            <input type="text" class="form-control" name="second_witness_name"
                                                placeholder="Enter Witness Name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Witness's Father Name</label>
                                            <input type="text" class="form-control" name="second_witness_father_name"
                                                placeholder="Enter Witness's Father Name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Witness's CNIC</label>
                                            <input type="number" class="form-control" name="second_witness_cnic"
                                                placeholder="Enter Witness's CNIC">
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Attachements:</h2>
                                    </div>
                                </div>
                                <div class="card shadow-sm mb-4" style="background-color: #eeeeee; border: none; border-radius: 10px;">
                                    <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>Allotment Order</label>
                                            <input type="file" class="" name="allotment_order" 
                                                placeholder="Enter Buyer Name" >
                                        </div>
                                        <div class="col-md-4">
                                            <label>Transfered Date</label>
                                            <input type="date" class="" name="transferred_date" 
                                                placeholder="Enter Buyer Name" >
                                        </div>
                                        <input type="hidden" name="property_id" value="{{$property->id}}">
                                        <input type="hidden" name="town_id" value="{{$property->town}}">
                                        
                                        
                                    </div>
                                
                                        
                                        
                                        </div>
                                    </div>
                                    <input type="submit" name="next" class="next action-button" value="Submit" />
                                </div>
                            </fieldset>
                        <!-- Step 2 -->
                       
                       
                    </form>
                </div>
            </div>
        </div>
    </div>


    

</x-app-layout>