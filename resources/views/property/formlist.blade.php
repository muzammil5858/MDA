<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Properties Without Complete File') }}
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
        .badge-missing {
            background-color: #dc3545;
            color: white;
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
                            <h3 class="text-center">Properties Missing Complete File</h3>
                        </div>
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
                                        <th>Plot No</th>
                                        <th>Sector</th>
                                        <th>Block</th>

                                        <th>Allotment Date</th>
                                        <th>Indexing Date</th>
                                        <th>File Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $dat)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dat->applicant_name ?? 'N/A' }}</td>
                                            <td>{{ $dat->plot_no ?? 'N/A' }}</td>
                                            <td>{{ $dat->sector->name ?? 'N/A' }}</td>
                                            <td>{{ $dat->block->name ?? 'N/A' }}</td>

                                            <td>{{ $dat->allotment_date ? date('d-m-Y', strtotime($dat->allotment_date)) : 'N/A' }}</td>
                                            <td>{{ $dat->created_at ? date('d-m-Y', strtotime($dat->created_at)) : 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-danger">
                                                    <i class="fa fa-times-circle"></i> Missing
                                                </span>
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
                                              
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="alert alert-success">
                                                    <i class="fa fa-check-circle"></i>
                                                    All properties have complete files uploaded!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-3 text-left">
                                <span class="text-muted">Total Properties Without File: {{ $data->count() }}</span>
                            </div>
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







{{-- <x-app-layout>
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
                                  <th>Code</th>
                                  <th>Plot No</th>
                                  <th>Category</th>
                                  <th>Indexing Date</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $dat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$dat->code}}
                                    </td>
                                    <td>{{$dat->plot_no}}</td>
                                    <td>{{$dat->category}}</td>
                                    <td>{{date('d-m-Y', strtotime($dat->created_at))}}</td>
                                    <td><a href="{{route('formEdit',$dat->id)}}"><i class="far fa-edit edit" data-toggle="tooltip" data-placement="top" title="edit"></i></a><a href="{{route('formDetail',$dat->id)}}"><i class="fa fa-wpforms ml-3 detail"  data-toggle="tooltip" data-placement="top" title="view detail"></i></a><a href="{{route('formDelete',$dat->id)}}"><i class="fa fa-trash ml-3 delete" aria-hidden="true"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                              </table>
                            </div>
                            <!-- /.card-body -->
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
            </script>
    </div>
</x-app-layout> --}}
