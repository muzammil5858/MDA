<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        p { color: grey }

        #heading {
            text-transform: uppercase;
            color: #03346E;
            font-weight: bolder;
            font-size: 1.5rem;
        }

        #msform { text-align: center; position: relative; margin-top: 20px }

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

        .form-card { text-align: left }

        #msform fieldset:not(:first-of-type) { display: none }

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
            background-color: #ECEFF1;
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
        #msform .action-button:focus { background-color: #311B92 }

        #msform .action-button:disabled {
            background-color: #9aa5b1;
            cursor: not-allowed;
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
        #msform .action-button-previous:focus { background-color: #000000 }

        .card { z-index: 0; border: none; position: relative }

        .fs-title {
            font-size: 25px;
            color: #03346E;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }

        .steps {
            font-size: 25px;
            color: gray;
            margin-bottom: 10px;
            font-weight: normal;
            text-align: right
        }

        #progressbar { margin-bottom: 30px; overflow: hidden; color: lightgrey }
        #progressbar .active { color: #03346E }

        #progressbar li {
            list-style-type: none;
            font-size: 14px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400;
            cursor: pointer;
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

        #progressbar #detail:before { content: "1"; font-family: FontAwesome; }
        #progressbar #price:before { content: "2"; font-family: FontAwesome; }
        #progressbar #transferees:before { content: "3"; font-family: FontAwesome; }
        #progressbar #attachments:before { content: "4"; font-family: FontAwesome; }

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
        #progressbar li.active:after { background: #03346E }

        .progress { height: 20px }
        .progress-bar { background-color: #03346E }

        .transferee-block {
            border: 1px dashed #03346E;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
        }

        .remove-transferee {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #c0392b;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 4px 10px;
            cursor: pointer;
            font-size: 12px;
        }

        #add-transferee {
            background: #03346E;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 18px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .file-hint { font-size: 12px; color: #888; margin-top: -10px; margin-bottom: 15px; }

        #form-alert-box {
            display: none;
            text-align: left;
        }
    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 text-center p-0 mt-3 mb-2">
                <div class="card px-4 pt-4 pb-0 mt-3 mb-3">
                    <h2 id="heading">MirPur Housing Authority - Property Allotment</h2>
                    <p>Fill all form's fields to go to next step</p>
                    <form id="msform" action="{{ route('formSubmission') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active" id="detail"><strong>Property Detail</strong></li>
                            <li id="price"><strong>Payment</strong></li>
                            <li id="transferees"><strong>Plot History</strong></li>
                            <li id="attachments"><strong>Attachments</strong></li>
                        </ul>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="form-alert-box" class="alert"></div>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ===================== STEP 1 : PROPERTY DETAIL ===================== --}}
                        <fieldset id="step-1">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7"><h2 class="fs-title">Property Detail:</h2></div>
                                    <div class="col-5"><h2 class="steps">Step 1 - 4</h2></div>
                                </div>

                                <div class="form-row">

                                    <div class="col-md-3">
                                        <div class="form-row mx-1 ">
                                            <div class="col-6 px-0">
                                        <label>Application No.</label>
                                        <input type="text" class="form-control" name="application_no"
                                        placeholder="Application No."
                                            value="{{ $property->application_no ?? '' }}">
                                            </div>
                                              <div class="col-6 px-0">
                                                  <label>Application Date</label>
                                        <input type="date" class="form-control datepicker" name="application_date"
                                        placeholder="Application Date"
                                            value="{{ $property->application_date ?? '' }}">
                                            </div>

                                        </div>

                                    </div>

                                                                        <div class="col-md-3">
                                        <label>Plot No.</label>
                                        <input type="text" class="form-control" name="plot_no"
                                        placeholder="Plot No."
                                            value="{{ $property->plot_no ?? '' }}">
                                    </div>
                                    <div class="col-md-3">

    <label for="Sector">Sector</label>

    <select name="sector" id="sector" class="form-control">
        <option value="">Select Sector</option>

        <option value="A"
            {{ old('sector', $property->sector?? '') == 'A' ? 'selected' : '' }}>
            A
        </option>

        <option value="B"
            {{ old('sector', $property->sector?? '') == 'B'? 'selected' : '' }}>
            B
        </option>

        <option value="C"
            {{ old('sector', $property->sector ?? '') == 'C' ? 'selected' : '' }}>
            C
        </option>
    </select>
