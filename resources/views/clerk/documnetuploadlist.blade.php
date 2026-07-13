<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        i{
            position: relative;
            font-size:16px;
        }
        .detail{
            font-size:18px;
        }
        .delete{
          font-size:18px;
        }
        i:hover{
            cursor: pointer;

        }

    </style>
<style>
/* Modal background */
.modern-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background-color: rgba(0,0,0,0.5);
}

/* Modal box */
.modern-modal-content {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    max-width: 350px;
    margin: 10% auto;
    position: relative;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    text-align: center;
    animation: fadeIn 0.3s ease-in-out;
}

/* Close button */
.modern-close {
    position: absolute;
    top: 10px; right: 15px;
    font-size: 24px;
    color: #007bff;
    cursor: pointer;
}

/* Input */
#appointment {
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-top: 15px;
    font-size: 14px;
}

/* Save button */
.modern-save-btn {
    background: #007bff;
    border: none;
    padding: 10px 20px;
    color: white;
    font-size: 14px;
    border-radius: 6px;
    margin-top: 15px;
    cursor: pointer;
}
.modern-save-btn:hover {
    background: #0056b3;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-10px);}
    to {opacity: 1; transform: translateY(0);}
}

</style>
<style>

.loader {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #007bff;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 0.8s linear infinite;
    margin: 0 auto;
}
@keyframes spin {
    0% { transform: rotate(0deg);}
    100% { transform: rotate(360deg);}
}

/* Message colors */
#appointmentMessage.error { color: red; }
#appointmentMessage.success { color: green; }

/* Message styles */
#appointmentMessage.error {
    color: red;
}
#appointmentMessage.success {
    color: green;
}

</style>
<style>
    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-left: 5px;
    }
    .pulse-green { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); animation: pulse-green 2s infinite; }
    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 5px rgba(40, 167, 69, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }
</style>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="card">
                            <div class="card-header">
                              <h3 class="text-center">Properties List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              @if(session('success'))
                                  <div class="alert alert-success">
                                      {{ session('success') }}
                                  </div>
                              @endif

                              <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                  <th style="width:50px !important;">#</th>
                                  <th>Applicant Name</th>
                                  <th>Applicant CNIC</th>
                                  <th>Code</th>
                                  <th>Request Type</th>
                                  <th>Plot No</th>
                                  <th>Town</th>
                                  <th>Sector</th>
                                  @if($type != 3)
                                  <th>Appointment Date</th>
                                  <th>Token No</th>
                                  @else
                                     <th>Requester Statement</th>
                                  <th>Receiver Statement</th>
                                  @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($properties as $dat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ $dat->participants?->isNotEmpty()
                                            ? $dat->participants->map(fn($p) => $p->owner->name)->join(', ')
                                            : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $dat->participants?->isNotEmpty()
                                            ? $dat->participants->map(fn($p) => $p->owner->cnic)->join(', ')
                                            : 'N/A' }}
                                    </td>

                                    <td>
                                         @if($type == 3)
                                        <a href="{{route('addedDetails',$dat->id)}}">{{$dat->property->code}}</a>
                                        @else
                                        {{$dat->property->code}}

                                        @endif
                                    </td>
                                    @php
                                      $Request = DB::table('request_types')->where('id',$dat->request_type)->first();
                                    @endphp
                                    <td>{{$Request->name}}
                                    </td>
                                    <td>
                                       @if($type == 1)
                                        <a href="{{route('transferRequestAttach',$dat->id)}}">{{$dat->property->plot_no}}</a>
                                        @elseif($type == 3)
                                        <a href="{{route('addedDetailEdit',$dat->id)}}">{{$dat->property->plot_no}}</a>
                                        @else
                                        <a href="{{route('receiverDetail',$dat->id)}}">{{$dat->property->plot_no}}</a>
                                        @endif
                                    <td>{{$dat->property->township->name ?? 'N/A'}}
                                    </td><td>Sector {{$dat->property->sector ?? 'N/A'}}
                                    </td>
                                    @if($type != 3)
                                    <td>{{$dat->appointment_date}}</td>
                                    <td>{{$dat->appointment_no}}</td>
                                    @else
                                    <td>@if($dat->statement && !empty($dat->statement->requester_statement))
                    <span class="badge rounded-pill bg-success-soft text-success border border-success px-3 py-2">
    <i class="fas fa-check-circle me-1"></i> مکمل ہے (Done)
</span>



                @else
                   <a href="/requester-statement/{{$dat->id}}/{{$dat->request_type}}" class="text-decoration-none">
    <span class="badge rounded-pill bg-danger-soft text-danger border border-danger px-3 py-2">
        <i class="fas fa-exclamation-circle me-1"></i> پینڈنگ (Pending)</span>
    </a>
                @endif</td>
                                    <td>@if($dat->statement && !empty($dat->statement->receiver_statement))
                    <span class="badge rounded-pill bg-success-soft text-success border border-success px-3 py-2">
    <i class="fas fa-check-circle me-1"></i> مکمل ہے (Done)
</span>



                @else
                   <a href="/receiver-statement/{{$dat->id}}/{{$dat->request_type}}" class="text-decoration-none">
    <span class="badge rounded-pill bg-danger-soft text-danger border border-danger px-3 py-2">
        <i class="fas fa-exclamation-circle me-1"></i> پینڈنگ (Pending)</span>
    </a>
                @endif</td>
                                    @endif

                                </tr>
                                @endforeach
                            </tbody>
                              </table>
                            </div>
                            <!-- /.card-body -->
                          </div>
                          <!-- Appointment Modal -->




                    </div>

                </div>
            </div>

            <script src="../../plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- DataTables  & Plugins -->
            <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
            <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../../dist/js/adminlte.min.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../../dist/js/demo.js"></script>
            <!-- Page specific script -->
            <script>
              $(function () {
                $("#example1").DataTable({
                  "responsive": true, "lengthChange": false, "autoWidth": false,

                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

              });
              </script>




    </div>
</x-app-layout>
