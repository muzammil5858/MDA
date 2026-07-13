<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        i { position: relative; font-size: 16px; }
        .detail { font-size: 18px; }
        .delete { font-size: 18px; }
        i:hover { cursor: pointer; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Properties List</h3>
                        </div>
                        <div class="card-body">
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
                                    <tr>
                                        <td>1</td>
                                        <td>MDHA-0012</td>
                                        <td><a href="#">R-14</a></td>
                                        <td>Residential</td>
                                        <td>Johar Town</td>
                                        <td>B</td>
                                        <td>Property Transfer</td>
                                        <td class="d-flex justify-center">
                                            <a href="/frontdesk-check-objections"><button class="btn btn-primary">View Detail</button></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>MDHA-0047</td>
                                        <td><a href="#">C-22</a></td>
                                        <td>Commercial</td>
                                        <td>Model Town</td>
                                        <td>D</td>
                                        <td>Warassat Transfer</td>
                                        <td class="d-flex justify-center">
                                            <a href="#"><button class="btn btn-primary">View Detail</button></a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>MDHA-0089</td>
                                        <td><a href="#">A-05</a></td>
                                        <td>Residential</td>
                                        <td>Gulberg</td>
                                        <td>A</td>
                                        <td>Hiba Transfer</td>
                                        <td class="d-flex justify-center">
                                            <a href="#"><button class="btn btn-primary">View Detail</button></a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>MDHA-0103</td>
                                        <td><a href="#">F-31</a></td>
                                        <td>Commercial</td>
                                        <td>Johar Town</td>
                                        <td>F</td>
                                        <td>Property Transfer</td>
                                        <td class="d-flex justify-center">
                                            <a href="#"><button class="btn btn-primary">View Detail</button></a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>MDHA-0156</td>
                                        <td><a href="#">G-08</a></td>
                                        <td>Residential</td>
                                        <td>Samanabad</td>
                                        <td>C</td>
                                        <td>Warassat Transfer</td>
                                        <td class="d-flex justify-center">
                                            <a href="#"><button class="btn btn-primary">View Detail</button></a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>MDHA-0201</td>
                                        <td><a href="#">B-17</a></td>
                                        <td>Industrial</td>
                                        <td>Model Town</td>
                                        <td>B</td>
                                        <td>Property Transfer</td>
                                        <td class="d-flex justify-center">
                                            <a href="#"><button class="btn btn-primary">View Detail</button></a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>MDHA-0278</td>
                                        <td><a href="#">E-44</a></td>
                                        <td>Residential</td>
                                        <td>Gulberg</td>
                                        <td>E</td>
                                        <td>Hiba Transfer</td>
                                        <td class="d-flex justify-center">
                                            <a href="#"><button class="btn btn-primary">View Detail</button></a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
                    "autoWidth": false
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    </div>
</x-app-layout>
