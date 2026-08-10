<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Entries') }}
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
        .badge-uploaded {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
        .badge-missing {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #333;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">My Entries ({{ auth()->user()->name }})</h3>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Summary Cards -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $data->count() }}</h3>
                                            <p>Total Entries</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-list"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $data->filter(function($item) {
                                                return $item->attachment && $item->attachment->complete_property_file;
                                            })->count() }}</h3>
                                            <p>Files Uploaded</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>{{ $data->filter(function($item) {
                                                return !$item->attachment || !$item->attachment->complete_property_file;
                                            })->count() }}</h3>
                                            <p>Files Missing</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-times-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th style="width:50px !important;">#</th>
                                        <th>Applicant Name</th>
                                        <th>Application No</th>
                                        <th>Plot No</th>
                                        <th>Created Date</th>
                                        <th>File Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $dat)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dat->applicant_name ?? 'N/A' }}</td>
                                            <td>{{ $dat->application_no ?? 'N/A' }}</td>
                                            <td>{{ $dat->plot_no ?? 'N/A' }}</td>
                                        
                                            <td>{{ $dat->created_at ? date('d-m-Y', strtotime($dat->created_at)) : 'N/A' }}</td>
                                            <td>
                                                @if($dat->attachment && $dat->attachment->complete_property_file)
                                                    <span class="badge badge-success">
                                                        <i class="fa fa-check-circle"></i> Uploaded
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        <i class="fa fa-times-circle"></i> Missing
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('formEdit', $dat->id) }}">
                                                    <i class="far fa-edit edit" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                                </a>
                                                <a href="{{ route('formDetail', $dat->id) }}">
                                                    <i class="fa fa-wpforms ml-3 detail" data-toggle="tooltip" data-placement="top" title="View Detail"></i>
                                                </a>
                                                <a href="{{ route('formDelete', $dat->id) }}" onclick="return confirm('Are you sure you want to delete this property?')">
                                                    <i class="fa fa-trash ml-3 delete" aria-hidden="true"></i>
                                                </a>
                                                @if(!$dat->attachment || !$dat->attachment->complete_property_file)
                                                    <a href="{{ route('formEdit', $dat->id) }}#step-4" class="ml-3">
                                                        <i class="fa fa-upload text-success" data-toggle="tooltip" data-placement="top" title="Upload File"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i>
                                                    No entries found for {{ auth()->user()->name }}.
                                                    <br>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
</x-app-layout>
