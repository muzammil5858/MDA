<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        i {
            position: relative;
            font-size: 16px;
        }

        .detail {
            font-size: 18px;
        }

        i:hover {
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
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Modal box */
        .modern-modal-content {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            max-width: 350px;
            margin: 10% auto;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Close button */
        .modern-close {
            position: absolute;
            top: 10px;
            right: 15px;
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
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
                            <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th style="width:50px !important;">#</th>
                                        <th>Tehsil</th>
                                        <th>Town</th>
                                        <th>Code</th>
                                        <th>Request Type</th>
                                        <th>Plot No</th>
                                        <th>Sector</th>
                                        <th>Appointment Date</th>
                                        <th>Token No</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $dat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dat->property->center ?? 'N/A' }}</td>
                                        <td>{{$dat->property->township->name ?? 'N/A'}}</td>

                                        <td>
                                            {{$dat->property->code}}

                                        </td>
                                        @php
                                        $Request = DB::table('request_types')->where('id',$dat->request_type)->first();
                                        @endphp
                                        <td>{{$Request->name}}
                                        </td>
                                        <td>

                                            {{$dat->property->plot_no}}

                                        <td>Sector {{$dat->property->sector ?? 'N/A'}}
                                        <td> {{$dat->appointment_date ?? 'N/A'}}
                                        <td> {{$dat->appointment_no ?? 'N/A'}}
                                        </td>
                                        @if (Request::is('transfer-order-statement'))
                                        <td>
                                           @if($dat->statement && !empty($dat->statement->transfer_order && !empty($dat->statement->nakle_bala)))
                   <a href="/generate-transferorder-statement/{{$dat->id}}" class="text-decoration-none"> <span class="badge rounded-pill bg-success-soft text-success border border-success px-3 py-2">
    <i class="fas fa-check-circle me-1"></i> مکمل ہے (Done)
</span>
 </a>



                @else
                   <a href="/generate-transferorder-statement/{{$dat->id}}" class="text-decoration-none">
    <span class="badge rounded-pill bg-danger-soft text-danger border border-danger px-3 py-2">
        <i class="fas fa-exclamation-circle me-1"></i> پینڈنگ (Pending)</span>
    </a>
                @endif

                                        </td>
                                        @elseif(Request::is('final-transfered-list'))
                                        <td>
                                            <a href="/generate-transfer-order/{{$dat->id}}">
                                                <button class="btn btn-primary">
                                                    Generate Order
                                                </button>
                                            </a>
                                            <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal"
                                                data-bs-target="#transferOrderModal">
                                                Upload Order
                                            </button>

                                        </td>
                                        @elseif(Request::is('completed-requests'))
                                        @else
                                        <td>
                                            @if($dat->request_type == 4)
                                                <a href="/dd-transfer-verification/{{$dat->id}}/{{$dat->request_type}}">
                                                    <button class="btn btn-success">Review House Construction</button>
                                                </a>
                                            @else
                                                <a href="/dd-transfer-verification/{{$dat->id}}/{{$dat->request_type}}">
                                                    <button class="btn btn-primary">Action</button>
                                                </a>
                                            @endif
                                        </td>
                                        @endif

                                    </tr>
                                    <div class="modal fade" id="transferOrderModal" tabindex="-1"
                            aria-labelledby="transferOrderModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Form -->
                                    <form id="transferOrderForm" method="POST"
                                        action="{{ route('uploadTransferOrder', ['id' => $dat->id]) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="transferOrderModalLabel">Upload Order
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="transferOrderFile" class="form-label">Choose File</label>
                                                <input type="file" class="form-control" id="transferOrderFile"
                                                    name="transfer_order" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                                    required>
                                                <input type="hidden" name="type" value="2">
                                            </div>
                                            <small class="text-muted">You can only upload one file.</small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        

                    </div>
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

              
}
        </script>
        <script>
            function openUploadModal(propertyId, requestId) {
    document.getElementById("uploadForm").reset();
    document.getElementById("property_id").value = propertyId;
    document.getElementById("request_id").value = requestId;
    document.getElementById("uploadModal").style.display = "block";
}

function closeUploadModal() {
    document.getElementById("uploadModal").style.display = "none";
}

window.onclick = function(event) {
    if (event.target.id === "uploadModal") {
        closeUploadModal();
    }
}
        </script>


    </div>
</x-app-layout>