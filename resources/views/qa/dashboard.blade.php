<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        body { background-color: #d7d7d7 !important; }
        .town-col { width: 5%; min-width: 100px; max-width: 200px; }
        .title h3 { font-size: 1.6vw !important; font-weight: bold; padding: 10px; }
        .inner h3 { font-size: 1.40rem !important; }
        .inner p  { font-size: 1.1rem !important; display: inline-block; margin-right: 10px; }
        .inner p span { margin-right: 15px; }
        h4 { font-size: 1.2vw !important; }

        .tabs3.active {
            background-color: #007bff !important;
            color: white !important;
            box-shadow: none !important;
        }

        .small-box { min-height: 70px; }
        .pie-chart-canvas { max-width: 400px; max-height: 400px; }
        .equal-height-card { height: 500px; display: flex; flex-direction: column; }
        .equal-height-card .card-body { flex: 1; display: flex; justify-content: center; align-items: center; }
        #second-card-title h3 { opacity: 0 !important; }

        .main-table-container {
            margin-bottom: 25px;
            margin-top: -40px;
            margin-left: 13px;
            margin-right: 13px;
        }

        .table-section { animation: fadeIn 0.5s ease-in-out; }
        .table-section.hide { animation: fadeOut 0.5s ease-in-out forwards; }

        .table-name {
            font-size: 18px; font-weight: 600; color: #1a3c6d;
            background: linear-gradient(90deg, #007bff, #00c4ff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            margin-bottom: 10px; display: inline-block;
        }

        .table-section table {
            width: 80%; max-width: 1000px; margin: 0 auto;
            border-collapse: separate; border-spacing: 0;
            font-size: 15px; table-layout: fixed;
            overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .table-section th,
        .table-section td {
            width: 25%; padding: 12px 15px;
            text-align: left; font-weight: 600;
        }

        .table-section th {
            background: linear-gradient(90deg, #66b2ff, #3399ff);
            color: #ffffff;
        }

        .table-section td {
            border: 1px solid #e9ecef;
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        .table-section tr:hover td { background-color: #e9ecef; }
        .table-section th:last-child { border-top-right-radius: 8px; }
        .table-section tr:last-child td:first-child { border-bottom-left-radius: 8px; }
        .table-section tr:last-child td:last-child  { border-bottom-right-radius: 8px; }

        .d-none { display: none !important; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .clickable-span { cursor: pointer; }
        .clickable-span:hover { color: #0056b3; }

        .table-section th.district-header {
            background: none; color: black; font-size: 30px;
            font-weight: normal; text-align: center; padding: 10px;
            border-top-left-radius: 8px; border-top-right-radius: 8px;
        }

        .main-table-container table td:first-child { width: 150px !important; white-space: nowrap; }

        .dropdown { margin-left: auto; }
        .dropdown-toggle { font-size: 14px; line-height: 1; background: transparent; border: none; padding: 0; }
        .dropdown-toggle::after { display: none !important; }
        .dropdown-menu { font-size: 13px; min-width: 100px; }

        .sector-row td { background-color: #d1cccc; font-style: italic; color: #333; }

        .size-btn {
            background-color: #f0f0f0; color: #000;
            border: 1px solid #ccc; padding: 8px 16px;
            cursor: pointer; margin: 5px; border-radius: 4px;
            font-size: 0.9rem;
        }
        .size-btn.active { background-color: #3498DB; color: #fff; }

        canvas { pointer-events: auto; }
    </style>

    <body style="background-color: #d7d7d7;">
        <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #d7d7d7 !important;">

            <input type="hidden" id="totalProperties"   value="{{ $totalProperties }}">
            <input type="hidden" id="categoryData"      value="{{ json_encode($categoryData) }}">
            <input type="hidden" id="townCategoryData"  value="{{ json_encode($orderedTownCategoryData) }}">

            <div class="row mt-2">
                <div class="col title" style="display:flex;justify-content:center; margin-right:40px;">
                    <h3>MANGLA DAM HOUSING AUTHORITY (MDHA)</h3>
                </div>
            </div>

            <div class="row mx-2 mb-1">
                <div class="col-lg-4 col-6 text-center p-2 tabs3"
                    style="box-shadow:0px 0px 10px rgb(209,209,209) inset; cursor:pointer; background-color:#f5f5f5;"
                    data-tab="properties">Properties</div>
                <div class="col-lg-4 col-6 text-center p-2 tabs3"
                    style="box-shadow:0px 0px 10px rgb(209,209,209) inset; cursor:pointer; background-color:#f5f5f5;"
                    data-tab="transfer">Transfer & Other Request's</div>
                <div class="col-lg-4 col-6 text-center p-2 tabs3"
                    style="box-shadow:0px 0px 10px rgb(209,209,209) inset; cursor:pointer; background-color:#f5f5f5;"
                    data-tab="complaints">Complaints/Suggestions</div>
            </div>

            <div class="row px-2 py-3" id="card-row">
                <div class="card-tile col-lg-4 col-md-6 col-12 mb-3" id="card-1">
                    <div class="small-box bg-info">
                        <div class="inner" id="first-card-content">
                            <h3 id="first-card-title">Properties</h3>
                            <p id="first-card-text">
                                <span>Total: {{ $totalProperties }}</span><br>
                                <span>Town Wise Detail</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-tile col-lg-4 col-md-6 col-12 mb-3" id="card-2">
                    <div class="small-box bg-success">
                        <div class="inner" id="second-card-content">
                            <h3 id="second-card-title">Size Wise Breakdown</h3>
                            <p id="second-card-text"></p>
                        </div>
                    </div>
                </div>
                <div class="card-tile col-lg-4 col-md-6 col-12 mb-3" id="card-3">
                    <div class="small-box bg-warning">
                        <div class="inner" id="third-card-content">
                            <h3 id="third-card-title" style="color:white;"></h3>
                            <p  id="third-card-text"  style="color:white;"></p>
                        </div>
                    </div>
                </div>
                <div class="card-tile col-lg-4 col-md-6 col-12 mb-3 d-none" id="card-4">
                    <div class="small-box bg-danger">
                        <div class="inner" id="fourth-card-content">
                            <h3 id="fourth-card-title" style="color:white;"></h3>
                            <p  id="fourth-card-text"  style="color:white;"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Size Breakdown -->
            <div id="size-breakdown-row" class="row px-1 d-none"
                style="margin-top:-12px; margin-left:2px; margin-right:2px; margin-bottom:50px;">
                @foreach ($sizeCounts as $label => $count)
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
                        <div class="small-box bg-secondary p-2" style="min-height:auto; height:auto;">
                            <div class="inner text-center p-1" style="margin:0;">
                                <h4 class="mb-1" style="font-size:1.1rem;">{{ $label }}: {{ $count }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Allotment Row -->
            <div id="allotment-row" class="row px-1"
                style="margin-top:-12px; margin-left:2px; margin-right:2px; margin-bottom:50px;">
                @php
                    $labels = [
                        'Original Allottee' => $allotmentStages->original_allottee,
                        '1st Transfer'      => $allotmentStages->first_transfer,
                        '2nd Transfer'      => $allotmentStages->second_transfer,
                        '3rd Transfer'      => $allotmentStages->third_transfer,
                        '4th Transfer'      => $allotmentStages->fourth_transfer,
                        '5th Transfer'      => $allotmentStages->fifth_transfer,
                    ];
                @endphp
                @foreach ($labels as $label => $count)
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-2 stage-box"
                        data-stage="{{ $label }}" style="cursor:pointer; color:#333 !important">
                        <div class="small-box bg-secondary p-2" style="height:30px;">
                            <div class="inner text-center p-1" style="margin:0;">
                                <h4 class="mb-1" style="font-size:1rem;">{{ $label }}</h4>
                                <p class="mb-0" style="font-size:1.3rem; font-weight:bold;">{{ $count }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="stage-details" style="margin-top:-40px; margin-bottom:20px; position:relative; z-index:2;"></div>

            <!-- ═══════════════════════════════════════════════
                 MAIN TABLE CONTAINER
                 5 dynamic status tables + Data Review + Town Wise
            ════════════════════════════════════════════════ -->
            <div class="main-table-container">

               @php
$tables = [
    'new' => [
        'label'      => 'Total REQUEST',
        'town_total' => 'total_requests',
        'town_trans' => 'total_transfer',
        'town_war'   => 'total_warassat',
        'town_hibba' => 'total_hibba',
    ],
    'completed' => [
        'label'      => 'COMPLETED REQUEST',
        'town_total' => 'completed_total',
        'town_trans' => 'completed_transfer',
        'town_war'   => 'completed_warassat',
        'town_hibba' => 'completed_hibba',
    ],
    'inprocess' => [
        'label'      => 'IN PROCESS REQUEST',
        'town_total' => 'inprocess_total',
        'town_trans' => 'inprocess_transfer',
        'town_war'   => 'inprocess_warassat',
        'town_hibba' => 'inprocess_hibba',
    ],
    'pending' => [
        'label'      => 'PENDING REQUEST',
        'town_total' => 'pending_total',
        'town_trans' => 'pending_transfer',
        'town_war'   => 'pending_warassat',
        'town_hibba' => 'pending_hibba',
    ],
    'rejected' => [
        'label'      => 'REJECTED REQUEST',
        'town_total' => 'rejected_total',
        'town_trans' => 'rejected_transfer',
        'town_war'   => 'rejected_warassat',
        'town_hibba' => 'rejected_hibba',
    ],
    'overdue' => [
        'label'      => 'OVERDUE REQUEST',
        'town_total' => 'overdue_total',
        'town_trans' => 'overdue_transfer',
        'town_war'   => 'overdue_warassat',
        'town_hibba' => 'overdue_hibba',
    ],
];
@endphp

@foreach($tables as $status => $cfg)

<div class="table-section d-none" id="{{ $status }}-table">

    {{-- Table Title --}}
    <div style="display:flex; justify-content:center; align-items:center; margin-bottom:0.75rem;">
        <strong style="font-size:1.2rem;">{{ $cfg['label'] }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>Town/Sector</th>
                <th>Total</th>
                <th>Sale / Purhace Transfer
                <th>Warassat Transfer</th>
                <th>Hiba Transfer</th>
            </tr>
        </thead>
        <tbody>

        @foreach($townStats as $town)

            {{-- Town Row --}}
            <tr class="town-row" style="cursor:pointer;"
                onclick="toggleTown('{{ $status }}-{{ $town->town_id }}')">
                <td style="width:250px; white-space:nowrap;">
                    <span class="me-2">{{ $town->town_name }}</span>
                    <i class="bi bi-chevron-right"
                       id="arrow-{{ $status }}-{{ $town->town_id }}"
                       style="font-size:11px; color:#888; transition:transform 0.2s;"></i>
                </td>
                <td class="text-center">{{ $town->{$cfg['town_total']} ?? 0 }}</td>
                <td class="text-center">{{ $town->{$cfg['town_trans']} ?? 0 }}</td>
                <td class="text-center">{{ $town->{$cfg['town_war']}   ?? 0 }}</td>
                <td class="text-center">{{ $town->{$cfg['town_hibba']} ?? 0 }}</td>
            </tr>

            {{-- Sector Rows (hidden by default, shown on town click) --}}
            @if(!empty($sectorStats[$town->town_id]))
                @foreach($sectorStats[$town->town_id] as $sector)
                <tr class="sector-row d-none sector-{{ $status }}-{{ $town->town_id }}">
                    <td style="padding-left:35px; white-space:nowrap;">
                        <i class="bi bi-dot" style="color:#2980b9;"></i>
                        {{ $sector->sector_name }}
                    </td>
                    <td class="text-center">{{ $sector->{$cfg['town_total']} ?? 0 }}</td>
                    <td class="text-center">{{ $sector->{$cfg['town_trans']} ?? 0 }}</td>
                    <td class="text-center">{{ $sector->{$cfg['town_war']}   ?? 0 }}</td>
                    <td class="text-center">{{ $sector->{$cfg['town_hibba']} ?? 0 }}</td>
                </tr>
                @endforeach
            @endif

        @endforeach

        </tbody>
    </table>
</div>

@endforeach

                <!-- DATA REVIEW TABLE -->
                <div class="table-section d-none" id="data-review-row">
                    <div class="table-name"></div>
                    <table class="table table-bordered" style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th colspan="8" class="district-header" style="text-align:center; padding:10px;">
                                    <strong>DATA REVIEW SUMMARY</strong>
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="2" style="vertical-align:middle; text-align:center; padding:8px;">Clerk Name</th>
                                <th rowspan="2" style="vertical-align:middle; text-align:center; padding:8px;">Review Entries</th>
                                <th colspan="4" style="text-align:center; padding:8px;">Types</th>
                                <th rowspan="2" style="vertical-align:middle; text-align:center; padding:8px;">No Error</th>
                                <th rowspan="2" style="vertical-align:middle; text-align:center; padding:8px;">Resolved</th>
                            </tr>
                            <tr>
                                <th style="text-align:center; padding:8px;">Document Missing</th>
                                <th style="text-align:center; padding:8px;">Blur Document</th>
                                <th style="text-align:center; padding:8px;">Wrong Attachment</th>
                                <th style="text-align:center; padding:8px;">Wrong Center</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataReviewSummary as $row)
                            <tr>
                                <td style="text-align:center;">{{ $row->clerk_name }}</td>
                                <td style="text-align:center;">
                                    <a href="{{ route('Qafiles', ['qa_id' => $row->user_id]) }}">{{ $row->review_entries }}</a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('Qafiles', ['qa_id' => $row->user_id, 'status' => 'Document Missing']) }}">{{ $row->document_missing }}</a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('Qafiles', ['qa_id' => $row->user_id, 'status' => 'Blur Document']) }}">{{ $row->blur_document }}</a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('Qafiles', ['qa_id' => $row->user_id, 'status' => 'Wrong Attachment']) }}">{{ $row->wrong_attachment }}</a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('Qafiles', ['qa_id' => $row->user_id, 'status' => 'Wrong Center']) }}">{{ $row->wrong_entry }}</a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('Qafiles', ['qa_id' => $row->user_id, 'status' => 'No Error']) }}">{{ $row->no_error }}</a>
                                </td>
                                <td style="text-align:center;">{{ $row->resolved }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>{{-- end .main-table-container --}}

            <!-- TOWN WISE DETAIL TABLE -->
            <div class="table-section d-none" id="town-wise-detail-row" style="margin-bottom:50px; margin-top:1px;">
                <div class="table-name"></div>
                <table class="table table-bordered" style="width:100%; border-collapse:collapse;">
                    <colgroup>
                        <col class="town-col"><col><col><col><col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="5" class="district-header" style="text-align:center; padding:10px;">
                                <strong>TOWN WISE DETAIL</strong>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align:center;">Town</th>
                            <th style="text-align:center;">Properties</th>
                            <th style="text-align:center;">Plots</th>
                            <th style="text-align:center;">House</th>
                            <th style="text-align:center;">Commercial</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($townWiseDetailsGrouped as $town)
                        <tr class="town-row" data-town-id="{{ $town['id'] }}"
                            data-sector-order="{{ $town['sectors'] }}"
                            data-sector-data="{{ json_encode($town['sector_data']) }}">
                            <td style="white-space:nowrap;">
                                <span class="me-5">{{ $town['name'] }}</span>
                                <button class="btn btn-sm p-0 ms-2 bg-transparent border-0 sector-toggle"
                                    type="button" data-town="{{ $town['id'] }}" title="Toggle Sectors">
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                            </td>
                            <td>{{ $town['total_properties'] }}</td>
                            <td>{{ $town['plot_count'] }}</td>
                            <td>{{ $town['house_count'] }}</td>
                            <td>{{ $town['commercial_count'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>{{-- end overflow-hidden --}}

        <!-- Charts -->
        <div class="col-lg-12" style="margin-top:30px;">
            <div class="row px-2 py-3" style="margin-top:-25px;">
                <div class="col-lg-6">
                    <div class="card card-info equal-height-card">
                        <div class="card-header">
                            <h3 class="card-title">MDHA-Total Representation</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <canvas id="pieChart" width="250" height="250" class="pie-chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-success equal-height-card">
                        <div class="card-header">
                            <h3 class="card-title">MDHA-Town Wise</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <canvas id="barChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-info" id="center">
                <div class="card-header">
                    <h3 class="card-title" id="title-graph">MDHA- Sector Wise</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bar" style="max-height:500px; max-width:100%; pointer-events:auto;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-12" style="width:calc(100% - 250px); margin-left:250px;">
            <div class="card card-success" id="center">
                <div class="card-header">
                    <h3 class="card-title" id="title-graph">MDHA - Size Wise Representation</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @foreach ($sizes as $label => $value)
                            <button class="btn btn-outline-dark mx-1 size-btn" data-size="{{ $label }}">{{ $label }}</button>
                        @endforeach
                    </div>
                    <canvas id="sectorTownChart" style="max-height:500px; max-width:100%; pointer-events:auto;"></canvas>
                </div>
            </div>
        </div>

    </body>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleTown(key) {
            const rows  = document.querySelectorAll('.sector-' + key);
            const arrow = document.getElementById('arrow-' + key);

            rows.forEach(r => r.classList.toggle('d-none'));

            if (arrow) {
                arrow.style.transform =
                    arrow.style.transform === 'rotate(90deg)' ? '' : 'rotate(90deg)';
            }
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // === DOM ===
        const tabs             = document.querySelectorAll('.tabs3');
        const firstCardTitle   = document.getElementById('first-card-title');
        const firstCardText    = document.getElementById('first-card-text');
        const secondCardTitle  = document.getElementById('second-card-title');
        const secondCardText   = document.getElementById('second-card-text');
        const thirdCardTitle   = document.getElementById('third-card-title');
        const thirdCardText    = document.getElementById('third-card-text');

        // All 6 dynamic status tables (+ extras)
        const newTable            = document.getElementById('new-table');
        const completedTable      = document.getElementById('completed-table');
        const inprocessTable      = document.getElementById('inprocess-table');
        const pendingTable        = document.getElementById('pending-table');
        const rejectedTable       = document.getElementById('rejected-table');
        const overdueTable        = document.getElementById('overdue-table');
        const townWiseDetailRow   = document.getElementById('town-wise-detail-row');

        const allotmentRow        = document.getElementById('allotment-row');
        const allotmentDetailRow  = document.createElement('div');
        allotmentDetailRow.id = 'allotment-detail-row';
        allotmentDetailRow.classList.add('mt-3', 'd-none');
        allotmentRow.insertAdjacentElement('afterend', allotmentDetailRow);

        const totalProperties = document.getElementById('totalProperties')?.value || '0';
        const categoryData    = JSON.parse(document.getElementById('categoryData')?.value || '{}');
        const townCategoryData = JSON.parse(document.getElementById('townCategoryData')?.value || '{}');

        let activeSection = null;

        // === Toggle a table section (click same = hide, click different = show) ===
        function toggleSection(section) {
            const isVisible = activeSection === section;

            document.querySelectorAll('.table-section').forEach(t => t.classList.add('d-none'));

            if (!isVisible) {
                section.classList.remove('d-none');
                activeSection = section;
                handleSectorDropdownsDelegated();
            } else {
                activeSection = null;
            }
        }

        // === Card content per tab ===
        function updateCardContent(tabType) {
            const fourthCard = document.getElementById('card-4');
            const allCards   = document.querySelectorAll('.card-tile');

            allCards.forEach(c => {
                c.classList.remove('col-lg-3', 'col-lg-4');
                c.classList.add('col-lg-4');
            });
            fourthCard.classList.add('d-none');

            secondCardText.innerHTML = '';
            thirdCardText.innerHTML  = '';

            // Hide all table sections when switching tabs
            document.querySelectorAll('.table-section').forEach(t => t.classList.add('d-none'));
            activeSection = null;

            if (tabType === 'properties') {
                firstCardTitle.textContent = 'Properties';
                firstCardText.innerHTML    = `<span>Total: ${totalProperties}</span>
                    <span class="clickable-span" id="town-wise-detail-toggle"
                        style="margin-left:80px; cursor:pointer;">Town Wise Detail</span>`;

                secondCardTitle.innerHTML = `<span class="clickable-span" id="size-breakdown-toggle"
                    style="cursor:pointer;">Size Wise Breakdown</span>`;
                secondCardText.innerHTML  = '';

                thirdCardTitle.innerHTML  = `
                    <div style="display:flex; justify-content:flex-start; align-items:center; gap:80px;">
                        <span class="clickable-span" id="allotment-toggle" style="cursor:pointer; margin-left:10px;">Allotment</span>
                        <span class="clickable-span" id="data-review-toggle" style="cursor:pointer;">Data Review</span>
                    </div>`;
                thirdCardText.innerHTML   = '';

                // Attach listeners
                document.getElementById('town-wise-detail-toggle')
                    ?.addEventListener('click', () => toggleSection(townWiseDetailRow));
                document.getElementById('data-review-toggle')
                    ?.addEventListener('click', () => toggleSection(document.getElementById('data-review-row')));

            } else if (tabType === 'transfer') {

                allCards.forEach(c => { c.classList.remove('col-lg-4'); c.classList.add('col-lg-3'); });
                fourthCard.classList.remove('d-none');

                firstCardTitle.textContent = 'Requests';
                firstCardText.innerHTML    = `<span class="clickable-span" id="new-toggle">
                    Total Requests: {{ $stats->total_requests }}</span>`;

                secondCardTitle.textContent = 'Completed';
                secondCardText.innerHTML    = `
                    <span class="clickable-span" id="completed-toggle">Completed: {{ $stats->completed_count }}</span>
                    <span class="mx-2"></span>
                    <span class="clickable-span" id="rejected-toggle">Rejected: {{ $stats->rejected_count }}</span>`;

                thirdCardTitle.textContent = 'In Process';
                thirdCardText.innerHTML    = `<span class="clickable-span" id="inprocess-toggle">
                    In Process: {{ $stats->in_process_count }}</span>`;

                document.getElementById('fourth-card-title').textContent = 'Pending';
                document.getElementById('fourth-card-text').style.whiteSpace = 'nowrap';
                document.getElementById('fourth-card-text').innerHTML    = `
                    <span class="clickable-span" id="pending-toggle">Pending: {{ $stats->pending_new_count }}</span>
                    <span class="mx-2"></span>
                    <span class="clickable-span" id="overdue-toggle">Overdue (5+ Days): {{ $stats->pending_overdue_count }}</span>`;

                // Attach listeners — each maps to its own table
                document.getElementById('new-toggle')       ?.addEventListener('click', () => toggleSection(newTable));
                document.getElementById('completed-toggle') ?.addEventListener('click', () => toggleSection(completedTable));
                document.getElementById('rejected-toggle')  ?.addEventListener('click', () => toggleSection(rejectedTable));
                document.getElementById('inprocess-toggle') ?.addEventListener('click', () => toggleSection(inprocessTable));
                document.getElementById('pending-toggle')   ?.addEventListener('click', () => toggleSection(pendingTable));
                document.getElementById('overdue-toggle')   ?.addEventListener('click', () => toggleSection(overdueTable));

            } else if (tabType === 'complaints') {
                firstCardTitle.textContent  = '';
                firstCardText.innerHTML     = '';
                secondCardTitle.textContent = '';
                secondCardText.innerHTML    = '';
                thirdCardTitle.textContent  = '';
                thirdCardText.innerHTML     = '';
            }
        }

        // === Town row chevron toggle (for new dynamic tables) ===
        window.toggleTown = function(key) {
            const rows  = document.querySelectorAll('.sector-' + key);
            const arrow = document.getElementById('arrow-' + key);
            rows.forEach(r => r.classList.toggle('d-none'));
            if (arrow) {
                arrow.style.transform =
                    arrow.style.transform === 'rotate(90deg)' ? '' : 'rotate(90deg)';
            }
        };

        // === Sector dropdowns for old-style tables (town-wise-detail etc.) ===
        function handleSectorDropdownsDelegated() {
            // Remove any existing listeners to prevent duplicates
            document.body.removeEventListener('click', sectorClickHandler);
            document.body.addEventListener('click', sectorClickHandler);
        }

        function sectorClickHandler(e) {
            const button = e.target.closest('.sector-toggle');
            if (!button) return;

            e.preventDefault();
            e.stopPropagation();

            const townId    = button.dataset.town;
            const dropdown  = button.closest('.table-section');
            if (!dropdown) return;

            const townRow   = dropdown.querySelector(`.town-row[data-town-id="${townId}"]`);
            if (!townRow) return;

            const existingRows = dropdown.querySelectorAll(`.sector-row[data-town="${townId}"]`);
            if (existingRows.length > 0) {
                existingRows.forEach(row => row.remove());
                return;
            }

            const sectorData  = JSON.parse(townRow.dataset.sectorData || '[]');
            const sectorOrder = (townRow.dataset.sectorOrder || '').split(',').map(s => s.trim()).filter(s => s);

            const orderedSectors = sectorOrder.map(sectorName => {
                return sectorData.find(s => s.sector === sectorName) || {
                    sector: sectorName,
                    property_transfer_count: 0,
                    property_mapping_count: 0,
                    noc_count: 0,
                    total_properties: 0,
                    plot_count: 0,
                    house_count: 0,
                    commercial_count: 0
                };
            });

            let lastInsertedRow = townRow;

            orderedSectors.forEach(sector => {
                const newRow = document.createElement('tr');
                newRow.classList.add('sector-row');
                newRow.setAttribute('data-town', townId);

                const isTownWiseDetail = dropdown.id === 'town-wise-detail-row';

                if (isTownWiseDetail) {
                    newRow.innerHTML = `
                        <td style="padding-left: 40px;">${sector.sector}</td>
                        <td>${sector.total_properties ?? 0}</td>
                        <td>${sector.plot_count ?? 0}</td>
                        <td>${sector.house_count ?? 0}</td>
                        <td>${sector.commercial_count ?? 0}</td>
                    `;
                } else {
                    newRow.innerHTML = `
                        <td style="padding-left: 40px;">${sector.sector}</td>
                        <td>${sector.property_transfer_count ?? 0}</td>
                        <td>${sector.property_mapping_count ?? 0}</td>
                        <td>${sector.noc_count ?? 0}</td>
                    `;
                }

                lastInsertedRow.parentNode.insertBefore(newRow, lastInsertedRow.nextSibling);
                lastInsertedRow = newRow;
            });
        }

        allotmentRow.classList.add("d-none");

        document.body.addEventListener('click', function(e) {
            const breakdownRow      = document.getElementById('size-breakdown-row');
            const dataReviewRow     = document.getElementById('data-review-row');
            const townWiseDetailRow = document.getElementById('town-wise-detail-row');
            const allotmentRow      = document.getElementById('allotment-row');
            const stageDetails      = document.getElementById('stage-details');

            const isBreakdownToggle      = e.target.id === 'size-breakdown-toggle'    || e.target.closest('#size-breakdown-toggle');
            const isDataReviewToggle     = e.target.id === 'data-review-toggle'       || e.target.closest('#data-review-toggle');
            const isTabClick             = e.target.classList.contains('tabs3')       || e.target.closest('.tabs3');
            const isButtonClick          = (e.target.tagName === 'BUTTON' || e.target.closest('button')) && !e.target.closest('.sector-toggle');
            const isTownWiseDetailToggle = e.target.id === 'town-wise-detail-toggle'  || e.target.closest('#town-wise-detail-toggle');
            const isAllotmentToggle      = e.target.id === 'allotment-toggle'         || e.target.closest('#allotment-toggle');

            if (isBreakdownToggle) {
                breakdownRow.classList.toggle('d-none');
                dataReviewRow?.classList.add('d-none');
                townWiseDetailRow?.classList.add('d-none');
                allotmentRow?.classList.add('d-none');
                stageDetails.innerHTML = "";
            } else if (isDataReviewToggle) {
                dataReviewRow.classList.toggle('d-none');
                breakdownRow?.classList.add('d-none');
                townWiseDetailRow?.classList.add('d-none');
                allotmentRow?.classList.add('d-none');
                stageDetails.innerHTML = "";
            } else if (isTownWiseDetailToggle) {
                townWiseDetailRow.classList.toggle('d-none');
                breakdownRow?.classList.add('d-none');
                dataReviewRow?.classList.add('d-none');
                allotmentRow?.classList.add('d-none');
                stageDetails.innerHTML = "";
            } else if (isTabClick || isButtonClick) {
                breakdownRow?.classList.add('d-none');
                dataReviewRow?.classList.add('d-none');
                townWiseDetailRow?.classList.add('d-none');
                allotmentRow?.classList.add('d-none');
                stageDetails.innerHTML = "";
            } else if (isAllotmentToggle) {
                allotmentRow.classList.toggle('d-none');
                breakdownRow?.classList.add('d-none');
                dataReviewRow?.classList.add('d-none');
                townWiseDetailRow?.classList.add('d-none');

                if (allotmentRow.classList.contains('d-none')) {
                    stageDetails.innerHTML = "";
                }
            }
        });

        const townStageCounts        = @json($townStageCounts);
        const townWiseDetailsGrouped = @json($townWiseDetailsGrouped);
        const stageKeyMap = {
            'Original Allottee': 'original_allottee',
            '1st Transfer': 'first_transfer',
            '2nd Transfer': 'second_transfer',
            '3rd Transfer': 'third_transfer',
            '4th Transfer': 'fourth_transfer',
            '5th Transfer': 'fifth_transfer'
        };

        document.querySelectorAll(".stage-box").forEach(box => {
            box.style.cursor = "pointer";

            box.addEventListener("click", () => {
                const stageLabel = box.dataset.stage;
                const key = stageKeyMap[stageLabel];
                if (!key) return;

                const container = document.getElementById("stage-details");

                let html = `
                    <div class="card p-3 shadow-sm border-0">
                        <h5 class="text-center mb-3" style="font-size:1.3rem; font-weight:600; color:#333;">
                            ${stageLabel} - Town Wise Detail
                        </h5>
                        <table class="table table-bordered text-center align-middle mb-0">
                            <thead class="table-light" style="font-size:0.95rem; background:#f1f3f5;">
                                <tr>
                                    ${townStageCounts.map(town => `
                                        <th style="padding:6px 10px; cursor:pointer;" class="town-toggle" data-town-id="${town.town_id}">
                                            ${town.town_name}
                                            <span class="dropdown-icon" style="font-size:0.85rem;">▼</span>
                                        </th>
                                    `).join('')}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    ${townStageCounts.map(town => `<td style="padding:6px 10px; font-weight:500;">${town[key] ?? 0}</td>`).join('')}
                                </tr>
                                <tr class="sector-row" style="display:none;">
                                    ${townStageCounts.map(town => {
                                        const townData = townWiseDetailsGrouped.find(t => t.id === town.town_id);
                                        if (!townData) return `<td></td>`;
                                        const sectors = townData.sector_data ?? [];
                                        const sectorHtml = sectors.map(sec => `
                                            <div style="font-size:1rem; margin-bottom:6px; padding:6px 10px; background:#f8f9fa; border-radius:4px;">
                                                <strong>Sector ${sec.sector}</strong>: ${sec[key] ?? 0}
                                            </div>
                                        `).join('');
                                        return `<td>${sectorHtml}</td>`;
                                    }).join('')}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `;

                container.innerHTML = html;

                // Toggle logic for showing/hiding sector row
                setTimeout(() => {
                    const toggleIcon = document.querySelectorAll('.town-toggle');
                    let isVisible = false;

                    toggleIcon.forEach(th => {
                        th.addEventListener('click', () => {
                            const sectorRow = document.querySelector('.sector-row');
                            if (!sectorRow) return;

                            isVisible = !isVisible;
                            sectorRow.style.display = isVisible ? 'table-row' : 'none';

                            const icon = th.querySelector('.dropdown-icon');
                            if (icon) {
                                icon.innerHTML = isVisible ? '▲' : '▼';
                            }
                        });
                    });
                }, 0);
            });
        });

        // === Charts ===
        (function renderPieChart() {
            const ctx = document.getElementById('pieChart')?.getContext('2d');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['House', 'Commercial', 'Plot'],
                    datasets: [{
                        data: [categoryData['House']||0, categoryData['Commercial']||0, categoryData['Plot']||0],
                        backgroundColor: ['#00ADB5','#393E46','#FF5722'],
                        borderColor:     ['#00858A','#2C2F34','#CC471B'],
                        borderWidth: 1
                    }]
                },
                options: { responsive:true, plugins:{ legend:{position:'top'}, tooltip:{enabled:true} } }
            });
        })();

        (function renderTownBarChart() {
            const ctx = document.getElementById('barChart')?.getContext('2d');
            if (!ctx) return;
            const labels = Object.keys(townCategoryData);
            const fullTownNames = {
                'NST Siakh':'New Small Town Siakh','NST Dudyal':'New Small Town Dudyal',
                'NC Mirpur':'New City Mirpur','NST Islamgarh':'New Small Town Islamgarh',
                'NST Chaksawari':'New Small Town Chaksawari'
            };
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        { label:'Commercial', data:labels.map(t=>townCategoryData[t]?.Commercial||0), backgroundColor:'#f28e2b', borderColor:'#d7741d', borderWidth:1 },
                        { label:'House',      data:labels.map(t=>townCategoryData[t]?.House||0),      backgroundColor:'#4e79a7', borderColor:'#3c5f8c', borderWidth:1 },
                        { label:'Plot',       data:labels.map(t=>townCategoryData[t]?.Plot||0),       backgroundColor:'#59a14f', borderColor:'#43853c', borderWidth:1 }
                    ]
                },
                options: {
                    responsive:true,
                    interaction:{ mode:'index', intersect:false },
                    plugins:{
                        tooltip:{
                            callbacks:{
                                title: ctx  => fullTownNames[ctx[0].label] || ctx[0].label,
                                label: ctx  => `${ctx.dataset.label}: ${townCategoryData[ctx.label]?.[ctx.dataset.label]||0}`
                            }
                        },
                        legend:{ position:'top' }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })();

        // =============================================
        // FIX: Tab click handlers (this was missing!)
        // =============================================
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                updateCardContent(this.dataset.tab);
            });
        });

        function init() {
            if (tabs.length > 0) {
                tabs[0].classList.add('active');
                updateCardContent('properties');
            }
            handleSectorDropdownsDelegated();
        }

        init();

    }); // end DOMContentLoaded
    </script>

    <script>
        const originalData = @json($categoryChartData);
        const categories = @json($categories);

        const townLabels = [];
        const shortLabels = [];
        const fullLabels = [];
        const fakeSpacingLabel = " ";

        let lastTown = '';
        Object.keys(originalData).forEach((key) => {
            const [town, sector] = key.split('|');
            if (town !== lastTown && lastTown !== '') {
                fullLabels.push(fakeSpacingLabel);
                shortLabels.push('');
                townLabels.push('');
            }
            fullLabels.push(key);
            shortLabels.push(sector);
            townLabels.push(town);
            lastTown = town;
        });

        const colorMap = {
            Plot: {
                background: '#2C3E50',
                border: '#1A252F'
            },
            Commercial: {
                background: '#8E44AD',
                border: '#6C3483'
            },
            House: {
                background: '#E67E22',
                border: '#CA6F1E'
            }
        };

        const datasets = categories.map(category => ({
            label: category,
            data: fullLabels.map(label => originalData[label]?.[category] || 0),
            backgroundColor: colorMap[category].background,
            borderColor: colorMap[category].border,
            borderWidth: 1,
            barPercentage: 0.8,
            categoryPercentage: 0.8
        }));

        const ctx = document.getElementById('bar').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: shortLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                layout: {
                    padding: {
                        bottom: 80
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            title: function(context) {
                                const i = context[0].dataIndex;
                                const label = fullLabels[i];
                                if (label === fakeSpacingLabel) return '';
                                const [town, sector] = label.split('|');
                                return `${town} - Sector ${sector}`;
                            },
                            label: function(context) {
                                const i = context.dataIndex;
                                const label = fullLabels[i];
                                const category = context.dataset.label;
                                if (label === fakeSpacingLabel) return '';
                                return `${category}: ${originalData[label][category] || 0}`;
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    x: {
                        stacked: false,
                        ticks: {
                            callback: function(value, index) {
                                return shortLabels[index];
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true
                    }
                }
            },
            plugins: [{
                id: 'groupTownLabels',
                afterDraw(chart) {
                    const {
                        ctx,
                        chartArea: { bottom },
                        scales: { x }
                    } = chart;
                    ctx.save();
                    let currentTown = '';
                    let startX = null;

                    for (let i = 0; i < fullLabels.length; i++) {
                        const label = fullLabels[i];
                        if (label === fakeSpacingLabel) continue;
                        const [town] = label.split('|');
                        if (town !== currentTown) {
                            if (currentTown && startX !== null) {
                                const endX = x.getPixelForValue(i - 1);
                                const center = (startX + endX) / 2;
                                ctx.fillStyle = '#000';
                                ctx.font = 'bold 12px sans-serif';
                                ctx.textAlign = 'center';
                                ctx.fillText(currentTown, center, bottom + 40);
                            }
                            currentTown = town;
                            startX = x.getPixelForValue(i);
                        }
                    }
                    if (currentTown && startX !== null) {
                        const endX = x.getPixelForValue(fullLabels.length - 1);
                        const center = (startX + endX) / 2;
                        ctx.fillStyle = '#000';
                        ctx.font = 'bold 12px sans-serif';
                        ctx.textAlign = 'center';
                        ctx.fillText(currentTown, center, bottom + 40);
                    }
                    ctx.restore();
                }
            }]
        });
    </script>

    <script>
        const allSizeData = @json($sizeChartData);
        const sectorChartCtx = document.getElementById('sectorTownChart').getContext('2d');

        let currentChart = null;

        const colorPerSize = {
            "5 Marla":  '#1ABC9C',
            "7 Marla":  '#E74C3C',
            "10 Marla": '#F1C40F',
            "12 Marla": '#3498DB',
            "15 Marla": '#9B59B6',
            "1 Kanal":  '#2ECC71'
        };

        function drawChart(sizeLabel) {
            console.log(`Data for ${sizeLabel}:`, allSizeData[sizeLabel]);

            const sizeData = allSizeData[sizeLabel] || {};
            const fullLabels  = [];
            const shortLabels = [];
            const townLabels  = [];
            const dataValues  = [];
            const fakeSpacingLabel = " ";

            let lastTown = '';
            Object.keys(sizeData).forEach((key) => {
                const [town, sector] = key.split('|').map(str => str.trim());
                if (town !== lastTown && lastTown !== '') {
                    fullLabels.push(fakeSpacingLabel);
                    shortLabels.push('');
                    townLabels.push('');
                    dataValues.push(null);
                }
                fullLabels.push(key);
                shortLabels.push(sector);
                townLabels.push(town);
                dataValues.push(sizeData[key]);
                lastTown = town;
            });

            console.log('Full Labels:', fullLabels);
            console.log('Short Labels:', shortLabels);
            console.log('Data Values:', dataValues);

            const backgroundColor = colorPerSize[sizeLabel] || '#95A5A6';

            if (currentChart) {
                currentChart.destroy();
            }

            currentChart = new Chart(sectorChartCtx, {
                type: 'bar',
                data: {
                    labels: shortLabels,
                    datasets: [{
                        label: sizeLabel,
                        data: dataValues,
                        backgroundColor: backgroundColor,
                        borderColor: '#333',
                        borderWidth: 1,
                        barPercentage: 1.0,
                        categoryPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    layout: {
                        padding: {
                            bottom: 100
                        }
                    },
                    plugins: {
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                title: function(context) {
                                    const index = context[0].dataIndex;
                                    const label = fullLabels[index];
                                    if (label === fakeSpacingLabel) return '';
                                    return label.replace('|', ' - Sector ');
                                },
                                label: function(context) {
                                    const index = context.dataIndex;
                                    const label = fullLabels[index];
                                    if (label === fakeSpacingLabel) return '';
                                    const value = context.parsed.y;
                                    return `${sizeLabel}: ${value || 0}`;
                                }
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value, index) {
                                    return shortLabels[index];
                                },
                                maxRotation: 45,
                                minRotation: 0
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                },
                plugins: [{
                    id: 'groupTownLabelsSize',
                    afterDraw(chart) {
                        const {
                            ctx,
                            chartArea: { bottom },
                            scales: { x }
                        } = chart;
                        ctx.save();
                        let currentTown = '';
                        let startX = null;

                        for (let i = 0; i < fullLabels.length; i++) {
                            const label = fullLabels[i];
                            if (label === fakeSpacingLabel) continue;
                            const [town] = label.split('|').map(str => str.trim());
                            if (town !== currentTown) {
                                if (currentTown && startX !== null) {
                                    const endX = x.getPixelForValue(i - 1);
                                    const center = (startX + endX) / 2;
                                    ctx.fillStyle = '#000';
                                    ctx.font = 'bold 12px sans-serif';
                                    ctx.textAlign = 'center';
                                    ctx.fillText(currentTown, center, bottom + 50);
                                }
                                currentTown = town;
                                startX = x.getPixelForValue(i);
                            }
                        }
                        if (currentTown && startX !== null) {
                            const endX = x.getPixelForValue(fullLabels.length - 1);
                            const center = (startX + endX) / 2;
                            ctx.fillStyle = '#000';
                            ctx.font = 'bold 12px sans-serif';
                            ctx.textAlign = 'center';
                            ctx.fillText(currentTown, center, bottom + 50);
                        }
                        ctx.restore();
                    }
                }]
            });
        }

        function setActiveButton(selectedSize) {
            document.querySelectorAll('.size-btn').forEach(btn => {
                if (btn.getAttribute('data-size') === selectedSize) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }

        try {
            drawChart("5 Marla");
            setActiveButton("5 Marla");
        } catch (error) {
            console.error('Error rendering initial chart:', error);
        }

        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const selectedSize = this.getAttribute('data-size');
                try {
                    drawChart(selectedSize);
                    setActiveButton(selectedSize);
                } catch (error) {
                    console.error(`Error rendering chart for ${selectedSize}:`, error);
                }
            });
        });
    </script>

</x-app-layout>
