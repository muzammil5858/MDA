<x-app-layout>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Scheduling</title>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
            integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
            crossorigin="anonymous" />
        <link rel="stylesheet" href="./fullcalender/css/bootstrap.min.css">
        <link rel="stylesheet" href="./fullcalender/fullcalendar/lib/main.min.css">
        <script src="./fullcalender/js/jquery-3.6.0.min.js"></script>
        <script src="./fullcalender/js/bootstrap.min.js"></script>
        <script src="./fullcalender/fullcalendar/lib/main.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <style>
            /* .footerlogo {
        text-align: center;
        height: 30px;
        width: 30px;
        margin: 20px;
      }
     
     
      .box {
        direction: rtl;
        display: flex;
        justify-content: center;
    }
        
    
            :root {
                --bs-success-rgb: 71, 222, 152 !important;
            }
    
            html,
            body {
                height: 100%;
                width: 100%;
              
            }
    
            .btn-info.text-light:hover,
            .btn-info.text-light:focus {
                background: #000;
            }
            table, tbody, td, tfoot, th, thead, tr {
                border-color: #ededed !important;
                border-style: solid;
                border-width: 1px !important;
            } */
            #calender {
                width: 100%;
                height: 90vh !important;
            }
        </style>
    </head>


    <div class="container p-5">
        <div class="row">
            <div class="col">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
            </div>
        </div>
        @if($check)
                    <h6 style="color: red">You have booked Your Appointment; cannot book appointment again until the previous date passed.</h4>
                    @endif
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                        <h5 class="card-title">Schedule Form</h5>
                    </div>
                    @if($errors->any())
                    <h4 style="color: red">{{$errors->first()}}</h4>
                    @endif
                    
                    
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="/appointment" method="post" id="schedule-form">
                                @csrf
                                <div class="form-group mb-2">
                                    <label for="description" class="control-label">Select Appointment date</label>
                                    <select class="select2-multiple form-control" name="date" id="date"
                                        style="font-size:14px; height:30px;">
                                        <option value="" disabled selected>Select date</option>
                                        @foreach($dates as $date)
                                        @php
                                        $d = new DateTime($date->start_datetime);
                                        $formatted = $d->format('F d, Y h:i A');
                                        @endphp
                                        <option value="{{$date->id}}">{{$formatted}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <input type="hidden" name="id" value="{{$id}}">
                                <div class="form-group mb-2">
                                    <label for="title" class="control-label">Title</label>
                                    <input type="text" name="title" class="form-control form-control-sm rounded-0"
                                        id="title1" placeholder="Add Title of Appointment" readonly>
                                    <div class="form-group mb-2">
                                        <label for="description" class="control-label">Description</label>
                                        <textarea rows="3" class="form-control form-control-sm rounded-0"
                                            name="description" id="description1" readonly></textarea>
                                    </div>
                                    <input type="hidden" name="town" id="town2" value="">
                                    <div class="form-group mb-2">
                                        <label for="title" class="control-label">Select Town</label>
                                        <select class="select2-multiple form-control" name="town" id="town1"
                                            style="font-size:14px; height:30px;" disabled>

                                            <option value="" disabled selected>Select Town</option>
                                            @foreach($type as $town)
                                            <option value="{{$town->id}}">{{$town->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="title" class="control-label">Limit</label>
                                        <input type="number" class="form-control form-control-sm rounded-0" name="limit"
                                            value="5" id="limit1" readonly>
                                    </div>


                                    <div class="form-group mb-2">
                                        <label for="start_datetime" class="control-label">Start</label>
                                        <input type="datetime-local" class="form-control form-control-sm rounded-0"
                                            name="start_datetime" id="start_datetime1" readonly>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="end_datetime" class="control-label">End</label>
                                        <input type="datetime-local" class="form-control form-control-sm rounded-0"
                                            name="end_datetime" id="end_datetime1" readonly>
                                    </div>
                            </form>
                        </div>
                    </div>
                     @if(!$check)
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i
                                    class="fa fa-save"></i> Save</button>
                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i
                                    class="fa fa-reset"></i> Cancel</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
   
    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Title</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description" class=""></dd>

                            <dt class="text-muted">Town</dt>
                            <dd id="town" class=""></dd>

                            <dt class="text-muted">Limit</dt>
                            <dd id="limit" class=""></dd>
                            <dt class="text-muted">Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        {{-- <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit"
                            data-id="">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete"
                            data-id="">Delete</button> --}}
                        <button type="button" class="btn btn-secondary btn-sm rounded-0"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="paymentNoticeModal" tabindex="-1" aria-labelledby="paymentNoticeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content message-card p-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title w-100" id="paymentNoticeModalLabel">Important Notice / اہم اطلاع</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.5rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       
                        Please pay the required fees in advance and bring the payment receipt (chalan) with you when you come for your appointment. Present the receipt to the clerk to proceed.
                    </p>
                    <p>Also, please bring the following documents:</p>
                    <ol class="documents-list">
                        <li style="list-style-type: decimal;">Deposit Slip of Transfer Fee</li>
                        <li style="list-style-type: decimal;">Deposit Slip of KLC</li>
                        <li style="list-style-type: decimal;">Deposit Slip of Income Tax</li>
                        <li style="list-style-type: decimal;">Deposit Slip of Education Cess</li>
                        @php
                            $threePercent = (3/ 100) * $track->amount;
                        @endphp
                        <li style="list-style-type: decimal;">Stamp Duty - {{$threePercent}} Rs</li>

                    </ol>
                    <p class="urdu-text">
                        
                        براہ کرم پہلے سے مطلوبہ فیس ادا کریں اور اپنی ملاقات کے وقت چالان (رسید) اپنے ساتھ لے کر آئیں۔ کارروائی کے لیے چالان کو کلرک کو پیش کریں۔
                    </p>
                    <p class="urdu-text">
                        مزید برآں، درج ذیل دستاویزات ساتھ لانا ضروری ہیں:
                    </p>
                    <ol class="documents-list urdu">
                        <li style="list-style-type: decimal;">منتقلی فیس کی رسید</li>
                        <li style="list-style-type: decimal;">KLC کی رسید</li>
                        <li style="list-style-type: decimal;">انکم ٹیکس کی رسید</li>
                        <li style="list-style-type: decimal;">ایجوکیشن سیس کی رسید</li>
                        <li style="list-style-type: decimal;">اسٹامپ ڈیوٹی - {{$threePercent}} روپے</li>


                    </ol>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close / بند کریں</button>
                </div>
            </div>
        </div>
    </div>
    </div>

@if($check)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('paymentNoticeModal'));
        successModal.show();
    });