</div>

      <div class="col-md-3">

    <label >Block</label>

    <select name="block" id="block" class="form-control">
        <option value="">Select Block</option>
                <option value="A"
            {{ old('block', $property->block?? '') == 'A' ? 'selected' : '' }}>
            A
        </option>

        <option value="B"
            {{ old('block', $property->block?? '') == 'B'? 'selected' : '' }}>
            B
        </option>

        <option value="C"
            {{ old('block', $property->block ?? '') == 'C' ? 'selected' : '' }}>
            C
        </option>
    </select>
</div>
                                <div class="col-md-3">
    <div class="row mx-0">

        <div class="col-4 px-0">
            <label>Kanal</label>
            <input type="number"
                   class="form-control"
                   name="kanal"
                   placeholder="Kanal"
                   value="{{ $property->kanal ?? '' }}">
        </div>

        <div class="col-4 px-0">
            <label>Marla</label>
            <input type="number"
                   class="form-control"
                   name="marla"
                   placeholder="Marla"
                   value="{{ $property->marla ?? '' }}">
        </div>

        <div class="col-4 px-0">
            <label>Sq Ft</label>
            <input type="number"
                   class="form-control"
                   name="sqrft"
                   placeholder="Sq Ft"
                   value="{{ $property->sqrft ?? '' }}">
        </div>

    </div>
</div>
                                  <div class="col-md-3">
                                  <label for="approved_scheme">Approved Scheme</label>

                        <select name="approved_scheme" id="approved_scheme" class="form-control">
        <option selected disabled>Select Scheme</option>

        <option value="Scheme 1"
            {{ old('approved_scheme', $property->approved_scheme ?? '') == 'Scheme 1' ? 'selected' : '' }}>
            Scheme 1
        </option>

        <option value="Scheme 2"
            {{ old('approved_scheme', $property->approved_scheme ?? '') == 'Scheme 2' ? 'selected' : '' }}>
            Scheme 2
        </option>

        <option value="Scheme 3"
            {{ old('approved_scheme', $property->approved_scheme ?? '') == 'Scheme 3' ? 'selected' : '' }}>
            Scheme 3
        </option>
    </select>
</div>

  <div class="col-md-3">
                                        <label>Initial Draft Amount</label>
                                        <input type="number" class="form-control" name="initial_draft_amount"
                                        placeholder="Initial Draft Amount"
                                            value="{{ $property->initial_draft_amount ?? '' }}">
                                    </div>
<div class="col-md-3">
                                        <label>Initial Draft Date</label>
                                        <input type="date" class="form-control datepicker" name="initial_draft_date"
                                        placeholder="Initial Draft Date"
                                            value="{{ $property->initial_draft_date ?? '' }}">
                                    </div>



                                </div>




                                <div class="form-row">






                                    <div class="col-md-3">
                                        <label>Name Applicant/Allottee</label>
                                        <input type="text" class="form-control" name="applicant_name"
                                        placeholder="Name Applicant"
                                            value="{{ $property->applicant_name ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Father/Husband Name</label>
                                        <input type="text" class="form-control" name="father_husband_name"
                                        placeholder="Father/Husband Name"
                                            value="{{ $property->father_husband_name ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Old NIC</label>
                                        <input type="number" class="form-control" name="old_nic"
                                        placeholder="Old NIC"
                                            value="{{ $property->old_nic ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>CNIC</label>
                                        <input type="number" class="form-control" name="cnic"
                                        placeholder="CNIC"
                                            value="{{ $property->cnic ?? '' }}">
                                    </div>

                                </div>


                                <div class="form-row">


                                    <div class="col-md-6">
                                        <label>Address (Temporary)</label>
                                        <textarea class="form-control"
                                        placeholder="Address (Temporary)"
                                        name="address_temporary" rows="1">{{ $property->address_temporary ?? '' }}</textarea>
                                    </div>
                                 <div class="col-md-6">
                                        <label>Address (Permanent)</label>
                                        <textarea class="form-control"
                                        placeholder="Address (Permanent)"
                                        name="address_permanent" rows="1">{{ $property->address_permanent ?? '' }}</textarea>
                                    </div>

                                </div>


                                <div class="form-row">


                                         <div class="col-md-3">
                                            <label for="name" >
                                                Category</label>

                                                  <select name="category" id="" class="form-control">
                                                     <option value="">Select Category</option>
                                                      <option {{$property && $property->category == 'Lawyer' ? 'selected' : ''}} value="Lawyer">Lawyer</option>
                                                     <option {{$property && $property->category == 'Overseas' ? 'selected' : ''}} value="Overseas">Overseas</option>
                                                     <option{{$property && $property->category == 'Permanent_Employee' ? 'selected' : ''}} value="Permanent_Employee">Permanent Employee</option>

                                                           </select> </div>

                                                                <div class="col-md-3">
    <label for="approved_scheme">Mode of Allottment</label>

    <select name="mode_allottment" id="mode_allottment" class="form-control">
        <option value="">Select Allottment</option>

        <option value="Balloting"
            {{ old('mode_allottment', $property->mode_allottment ?? '') == 'Balloting' ? 'selected' : '' }}>
            Balloting
        </option>

        <option value="Auction"
            {{ old('mode_allottment', $property->mode_allottment ?? '') == 'Auction' ? 'selected' : '' }}>
            Auction
        </option>

        <option value="By_Chairman"
            {{ old('mode_allottment', $property->mode_allottment ?? '') == 'By_Chairman' ? 'selected' : '' }}>
            By Chairman
        </option>
    </select>
