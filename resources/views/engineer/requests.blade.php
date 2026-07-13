<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('HDM - Pending Applications') }}
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
        i {
            position: relative;
            font-size: 16px;
        }
        .detail {
            font-size: 18px;
        }
        .delete {
            font-size: 18px;
        }
        i:hover {
            cursor: pointer;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Pending Applications for HDM</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($pendingApplications->count() > 0)
                                <table id="pendingTable" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th style="width:50px !important;">#</th>
                                            <th>Applicant Name</th>
                                            <th>Applicant CNIC</th>
                                            <th>Property Code</th>
                                            <th>Request Type</th>
                                            <th>Plot No</th>
                                            <th>Town</th>
                                            <th>Sector</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingApplications as $application)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $application->participants->map(fn($owner) => $owner->owner->name ?? 'N/A')->implode(', ') ?? 'N/A' }}</td>
                                                <td>{{ $application->participants->map(fn($owner) => $owner->owner->cnic ?? 'N/A')->implode(', ') ?? 'N/A' }}</td>
                                                <td>{{ $application->property ? $application->property->code : 'N/A' }}</td>
                                                @php
                                                    $requestType = DB::table('request_types')->where('id', $application->request_type)->first();
                                                @endphp
                                                <td>{{ $requestType->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="/view-property-detail/{{ $application->id }}">
                                                        {{ $application->property ? $application->property->plot_no : 'N/A' }}
                                                    </a>
                                                </td>
                                                <td>{{ $application->property->township->name ?? 'N/A' }}</td>
                                                <td>Sector {{ $application->property->sector ?? 'N/A' }}</td>
                                                <td>

                                                    @if($application->engineer_status == 2)
                                                    <span class="badge badge-warning">Onjection Raised Sub-engineer</span>
                                                    @elseif($application->engineer_status == 1)
                                                    <span class="badge badge-success">Approved Sub-engineer</span>
                                                    @else

                                                    <span class="badge badge-warning">Pending Sub-engineer</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="/engineer/view-pending-request/{{ $application->id }}" class="btn btn-sm btn-info" title="View Details">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    @if(Route::currentRouteName() == 'engineer.approvedRequests')
                                                        @if($application->mapApprovals->isEmpty())
                                                        <a href="/engineer/map-approval/{{ $application->id }}" class="btn btn-sm btn-primary mt-2" title="Map Approval">
                                                            <i class="fas fa-map"></i> Map
                                                        </a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $pendingApplications->links() }}
                                </div>
                            @else
                                <div class="alert alert-info text-center">
                                    <strong>No pending applications found.</strong>
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- DataTables & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

    <script>
        $(function() {
            $("#pendingTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#pendingTable_wrapper .col-md-6:eq(0)');
        });
    </script>
</x-app-layout>
