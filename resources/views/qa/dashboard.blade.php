<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        /* ====================================================
           COLOR VARIABLES
        ==================================================== */
        :root {
            --color-primary: #4EC9DF;
            --color-primary-dark: #3b8db0;
            --color-primary-light: #60A5FA;
            --color-primary-gradient: linear-gradient(135deg, #3b8db0 0%, #3b8db0 100%);
            --color-secondary: #AEB877;
            --color-secondary-dark: #AEB877;
            --color-success: #10B981;
            --color-success-dark: #059669;
            --color-warning: #647FBC;
            --color-warning-dark: #D97706;
            --color-danger: #EF4444;
            --color-danger-dark: #DC2626;
            --color-info: #06B6D4;
            --color-rose: #EC4899;
            --color-indigo: #3b8db0;
            --color-bg: #F1F5F9;
            --color-bg-dark: #E2E8F0;
            --color-white: #FFFFFF;
            --color-black: #E2E8F0;
            --color-gray: #64748B;
            --color-gray-light: #94A3B8;
            --color-gray-lighter: #F8FAFC;
            --color-gray-border: #E2E8F0;
            --color-shadow: rgba(0,0,0,0.06);
            --color-shadow-hover: rgba(0,0,0,0.10);
            --gradient-info: linear-gradient(135deg, #3b8db0 0%, #3b8db0 100%);
            --gradient-success: linear-gradient(135deg, #5f9e6e 0%, #5f9e6e 100%);
            --gradient-warning: linear-gradient(135deg, #647FBC 0%, #647FBC 100%);
            --gradient-danger: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            --gradient-secondary: linear-gradient(135deg, #64748B 0%, #475569 100%);
            --gradient-title: linear-gradient(135deg, #3b8db0 0%, #3b8db0 50%, #3b8db0 100%);
            --gradient-table-header: linear-gradient(135deg, #3b8db0 0%, #3b8db0 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.06);
            --shadow-lg: 0 8px 24px rgba(37,99,235,0.15);
            --shadow-xl: 0 8px 32px rgba(37,99,235,0.35);
            --shadow-card: 0 4px 24px rgba(0,0,0,0.06);
            --shadow-card-hover: 0 12px 48px rgba(0,0,0,0.10);
        }

        /* ====================================================
           GLOBAL STYLES
        ==================================================== */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }
        body {
            background: linear-gradient(135deg, var(--color-bg) 0%, var(--color-bg-dark) 100%) !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }
        canvas { max-width: 100% !important; }

        .mda-wrapper {
            background: transparent;
            width: 100%;
            max-width: 100%;
        }

        .third-card-inner {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            width: 100%;
        }

        /* ====================================================
           TABS
        ==================================================== */
        .tabs3 {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
            border: none !important;
            box-shadow: var(--shadow-sm) !important;
            background: var(--color-white) !important;
            color: var(--color-black) !important;
            font-size: 0.95rem;
            padding: 12px 16px !important;
        }
        .tabs3:hover:not(.disabled-tab) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg) !important;
        }
        .tabs3.active {
            background: var(--color-primary-gradient) !important;
            color: white !important;
            box-shadow: var(--shadow-xl) !important;
            transform: translateY(-2px);
        }
        .disabled-tab {
            opacity: 0.5;
            cursor: not-allowed !important;
            pointer-events: none;
            filter: grayscale(0.3);
        }

        /* ====================================================
           SMALL BOX CARDS
        ==================================================== */
        .small-box {
            min-height: 110px !important;
            border-radius: 16px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 10px 16px !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .small-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px var(--color-shadow-hover);
        }
        .small-box.bg-info    { background: var(--gradient-info) !important; }
        .small-box.bg-success { background: var(--gradient-success) !important; }
        .small-box.bg-warning { background: var(--gradient-warning) !important; }
        .small-box.bg-danger  { background: var(--gradient-danger) !important; }
        .small-box.bg-secondary { background: var(--gradient-secondary) !important; }

        .inner {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        .inner h3 {
            font-size: 1.4rem !important;
            font-weight: 700 !important;
            letter-spacing: -0.5px;
            color: var(--color-white) !important;
            margin: 0 0 4px 0 !important;
        }
        .inner p {
            font-size: 0.95rem !important;
            display: inline-block;
            margin-right: 10px;
            color: rgba(255,255,255,0.9) !important;
            margin: 0 !important;
        }
        .inner p span { margin-right: 15px; display: inline-block; }

        /* ====================================================
           TITLE
        ==================================================== */
        .title h3 {
            font-size: 2rem !important;
            font-weight: 800 !important;
            padding: 12px 24px;
            letter-spacing: -0.5px;
            background: var(--gradient-title);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            margin: 0;
        }

        /* ====================================================
           TABLES - MAIN
        ==================================================== */
        .main-table-container {
            margin-bottom: 25px;
            margin-top: -40px;
            margin-left: 13px;
            margin-right: 13px;
        }
        .table-section { animation: fadeIn 0.4s ease-in-out; }
        .table-section.hide { animation: fadeOut 0.5s ease-in-out forwards; }

        .table-section table {
            width: 80%;
            max-width: 1000px;
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 15px;
            table-layout: fixed;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: var(--shadow-card);
            background: var(--color-white);
        }
        .table-section th {
            background: var(--gradient-table-header) !important;
            color: var(--color-white);
            font-weight: 600;
            padding: 14px 18px;
            border: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-section td {
            border: 1px solid var(--color-bg);
            background-color: var(--color-white);
            transition: all 0.2s ease;
            padding: 12px 18px;
            font-weight: 500;
            color: var(--color-black);
        }
        .table-section tr:hover td { background-color: var(--color-gray-lighter); }
        .table-section th:last-child { border-top-right-radius: 12px; }
        .table-section tr:last-child td:first-child { border-bottom-left-radius: 12px; }
        .table-section tr:last-child td:last-child { border-bottom-right-radius: 12px; }

        .table-name {
            font-size: 18px;
            font-weight: 700;
            background: var(--color-primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            display: inline-block;
            letter-spacing: -0.3px;
        }
        .main-table-container table td:first-child {
            width: 150px !important;
            white-space: nowrap;
        }
        .sector-row td {
            background-color: var(--color-bg) !important;
            font-weight: 600;
            color: var(--color-black);
        }
        .sector-row:hover td { background-color: var(--color-bg-dark) !important; }
        .block-row td {
            background-color: #FAFBFC !important;
            padding-left: 40px !important;
        }
        .block-row:hover td { background-color: var(--color-bg) !important; }

        /* ====================================================
           FILES STATUS ROW
        ==================================================== */
        #files-status-row .small-box {
            border-radius: 12px !important;
            min-height: 90px !important;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        #files-status-row .small-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px var(--color-shadow-hover);
        }
        #files-status-row .small-box.active-status {
            outline: 3px solid #fff;
            outline-offset: -3px;
            transform: translateY(-4px);
        }
        #files-detail-row {
            margin-top: 20px;
            margin-bottom: 50px;
        }
        #files-detail-row .files-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-card);
            background: var(--color-white);
        }
        #files-detail-row .files-table th {
            background: var(--gradient-table-header) !important;
            color: #fff;
            font-weight: 600;
            padding: 14px 18px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            text-align: center;
        }
        #files-detail-row .files-table td {
            border: 1px solid var(--color-bg);
            padding: 12px 18px;
            font-weight: 500;
            color: #000000 !important;
            text-align: center;
        }
        #files-detail-row .files-table tr:hover td {
            background-color: var(--color-gray-lighter);
        }
        #files-detail-row .files-pagination .page-item.active .page-link {
            background: var(--color-primary-gradient);
            border-color: var(--color-primary);
            color: white;
        }
        #files-detail-row .files-pagination .page-link {
            color: var(--color-primary);
        }

        /* ====================================================
           SECTOR WISE DETAIL
        ==================================================== */
        #sector-wise-detail-row {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 10px;
        }
        #sector-wise-detail-row .table-responsive { width: 100%; }
        #sector-wise-detail-row .table {
            width: 100%;
            max-width: 100%;
            margin: 0;
            table-layout: fixed;
        }
        #sector-wise-detail-row .table td { word-wrap: break-word; }
        #sector-wise-detail-row .form-control,
        #sector-wise-detail-row .form-select { border: 1px solid #dee2e6; }
        #sector-wise-detail-row .form-control:focus,
        #sector-wise-detail-row .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(59, 141, 176, 0.25);
        }
        #sector-wise-detail-row .pagination .page-item.active .page-link {
            background: var(--color-primary-gradient);
            border-color: var(--color-primary);
            color: white;
        }
        #sector-wise-detail-row .pagination .page-link { color: var(--color-primary); }

        /* ====================================================
           BUTTONS
        ==================================================== */
        .size-btn {
            background: var(--color-white);
            color: var(--color-black);
            border: 2px solid var(--color-gray-border);
            padding: 8px 20px;
            cursor: pointer;
            margin: 4px;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .size-btn:hover {
            transform: translateY(-2px);
            border-color: var(--color-primary);
            box-shadow: var(--shadow-lg);
        }
        .size-btn.active {
            background: var(--color-primary-gradient);
            color: var(--color-white);
            border-color: transparent;
            box-shadow: var(--shadow-xl);
        }
        #backToSectorsBtn {
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 100px;
            padding: 6px 18px;
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            background: transparent;
            transition: all 0.3s ease;
        }
        #backToSectorsBtn:hover {
            background: var(--color-primary-gradient);
            color: var(--color-white);
            border-color: transparent;
            box-shadow: 0 8px 24px rgba(37,99,235,0.25);
            transform: translateX(-4px);
        }

        /* ====================================================
           CARDS
        ==================================================== */
        .equal-height-card {
            height: 500px;
            display: flex;
            flex-direction: column;
            border-radius: 16px !important;
            border: none !important;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            transition: all 0.3s ease;
            background: var(--color-white);
        }
        .equal-height-card:hover {
            box-shadow: var(--shadow-card-hover);
            transform: translateY(-2px);
        }
        .equal-height-card .card-header {
            background: linear-gradient(135deg, var(--color-gray-lighter), var(--color-bg));
            border-bottom: 2px solid var(--color-gray-border);
            padding: 16px 20px;
        }
        .equal-height-card .card-header h3 {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--color-black);
            letter-spacing: -0.3px;
            margin: 0;
        }
        .equal-height-card .card-body {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: var(--color-white);
        }
        .card-info .card-header    { border-bottom: 3px solid var(--color-primary) !important; }
        .card-danger .card-header  { border-bottom: 3px solid var(--color-danger) !important; }
        .card-warning .card-header { border-bottom: 3px solid var(--color-warning) !important; }
        .card-success .card-header { border-bottom: 3px solid var(--color-success) !important; }
        .card-primary .card-header { border-bottom: 3px solid var(--color-secondary) !important; }

        .new-chart-card {
            min-height: 350px;
            margin-bottom: 20px;
            border-radius: 16px !important;
            border: none !important;
            box-shadow: var(--shadow-card);
            background: var(--color-white);
            transition: all 0.3s ease;
        }
        .new-chart-card:hover {
            box-shadow: var(--shadow-card-hover);
            transform: translateY(-2px);
        }
        .new-chart-card .card-header {
            background: linear-gradient(135deg, var(--color-gray-lighter), var(--color-bg));
            border-bottom: 2px solid var(--color-gray-border);
            padding: 14px 18px;
        }
        .new-chart-card .card-header h3 {
            font-weight: 700;
            color: var(--color-black);
            letter-spacing: -0.3px;
            font-size: 1rem;
            margin: 0;
        }
        .new-chart-card .card-body { padding: 15px; }

        /* ====================================================
           CHARTS
        ==================================================== */
        .pie-chart-canvas { max-width: 400px; max-height: 400px; }
        .chart-container { position: relative; height: 300px; width: 100%; }
        .chart-container-sm { position: relative; height: 250px; width: 100%; }
        .small-chart-container { position: relative; height: 200px; width: 100%; }
        canvas { pointer-events: auto; }

        /* ====================================================
           CLICKABLE SPANS
        ==================================================== */
        .clickable-span {
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
            padding: 4px 12px;
            border-radius: 8px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(4px);
            display: inline-block;
        }
        .clickable-span:hover {
            background: rgba(255,255,255,0.25);
            transform: scale(1.02);
            color: var(--color-white) !important;
        }

        /* ====================================================
           BLOCK TOGGLE
        ==================================================== */
        .block-toggle {
            cursor: pointer;
            padding: 2px 8px;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: rgba(37,99,235,0.08);
            border: none !important;
        }
        .block-toggle:hover { background: rgba(37,99,235,0.15); }
        .block-toggle i {
            font-size: 14px;
            transition: transform 0.3s ease;
            color: var(--color-primary);
        }

        /* ====================================================
           DROPDOWN
        ==================================================== */
        .dropdown { margin-left: auto; }
        .dropdown-toggle {
            font-size: 14px;
            line-height: 1;
            background: transparent;
            border: none;
            padding: 0;
            color: var(--color-gray);
        }
        .dropdown-toggle::after { display: none !important; }
        .dropdown-menu {
            font-size: 13px;
            min-width: 100px;
            border-radius: 12px;
            box-shadow: 0 8px 32px var(--color-shadow-hover);
            border: none;
            padding: 6px 0;
        }
        .dropdown-menu .dropdown-item { padding: 8px 16px; transition: all 0.2s; font-weight: 500; }
        .dropdown-menu .dropdown-item:hover {
            background: var(--color-primary-gradient);
            color: var(--color-white);
        }

        /* ====================================================
           SIZE BREAKDOWN ROW
        ==================================================== */
        #size-breakdown-row .small-box {
            border-radius: 12px !important;
            background: linear-gradient(135deg, var(--color-white), var(--color-gray-lighter)) !important;
            border: 1px solid var(--color-gray-border);
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            min-height: auto !important;
            height: auto !important;
            padding: 8px 12px !important;
        }
        #size-breakdown-row .small-box .inner h4 {
            color: var(--color-black) !important;
            font-weight: 700;
            font-size: 1rem !important;
            margin: 0 !important;
        }
        #allotment-row .small-box { border-radius: 12px !important; }
        #stage-details {
            margin-top: -40px;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        /* ====================================================
           MISC
        ==================================================== */
        .town-col { width: 5%; min-width: 100px; max-width: 200px; }
        h4 { font-size: 1.1rem !important; font-weight: 600; color: var(--color-black); }
        .d-none { display: none !important; }

        /* ====================================================
           ANIMATIONS
        ==================================================== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(12px); }
        }

        /* ====================================================
           SCROLLBAR
        ==================================================== */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--color-bg); border-radius: 8px; }
        ::-webkit-scrollbar-thumb {
            background: var(--color-primary-gradient);
            border-radius: 8px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-indigo); }

        /* ====================================================
           RESPONSIVE
        ==================================================== */
        @media (max-width: 1200px) {
            .table-section table { width: 95%; }
            .equal-height-card { height: 420px; }
            .title h3 { font-size: 1.6rem !important; }
        }
        @media (max-width: 992px) {
            .main-table-container { margin-top: 0 !important; margin-left: 6px !important; margin-right: 6px !important; }
            #stage-details { margin-top: 0 !important; }
            .table-section table { width: 100%; }
            .equal-height-card { height: 380px; }
            #card-row .card-tile { margin-bottom: 12px; }
            #third-card-title > div { gap: 20px !important; flex-wrap: wrap; }
            .chart-container { height: 260px; }
            .chart-container-sm { height: 220px; }
            .small-chart-container { height: 200px; }
        }
        @media (max-width: 768px) {
            .title h3 { font-size: 1.15rem !important; padding: 8px 10px !important; text-align: center; line-height: 1.3; }
            .tabs3 { font-size: 0.82rem !important; padding: 10px 8px !important; border-radius: 10px !important; }
            .table-section table { width: 100% !important; font-size: 12.5px; border-radius: 12px; }
            .table-section th, .table-section td { padding: 8px 6px !important; font-size: 12px; }
            .table-section th { font-size: 11px; letter-spacing: 0.3px; }
            .small-box { padding: 10px 12px !important; min-height: 100px !important; }
            .inner h3 { font-size: 1.1rem !important; }
            .inner p  { font-size: 0.85rem !important; }
            #card-row .card-tile { flex: 0 0 50%; max-width: 50%; }
            #card-row .small-box { min-height: 100px; }
            .main-table-container { margin: 0 6px 16px !important; }
            #size-breakdown-row, #allotment-row { margin-left: 0 !important; margin-right: 0 !important; margin-bottom: 20px !important; }
            #stage-details { margin-top: 0 !important; margin-bottom: 12px !important; }
            #files-status-row .small-box { min-height: 80px !important; }
            #files-detail-row .files-table { font-size: 12px; }
            #files-detail-row .files-table th, #files-detail-row .files-table td { padding: 8px 6px; }
            .col-lg-6, .col-lg-3, .col-lg-12 { width: 100% !important; max-width: 100% !important; }
            .equal-height-card { height: auto !important; min-height: 300px; margin-bottom: 16px; }
            #backToSectorsBtn { font-size: 0.75rem; padding: 5px 12px; }
        }
        @media (max-width: 480px) {
            .title h3 { font-size: 0.98rem !important; padding: 6px 8px !important; }
            .tabs3 { font-size: 0.72rem !important; padding: 8px 6px !important; }
            .table-section table { font-size: 11px; }
            .table-section th, .table-section td { padding: 6px 4px !important; font-size: 11px; }
            .inner h3 { font-size: 0.95rem !important; }
            .inner p  { font-size: 0.72rem !important; }
            .clickable-span { padding: 3px 8px !important; font-size: 0.72rem !important; }
            #third-card-title > div { gap: 8px !important; flex-direction: column; align-items: flex-start !important; }
            #third-card-title .clickable-span { margin-left: 0 !important; }
            .equal-height-card { min-height: 260px; }
            #files-detail-row .files-table { font-size: 11px; }
        }
    </style>

    <body>
        <div class="overflow-hidden shadow-sm sm:rounded-lg mda-wrapper">

            <input type="hidden" id="totalProperties"   value="{{ $totalProperties }}">
            <input type="hidden" id="categoryData"      value="{{ json_encode($categoryData) }}">
            <input type="hidden" id="sectorCategoryData"  value="{{ json_encode($orderedSectorCategoryData) }}">
            <input type="hidden" id="sectorSummaryData" value="{{ json_encode($sectorSummary) }}">
            <input type="hidden" id="sectorBlockData"   value="{{ json_encode($sectorBlockData) }}">
            <input type="hidden" id="filesUploadedCount" value="{{ $filesUploadedCount }}">
            <input type="hidden" id="filesRemainingCount" value="{{ $filesRemainingCount }}">

            <div class="row mt-2">
                <div class="col title text-center">
                    <h3>MIRPUR DEVELOPMENT AUTHORITY (MDA)</h3>
                </div>
            </div>

            <div class="row mx-1 mb-1 g-2">
                <div class="col-lg-4 col-6 text-center p-2 tabs3"
                    style="box-shadow:0px 0px 10px rgb(209,209,209) inset; cursor:pointer; background-color:#f5f5f5;"
                    data-tab="properties">Properties</div>

                <div class="col-lg-4 col-6 text-center p-2 tabs3 disabled-tab"
                    style="background-color:#5f9e6e !important; box-shadow:0px 0px 10px rgb(209,209,209) inset;"
                    data-tab="transfer">Transfer &amp; Other Request's</div>

                <div class="col-lg-4 col-6 text-center p-2 tabs3 disabled-tab"
                    style="background-color:#647FBC !important; box-shadow:0px 0px 10px rgb(209,209,209) inset;"
                    data-tab="complaints">Complaints/Suggestions</div>
            </div>

            <!-- 4 CARDS -->
            <div class="row px-2 py-3" id="card-row">
                <div class="card-tile col-lg-3 col-md-6 col-12 mb-3" id="card-1">
                    <div class="small-box bg-info">
                        <div class="inner" id="first-card-content">
                            <h3 id="first-card-title">Properties</h3>
                            <p id="first-card-text">
                                <span>Total: {{ $totalProperties }}</span><br>
                                <span>Sector Wise Detail</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-tile col-lg-3 col-md-6 col-12 mb-3" id="card-2">
                    <div class="small-box bg-success">
                        <div class="inner" id="second-card-content">
                            <h3 id="second-card-title">Size Wise Breakdown</h3>
                            <p id="second-card-text"></p>
                        </div>
                    </div>
                </div>
                <div class="card-tile col-lg-3 col-md-6 col-12 mb-3" id="card-3">
                    <div class="small-box bg-warning">
                        <div class="inner" id="third-card-content">
                            <h3 id="third-card-title" style="color:white;"></h3>
                            <p  id="third-card-text"  style="color:white;"></p>
                        </div>
                    </div>
                </div>
                <div class="card-tile col-lg-3 col-md-6 col-12 mb-3" id="card-4">
                    <div class="small-box bg-secondary">
                        <div class="inner" id="fourth-card-content">
                            <h3 id="fourth-card-title" style="color:white;"></h3>
                            <p  id="fourth-card-text"  style="color:white;"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILES STATUS ROW (2 cards: Uploaded & Remaining) -->
            <div id="files-status-row" class="row px-2 d-none" style="margin-top:-12px; margin-bottom:30px;">
                <div class="col-lg-6 col-md-6 col-12 mb-3">
                    <div class="small-box bg-success" id="uploaded-card" style="cursor:pointer;">
                        <div class="inner">
                            <h3 style="color:#fff;">Uploaded Files</h3>
                            <p style="color:#fff; font-size:1.2rem; font-weight:700;">
                                Total: {{ $filesUploadedCount }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 mb-3">
                    <div class="small-box bg-danger" id="remaining-card" style="cursor:pointer;">
                        <div class="inner">
                            <h3 style="color:#fff;">Remaining Files</h3>
                            <p style="color:#fff; font-size:1.2rem; font-weight:700;">
                                Total: {{ $filesRemainingCount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILES DETAIL ROW -->
            <div id="files-detail-row" class="table-section d-none" style="padding: 0 15px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; flex-wrap:wrap; gap:10px;">
                    <h4 id="files-detail-title" style="margin:0; font-weight:700; color:#3b8db0;">Uploaded Files</h4>
                    <button type="button" id="closeFilesDetail" class="btn btn-sm btn-outline-secondary" style="border-radius:20px;">
                        &larr; Back
                    </button>
                </div>
                <div class="table-responsive" style="overflow-x:auto; width:100%;">
                    <table class="files-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Applicant Name</th>
                                <th>Application No</th>
                                <th>Plot No</th>
                                <th>Sector</th>
                                <th>Block</th>
                                <th>Uploaded By</th>
                                <th>Uploaded At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="filesDetailBody">
                            <tr><td colspan="9" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <nav>
                            <ul class="pagination justify-content-end files-pagination" id="filesPagination" style="margin:0;">
                            </ul>
                        </nav>
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
                                <h4 class="mb-1 text-dark" style="font-size:1.1rem; color: black !important;">{{ $label }}: {{ $count }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Allotment Row -->
            <div id="allotment-row" class="row px-1"
                style="margin-top:-12px; margin-left:2px; margin-right:2px; margin-bottom:50px;">
            </div>

            <div id="stage-details" style="margin-top:-40px; margin-bottom:20px; position:relative; z-index:2;"></div>

            <!-- MAIN TABLE CONTAINER -->
            <div class="main-table-container">

            @php
            $tables = [
                'new' => ['label' => 'Total REQUEST', 'sector_total' => 'total_requests', 'sector_original' => 'original_allottee_pending', 'sector_transfer' => 'transfer_allottee_pending'],
                'completed' => ['label' => 'COMPLETED REQUEST', 'sector_total' => 'total_requests', 'sector_original' => 'original_allottee_completed', 'sector_transfer' => 'transfer_allottee_completed'],
                'inprocess' => ['label' => 'IN PROCESS REQUEST', 'sector_total' => 'total_requests', 'sector_original' => 'original_allottee_inprocess', 'sector_transfer' => 'transfer_allottee_inprocess'],
                'pending' => ['label' => 'PENDING REQUEST', 'sector_total' => 'total_requests', 'sector_original' => 'original_allottee_pending', 'sector_transfer' => 'transfer_allottee_pending'],
                'rejected' => ['label' => 'REJECTED REQUEST', 'sector_total' => 'total_requests', 'sector_original' => 'original_allottee_rejected', 'sector_transfer' => 'transfer_allottee_rejected'],
                'overdue' => ['label' => 'OVERDUE REQUEST', 'sector_total' => 'total_requests', 'sector_original' => 'original_allottee_pending', 'sector_transfer' => 'transfer_allottee_pending'],
            ];
            @endphp

            @foreach($tables as $status => $cfg)
            <div class="table-section d-none" id="{{ $status }}-table">
                <div style="display:flex; justify-content:center; align-items:center; margin-bottom:0.75rem;">
                    <strong style="font-size:1.2rem;">{{ $cfg['label'] }}</strong>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Sector</th>
                            <th>Total</th>
                            <th>Original Allottee</th>
                            <th>Transfer Allottee</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sectorRequestStats as $sector)
                        <tr class="sector-main-row" style="cursor:pointer;"
                            onclick="toggleSector('{{ $status }}-{{ $sector->sector_id }}')">
                            <td style="width:250px; white-space:nowrap;">
                                <span class="me-2">{{ $sector->sector_name }}</span>
                                <i class="bi bi-chevron-right" id="arrow-{{ $status }}-{{ $sector->sector_id }}"
                                   style="font-size:11px; color:#888; transition:transform 0.2s;"></i>
                            </td>
                            <td class="text-center">{{ $sector->{$cfg['sector_total']} ?? 0 }}</td>
                            <td class="text-center">{{ $sector->{$cfg['sector_original']} ?? 0 }}</td>
                            <td class="text-center">{{ $sector->{$cfg['sector_transfer']} ?? 0 }}</td>
                        </tr>
                        @if(isset($sectorBlockWiseDetails) && !empty($sectorBlockWiseDetails))
                            @php $sectorBlocks = $sectorBlockWiseDetails->where('sector_id', $sector->sector_id); @endphp
                            @foreach($sectorBlocks as $block)
                            <tr class="block-row d-none block-{{ $status }}-{{ $sector->sector_id }}">
                                <td style="padding-left:35px; white-space:nowrap;">
                                    <i class="bi bi-dot" style="color:#2980b9;"></i>
                                    {{ $block->block_name }}
                                </td>
                                <td class="text-center">{{ $block->total_properties ?? 0 }}</td>
                                <td class="text-center">{{ $block->plot_count ?? 0 }}</td>
                                <td class="text-center">{{ $block->house_count ?? 0 }}</td>
                            </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach

            </div>

            <!-- SECTOR WISE DETAIL TABLE -->
            <div class="table-section d-none" id="sector-wise-detail-row" style="margin-bottom:50px; margin-top:1px; width:100%;">
                <div class="table-name"></div>
                <div class="row mb-3" style="width:100%;">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: #f8f9fa; padding: 12px 15px; border-radius: 8px; width:100%">
                            <div class="d-flex align-items-center gap-2" style="flex: 1; min-width: 200px;">
                                <i class="bi bi-search" style="color: #6c757d;"></i>
                                <input type="text" id="sectorSearch" class="form-control" placeholder="Search sectors..." style="border-radius: 8px; max-width: 300px; height: 36px; font-size: 14px;">
                                <button class="btn btn-primary" id="searchSectorBtn" style="border-radius: 8px; background: var(--color-primary-gradient); border: none; padding: 6px 16px; height: 36px; font-size: 14px;">
                                    <i class="bi bi-search me-1"></i> Search
                                </button>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <label class="me-1" style="font-weight: 600; color: #495057; font-size: 14px; margin: 0;">Show:</label>
                                <select id="sectorPerPage" class="form-select" style="width: auto; border-radius: 8px; height: 36px; font-size: 14px; padding: 2px 30px 2px 10px;">
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span style="font-size: 14px; color: #6c757d;" id="sectorPaginationInfo"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTOR WISE TABLE (Directly visible) -->
                <div id="sector-wise-table-wrapper">
                    <div class="table-responsive" style="overflow-x: auto; width:100%;">
                        <table class="table table-bordered" style="width:100%; border-collapse:collapse; table-layout:fixed;">
                            <colgroup>
                                <col style="width:25%; min-width:150px; max-width:300px;">
                                <col style="width:18.75%;">
                                <col style="width:18.75%;">
                                <col style="width:18.75%;">
                                <col style="width:18.75%;">
                            </colgroup>
                            <thead>
                                <tr><th colspan="5" class="district-header" style="text-align:center; padding:10px;"><strong>SECTOR WISE DETAIL</strong></th></tr>
                                <tr>
                                    <th style="text-align:center; padding:10px 8px;">Sector</th>
                                    <th style="text-align:center; padding:10px 8px;">Properties</th>
                                    <th style="text-align:center; padding:10px 8px;">Plots</th>
                                    <th style="text-align:center; padding:10px 8px;">House</th>
                                    <th style="text-align:center; padding:10px 8px;">Commercial</th>
                                </tr>
                            </thead>
                            <tbody id="sectorWiseTableBody">
                                <tr><td colspan="5" class="text-center">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3" style="padding: 0 15px; width:100%;">
                        <div class="col-md-12">
                            <nav><ul class="pagination justify-content-end" id="sectorPagination" style="margin: 0;"></ul></nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATA REVIEW ROW -->
            <div class="table-section d-none" id="data-review-row" style="margin-bottom:50px; margin-top:1px; width:100%;">
                <div style="display:flex; justify-content:center; align-items:center; margin-bottom:0.75rem;">
                    <strong style="font-size:1.2rem;">DATA REVIEW - QA USERS</strong>
                </div>
                <div class="table-responsive" style="overflow-x:auto; width:100%;">
                    <table class="table table-bordered" style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background: var(--gradient-table-header); color:#fff;">
                                <th style="text-align:center; padding:10px 8px;">QA User</th>
                                <th style="text-align:center; padding:10px 8px;">Assigned Sectors</th>
                                <th style="text-align:center; padding:10px 8px;">Forms in Sectors</th>
                                <th style="text-align:center; padding:10px 8px;">Total Checked</th>
                                <th style="text-align:center; padding:10px 8px;">Verified</th>
                                <th style="text-align:center; padding:10px 8px;">Issue</th>
                            </tr>
                        </thead>
                        <tbody id="dataReviewTableBody">
                            <tr><td colspan="6" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="dataReviewDetailModal" tabindex="-1">
                <div class="modal-dialog modal-xl" style="max-width:95%;">
                    <div class="modal-content" style="border-radius:12px;">
                        <div class="modal-header" style="background: var(--color-primary-gradient); color:#fff;">
                            <h5 class="modal-title" id="dataReviewModalTitle">List</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="opacity:1;"></button>
                        </div>
                        <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
                            <table class="table table-bordered table-striped" id="dataReviewDetailTable" style="width:100%; font-size:14px;">
                                <thead>
                                    <tr style="background:#f1f5f9;">
                                        <th>#</th><th>Applicant Name</th><th>Application No</th><th>Plot No</th>
                                        <th>Sector</th><th>Block</th><th>Status</th><th>Checked By</th><th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="dataReviewDetailBody">
                                    <tr><td colspan="9" class="text-center">Loading...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- CHARTS SECTION -->
        <div class="col-lg-12" style="margin-top:30px;">
            <div class="row px-2 py-3" style="margin-top:-25px;">
                <div class="col-lg-6">
                    <div class="card card-info equal-height-card">
                        <div class="card-header"><h3 class="card-title">MDA-Total Representation</h3></div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <canvas id="pieChart" width="250" height="250" class="pie-chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-danger equal-height-card new-chart-card">
                        <div class="card-header"><h3 class="card-title">Allotment Type</h3></div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="small-chart-container"><canvas id="allotmentTypeChart"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-warning equal-height-card new-chart-card">
                        <div class="card-header"><h3 class="card-title">Ownership Type</h3></div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="small-chart-container"><canvas id="ownershipTypeChart"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-info" id="center">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title" id="title-graph">MDA - Sector Wise</h3>
                    <button type="button" id="backToSectorsBtn" class="btn btn-sm btn-outline-primary d-none">&larr; Back to Sectors</button>
                </div>
                <div class="card-body">
                    <canvas id="bar" style="max-height:500px; max-width:100%; pointer-events:auto;"></canvas>
                </div>
            </div>
        </div>

    </body>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const COLORS = {
            primary: '#3b8db0', secondary: '#7C3AED', success: '#10B981', warning: '#647FBC',
            danger: '#EF4444', info: '#06B6D4', rose: '#EC4899', violet: '#8B5CF6',
            pie: { house: '#0AA1DD', commercial: '#D0E8F2', plot: '#E5D1FA' },
            bar: {
                commercial: { background: '#00E0FF', border: '#00E0FF' },
                house: { background: '#3b8db0', border: '#1D4ED8' },
                plot: { background: '#E5D1FA', border: '#E5D1FA' }
            }
        };

        function toggleSector(key) {
            const rows  = document.querySelectorAll('.block-' + key);
            const arrow = document.getElementById('arrow-' + key);
            rows.forEach(r => r.classList.toggle('d-none'));
            if (arrow) arrow.style.transform = arrow.style.transform === 'rotate(90deg)' ? '' : 'rotate(90deg)';
        }
    </script>

    <!-- SECTOR WISE DETAIL PAGINATION - UPDATED TO AUTO-LOAD -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentSectorPage = 1;
            let sectorPerPage = 10;
            let sectorSearchQuery = '';
            let totalSectorPages = 1;
            let sectorDataLoaded = false; // Flag: data load hua ya nahi

            const sectorWiseTableBody = document.getElementById('sectorWiseTableBody');
            const sectorPagination = document.getElementById('sectorPagination');
            const sectorPaginationInfo = document.getElementById('sectorPaginationInfo');
            const sectorSearch = document.getElementById('sectorSearch');
            const searchBtn = document.getElementById('searchSectorBtn');
            const perPageSelect = document.getElementById('sectorPerPage');

            // Public function: load sector wise data
window.loadSectorWiseData = function() {
    if (!sectorWiseTableBody) return;

    // Show loading text sirf first time
    sectorWiseTableBody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">Loading...</td></tr>`;

    const url = `/sector-wise-details?page=${currentSectorPage}&per_page=${sectorPerPage}&search=${encodeURIComponent(sectorSearchQuery)}`;

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(data => {
        if (!data || !data.data) {
            sectorWiseTableBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Invalid response</td></tr>`;
            return;
        }
        renderSectorTable(data.data);
        renderSectorPagination(data);
    })
    .catch(error => {
        console.error('Sector load error:', error);
        sectorWiseTableBody.innerHTML = `
            <tr><td colspan="5" class="text-center text-danger">
                <i class="bi bi-exclamation-triangle"></i> Data load nahi ho saka (Error: ${error.message})
            </td></tr>`;
    });
};

            function renderSectorTable(sectors) {
                if (!sectors || sectors.length === 0) {
                    sectorWiseTableBody.innerHTML = `<tr><td colspan="5" class="text-center">No sectors found</td></tr>`;
                    return;
                }
                let html = '';
                sectors.forEach(sector => {
                    const blockData = sector.block_data || [];
                    const blockOrder = sector.block_order || [];
                    const hasData = sector.total_properties > 0 || sector.plot_count > 0 || sector.house_count > 0 || sector.commercial_count > 0;
                    const textColor = hasData ? '#000000' : '#999999';
                    let sortedBlocks = [...blockData];
                    if (blockOrder.length > 0) {
                        sortedBlocks = blockOrder.map(blockName => {
                            const found = blockData.find(b => b.block === blockName);
                            return found || { block: blockName, total_properties: 0, plot_count: 0, house_count: 0, commercial_count: 0 };
                        });
                    }
                    html += `
                        <tr class="sector-main-row" data-sector-id="${sector.id}" data-block-order='${JSON.stringify(blockOrder)}' data-block-data='${JSON.stringify(sortedBlocks)}'>
                            <td style="white-space: normal; word-wrap: break-word; word-break: break-word; padding:10px 8px; vertical-align:middle; color: ${textColor};">
                                <div style="display:flex; align-items:center; flex-wrap:wrap; gap:4px;">
                                    <span style="flex:1; min-width:60px; font-weight: ${hasData ? '600' : '400'}; color: ${textColor};">${sector.name}</span>
                                    ${blockData.length > 0 ? `
                                        <button class="btn btn-sm p-0 ms-1 bg-transparent border-0 block-toggle flex-shrink-0"
                                            type="button" data-sector="${sector.id}" title="Toggle Blocks">
                                            <i class="bi bi-chevron-down" style="color: ${hasData ? '#2980b9' : '#cccccc'};"></i>
                                        </button>
                                    ` : ''}
                                </div>
                            </td>
                            <td style="text-align:center; padding:10px 8px; white-space:nowrap; color: ${textColor}; font-weight: ${hasData ? '600' : '400'};">${sector.total_properties}</td>
                            <td style="text-align:center; padding:10px 8px; white-space:nowrap; color: ${textColor}; font-weight: ${hasData ? '600' : '400'};">${sector.plot_count}</td>
                            <td style="text-align:center; padding:10px 8px; white-space:nowrap; color: ${textColor}; font-weight: ${hasData ? '600' : '400'};">${sector.house_count}</td>
                            <td style="text-align:center; padding:10px 8px; white-space:nowrap; color: ${textColor}; font-weight: ${hasData ? '600' : '400'};">${sector.commercial_count}</td>
                        </tr>
                    `;
                });
                sectorWiseTableBody.innerHTML = html;
                document.querySelectorAll('.block-toggle').forEach(btn => {
                    btn.removeEventListener('click', toggleBlockHandler);
                    btn.addEventListener('click', toggleBlockHandler);
                });
            }

            function toggleBlockHandler(e) {
                e.preventDefault();
                e.stopPropagation();
                const button = e.currentTarget;
                const sectorId = button.dataset.sector;
                const row = button.closest('tr');
                if (!row) return;
                const existingRows = document.querySelectorAll(`.block-row[data-sector="${sectorId}"]`);
                if (existingRows.length > 0) {
                    const isHidden = existingRows[0].classList.contains('d-none');
                    existingRows.forEach(r => { if (isHidden) r.classList.remove('d-none'); else r.classList.add('d-none'); });
                    const icon = button.querySelector('i');
                    if (icon) icon.className = isHidden ? 'bi bi-chevron-up' : 'bi bi-chevron-down';
                    return;
                }
                let blockData = [];
                try {
                    const dataAttr = row.dataset.blockData;
                    if (dataAttr && dataAttr !== '[]' && dataAttr !== '') blockData = JSON.parse(dataAttr);
                } catch(e) { console.error('Error parsing block data:', e); }
                if (!blockData || blockData.length === 0) return;
                let lastInsertedRow = row;
                blockData.forEach(block => {
                    const newRow = document.createElement('tr');
                    newRow.classList.add('block-row');
                    newRow.setAttribute('data-sector', sectorId);
                    const hasBlockData = (block.total_properties > 0) || (block.plot_count > 0) || (block.house_count > 0) || (block.commercial_count > 0);
                    const blockTextColor = hasBlockData ? '#000000' : '#999999';
                    newRow.innerHTML = `
                        <td style="padding-left: 40px; white-space: nowrap; color: ${blockTextColor}; font-weight: ${hasBlockData ? '600' : '400'};">
                            <i class="bi bi-dot" style="color:#2980b9;"></i> ${block.block || 'Unknown'}
                        </td>
                        <td style="text-align:center; color: ${blockTextColor};">${block.total_properties || 0}</td>
                        <td style="text-align:center; color: ${blockTextColor};">${block.plot_count || 0}</td>
                        <td style="text-align:center; color: ${blockTextColor};">${block.house_count || 0}</td>
                        <td style="text-align:center; color: ${blockTextColor};">${block.commercial_count || 0}</td>
                    `;
                    lastInsertedRow.parentNode.insertBefore(newRow, lastInsertedRow.nextSibling);
                    lastInsertedRow = newRow;
                });
                const icon = button.querySelector('i');
                if (icon) icon.className = 'bi bi-chevron-up';
            }

            function renderSectorPagination(data) {
                const total = data.total || 0;
                const perPage = data.per_page || sectorPerPage;
                const currentPage = data.current_page || 1;
                const lastPage = data.last_page || 1;
                totalSectorPages = lastPage;
                const start = (currentPage - 1) * perPage + 1;
                const end = Math.min(currentPage * perPage, total);
                sectorPaginationInfo.textContent = `Showing ${start} to ${end} of ${total} sectors`;
                let html = '';
                html += `<li class="page-item ${currentPage <= 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(lastPage, currentPage + 2);
                if (startPage > 1) {
                    html += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
                    if (startPage > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                for (let i = startPage; i <= endPage; i++) {
                    html += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                }
                if (endPage < lastPage) {
                    if (endPage < lastPage - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    html += `<li class="page-item"><a class="page-link" href="#" data-page="${lastPage}">${lastPage}</a></li>`;
                }
                html += `<li class="page-item ${currentPage >= lastPage ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;
                sectorPagination.innerHTML = html;
                sectorPagination.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.dataset.page);
                        if (page && page >= 1 && page <= totalSectorPages) {
                            currentSectorPage = page;
                            window.loadSectorWiseData();
                        }
                    });
                });
            }

            if (searchBtn) searchBtn.addEventListener('click', function() {
                sectorSearchQuery = sectorSearch.value.trim();
                currentSectorPage = 1;
                window.loadSectorWiseData();
            });
            if (sectorSearch) sectorSearch.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') { sectorSearchQuery = this.value.trim(); currentSectorPage = 1; window.loadSectorWiseData(); }
            });
            if (perPageSelect) perPageSelect.addEventListener('change', function() {
                sectorPerPage = parseInt(this.value);
                currentSectorPage = 1;
                window.loadSectorWiseData();
            });

            // ---- MAIN CHANGE: Jab bhi Sector Wise Detail open ho, auto load ----
            const originalToggleSection = window.toggleSection;
            window.toggleSection = function(section) {
                if (typeof originalToggleSection === 'function') {
                    originalToggleSection(section);
                }
                if (section && section.id === 'sector-wise-detail-row') {
                    // Section visible hai? To list load karo
                    if (!section.classList.contains('d-none')) {
                        window.loadSectorWiseData();
                    }
                }
            };

            // Sector Wise Detail toggle button click par bhi auto load
 // Sector Wise Detail toggle par foran load
document.addEventListener('click', function(e) {
    const toggle = e.target.closest('#sector-wise-detail-toggle');
    if (!toggle) return;
    e.preventDefault();
    e.stopPropagation();
    // Section open karo
    const section = document.getElementById('sector-wise-detail-row');
    if (!section) return;
    // Baqi sections band karo
    document.querySelectorAll('.table-section').forEach(t => t.classList.add('d-none'));
    section.classList.remove('d-none');
    activeSection = section;
    // Data load karo
    currentSectorPage = 1;
    window.loadSectorWiseData();
});

            // Agar page load par hi section visible ho (rare case), to bhi load karo
            window.addEventListener('load', function() {
                const section = document.getElementById('sector-wise-detail-row');
                if (section && !section.classList.contains('d-none')) {
                    window.loadSectorWiseData();
                }
            });
        });
    </script>

    <!-- DATA REVIEW -->
    <script>
        window.openDataReviewDetail = function (userId, type, title) {
            sessionStorage.setItem('dataReviewState', JSON.stringify({ userId, type, title }));
            document.getElementById('dataReviewModalTitle').textContent = title;
            const body = document.getElementById('dataReviewDetailBody');
            body.innerHTML = '<tr><td colspan="9" class="text-center">Loading...</td></tr>';
            const modalEl = document.getElementById('dataReviewDetailModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
            const url = `/data-review-details?user_id=${encodeURIComponent(userId)}&type=${encodeURIComponent(type)}`;
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(res => {
                    const rows = res.data || [];
                    if (rows.length === 0) { body.innerHTML = '<tr><td colspan="9" class="text-center">No records found</td></tr>'; return; }
                    body.innerHTML = rows.map((r, i) => `
                        <tr>
                            <td>${i + 1}</td><td>${r.applicant_name}</td><td>${r.application_no}</td>
                            <td>${r.plot_no}</td><td>${r.sector}</td><td>${r.block}</td>
                            <td>${r.status}</td><td>${r.checked_by}</td>
                            <td><a href="${r.detail_url}"><i class="bi bi-eye"></i> View</a></td>
                        </tr>
                    `).join('');
                })
                .catch(err => { console.error(err); body.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>'; });
        };
        document.addEventListener('click', function (e) {
            const el = e.target.closest('.review-num');
            if (!el) return;
            window.openDataReviewDetail(el.dataset.uid, el.dataset.type, el.dataset.title);
        });
        window.loadDataReviewStats = function () {
            const tbody = document.getElementById('dataReviewTableBody');
            if (!tbody) return;
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">Loading...</td></tr>';
            fetch('{{ route("data.review.stats") }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(res => {
                const rows = res.data || [];
                if (rows.length === 0) { tbody.innerHTML = '<tr><td colspan="6" class="text-center">No QA users found</td></tr>'; return; }
                tbody.innerHTML = rows.map(u => {
                    const uid = u.is_summary ? 'all' : u.id;
                    return `
                    <tr>
                        <td style="text-align:center; padding:10px 8px; font-weight:600; color:#000000;">${u.name}</td>
                        <td style="text-align:center; padding:10px 8px; color:#000000;">${u.sectors}</td>
                        <td style="text-align:center; padding:10px 8px;"><span class="clickable-span review-num" style="background:rgba(37,99,235,0.08); color:#03346E;" data-uid="${uid}" data-type="forms" data-title="${u.name} - Total Forms in Sectors">${u.sector_total_forms}</span></td>
                        <td style="text-align:center; padding:10px 8px;"><span class="clickable-span review-num" style="background:rgba(37,99,235,0.08); color:#03346E;" data-uid="${uid}" data-type="checked" data-title="${u.name} - Total Checked">${u.total_checked}</span></td>
                        <td style="text-align:center; padding:10px 8px;"><span class="clickable-span review-num" style="background:rgba(16,185,129,0.12); color:#10B981; font-weight:700;" data-uid="${uid}" data-type="verified" data-title="${u.name} - Verified">${u.verified}</span></td>
                        <td style="text-align:center; padding:10px 8px;"><span class="clickable-span review-num" style="background:rgba(239,68,68,0.12); color:#EF4444; font-weight:700;" data-uid="${uid}" data-type="issue" data-title="${u.name} - Issue">${u.issue}</span></td>
                    </tr>`;
                }).join('');
            })
            .catch(err => { console.error('Error loading data review stats:', err); tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading data</td></tr>'; });
        };
        document.addEventListener('DOMContentLoaded', function () {
            const modalEl = document.getElementById('dataReviewDetailModal');
            if (modalEl) modalEl.addEventListener('hidden.bs.modal', function () { sessionStorage.removeItem('dataReviewState'); });
        });
        window.addEventListener('pageshow', function () {
            const raw = sessionStorage.getItem('dataReviewState');
            if (!raw) return;
            let state;
            try { state = JSON.parse(raw); } catch (e) { return; }
            setTimeout(function () {
                const toggle = document.getElementById('data-review-toggle');
                if (toggle) toggle.click();
                window.openDataReviewDetail(state.userId, state.type, state.title);
            }, 300);
        });
    </script>

    <!-- MAIN DASHBOARD SCRIPT -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs             = document.querySelectorAll('.tabs3');
        const firstCardTitle   = document.getElementById('first-card-title');
        const firstCardText    = document.getElementById('first-card-text');
        const secondCardTitle  = document.getElementById('second-card-title');
        const secondCardText   = document.getElementById('second-card-text');
        const thirdCardTitle   = document.getElementById('third-card-title');
        const thirdCardText    = document.getElementById('third-card-text');

        const newTable            = document.getElementById('new-table');
        const completedTable      = document.getElementById('completed-table');
        const inprocessTable      = document.getElementById('inprocess-table');
        const pendingTable        = document.getElementById('pending-table');
        const rejectedTable       = document.getElementById('rejected-table');
        const overdueTable        = document.getElementById('overdue-table');
        const sectorWiseDetailRow = document.getElementById('sector-wise-detail-row');

        const allotmentRow        = document.getElementById('allotment-row');
        const allotmentDetailRow  = document.createElement('div');
        allotmentDetailRow.id = 'allotment-detail-row';
        allotmentDetailRow.classList.add('mt-3', 'd-none');
        allotmentRow.insertAdjacentElement('afterend', allotmentDetailRow);

        const totalProperties = document.getElementById('totalProperties')?.value || '0';
        const categoryData    = JSON.parse(document.getElementById('categoryData')?.value || '{}');

        // FILES STATUS ELEMENTS
        const filesStatusRow   = document.getElementById('files-status-row');
        const filesDetailRow   = document.getElementById('files-detail-row');
        const filesDetailBody  = document.getElementById('filesDetailBody');
        const filesPagination  = document.getElementById('filesPagination');
        const filesDetailTitle = document.getElementById('files-detail-title');
        const uploadedCard     = document.getElementById('uploaded-card');
        const remainingCard    = document.getElementById('remaining-card');
        const closeFilesDetail = document.getElementById('closeFilesDetail');

        let activeSection = null;
        let filesCurrentPage = 1;
        let filesCurrentType = 'uploaded';
        let filesTotalPages = 1;
        let filesStatusOpen = false;

        function toggleSection(section) {
            const isVisible = activeSection === section;
            document.querySelectorAll('.table-section').forEach(t => t.classList.add('d-none'));
            if (!isVisible) {
                section.classList.remove('d-none');
                activeSection = section;
                handleBlockDropdownsDelegated();
            } else {
                activeSection = null;
            }
        }
        window.toggleSection = toggleSection;

        // ====================================================
        // LOAD FILES DETAIL (Uploaded / Remaining)
        // ====================================================
        function loadFilesDetail(type, page = 1) {
            filesCurrentType = type;
            filesCurrentPage = page;

            filesDetailTitle.textContent = type === 'uploaded' ? 'Uploaded Files' : 'Remaining Files';
            filesDetailBody.innerHTML = '<tr><td colspan="9" class="text-center">Loading...</td></tr>';

            uploadedCard.classList.toggle('active-status', type === 'uploaded');
            remainingCard.classList.toggle('active-status', type === 'remaining');

            const url = `/files-status/${type}?page=${page}`;

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(res => {
                    const rows = res.data || [];
                    if (rows.length === 0) {
                        filesDetailBody.innerHTML = `<tr><td colspan="9" class="text-center">No records found</td></tr>`;
                        filesPagination.innerHTML = '';
                        return;
                    }
                    filesDetailBody.innerHTML = rows.map((r, i) => `
                        <tr>
                            <td>${(res.current_page - 1) * res.per_page + i + 1}</td>
                            <td>${r.applicant_name || '-'}</td>
                            <td>${r.application_no || '-'}</td>
                            <td>${r.plot_no || '-'}</td>
                            <td>${r.sector || '-'}</td>
                            <td>${r.block || '-'}</td>
                            <td>${r.uploaded_by || '-'}</td>
                            <td>${r.uploaded_at || '-'}</td>
                            <td><a href="${r.detail_url || '#'}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;"><i class="bi bi-eye"></i> View</a></td>
                        </tr>
                    `).join('');
                    renderFilesPagination(res);
                })
                .catch(err => {
                    console.error('Error loading files:', err);
                    filesDetailBody.innerHTML = `<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>`;
                });
        }

        function renderFilesPagination(data) {
            const currentPage = data.current_page || 1;
            const lastPage = data.last_page || 1;
            filesTotalPages = lastPage;

            let html = '';
            html += `<li class="page-item ${currentPage <= 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;

            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(lastPage, currentPage + 2);

            if (startPage > 1) {
                html += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
                if (startPage > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            for (let i = startPage; i <= endPage; i++) {
                html += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
            if (endPage < lastPage) {
                if (endPage < lastPage - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                html += `<li class="page-item"><a class="page-link" href="#" data-page="${lastPage}">${lastPage}</a></li>`;
            }
            html += `<li class="page-item ${currentPage >= lastPage ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;

            filesPagination.innerHTML = html;

            filesPagination.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = parseInt(this.dataset.page);
                    if (page && page >= 1 && page <= filesTotalPages) {
                        loadFilesDetail(filesCurrentType, page);
                    }
                });
            });
        }

        // ====================================================
        // UPDATE CARD CONTENT (Tabs)
        // ====================================================
        function updateCardContent(tabType) {
            const fourthCard = document.getElementById('card-4');
            const allCards   = document.querySelectorAll('.card-tile');

            allCards.forEach(c => {
                c.classList.remove('col-lg-4', 'col-lg-6', 'col-md-6');
                c.classList.add('col-lg-3', 'col-md-6', 'col-12');
            });
            fourthCard.classList.remove('d-none');

            secondCardText.innerHTML = '';
            thirdCardText.innerHTML  = '';

            document.querySelectorAll('.table-section').forEach(t => t.classList.add('d-none'));
            filesStatusRow.classList.add('d-none');
            filesDetailRow.classList.add('d-none');
            filesStatusOpen = false;
            activeSection = null;

            if (tabType === 'properties') {
                firstCardTitle.textContent = 'Properties';
                firstCardText.innerHTML    = `<span>Total: ${totalProperties}</span>
                    <span class="clickable-span" id="sector-wise-detail-toggle"
                        style="margin-left:10px; cursor:pointer;">Sector Wise Detail</span>`;

                secondCardTitle.innerHTML = `<span class="clickable-span" id="size-breakdown-toggle"
                    style="cursor:pointer;">Size Wise Breakdown</span>`;
                secondCardText.innerHTML  = '';

                thirdCardTitle.innerHTML  = `
                    <div class="third-card-inner">
                        <span class="clickable-span" id="allotment-toggle" style="cursor:pointer;">Allotment</span>
                        <span class="clickable-span" id="data-review-toggle" style="cursor:pointer;">Data Review</span>
                    </div>`;
                thirdCardText.innerHTML   = '';

                document.getElementById('fourth-card-title').textContent = 'Files Status';
                document.getElementById('fourth-card-text').style.whiteSpace = 'normal';
                document.getElementById('fourth-card-text').innerHTML = `
                    <span>Uploaded: {{ $filesUploadedCount }}</span><br>
                    <span>Remaining: {{ $filesRemainingCount }}</span>`;

                const card4 = document.getElementById('card-4');
                card4.style.cursor = 'pointer';
                card4.onclick = function() {
                    if (filesStatusOpen) {
                        filesStatusRow.classList.add('d-none');
                        filesDetailRow.classList.add('d-none');
                        filesStatusOpen = false;
                        uploadedCard.classList.remove('active-status');
                        remainingCard.classList.remove('active-status');
                    } else {
                        filesStatusRow.classList.remove('d-none');
                        filesDetailRow.classList.add('d-none');
                        filesStatusOpen = true;
                        filesStatusRow.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                };

             document.getElementById('sector-wise-detail-toggle')
    ?.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleSection(sectorWiseDetailRow);

        // section open hote hi list load karo (default per_page/page already 10/1 hain)
        if (!sectorWiseDetailRow.classList.contains('d-none')) {
            if (typeof window.loadSectorWiseData === 'function') {
                window.loadSectorWiseData();
            }
        }
    });

                document.getElementById('data-review-toggle')
                    ?.addEventListener('click', (e) => {
                        e.stopPropagation();
                        toggleSection(document.getElementById('data-review-row'));
                        window.loadDataReviewStats();
                    });

                const sizeBreakdownRow = document.getElementById('size-breakdown-row');
                document.getElementById('size-breakdown-toggle')
                    ?.addEventListener('click', function(e) {
                        e.stopPropagation();
                        sizeBreakdownRow.classList.toggle('d-none');
                    });

                document.getElementById('allotment-toggle')
                    ?.addEventListener('click', function(e) {
                        e.stopPropagation();
                        allotmentRow.classList.toggle('d-none');
                    });

            } else if (tabType === 'transfer') {
                firstCardTitle.textContent = 'Requests';
                firstCardText.innerHTML    = `<span class="clickable-span" id="new-toggle">Total Requests: {{ $stats->total_requests }}</span>`;

                secondCardTitle.textContent = 'Completed';
                secondCardText.innerHTML    = `
                    <span class="clickable-span" id="completed-toggle">Completed: {{ $stats->completed_count }}</span>
                    <span class="mx-2"></span>
                    <span class="clickable-span" id="rejected-toggle">Rejected: {{ $stats->rejected_count }}</span>`;

                thirdCardTitle.textContent = 'In Process';
                thirdCardText.innerHTML    = `<span class="clickable-span" id="inprocess-toggle">In Process: {{ $stats->in_process_count }}</span>`;

                document.getElementById('fourth-card-title').textContent = 'Pending';
                document.getElementById('fourth-card-text').style.whiteSpace = 'nowrap';
                document.getElementById('fourth-card-text').innerHTML    = `
                    <span class="clickable-span" id="pending-toggle">Pending: {{ $stats->pending_new_count }}</span>
                    <span class="mx-2"></span>
                    <span class="clickable-span" id="overdue-toggle">Overdue (5+ Days): {{ $stats->pending_overdue_count }}</span>`;

                document.getElementById('new-toggle')       ?.addEventListener('click', () => toggleSection(newTable));
                document.getElementById('completed-toggle') ?.addEventListener('click', () => toggleSection(completedTable));
                document.getElementById('rejected-toggle')  ?.addEventListener('click', () => toggleSection(rejectedTable));
                document.getElementById('inprocess-toggle') ?.addEventListener('click', () => toggleSection(inprocessTable));
                document.getElementById('pending-toggle')   ?.addEventListener('click', () => toggleSection(pendingTable));
                document.getElementById('overdue-toggle')   ?.addEventListener('click', () => toggleSection(overdueTable));

            } else if (tabType === 'complaints') {
                firstCardTitle.textContent  = 'Complaints';
                firstCardText.innerHTML     = '<span>Total: 0</span>';
                secondCardTitle.textContent = 'Suggestions';
                secondCardText.innerHTML    = '<span>Total: 0</span>';
                thirdCardTitle.textContent  = 'Resolved';
                thirdCardText.innerHTML     = '<span>Total: 0</span>';
                document.getElementById('fourth-card-title').textContent = 'Pending';
                document.getElementById('fourth-card-text').innerHTML = '<span>Total: 0</span>';
            }
        }

        // ====================================================
        // FILES STATUS CARD CLICK HANDLERS
        // ====================================================
        uploadedCard?.addEventListener('click', function(e) {
            e.stopPropagation();
            filesDetailRow.classList.remove('d-none');
            loadFilesDetail('uploaded', 1);
            filesDetailRow.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        remainingCard?.addEventListener('click', function(e) {
            e.stopPropagation();
            filesDetailRow.classList.remove('d-none');
            loadFilesDetail('remaining', 1);
            filesDetailRow.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        closeFilesDetail?.addEventListener('click', function() {
            filesDetailRow.classList.add('d-none');
            uploadedCard.classList.remove('active-status');
            remainingCard.classList.remove('active-status');
        });

        // ====================================================
        // BLOCK DROPDOWNS
        // ====================================================
        function handleBlockDropdownsDelegated() {
            document.body.removeEventListener('click', blockClickHandler);
            document.body.addEventListener('click', blockClickHandler);
        }

        function blockClickHandler(e) {
            const button = e.target.closest('.block-toggle');
            if (!button) return;
            e.preventDefault();
            e.stopPropagation();
            const sectorId = button.dataset.sector;
            const dropdown = button.closest('.table-section');
            if (!dropdown) return;
            const sectorRow = dropdown.querySelector(`.sector-main-row[data-sector-id="${sectorId}"]`);
            if (!sectorRow) return;
            const existingRows = dropdown.querySelectorAll(`.block-row[data-sector="${sectorId}"]`);
            if (existingRows.length > 0) {
                existingRows.forEach(row => row.remove());
                const icon = button.querySelector('i');
                if (icon) icon.className = 'bi bi-chevron-down';
                return;
            }
            let blockData = [];
            try {
                const dataAttr = sectorRow.dataset.blockData;
                if (dataAttr && dataAttr !== '[]' && dataAttr !== '') blockData = JSON.parse(dataAttr);
            } catch(e) { console.error('Error parsing block data:', e); }
            if (!blockData || blockData.length === 0) return;
            let lastInsertedRow = sectorRow;
            const isSectorWiseDetail = dropdown.id === 'sector-wise-detail-row';
            blockData.forEach(block => {
                const newRow = document.createElement('tr');
                newRow.classList.add('block-row');
                newRow.setAttribute('data-sector', sectorId);
                const blockName = block.block || 'Unknown';
                if (isSectorWiseDetail) {
                    newRow.innerHTML = `
                        <td style="padding-left: 40px; white-space: nowrap;"><i class="bi bi-dot" style="color:#2980b9;"></i> ${blockName}</td>
                        <td>${block.total_properties ?? 0}</td>
                        <td>${block.plot_count ?? 0}</td>
                        <td>${block.house_count ?? 0}</td>
                        <td>${block.commercial_count ?? 0}</td>
                    `;
                } else {
                    newRow.innerHTML = `
                        <td style="padding-left: 40px; white-space: nowrap;"><i class="bi bi-dot" style="color:#2980b9;"></i> ${blockName}</td>
                        <td class="text-center">${block.total_properties ?? 0}</td>
                        <td class="text-center">${block.plot_count ?? 0}</td>
                        <td class="text-center">${block.house_count ?? 0}</td>
                    `;
                }
                lastInsertedRow.parentNode.insertBefore(newRow, lastInsertedRow.nextSibling);
                lastInsertedRow = newRow;
            });
            const icon = button.querySelector('i');
            if (icon) icon.className = 'bi bi-chevron-up';
        }

        allotmentRow.classList.add("d-none");

        // PIE CHART
        (function renderPieChart() {
            const ctx = document.getElementById('pieChart')?.getContext('2d');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['House', 'Commercial', 'Plot'],
                    datasets: [{
                        data: [categoryData['House']||0, categoryData['Commercial']||0, categoryData['Plot']||0],
                        backgroundColor: ['#0AA1DD', '#D0E8F2', '#E5D1FA'],
                        borderWidth: 3
                    }]
                },
                options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'top' }, tooltip: { enabled: true } } }
            });
        })();

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
            handleBlockDropdownsDelegated();
        }

        init();
    });
    </script>

    <!-- SECTOR WISE CHART -->
    <script>
        const sectorSummaryData = @json($sectorSummary);
        const sectorBlockData   = @json($sectorBlockData);
        const chartCategories   = @json($categories);

        const barColorMap = {
            Plot:       { background: '#E5D1FA', border: '#E5D1FA' },
            Commercial: { background: '#00E0FF', border: '#00E0FF' },
            House:      { background: '#3b8db0', border: '#1D4ED8' }
        };

        const barCtx   = document.getElementById('bar').getContext('2d');
        const titleEl  = document.getElementById('title-graph');
        const backBtn  = document.getElementById('backToSectorsBtn');

        let barChartInstance = null;

        function renderSectorChart() {
            titleEl.textContent = 'MDA - Sector Wise';
            backBtn.classList.add('d-none');
            const labels = sectorSummaryData.map(s => s.name);
            const datasets = chartCategories.map(cat => ({
                label: cat,
                data: sectorSummaryData.map(s => s.counts[cat] || 0),
                backgroundColor: barColorMap[cat]?.background || '#95A5A6',
                borderColor: barColorMap[cat]?.border || '#7f8c8d',
                borderWidth: 1, barPercentage: 0.8, categoryPercentage: 0.8
            }));
            if (barChartInstance) barChartInstance.destroy();
            barChartInstance = new Chart(barCtx, {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    onClick: (evt, elements) => {
                        if (!elements.length) return;
                        const sector = sectorSummaryData[elements[0].index];
                        if (sector) renderBlockChart(sector.id, sector.name);
                    },
                    plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        function renderBlockChart(sectorId, sectorName) {
            titleEl.textContent = `MDA - ${sectorName} (Block Wise)`;
            backBtn.classList.remove('d-none');
            const sectorInfo = sectorBlockData[sectorId];
            const blocks = sectorInfo ? sectorInfo.blocks : {};
            const labels = Object.keys(blocks);
            if (barChartInstance) barChartInstance.destroy();
            if (labels.length === 0) {
                barChartInstance = new Chart(barCtx, { type: 'bar', data: { labels: ['No blocks found'], datasets: [] }, options: { responsive: true, maintainAspectRatio: false } });
                return;
            }
            const datasets = chartCategories.map(cat => ({
                label: cat, data: labels.map(b => blocks[b][cat] || 0),
                backgroundColor: barColorMap[cat]?.background || '#95A5A6',
                borderColor: barColorMap[cat]?.border || '#7f8c8d',
                borderWidth: 1, barPercentage: 0.8, categoryPercentage: 0.8
            }));
            barChartInstance = new Chart(barCtx, {
                type: 'bar', data: { labels, datasets },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false, callbacks: { title: ctx => `Block ${ctx[0].label}` } } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        backBtn.addEventListener('click', renderSectorChart);
        renderSectorChart();
    </script>

    <!-- ADDITIONAL CHARTS -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const allotmentTypeData = @json($allotmentTypeDistribution);
        const allotmentTypeLabels = Object.keys(allotmentTypeData);
        const allotmentTypeValues = Object.values(allotmentTypeData);
        const allotmentColorPalette = ['#F97316', '#06B6D4', '#8B5CF6', '#22C55E', '#EF4444', '#EC4899'];
        const allotmentColors = allotmentTypeLabels.map((label, i) => allotmentColorPalette[i % allotmentColorPalette.length]);
        if (allotmentTypeLabels.length > 0) {
            new Chart(document.getElementById('allotmentTypeChart'), {
                type: 'pie',
                data: { labels: allotmentTypeLabels, datasets: [{ data: allotmentTypeValues, backgroundColor: allotmentColors, borderColor: '#fff', borderWidth: 2 }] },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { size: 10 } } },
                        tooltip: { callbacks: { label: function(context) { let total = context.dataset.data.reduce((a, b) => a + b, 0); let percentage = ((context.parsed / total) * 100).toFixed(1); return context.label + ': ' + context.parsed + ' (' + percentage + '%)'; } } }
                    }
                }
            });
        }

        const ownershipData = @json($ownershipTypeDistribution);
        const ownershipLabels = Object.keys(ownershipData);
        const ownershipValues = Object.values(ownershipData);
        const ownershipColorPalette = ['#7C9D96', '#EAB308', '#0EA5E9', '#14B8A6', '#F97316', '#8B5CF6'];
        const ownershipColors = ownershipLabels.map((label, i) => ownershipColorPalette[i % ownershipColorPalette.length]);
        if (ownershipLabels.length > 0) {
            new Chart(document.getElementById('ownershipTypeChart'), {
                type: 'pie',
                data: { labels: ownershipLabels, datasets: [{ data: ownershipValues, backgroundColor: ownershipColors, borderColor: '#fff', borderWidth: 2 }] },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { size: 10 } } },
                        tooltip: { callbacks: { label: function(context) { let total = context.dataset.data.reduce((a, b) => a + b, 0); let percentage = ((context.parsed / total) * 100).toFixed(1); return context.label + ': ' + context.parsed + ' (' + percentage + '%)'; } } }
                    }
                }
            });
        }
    });
    </script>

</x-app-layout>