</script>
@endif
{{-- @if(session('success'))
<script>
    setTimeout(function () {
            location.reload();
        }, 3000); // 3000 milliseconds = 3 seconds
</script>
@endif --}}
<script>
        document.getElementById('date').addEventListener('change', () => {
    let date = document.getElementById('date').value;
    let csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token from the meta tag
    // Setup CSRF Token for AJAX request
   

    // Make the AJAX request
    $.ajax({
        url: '/appointment-detail',
        type: 'POST',
        data: {
            id: date,
            _token:csrfToken,
        },
        dataType: 'JSON',
        success: function(data) {
            if(data.status == 200){
                // console.log(data.schedule);
                document.getElementById('limit1').value = data.schedule.limit;
                document.getElementById('start_datetime1').value = data.schedule.start_datetime;
                document.getElementById('end_datetime1').value = data.schedule.end_datetime;
                document.getElementById('description1').value = data.schedule.description;
                document.getElementById('title1').value = data.schedule.title;
                document.getElementById('town1').value = data.schedule.town;
                document.getElementById('town2').value = data.schedule.town;
            
            }
            else{
                alert(data.message);
                document.getElementById('date').value = '';
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); // Log the error response
            alert('Some error happend while booking appointment');
        }
    });
});

                
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var today = new Date().toISOString().slice(0, 16);
            
    
    document.getElementsByName("end_datetime")[0].min = today;
    document.getElementsByName("start_datetime")[0].min = today;
    </script>
    <script>
        $(document).ready(function() {
                 // Select2 Multiple
                 $('.select2-multiple').select2({
                     placeholder: "Select",
                     allowClear: true
                 });
     
             });
     
    </script>

    <!-- Event Details Modal -->

    <?php 
    $sched_res = [];
    
    foreach($schedules as $row){
        $row->sdate = date("F d, Y h:i A",strtotime($row->start_datetime));
        $row->edate = date("F d, Y h:i A",strtotime($row->end_datetime));
        $sched_res[$row->id] = $row;
        
    }
    ?>

    </body>

    <script>
        var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    </script>
    <script src="./fullcalender/js/script.js"></script>
    <!-- Google tag (gtag.js) -->


    <script>
        var jArray = @json($type);
        console.log(jArray);
        $(document).ready(() => {
          $(document.body).on("click", ".card[data-clickable=true]", (e) => {
            var href = $(e.currentTarget).data("href");
            window.location = href;
          });
        });
    </script>



    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css"
        rel="stylesheet">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>

    </html>


</x-app-layout>