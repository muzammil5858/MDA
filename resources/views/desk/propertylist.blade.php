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
                              @if(session('warning'))
                              <div class="alert alert-warning">
                                {{ session('warning') }}
                              </div>
                          @endif


                              <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                  <th style="width:50px !important;">#</th>
                                  <th>Code</th>
                                  <th>Plot No</th>
                                  <th>Category</th>
                                  <th>Town</th>
                                  <th>Sector</th>
                                  <th>Request Type</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($properties as $dat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$dat->property->code}}
                                    </td>
                                    <td><a href="{{route('formDetail',$dat->property->id ?? $dat->id)}}">{{$dat->plot_no ?? $dat->property->plot_no}}</a></td>
                                    <td>{{$dat->category ?? $dat->property->category}}</td>
                                    <td>{{$dat->property->township->name ?? 'N/A'}}</td>
                                    <td>{{$dat->sector}}</td>
                                    @php
                                      $Request = DB::table('request_types')->where('id',$dat->request_type)->first();
                                    @endphp
                                    <td>{{$Request->name ?? 'N/A'}}
                                    </td>
                                    <td class="d-flex justify-center">

                                      <a href="/transfer-file-edit/{{$dat->id}}">
                                          <button class="btn btn-primary ">Edit</button>
                                      </a>

                                      <a href="/track-property/{{$dat->id}}">
                                          <button class="btn btn-primary ml-2">Track</button>
                                      </a>


                                    </td>
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
            <script>
    $(document).on('click', '.send-btn', function () {
        const propertyId = $(this).data('id');
        const selectedType = $(this).siblings('.request-type').val();

        if (!selectedType) {
            alert("Please select a request type.");
            return;
        }

        // Construct URL
        const url = `/transfer-file/${propertyId}?type=${encodeURIComponent(selectedType)}`;

        // Redirect
        window.location.href = url;
    });
</script>
    </div>
</x-app-layout>
