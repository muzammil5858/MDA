<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <head>
                    <link rel='stylesheet'
                        href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css'>
                    <link rel='stylesheet'
                        href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css'>
                    <link rel='stylesheet'
                        href='https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/css/mdb.min.css'>

                    <link rel="stylesheet" href="https://code.jquery.com/qunit/qunit-2.16.0.css" />
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/21.1.4/css/dx.light.css"
                        rel="stylesheet" />
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.0.0/jspdf.umd.min.js"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/21.1.4/js/dx.all.js"></script>

                    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js">
                    </script>
                </head>

                <style>
                    .dxcaption {
                        font-weight: 900;
                    }

                    .button {
                        border: none;
                        color: white;
                        padding: 5px 10px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-size: 14px;
                        margin: 2px 1.5px;
                        transition-duration: 0.4s;
                        cursor: pointer;
                    }

                    .button1 {
                        background-color: white;
                        color: black;
                        border: 2px solid #4CAF50;
                        border-radius: 6px;
                    }

                    .button1:hover {
                        background-color: #4CAF50;
                        color: white;
                        border-radius: 6px;
                    }
                </style>
                </header>

                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            @if($type == 'index')
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Daily Indexing Details </h2>
                            @elseif($type == 'entry')
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Daily Entry Details </h2>
                            @elseif($type == 'CSC-5 Entry')
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Daily {{$type}} Details </h2>
                            @elseif($type == 'CSC-5 Indexing')
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Daily {{$type}} Details </h2>
                            @else
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Daily QA Details </h2>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div style="width: 380px; margin-left:auto; margin-right:auto; border-radius: 20px; padding: 20px; border: solid 3px rgba(54, 162, 235, 1);"
                                id="gridContainer">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form action="/excel-sheet" action="get">
                                <div class="ml-2">
                                    <input type="month" name="month" id="">
                                    <button class="btn btn-primary">Download Excel</button>
                                </div>
                            </form>
                            <div class="chartCard">
                                <div class="chartBox">
                                    <canvas id="myChart"></canvas>
                                    {{-- <input type="month" onChange="filterChart(this)">
                                    <button onclick="reset()">Reset</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .bullet {
                            background-color: #cfdaf5;
                        }

                        .profileImage {
                            max-width: 70px;
                            height: auto;
                            display: block;
                            margin-left: auto;
                            margin-right: auto;
                        }

                        .chartCard {
                            padding: 20px;
                        }

                        .chartBox {
                            padding: 20px;
                            border-radius: 20px;
                            border: solid 3px rgba(54, 162, 235, 1);
                            background: white;
                        }
                        table thead tr {
                            padding:0px !important;
                        }
                        table thead tr  th{
                            padding: 0px !important;
                        }
                    </style>
                    <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7mOx8oSLbH71nY/kcoKE+o4s1mqab+4iwoF" crossorigin="anonymous"></script>

                    <script>
                        console.log(@json($appdata));
                        const dataGrid = $('#gridContainer').dxDataGrid({
                            dataSource: @json($appdata),
                            paging: {
                                pageSize: 10,
                            },
                            pager: {
                                showPageSizeSelector: true,
                                allowedPageSizes: [25, 50, 100],
                            },
                            remoteOperations: false,
                            searchPanel: {
                                visible: true,
                                highlightCaseSensitive: true,
                            },
                            groupPanel: {
                                visible: false
                            },
                            grouping: {
                                autoExpandAll: false,
                            },
                            allowColumnReordering: true,
                            rowAlternationEnabled: true,
                            showBorders: true,
                            filterRow: {
                                visible: true,
                            },
                    
                            columns: [{
                                    caption: 'Date',
                                    alignment: 'center',
                                    cssClass: 'bullet',
                                    allowFiltering: true,
                                    wordWrapEnabled: true,
                                    width: 160,
                                    calculateCellValue: function(data) {
                                        let formattedDate =data.date;
                                        
                                        const dateValue = new Date(formattedDate);
                                        // console.log(dateValue);
                                        return dateValue.toDateString().split(' ').slice(1).join(' ');
                                    },
                                    headerCellTemplate: function(header, info) {
                                        $('<div>')
                                            .text(info.column.caption)
                                            .css({
                                                fontWeight: 'bold',

                                            })
                                            .appendTo(header);
                                    },
                                    cellTemplate: function(container, options) {
                                        $('<div>')
                                            .text(options.value)
                                            .css({
                                                whiteSpace: 'normal',
                                                overflow: 'visible',
                                                textOverflow: 'unset',
                                                fontSize: '16px'
                                            })
                                            .appendTo(container);
                                            
                                    }
                                },
                                {
                                    dataField: 'entries',
                                    caption: 'Entries',
                                    alignment: 'center',
                                    cssClass: 'bullet',
                                    allowFiltering: true,
                                    wordWrapEnabled: true,
                                    width: 160,
                                    calculateCellValue: function(data) {
                                        var checkLoggedin = data.entries;
                                        if (checkLoggedin == null) {
                                            return '0';
                                        } else {
                                            return data.entries;
                                        }
                                    },
                                    headerCellTemplate: function(header, info) {
                                        $('<div>')
                                            .text(info.column.caption)
                                            .css({
                                                fontWeight: 'bold'
                                            })
                                            .appendTo(header);
                                    },
                                    cellTemplate: function(container, options) {
                                        console.log(options.data.date);

                                        // $('<a style="" class=""> ')
                                        //     .text(options.value)
                                            
                                        //     .css({
                                        //         whiteSpace: 'normal',
                                        //         overflow: 'visible',
                                        //         textOverflow: 'unset'
                                        //     })
                                        //     .appendTo(container);
                                var link = $('<a>')
                                .text(options.value)
                                .css('cursor', 'pointer','whiteSpace', 'normal',
                                                'overflow', 'visible',
                                                'textOverflow', 'unset'
                                    )
                                .on('click', function() {
                                    var backdrop = $('<div class="modal-backdrop fade show"></div>').appendTo('body');
                                    var modalContent = $('<div class="styled-modal">')
                                        .css({
                                            'position': 'fixed',
                                            'top': '50%',
                                            'left': '50%',
                                            'transform': 'translate(-50%, -50%)',
                                            'padding': '20px',
                                            'background-color': '#f8f9fa',
                                            'border': '1px solid #d6d8db',
                                            'border-radius': '5px',
                                            'box-shadow': '0 2px 10px rgba(0, 0, 0, 0.1)',
                                            'max-width': '80%', // Adjusted width for better responsiveness
                                            'max-height': '80%', // Added max-height to allow scrolling
                                            'overflow-y': 'auto', // Enable vertical scrolling
                                            'margin': '0 auto',
                                            'text-align': 'center',
                                            'z-index': '1050'
                                        });

                                    var modalText = $('<p>')
                                        .text('Details for ' + options.value + ' applications on ' + options.data.date + ':')
                                        .css({
                                            'font-size': '14px',
                                            'margin-bottom': '15px'
                                        });
                                      
                                        var detailsTable = $('<table>')
                                        .addClass('table'); // Add Bootstrap table class or customize as needed

                                    // Add table header
                                    var tableHeader = $('<thead>')
                                        .append($('<tr>')
                                            .append($('<th>').text('Person'))
                                            .append($('<th>').text('Entries')));

                                    // Add table body
                                    var tableBody = $('<tbody>');

                                    // Assuming you have a PHP variable $usersDistrictDetails with the detailed data
                                    // Replace this with your actual variable or fetch the data in some other way
                                        let type = @json($type);
                                    $.ajax({
                                    url: '/daily-detail',
                                    type: 'GET',
                                    data: {date : options.data.date,type : type},
                                    dataType: 'JSON',
                                    success: function(data) {
                                        var selectedDetails = data
                                    console.log(selectedDetails);
                                    // Iterate over the details and append them to the table body
                                    for (var i = 0; i < selectedDetails.length; i++) {
                                        var detail = selectedDetails[i];
                                        var tableRow = $('<tr>')
                                            .append($('<td style="padding:10px;">').text(detail.name))
                                            .append($('<td style="padding:10px;">').text(detail.entries));
                                        tableBody.append(tableRow);
                                    }
                                    }
                                    });
                                    

                                    // Filter details for the selected date
                                    

                                    detailsTable.append(tableHeader, tableBody);

                                    var closeButton = $('<button>')
                                        .text('Close')
                                        .on('click', function() {
                                            // Close the modal and remove the backdrop
                                            modalContent.fadeOut('fast', function() {
                                                $(this).remove();
                                                backdrop.remove();
                                            });
                                        })
                                        .css({
                                            'padding': '10px 15px',
                                            'background-color': '#D11A2A',
                                            'border': 'none',
                                            'color': '#fff',
                                            'cursor': 'pointer',
                                            'border-radius': '3px',
                                            'font-size': '14px'
                                        });

                                    modalContent.append(modalText, detailsTable, closeButton);

                                    // Append the styled modal content to the body
                                    $('body').append(modalContent);    
                                        
                                    });
                                container.append(link);
                                },
                            }
                            ],

                            headerFilter: {
                                visible: true,
                                allowSearch: true,
                                showRelevantValues: true,
                            },
                            onContentReady: function(e) {
                                $(e.element).find('.dx-datagrid-headers .bullet').css('background-color', '#F0F8FF');
                            },



                        }).dxDataGrid('instance');

                        function hellno(that){
                                              console.log(that);
                                            }

                        
                    </script>
                    <script>
                       let type;
                       if(@json($type) == 'index'){
                        type = 'Indexing';
                       }
                       else if(@json($type) == 'entry'){
                        type = 'Entries'
                       }
                       else{
                        type = 'QA of Entries'
                       }
                        const data = {
                            labels: @json($labels).map(dateStr => {
                                        if(@json($type) == 'index'){
                                            return dateStr;
                                        }
                                        else{

                                            // Split the date string into [day, month, year]
                                        const [day, month, year] = dateStr.split('-');
                                        // Return the formatted date as 'yyyy-mm-dd'
                                        return `${year}-${month}-${day}`;
                                    }
                                    }),
                            datasets: [{
                                label: type,
                                data: @json($data),
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(70, 130, 180, 0.2)',
                                    'rgba(100, 149, 237, 0.2)',
                                    'rgba(135, 206, 250, 0.2)',
                                    'rgba(0, 0, 128, 0.2)',
                                    'rgba(30, 144, 255, 0.2)',
                                    'rgba(25, 25, 112, 0.2)',
                                    'rgba(70, 130, 180, 0.2)',
                                    'rgba(0, 0, 205, 0.2)',
                                    'rgba(0, 0, 139, 0.2)',
                                    'rgba(0, 0, 255, 0.2)',
                                    'rgba(65, 105, 225, 0.2)',
                                    'rgba(0, 0, 128, 0.2)',
                                    'rgba(0, 191, 255, 0.2)',
                                    'rgba(0, 0, 205, 0.2)',
                                    'rgba(70, 130, 180, 0.2)',
                                    'rgba(100, 149, 237, 0.2)',
                                    'rgba(25, 25, 112, 0.2)',
                                    'rgba(0, 0, 128, 0.2)',
                                    'rgba(135, 206, 250, 0.2)',
                                    'rgba(0, 0, 255, 0.2)',
                                    'rgba(65, 105, 225, 0.2)',
                                    'rgba(0, 191, 255, 0.2)',
                                    'rgba(30, 144, 255, 0.2)',
                                    'rgba(0, 0, 139, 0.2)',
                                    'rgba(0, 0, 205, 0.2)',
                                    'rgba(0, 0, 128, 0.2)',
                                    'rgba(100, 149, 237, 0.2)',
                                    'rgba(70, 130, 180, 0.2)',
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(70, 130, 180, 1)',
                                    'rgba(100, 149, 237, 1)',
                                    'rgba(135, 206, 250, 1)',
                                    'rgba(0, 0, 128, 1)',
                                    'rgba(30, 144, 255, 1)',
                                    'rgba(25, 25, 112, 1)',
                                    'rgba(70, 130, 180, 1)',
                                    'rgba(0, 0, 205, 1)',
                                    'rgba(0, 0, 139, 1)',
                                    'rgba(0, 0, 255, 1)',
                                    'rgba(65, 105, 225, 1)',
                                    'rgba(0, 0, 128, 1)',
                                    'rgba(0, 191, 255, 1)',
                                    'rgba(0, 0, 205, 1)',
                                    'rgba(70, 130, 180, 1)',
                                    'rgba(100, 149, 237, 1)',
                                    'rgba(25, 25, 112, 1)',
                                    'rgba(0, 0, 128, 1)',
                                    'rgba(135, 206, 250, 1)',
                                    'rgba(0, 0, 255, 1)',
                                    'rgba(65, 105, 225, 1)',
                                    'rgba(0, 191, 255, 1)',
                                    'rgba(30, 144, 255, 1)',
                                    'rgba(0, 0, 139, 1)',
                                    'rgba(0, 0, 205, 1)',
                                    'rgba(0, 0, 128, 1)',
                                    'rgba(100, 149, 237, 1)',
                                    'rgba(70, 130, 180, 1)',
                                ],
                                borderWidth: 1
                            }]
                        };
                        const currentDate = new Date();
                        const currentMonth = currentDate.getMonth() + 1;
                        const currentYear = currentDate.getFullYear();
                        const config = {
                            type: 'bar',
                            data,
                            options: {
                                scales: {
                                    x: {
                                        min: `${currentYear}-${currentMonth}-01`,
                                        max: `${currentYear}-${currentMonth}-31`,
                                        type: 'time',
                                        time: {
                                            unit: 'day'
                                        }
                                    },
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };


                        const myChart = new Chart(
                            document.getElementById('myChart'),
                            config
                        );

                        function filterChart(date) {
                            const year = date.value.substring(0, 4);
                            const month = date.value.substring(5, 7);
                            

                            const lastDay = (y, m) => {
                                return new Date(y, m, 0).getDate()
                            };
                            lastDay(year, month);

                            const startDate = `${date.value}-01`;
                            const endDate = `${date.value}-${lastDay(year,month)}`;

                            myChart.config.options.scales.x.min = startDate;
                            myChart.config.options.scales.x.max = endDate;
                            myChart.update();
                        }

                        function reset() {
                            const currentDate = new Date();
                            const currentMonth = currentDate.getMonth() + 1;
                            const currentYear = currentDate.getFullYear();
                            myChart.config.options.scales.x.min = `${currentYear}-${currentMonth}-01`;
                            myChart.config.options.scales.x.max = `${currentYear}-${currentMonth}-31`;
                            myChart.update();
                        }
                    </script>
                </div>
            </div>

            </p>

        </div>



    </div>

    </div>
    </div>




</x-app-layout>
