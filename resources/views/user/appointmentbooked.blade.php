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
                              <h3 class="text-center">Appointment Details</h3>
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
                                  <th>Appointment Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>code-123</td>
                                        <td>Plot-32</td>
                                        <td>Plot</td>
                                        <td>New Ahmad pur Siakh</td>
                                        <td>A</td>
                                        <td>05 December,2024 09:00 AM</td>
                                    </tr>
                                {{-- @foreach($properties as $dat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$dat->code}}
                                    </td>
                                    <td><a href="{{route('formDetail',$dat->id)}}">{{$dat->plot_no}}</a></td>
                                    <td>{{$dat->category}}</td>
                                    @php
                                      $town = DB::table('towns')->where('id',$dat->town)->first();
                                    @endphp
                                    <td>{{$town->name}}</td>
                                    <td>{{$dat->sector}}</td>
                                    <td class="d-flex"><a href="/transfer-file/{{$dat->id}}"><button class="btn btn-primary">Transfer</button></a>
                                      <form action="/book-appointment" method="GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$dat->town}}">
                                        <button type="submit" class="btn btn-primary ml-2">Appointment</button>
                                      </form>
                                    </td>
                                    {{-- <td>{{$dat->attachement ? 'Attachement' : ''}}</td> --}}
                                    {{-- <td><a href="{{route('formEdit',$dat->id)}}"><i class="far fa-edit edit" data-toggle="tooltip" data-placement="top" title="edit"></i></a><a href="{{route('formDetail',$dat->id)}}"><i class="fa fa-wpforms ml-3 detail"  data-toggle="tooltip" data-placement="top" title="view detail"></i></a><a href="{{route('formDelete',$dat->id)}}"><i class="fa fa-trash ml-3 delete" aria-hidden="true"></i></a></td> 
                                </tr>
                                @endforeach --}}
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
</x-app-layout>