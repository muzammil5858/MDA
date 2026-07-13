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
        i:hover{
            cursor: pointer;
           
        }
        
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                        
                    <div class="card">
                            <div class="card-header">
                              <h3 class="text-center">{{$heading}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              <div class="row">
                                <div id="dataGrid"></div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>
                    </div>

                </div>
            </div>
        
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script src="https://cdn3.devexpress.com/jslib/23.1.3/js/dx.all.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.9/jspdf.plugin.autotable.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/21.1.4/css/dx.light.css" rel="stylesheet" />
            <script>
      
              var i = 0;
              var datasource = @json($data);
              console.log(datasource);
               const dataGrid =  $("#dataGrid").dxDataGrid({
                  
                dataSource: datasource,
              //   filterRow: { visible: true },
              paging: {
                      pageSize: 20,
                  },
              pager: {
                      showPageSizeSelector: true,
                      allowedPageSizes: [20, 40, 60],
                },
      
              searchPanel: { visible: true },
              // filterRow:{visible:true},
                columns:[{
                dataField: '',
                caption: "#", // provides actual values
                cssClass: "bullet",
                alignment:'center',
                width:60,
                cellTemplate: function(container, options) {
                                                      var pageIndex = dataGrid.pageIndex();
                                                      var pageSize = dataGrid.pageSize();
                                                      var rowIndex = (pageIndex * pageSize) + options.rowIndex + 1;
                                                      console.log(rowIndex);
      
                                                      $('<div>')
                                                          .text(rowIndex)
                                                          .appendTo(container);
                                                  }
      
                },{
              dataField: "town",
              caption: "Town", // provides actual values
              cssClass: "bullet",
              alignment:'center',
              // allowHeaderFiltering: false,
          },{
                dataField: "sector",
                caption: "Sector", // provides actual values
                cssClass: "bullet",
                alignment:'center',
                width:150,
                // allowHeaderFiltering: false,
              
              },{
              dataField: "center",
              caption: "Tehsil", // provides actual values
              cssClass: "bullet",
              alignment:'center',
              width:140,
              // allowFiltering: true,
              // allowHeaderFiltering: true,
      
                },{
                  dataField: 'code',
                  caption: 'Code',
                  cssClass: 'bullet',
                  alignment: 'center',
                  width:160,
                  allowHeaderFiltering: false,
                  
                }
                ,{
                  dataField: 'plot_no',
                  caption: 'Plot No',
                  cssClass: 'bullet',
                  alignment: 'center',
                  width:160,
                 allowHeaderFiltering: false,
                  
                },{
                    caption: "Action",
                    cssClass: 'bullet',
                    cellTemplate: function (container, options) {
                        const id = options.data.id;
                        container.append(`
                            <a href="/form-edit/${id}"><i class="far fa-edit edit" data-toggle="tooltip" data-placement="top" title="edit"></i></a>
                            <a href="/view-property-detail/${id}" class="ml-3 detail" title="view detail">
                                <i class="fa fa-wpforms"></i>
                            </a>
                        `);
                    },}],
                onContentReady: function (e) {
                                $(e.element).find('.dx-datagrid-headers .bullet').css('background-color', 'lightblue').css('color','white').css('font-weight','bold').css('font','28px').css('text-align','center').css('word-wrap','break-word');
                
                                $(e.element).find('.dx-datagrid-content').css('text-align','center');
                              },
                            headerFilter: {
                      visible: true,
                      // allowSearch: true,
                      showRelevantValues: true,
                  },
                allowColumnReordering: true,
                allowColumnResizing: true,
                rowAlternationEnabled:true,
                columnAutoWidth: true, 
                showBorders:true,  
                width: "100%" ,
                
              }).dxDataGrid("instance");;
           
          </script>

    </div>
</x-app-layout>