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
                          @if(Request::is('appointment-book-list'))
                          <div class="row">
                            <span class="text-bold ml-2">NOTE:  </span> You Can only Book Appointment when your transfer request is accepted.  
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
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($properties as $dat)
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
                                    <td class="d-flex justify-center">
                                      @if(Request::is('properties-list'))
                                      <a href="/transfer-file/{{$dat->id}}"><button class="btn btn-primary">Transfer</button></a>
                                      @elseif(Request::is('appointment-book-list'))
                                      @if($status && $status->verify_status == 'Yes')
                                      <form action="/book-appointment" method="GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$dat->town}}">
                                        <button type="submit" class="btn btn-primary ml-2">Appointment</button>
                                      </form>
                                      @endif
                                      @elseif(Request::is('track-application'))
                                      <a href="/track-property/{{$dat->id}}"><button class="btn btn-primary">Track</button></a>
                                      @endif
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
    </div>
</x-app-layout>