</div>




                                    <div class="col-md-3">
                                        <label>Allotment Date</label>
                                        <input type="date" class="form-control datepicker" name="allotment_date"
                                        placeholder="Allotment Date"
                                            value="{{ $property->allotment_date ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Serial No of Balloting</label>
                                        <input type="text" class="form-control" name="balloting_serial_no"
                                        placeholder="Serial No of Balloting"
                                            value="{{ $property->balloting_serial_no ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <input type="button" class="next action-button" value="Next">
                        </fieldset>

                        {{-- ===================== STEP 2 : PRICE ===================== --}}
                        <fieldset id="step-2">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7"><h2 class="fs-title">Payment Detail:</h2></div>
                                    <div class="col-5"><h2 class="steps">Step 2 - 4</h2></div>
                                </div>


                                <div class="form-row">

                                   <div class="col-md-3">
                                        <label>Total Price of Plot</label>
                                        <input type="number" class="form-control"
                                        placeholder="Total Price of Plot"
                                        name="total_price"
                                            value="{{ $property->payment->total_price ?? ''}}">
                                    </div>



                                    <div class="col-md-3">
                                        <label>Amount Deposited</label>
                                        <input type="number" class="form-control"
                                        placeholder="Amount Deposited"
                                        name="amount_deposited"
                                            value="{{ $property->payment->amount_deposited ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Remaining Amount</label>
                                        <input type="number" class="form-control"
                                        placeholder="Remaining Amount"
                                        name="remaining_amount"
                                            value="{{ $property->payment->remaining_amount ?? '' }}">
                                    </div>
                                           <div class="col-md-3">
                                        <label>Down payment</label>
                                        <input type="number" class="form-control"
                                        placeholder="Down payment"
                                        name="down_payment"
                                            value="{{$property->payment->down_payment ?? '' }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Initial Notice No. (Allotment Letter)</label>
                                        <input type="text" class="form-control" name="initial_notice_no"
                                        placeholder="Initial Notice No."
                                            value="{{ $property->payment->initial_notice_no ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Initial Notice Date</label>
                                        <input type="text" class="form-control datepicker"
                                        placeholder="Initial Notice Date"
                                        name="initial_notice_date"
                                            value="{{ $property->payment->initial_notice_date ?? '' }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Total Received Amount </label>
                                        <input type="number" class="form-control"
                                        placeholder="Total Received Amount"
                                        name="total_received_amount"
                                            value="{{ $property->payment->total_received_amount ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Received Amount Date</label>
                                        <input type="text" class="form-control datepicker"
                                        placeholder="Received Amount Date"
                                        name="received_amount_date"
                                            value="{{ $property->payment->received_amount_date ?? '' }}">
                                    </div>
 </div>
                                <div class="row">
                                    <div class="col-7"><h2 class="fs-title">Allotment / Possession:</h2></div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-3">
                                        <label>Allotment Order No.</label>
                                        <input type="text" class="form-control"
                                        placeholder="Allotment Order No." name="allotment_order_no"
                                            value="{{ $property->payment->allotment_order_no ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Allotment Order Date</label>
                                        <input type="date" class="form-control datepicker"
                                        placeholder="Allotment Order Date"
                                        name="allotment_order_date"
                                            value="{{ $property->payment->allotment_order_date ?? '' }}">
                                    </div>


                                    <div class="col-md-3">
                                        <label>Possession Slip No.</label>
                                        <input type="text" class="form-control"
                                        placeholder="Possession Slip No."
                                        name="possession_slip_no"
                                            value="{{ $property->payment->possession_slip_no ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Possession Slip Date</label>
                                        <input type="date" class="form-control datepicker"
                                        placeholder="Possession Slip Date"
                                        name="possession_slip_date"
                                            value="{{ $property->payment->possession_slip_date ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Approval of Boundary Wall</label>
                                        <input type="text" class="form-control" name="boundary_wall_approval"
                                        placeholder="Approval of Boundary Wall"
                                            value="{{ $property->payment->boundary_wall_approval ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Approval Date of Maps</label>
                                        <input type="date" class="form-control datepicker" name="map_approval_date"
                                        placeholder="Approval Date of Maps"
                                        value="{{ $property->payment->map_approval_date ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Transfer Order No.</label>
                                        <input type="text" class="form-control" placeholder="Transfer Order No."
                                         name="transfer_order_no"
                                            value="{{ $property->payment->transfer_order_no ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <input type="button" class="next action-button" value="Next">
                            <input type="button" class="previous action-button-previous" value="Previous">
                        </fieldset>

                        {{-- ===================== STEP 3 : DETAIL OF TRANSFEREES ===================== --}}
                        <fieldset id="step-3">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7"><h2 class="fs-title">Detail of Transferees:</h2></div>
                                    <div class="col-5"><h2 class="steps">Step 3 - 4</h2></div>
                                </div>



                                <div id="transferees-wrapper">
                                    <div class="transferee-block" data-index="0">
                                        <div class="form-row">
                                            <div class="col-md-3">
                                                <label>Transferee Name</label>
                                                <input type="text" class="form-control"
                                                placeholder="Transferee Name" name="transferees[0][name]">
                                            </div>
                                            <div class="col-md-3">
                                                <label>ID Card</label>
                                                <input type="number" class="form-control"
                                                placeholder="ID Card"
                                                name="transferees[0][id_card]">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Challan No.</label>
                                                <input type="text" class="form-control"
                                                placeholder="Challan No."
                                                name="transferees[0][challan_no]">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="add-transferee">+ Add Transferee</button>
                            </div>
                            <input type="button" class="next action-button" value="Next">
                            <input type="button" class="previous action-button-previous" value="Previous">
                        </fieldset>

                        {{-- ===================== STEP 4 : ATTACHMENTS ===================== --}}
                        <fieldset id="step-4">



                                           {{-- NOTE (assumption): "Alternate Allotment" placed here — please confirm --}}
                                <div class="form-row">
                                    <div class="col-md-4 text-left">
                                        <label>Alternate Allotment </label>
                                        <input type="text" class="form-control" name="alternate_allotment"
                                        placeholder="Alternate Allotment"
                                            value="{{ $property->alternate_allotment ?? '' }}">
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-7"><h2 class="fs-title">Attachments:</h2></div>
                                <div class="col-5"><h2 class="steps">Step 4 - 4</h2></div>
                            </div>

                            <div class="form-row">
                                   <div class="col-md-4 text-left">
                                    <label>Complete Property File</label>
                                    <input type="file" name="complete_property_file">
                                </div>
                                <div class="col-md-4 text-left">
                                    <label>Adjacent Area Allotment</label>
                                    <input type="file" name="adjacent_area_allotment">
                                </div>
                                <div class="col-md-4 text-left">
                                    <label>Division of Plots</label>
                                    <input type="file" name="division_of_plots">
                                </div>
                                <div class="col-md-4 text-left">
                                    <label>Decision of Courts Against Plot</label>
                                    <input type="file" name="decision_courts">
                                </div>
                                <div class="col-md-4 text-left">
                                    <label>Decision of Allotment Committee</label>
                                    <input type="file" name="decision_allotment_committee">
                                </div>
                                <div class="col-md-4 text-left">
                                    <label>Decision of MDA Board</label>
                                    <input type="file" name="decision_mda_board">
                                </div>
                                <div class="col-md-4 text-left">
                                    <label>Decision of Revising Authority (Cancel/Restore etc)</label>
                                    <input type="file" name="decision_revising_authority">
                                </div>
                            </div>

                            <button type="submit" id="submit-btn" class="action-button">Submit</button>
                            <input type="button" class="previous action-button-previous" value="Previous">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
    $(document).ready(function () {
        $('.datepicker').flatpickr({ dateFormat: "Y-m-d" });

        // Explicit step order
        var stepIds = ['#step-1', '#step-2', '#step-3', '#step-4'];
        var current = 0; // index into stepIds

        function setProgressBar(stepIndex) {
            var percent = (100 / stepIds.length) * (stepIndex + 1);
            $('.progress-bar').css('width', percent.toFixed() + '%');
        }

        function goToStep(index) {
            if (index < 0 || index >= stepIds.length) return;

            var current_fs = $(stepIds[current]);
            var target_fs = $(stepIds[index]);

            $('#progressbar li').removeClass('active');
            $('#progressbar li').each(function (i) {
        if (i <= index) {
            $(this).addClass('active');
        }
    });

            current_fs.hide();
            target_fs.show();

            current = index;
            setProgressBar(current);
        }

        // Next button
        $(document).off('click', '.next').on('click', '.next', function (e) {

            e.preventDefault();
            goToStep(current + 1);
        });

        // Previous button
        $(document).off('click', '.previous').on('click', '.previous', function (e) {
            e.preventDefault();
            goToStep(current - 1);
        });

        // Progressbar item click → seedha us step par jump
        $('#progressbar li').on('click', function () {
            var index = $('#progressbar li').index(this);
            goToStep(index);
        });

        // Dynamic "Add Transferee"
        var transfereeIndex = 1;
        $('#add-transferee').click(function () {
            var block = `
                <div class="transferee-block" data-index="${transfereeIndex}">
                    <button type="button" class="btn btn-danger remove-transferee">Remove</button>
                    <div class="form-row">
                        <div class="col-md-4">
                            <label>Transferees Name</label>
                            <input type="text" class="form-control"
                            placeholder="Transferees Name"
                            name="transferees[${transfereeIndex}][name]">
                        </div>
                        <div class="col-md-4">
                            <label>ID Card</label>
                            <input type="text"
                            placeholder="ID Card"
                            class="form-control" name="transferees[${transfereeIndex}][id_card]">
                        </div>
                        <div class="col-md-4">
                            <label>Challan No.</label>
                            <input type="text"
                             placeholder="Challan No."
                            class="form-control" name="transferees[${transfereeIndex}][challan_no]">
                        </div>
                    </div>
                </div>`;
            $('#transferees-wrapper').append(block);
            transfereeIndex++;
        });

     $(document).on('click', '.remove-transferee', function (e) {

   e.preventDefault();
           console.log("Remove clicked");

    $(this).closest('.transferee-block').remove();

});

        // ===================== SUBMIT (AJAX) =====================
        function showAlert(type, message) {
            var box = $('#form-alert-box');
            box.removeClass('alert-success alert-danger').addClass('alert-' + type);
            box.html(message);
            box.show();
            $('html, body').animate({ scrollTop: box.offset().top - 100 }, 300);
        }

        $('#msform').on('submit', function (e) {
            e.preventDefault();

            var form = this;
            var formData = new FormData(form);
            var $submitBtn = $('#submit-btn');

            $submitBtn.prop('disabled', true).text('Saving...');
            $('#form-alert-box').hide();

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function (response) {
                    showAlert('success', response.message || 'Data saved successfully.');

                    // Redirect to list page after a short pause, agar backend redirect url bheje
                    if (response.redirect) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 1200);
                    } else {
                        form.reset();
                        goToStep(0);
                    }
                },
                error: function (xhr) {
                    var message = 'Kuch masla ho gaya. Dobara koshish karein.';
    console.log(xhr);
    console.log(xhr.status);
    console.log(xhr.responseText);
    console.log(xhr.responseJSON);

    alert(xhr.responseText);

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var list = '<ul class="mb-0">';
                        $.each(errors, function (field, messages) {
                            list += '<li>' + messages[0] + '</li>';
                        });
                        list += '</ul>';
                        message = list;
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    showAlert('danger', message);
                },
                complete: function () {
                    $submitBtn.prop('disabled', false).text('Submit');
                }
            });
        });
    });
    </script>
</x-app-layout>
