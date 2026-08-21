<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        /* ====================================================
           COLOR VARIABLES - Defined once, used everywhere
        ==================================================== */
        :root {
            /* Primary Colors */
            --color-primary: #4EC9DF;
            --color-primary-dark: #1D4ED8;
            --color-primary-light: #60A5FA;
            --color-primary-gradient: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);

            /* Secondary Colors */
            --color-secondary: #AEB877;
            --color-secondary-dark: #AEB877;

            /* Accent Colors */
            --color-success: #10B981;
            --color-success-dark: #059669;
            --color-warning: #F59E0B;
            --color-warning-dark: #D97706;
            --color-danger: #EF4444;
            --color-danger-dark: #DC2626;
            --color-info: #06B6D4;
            --color-rose: #EC4899;
            --color-indigo: #4F46E5;

            /* Neutral Colors */
            --color-bg: #F1F5F9;
            --color-bg-dark: #E2E8F0;
            --color-white: #FFFFFF;
            --color-black: #1E293B;
            --color-gray: #64748B;
            --color-gray-light: #94A3B8;
            --color-gray-lighter: #F8FAFC;
            --color-gray-border: #E2E8F0;
            --color-shadow: rgba(0,0,0,0.06);
            --color-shadow-hover: rgba(0,0,0,0.10);

            /* Chart Colors */
            --chart-blue: #2563EB;
            --chart-purple: #AEB877;
            --chart-emerald: #10B981;
            --chart-gold: #F59E0B;
            --chart-red: #EF4444;
            --chart-cyan: #06B6D4;
            --chart-pink: #EC4899;
            --chart-violet: #8B5CF6;
            --chart-rose: #F43F5E;
            --chart-teal: #14B8A6;
            --chart-orange: #F97316;

            /* Size Chart Colors */
            --size-5marla: #2563EB;
            --size-7marla: #7C3AED;
            --size-10marla: #10B981;
            --size-12marla: #F59E0B;
            --size-15marla: #EF4444;
            --size-1kanal: #06B6D4;

            /* Bar Chart Colors */
            --bar-commercial: #AEB877;
            --bar-house: #2563EB;
            --bar-plot: #10B981;

            /* Pie Chart Colors */
            --pie-house: #10B981;
            --pie-commercial: #AEB877;
            --pie-plot: #2563EB;

            /* Card Gradients */
            --gradient-info: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
            --gradient-success: linear-gradient(135deg, #10B981 0%, #059669 100%);
            --gradient-warning: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            --gradient-danger: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            --gradient-secondary: linear-gradient(135deg, #64748B 0%, #475569 100%);
            --gradient-title: linear-gradient(135deg, #1E293B 0%, #2563EB 50%, #7C3AED 100%);

            /* Table Gradients */
            --gradient-table-header: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);

            /* Shadows */
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
        body {
            background: linear-gradient(135deg, var(--color-bg) 0%, var(--color-bg-dark) 100%) !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
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
            min-height: 70px;
            border-radius: 16px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 10px 16px !important;
        }
        .small-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px var(--color-shadow-hover);
        }
        .small-box.bg-info {
            background: var(--gradient-info) !important;
        }
        .small-box.bg-success {
            background: var(--gradient-success) !important;
        }
        .small-box.bg-warning {
            background: var(--gradient-warning) !important;
        }
        .small-box.bg-danger {
            background: var(--gradient-danger) !important;
        }
        .small-box.bg-secondary {
            background: var(--gradient-secondary) !important;
        }

        .inner h3 {
            font-size: 1.4rem !important;
            font-weight: 700 !important;
            letter-spacing: -0.5px;
            color: var(--color-white) !important;
            margin: 0 !important;
        }
        .inner p {
            font-size: 1rem !important;
            display: inline-block;
            margin-right: 10px;
            color: rgba(255,255,255,0.9) !important;
            margin: 4px 0 0 0 !important;
        }
        .inner p span {
            margin-right: 15px;
            display: inline-block;
        }

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

        .table-section {
            animation: fadeIn 0.4s ease-in-out;
        }
        .table-section.hide {
            animation: fadeOut 0.5s ease-in-out forwards;
        }

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
            letter-spacing: 0.3px;
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
        .table-section tr:hover td {
            background-color: var(--color-gray-lighter);
        }
        .table-section th:last-child {
            border-top-right-radius: 12px;
        }
        .table-section tr:last-child td:first-child {
            border-bottom-left-radius: 12px;
        }
        .table-section tr:last-child td:last-child {
            border-bottom-right-radius: 12px;
        }

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
        .sector-row:hover td {
            background-color: var(--color-bg-dark) !important;
        }

        .block-row td {
            background-color: #FAFBFC !important;
            padding-left: 40px !important;
        }
        .block-row:hover td {
            background-color: var(--color-bg) !important;
        }

        /* ====================================================
           SECTOR WISE DETAIL TABLE
        ==================================================== */
        .sector-col {
            width: 200px !important;
        }

        .district-header {
            background: none !important;
            color: var(--color-black) !important;
            font-size: 28px !important;
            font-weight: 700 !important;
            text-align: center;
            padding: 16px !important;
            letter-spacing: -0.5px;
            border-bottom: 3px solid var(--color-primary) !important;
        }
        .district-header strong {
            background: var(--color-primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

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
        .equal-height-card .card-tools .btn-tool {
            color: var(--color-gray-light);
            transition: color 0.2s;
        }
        .equal-height-card .card-tools .btn-tool:hover {
            color: var(--color-black);
        }

        .card-info .card-header {
           border-bottom: 3px solid var(--color-primary) !important;
        }
        .card-danger .card-header {
            border-bottom: 3px solid var(--color-danger) !important;
        }
        .card-warning .card-header {
            border-bottom: 3px solid var(--color-warning) !important;
        }
        .card-success .card-header {
            border-bottom: 3px solid var(--color-success) !important;
        }
        .card-primary .card-header {
            border-bottom: 3px solid var(--color-secondary) !important;
        }

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
        .new-chart-card .card-body {
            padding: 15px;
        }

        /* ====================================================
           CHARTS
        ==================================================== */
        .pie-chart-canvas {
            max-width: 400px;
            max-height: 400px;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .chart-container-sm {
            position: relative;
            height: 250px;
            width: 100%;
        }
        .small-chart-container {
            position: relative;
            height: 200px;
            width: 100%;
        }
        canvas {
            pointer-events: auto;
        }

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
        .block-toggle:hover {
            background: rgba(37,99,235,0.15);
        }
        .block-toggle i {
            font-size: 14px;
            transition: transform 0.3s ease;
            color: var(--color-primary);
        }
        .block-toggle i.rotated {
            transform: rotate(180deg);
        }

        /* ====================================================
           DROPDOWN
        ==================================================== */
        .dropdown {
            margin-left: auto;
        }
        .dropdown-toggle {
            font-size: 14px;
            line-height: 1;
            background: transparent;
            border: none;
            padding: 0;
            color: var(--color-gray);
        }
        .dropdown-toggle::after {
            display: none !important;
        }
        .dropdown-menu {
            font-size: 13px;
            min-width: 100px;
            border-radius: 12px;
            box-shadow: 0 8px 32px var(--color-shadow-hover);
            border: none;
            padding: 6px 0;
        }
        .dropdown-menu .dropdown-item {
            padding: 8px 16px;
            transition: all 0.2s;
            font-weight: 500;
        }
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

        /* ====================================================
           ALLOTMENT ROW
        ==================================================== */
        #allotment-row .small-box {
            border-radius: 12px !important;
        }

        /* ====================================================
           STAGE DETAILS
        ==================================================== */
        #stage-details {
            margin-top: -40px;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        /* ====================================================
           MISC
        ==================================================== */
        .town-col {
            width: 5%;
            min-width: 100px;
            max-width: 200px;
        }
        h4 {
            font-size: 1.1rem !important;
            font-weight: 600;
            color: var(--color-black);
        }
        .d-none {
            display: none !important;
        }

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
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--color-bg);
            border-radius: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--color-primary-gradient);
            border-radius: 8px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-indigo);
        }

        /* ====================================================
           RESPONSIVE FINE-TUNING
        ==================================================== */
        @media (max-width: 768px) {
            .title h3 {
                font-size: 1.4rem !important;
                padding: 8px 12px;
            }
            .table-section table {
                width: 100%;
                font-size: 13px;
            }
            .table-section th,
            .table-section td {
                padding: 8px 10px;
            }
            .inner h3 {
                font-size: 1.1rem !important;
            }
            .inner p {
                font-size: 0.85rem !important;
            }
            .equal-height-card {
                height: auto;
                min-height: 350px;
            }
            .district-header {
                font-size: 20px !important;
                padding: 10px !important;
            }
            .main-table-container {
                margin-top: -20px;
                margin-left: 5px;
                margin-right: 5px;
            }
            .tabs3 {
                font-size: 0.8rem !important;
                padding: 8px 10px !important;
            }
            .size-btn {
                padding: 6px 14px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .title h3 {
                font-size: 1.1rem !important;
            }
            .table-section table {
                font-size: 11px;
            }
            .table-section th,
            .table-section td {
                padding: 6px 8px;
            }
            .inner h3 {
                font-size: 0.95rem !important;
            }
            .inner p {
                font-size: 0.75rem !important;
            }
            .clickable-span {
                padding: 2px 8px;
                font-size: 0.75rem;
            }
        }
    </style>

    <body style="background-color: #d7d7d7;">
        <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #d7d7d7 !important;">

            <input type="hidden" id="totalProperties"   value="{{ $totalProperties }}">
            <input type="hidden" id="categoryData"      value="{{ json_encode($categoryData) }}">
            <input type="hidden" id="sectorCategoryData"  value="{{ json_encode($orderedSectorCategoryData) }}">
            <input type="hidden" id="sectorSummaryData" value="{{ json_encode($sectorSummary) }}">
            <input type="hidden" id="sectorBlockData"   value="{{ json_encode($sectorBlockData) }}">

            <div class="row mt-2">
                <div class="col title" style="display:flex;justify-content:center; margin-right:40px;">
                    <h3>MIRPUR DEVELOPMENT AUTHORITY (MDA)</h3>
                </div>
            </div>

<div class="row mx-1 mb-1 g-2">
    <div class="col-lg-4 col-6 text-center p-2 tabs3"
        style="box-shadow:0px 0px 10px rgb(209,209,209) inset; cursor:pointer; background-color:#f5f5f5;"
        data-tab="properties">Properties</div>
    <div class="col-lg-4 col-6 text-center p-2 tabs3 disabled-tab"
        style="box-shadow:0px 0px 10px rgb(209,209,209) inset; background-color:#f5f5f5;"
        data-tab="transfer">Transfer & Other Request's</div>
    <div class="col-lg-4 col-6 text-center p-2 tabs3 disabled-tab"
        style="box-shadow:0px 0px 10px rgb(209,209,209) inset; background-color:#f5f5f5;"
        data-tab="complaints">Complaints/Suggestions</div>
</div>

            <div class="row px-2 py-3" id="card-row">
                <div class="card-tile col-lg-4 col-md-6 col-12 mb-3" id="card-1">
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
            </div>

            <div id="stage-details" style="margin-top:-40px; margin-bottom:20px; position:relative; z-index:2;"></div>

            <!-- ═══════════════════════════════════════════════
                 MAIN TABLE CONTAINER
            ════════════════════════════════════════════════ -->
            <div class="main-table-container">

            @php
            $tables = [
                'new' => [
                    'label'      => 'Total REQUEST',
                    'sector_total' => 'total_requests',
                    'sector_original' => 'original_allottee_pending',
                    'sector_transfer'  => 'transfer_allottee_pending',
                ],
                'completed' => [
                    'label'      => 'COMPLETED REQUEST',
                    'sector_total' => 'total_requests',
                    'sector_original' => 'original_allottee_completed',
                    'sector_transfer'  => 'transfer_allottee_completed',
                ],
                'inprocess' => [
                    'label'      => 'IN PROCESS REQUEST',
                    'sector_total' => 'total_requests',
                    'sector_original' => 'original_allottee_inprocess',
                    'sector_transfer'  => 'transfer_allottee_inprocess',
                ],
                'pending' => [
                    'label'      => 'PENDING REQUEST',
                    'sector_total' => 'total_requests',
                    'sector_original' => 'original_allottee_pending',
                    'sector_transfer'  => 'transfer_allottee_pending',
                ],
                'rejected' => [
                    'label'      => 'REJECTED REQUEST',
                    'sector_total' => 'total_requests',
                    'sector_original' => 'original_allottee_rejected',
                    'sector_transfer'  => 'transfer_allottee_rejected',
                ],
                'overdue' => [
                    'label'      => 'OVERDUE REQUEST',
                    'sector_total' => 'total_requests',
                    'sector_original' => 'original_allottee_pending',
                    'sector_transfer'  => 'transfer_allottee_pending',
                ],
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
                                <i class="bi bi-chevron-right"
                                   id="arrow-{{ $status }}-{{ $sector->sector_id }}"
                                   style="font-size:11px; color:#888; transition:transform 0.2s;"></i>
                            </td>
                            <td class="text-center">{{ $sector->{$cfg['sector_total']} ?? 0 }}</td>
                            <td class="text-center">{{ $sector->{$cfg['sector_original']} ?? 0 }}</td>
                            <td class="text-center">{{ $sector->{$cfg['sector_transfer']} ?? 0 }}</td>
                        </tr>
                        @if(isset($sectorBlockWiseDetails) && !empty($sectorBlockWiseDetails))
                            @php
                                $sectorBlocks = $sectorBlockWiseDetails->where('sector_id', $sector->sector_id);
                            @endphp
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

            </div>{{-- end .main-table-container --}}

            <!-- SECTOR WISE DETAIL TABLE -->
<!-- SECTOR WISE DETAIL TABLE -->
<div class="table-section d-none" id="sector-wise-detail-row" style="margin-bottom:50px; margin-top:1px;">
    <div class="table-name"></div>
    <div class="table-responsive" style="overflow-x: auto;">
        <table class="table table-bordered" style="width:100%; border-collapse:collapse; table-layout:fixed;">
            <colgroup>
                <col style="width:20%; min-width:150px; max-width:250px;">
                <col style="width:20%;">
                <col style="width:20%;">
                <col style="width:20%;">
                <col style="width:20%;">
            </colgroup>
            <thead>
                <tr>
                    <th colspan="5" class="district-header" style="text-align:center; padding:10px;">
                        <strong>SECTOR WISE DETAIL</strong>
                    </th>
                </tr>
                <tr>
                    <th style="text-align:center; padding:10px 8px;">Sector</th>
                    <th style="text-align:center; padding:10px 8px;">Properties</th>
                    <th style="text-align:center; padding:10px 8px;">Plots</th>
                    <th style="text-align:center; padding:10px 8px;">House</th>
                    <th style="text-align:center; padding:10px 8px;">Commercial</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sectorWiseDetailsGrouped as $sector)
                <tr class="sector-main-row"
                    data-sector-id="{{ $sector['id'] }}"
                    data-block-order="{{ implode(',', $sector['block_order'] ?? []) }}"
                    data-block-data="{{ json_encode($sector['block_data'] ?? []) }}">
                    <td style="white-space: normal; word-wrap: break-word; word-break: break-word; padding:10px 8px; vertical-align:middle;">
                        <div style="display:flex; align-items:center; flex-wrap:wrap; gap:4px;">
                            <span style="flex:1; min-width:60px;">{{ $sector['name'] }}</span>
                            <button class="btn btn-sm p-0 ms-1 bg-transparent border-0 block-toggle flex-shrink-0"
                                type="button" data-sector="{{ $sector['id'] }}" title="Toggle Blocks">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>
                    </td>
                    <td style="text-align:center; padding:10px 8px; white-space:nowrap;">{{ $sector['total_properties'] }}</td>
                    <td style="text-align:center; padding:10px 8px; white-space:nowrap;">{{ $sector['plot_count'] }}</td>
                    <td style="text-align:center; padding:10px 8px; white-space:nowrap;">{{ $sector['house_count'] }}</td>
                    <td style="text-align:center; padding:10px 8px; white-space:nowrap;">{{ $sector['commercial_count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

        </div>{{-- end overflow-hidden --}}

        <!-- ═══════════════════════════════════════════════
             CHARTS SECTION
        ════════════════════════════════════════════════ -->
        <div class="col-lg-12">
            <div class="card card-info" id="center">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title" id="title-graph">MDA - Sector Wise</h3>
                    <button type="button" id="backToSectorsBtn" class="btn btn-sm btn-outline-primary d-none">
                        &larr; Back to Sectors
                    </button>
                    <div class="card-tools d-flex gap-1">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus" style="color: #1E293B;"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times" style="color: #1E293B;"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bar" style="max-height:500px; max-width:100%; pointer-events:auto;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-12" style="margin-top:30px;">
            <div class="row px-2 py-3" style="margin-top:-25px;">
                <div class="col-lg-6">
                    <div class="card card-info equal-height-card">
                        <div class="card-header">
                            <h3 class="card-title">MDA-Total Representation</h3>
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
                <div class="col-lg-3">
                    <div class="card card-danger equal-height-card new-chart-card">
                        <div class="card-header">
                            <h3 class="card-title">Allotment Type</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="small-chart-container">
                                <canvas id="allotmentTypeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-warning equal-height-card new-chart-card">
                        <div class="card-header">
                            <h3 class="card-title">Ownership Type</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="small-chart-container">
                                <canvas id="ownershipTypeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ====================================================
        // COLOR VARIABLES FOR JAVASCRIPT
        // ====================================================
        const COLORS = {
            primary: '#2563EB',
            secondary: '#7C3AED',
            success: '#10B981',
            warning: '#F59E0B',
            danger: '#EF4444',
            info: '#06B6D4',
            rose: '#EC4899',
            violet: '#8B5CF6',

            // Chart 1: MDA-Total Representation
            pie: {
                house: '#0AA1DD',       // Fresh Green
                commercial: '#D0E8F2',  // Vibrant Purple
                plot: '#E5D1FA'         // Sky Blue
            },

            bar: {
                commercial: { background: '#00E0FF', border: '#00E0FF' },
                house: { background: '#2563EB', border: '#1D4ED8' },
                plot: { background: '#E5D1FA', border: '#E5D1FA' }
            },

            size: {
                '5 Marla': '#2563EB',
                '7 Marla': '#7C3AED',
                '10 Marla': '#10B981',
                '12 Marla': '#F59E0B',
                '15 Marla': '#EF4444',
                '1 Kanal': '#06B6D4'
            },

            // Chart 2: Allotment Type (original / transferee)
            allotmentType: {
                'original': '#F97316',    // Bold Orange
                'transferee': '#06B6D4'   // Bright Cyan
            },

            // Chart 3: Ownership Type (single / multiple)
            ownershipType: {
                'single': '#EC4899',      // Hot Pink
                'multiple': '#EAB308'     // Golden Yellow
            },

            allotmentMode: {
                'Ballot': '#2563EB',
                'Direct': '#10B981',
                'Transfer': '#7C3AED',
                'Exchange': '#F59E0B',
                'Auction': '#EF4444',
                'Gifted': '#06B6D4',
                'Inherited': '#EC4899'
            }
        };

        // ====================================================
        // TOGGLE SECTOR FUNCTION
        // ====================================================
        function toggleSector(key) {
            const rows  = document.querySelectorAll('.block-' + key);
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

        // All tables
        const newTable            = document.getElementById('new-table');
        const completedTable      = document.getElementById('completed-table');
        const inprocessTable      = document.getElementById('inprocess-table');
        const pendingTable        = document.getElementById('pending-table');
        const rejectedTable       = document.getElementById('rejected-table');
        const overdueTable        = document.getElementById('overdue-table');
        const sectorWiseDetailRow   = document.getElementById('sector-wise-detail-row');

        const allotmentRow        = document.getElementById('allotment-row');
        const allotmentDetailRow  = document.createElement('div');
        allotmentDetailRow.id = 'allotment-detail-row';
        allotmentDetailRow.classList.add('mt-3', 'd-none');
        allotmentRow.insertAdjacentElement('afterend', allotmentDetailRow);

        const totalProperties = document.getElementById('totalProperties')?.value || '0';
        const categoryData    = JSON.parse(document.getElementById('categoryData')?.value || '{}');
        const sectorCategoryData = JSON.parse(document.getElementById('sectorCategoryData')?.value || '{}');

        let activeSection = null;

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

            document.querySelectorAll('.table-section').forEach(t => t.classList.add('d-none'));
            activeSection = null;

            if (tabType === 'properties') {
                firstCardTitle.textContent = 'Properties';
                firstCardText.innerHTML    = `<span>Total: ${totalProperties}</span>
                    <span class="clickable-span" id="sector-wise-detail-toggle"
                        style="margin-left:80px; cursor:pointer;">Sector Wise Detail</span>`;

                secondCardTitle.innerHTML = `<span class="clickable-span" id="size-breakdown-toggle"
                    style="cursor:pointer;">Size Wise Breakdown</span>`;
                secondCardText.innerHTML  = '';

                thirdCardTitle.innerHTML  = `
                    <div style="display:flex; justify-content:flex-start; align-items:center; gap:80px;">
                        <span class="clickable-span" id="allotment-toggle" style="cursor:pointer; margin-left:10px;">Allotment</span>
                        <span class="clickable-span" id="data-review-toggle" style="cursor:pointer;">Data Review</span>
                    </div>`;
                thirdCardText.innerHTML   = '';

                document.getElementById('sector-wise-detail-toggle')
                    ?.addEventListener('click', () => toggleSection(sectorWiseDetailRow));
                document.getElementById('data-review-toggle')
                    ?.addEventListener('click', () => toggleSection(document.getElementById('data-review-row')));

                const sizeBreakdownRow = document.getElementById('size-breakdown-row');
                document.getElementById('size-breakdown-toggle')
                    ?.addEventListener('click', function() {
                        sizeBreakdownRow.classList.toggle('d-none');
                    });

                document.getElementById('allotment-toggle')
                    ?.addEventListener('click', function() {
                        allotmentRow.classList.toggle('d-none');
                    });

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

        // ============================================================
        // BLOCK TOGGLE HANDLER
        // ============================================================
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
                if (icon) {
                    icon.className = 'bi bi-chevron-down';
                }
                return;
            }

            let blockData = [];
            try {
                const dataAttr = sectorRow.dataset.blockData;
                if (dataAttr && dataAttr !== '[]' && dataAttr !== '') {
                    blockData = JSON.parse(dataAttr);
                }
            } catch(e) {
                console.error('Error parsing block data:', e);
            }

            if (!blockData || blockData.length === 0) {
                const hiddenRows = dropdown.querySelectorAll(`.block-row.d-none.block-${sectorId}`);
                if (hiddenRows.length > 0) {
                    hiddenRows.forEach(row => {
                        row.classList.remove('d-none');
                        row.setAttribute('data-sector', sectorId);
                        row.className = row.className
                            .split(' ')
                            .filter(cls => !cls.startsWith('block-'))
                            .join(' ');
                        row.classList.add('block-row');
                    });
                    const icon = button.querySelector('i');
                    if (icon) {
                        icon.className = 'bi bi-chevron-up';
                    }
                    return;
                }
                return;
            }

            const blockOrder = (sectorRow.dataset.blockOrder || '')
                .split(',')
                .map(s => s.trim())
                .filter(s => s);

            const orderedBlocks = blockOrder.length > 0
                ? blockOrder.map(blockName => {
                    const found = blockData.find(b => b.block === blockName);
                    return found || {
                        block: blockName,
                        total_properties: 0,
                        plot_count: 0,
                        house_count: 0,
                        commercial_count: 0
                    };
                })
                : blockData;

            let lastInsertedRow = sectorRow;
            const isSectorWiseDetail = dropdown.id === 'sector-wise-detail-row';

            orderedBlocks.forEach(block => {
                const newRow = document.createElement('tr');
                newRow.classList.add('block-row');
                newRow.setAttribute('data-sector', sectorId);

                const blockName = block.block || 'Unknown';

                if (isSectorWiseDetail) {
                    newRow.innerHTML = `
                        <td style="padding-left: 40px; white-space: nowrap;">
                            <i class="bi bi-dot" style="color:#2980b9;"></i>
                            ${blockName}
                        </td>
                        <td>${block.total_properties ?? 0}</td>
                        <td>${block.plot_count ?? 0}</td>
                        <td>${block.house_count ?? 0}</td>
                        <td>${block.commercial_count ?? 0}</td>
                    `;
                } else {
                    newRow.innerHTML = `
                        <td style="padding-left: 40px; white-space: nowrap;">
                            <i class="bi bi-dot" style="color:#2980b9;"></i>
                            ${blockName}
                        </td>
                        <td class="text-center">${block.total_properties ?? 0}</td>
                        <td class="text-center">${block.plot_count ?? 0}</td>
                        <td class="text-center">${block.house_count ?? 0}</td>
                    `;
                }

                lastInsertedRow.parentNode.insertBefore(newRow, lastInsertedRow.nextSibling);
                lastInsertedRow = newRow;
            });

            const icon = button.querySelector('i');
            if (icon) {
                icon.className = 'bi bi-chevron-up';
            }
        }

        allotmentRow.classList.add("d-none");

        // ============================================================
        // PIE CHART - Total Representation
        // ============================================================
        (function renderPieChart() {
            const ctx = document.getElementById('pieChart')?.getContext('2d');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['House', 'Commercial', 'Plot'],
                    datasets: [{
                        data: [categoryData['House']||0, categoryData['Commercial']||0, categoryData['Plot']||0],
                        backgroundColor: [COLORS.pie.house, COLORS.pie.commercial, COLORS.pie.plot],
                      //  borderColor: ['#059669', '#6D28D9', '#1D4ED8'],
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { enabled: true }
                    }
                }
            });
        })();

        // ============================================================
        // SECTOR BAR CHART
        // ============================================================
        (function renderSectorBarChart() {
            const ctx = document.getElementById('barChart')?.getContext('2d');
            if (!ctx) return;
            const labels = Object.keys(sectorCategoryData);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        { label:'Commercial', data:labels.map(s=>sectorCategoryData[s]?.Commercial||0), backgroundColor: COLORS.bar.commercial.background, borderColor: COLORS.bar.commercial.border, borderWidth:1 },
                        { label:'House', data:labels.map(s=>sectorCategoryData[s]?.House||0), backgroundColor: COLORS.bar.house.background, borderColor: COLORS.bar.house.border, borderWidth:1 },
                        { label:'Plot', data:labels.map(s=>sectorCategoryData[s]?.Plot||0), backgroundColor: COLORS.bar.plot.background, borderColor: COLORS.bar.plot.border, borderWidth:1 }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode:'index', intersect: false },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: ctx => ctx[0].label,
                                label: ctx => `${ctx.dataset.label}: ${sectorCategoryData[ctx.label]?.[ctx.dataset.label]||0}`
                            }
                        },
                        legend: { position: 'top' }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        })();

        // Tab click handlers
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

    <!-- ============================================================
         SECTOR WISE CHART
    ============================================================ -->
    <script>
        const sectorSummaryData = @json($sectorSummary);
        const sectorBlockData   = @json($sectorBlockData);
        const chartCategories   = @json($categories);

        const barColorMap = {
            Plot:       { background: COLORS.bar.plot.background, border: COLORS.bar.plot.border },
            Commercial: { background: COLORS.bar.commercial.background, border: COLORS.bar.commercial.border },
            House:      { background: COLORS.bar.house.background, border: COLORS.bar.house.border }
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
                borderWidth: 1,
                barPercentage: 0.8,
                categoryPercentage: 0.8
            }));

            if (barChartInstance) barChartInstance.destroy();

            barChartInstance = new Chart(barCtx, {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    onClick: (evt, elements) => {
                        if (!elements.length) return;
                        const sector = sectorSummaryData[elements[0].index];
                        if (sector) renderBlockChart(sector.id, sector.name);
                    },
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { mode: 'index', intersect: false }
                    },
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
                barChartInstance = new Chart(barCtx, {
                    type: 'bar',
                    data: { labels: ['No blocks found'], datasets: [] },
                    options: { responsive: true }
                });
                return;
            }

            const datasets = chartCategories.map(cat => ({
                label: cat,
                data: labels.map(b => blocks[b][cat] || 0),
                backgroundColor: barColorMap[cat]?.background || '#95A5A6',
                borderColor: barColorMap[cat]?.border || '#7f8c8d',
                borderWidth: 1,
                barPercentage: 0.8,
                categoryPercentage: 0.8
            }));

            barChartInstance = new Chart(barCtx, {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: { title: ctx => `Block ${ctx[0].label}` }
                        }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        backBtn.addEventListener('click', renderSectorChart);
        renderSectorChart();
    </script>

    <!-- ============================================================
         SIZE WISE CHART
    ============================================================ -->
    <script>
        const allSizeData = @json($sizeChartData);
        const sectorChartCtx = document.getElementById('sectorBlockChart').getContext('2d');

        let currentChart = null;

        const colorPerSize = COLORS.size;

        function drawChart(sizeLabel) {
            const sizeData = allSizeData[sizeLabel] || {};
            const fullLabels  = [];
            const shortLabels = [];
            const dataValues  = [];
            const fakeSpacingLabel = " ";

            let lastSector = '';
            Object.keys(sizeData).forEach((key) => {
                const [sector, block] = key.split('|').map(str => str.trim());
                if (sector !== lastSector && lastSector !== '') {
                    fullLabels.push(fakeSpacingLabel);
                    shortLabels.push('');
                    dataValues.push(null);
                }
                fullLabels.push(key);
                shortLabels.push(block);
                dataValues.push(sizeData[key]);
                lastSector = sector;
            });

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
                                    return label.replace('|', ' - Block ');
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
                    id: 'groupSectorLabelsSize',
                    afterDraw(chart) {
                        const {
                            ctx,
                            chartArea: { bottom },
                            scales: { x }
                        } = chart;
                        ctx.save();
                        let currentSector = '';
                        let startX = null;

                        for (let i = 0; i < fullLabels.length; i++) {
                            const label = fullLabels[i];
                            if (label === fakeSpacingLabel) continue;
                            const [sector] = label.split('|').map(str => str.trim());
                            if (sector !== currentSector) {
                                if (currentSector && startX !== null) {
                                    const endX = x.getPixelForValue(i - 1);
                                    const center = (startX + endX) / 2;
                                    ctx.fillStyle = '#000';
                                    ctx.font = 'bold 12px sans-serif';
                                    ctx.textAlign = 'center';
                                    ctx.fillText(currentSector, center, bottom + 50);
                                }
                                currentSector = sector;
                                startX = x.getPixelForValue(i);
                            }
                        }
                        if (currentSector && startX !== null) {
                            const endX = x.getPixelForValue(fullLabels.length - 1);
                            const center = (startX + endX) / 2;
                            ctx.fillStyle = '#000';
                            ctx.font = 'bold 12px sans-serif';
                            ctx.textAlign = 'center';
                            ctx.fillText(currentSector, center, bottom + 50);
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
            const firstSizeLabel = Object.keys(allSizeData)[0];
            if (firstSizeLabel) {
                drawChart(firstSizeLabel);
                setActiveButton(firstSizeLabel);
            }
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

    <!-- ============================================================
         ADDITIONAL CHARTS
    ============================================================ -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Allotment Mode Distribution (Doughnut Chart)
        const modeData = @json($allotmentModeDistribution);
        const modeLabels = Object.keys(modeData);
        const modeValues = Object.values(modeData);
        const modeColors = Object.values(COLORS.allotmentMode);

        if (modeLabels.length > 0) {
            new Chart(document.getElementById('allotmentModeChart'), {
                type: 'doughnut',
                data: {
                    labels: modeLabels,
                    datasets: [{
                        data: modeValues,
                        backgroundColor: modeColors.slice(0, modeLabels.length),
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { font: { size: 11 } }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        // 2. Allotment Type Distribution (Pie Chart)
        // 2. Allotment Type Distribution (Pie Chart)
        const allotmentTypeData = @json($allotmentTypeDistribution);
        const allotmentTypeLabels = Object.keys(allotmentTypeData);
        const allotmentTypeValues = Object.values(allotmentTypeData);
        const allotmentColorPalette = ['#F97316', '#06B6D4', '#8B5CF6', '#22C55E', '#EF4444', '#EC4899'];
        const allotmentColors = allotmentTypeLabels.map((label, i) => allotmentColorPalette[i % allotmentColorPalette.length]);

        if (allotmentTypeLabels.length > 0) {
            new Chart(document.getElementById('allotmentTypeChart'), {
                type: 'pie',
                data: {
                    labels: allotmentTypeLabels,
                    datasets: [{
                        data: allotmentTypeValues,
                        backgroundColor: allotmentColors,
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 10 } }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        // 3. Ownership Type Distribution (Pie Chart)
        const ownershipData = @json($ownershipTypeDistribution);
        const ownershipLabels = Object.keys(ownershipData);
        const ownershipValues = Object.values(ownershipData);
        const ownershipColorPalette = ['#7C9D96', '#EAB308', '#0EA5E9', '#14B8A6', '#F97316', '#8B5CF6'];
        const ownershipColors = ownershipLabels.map((label, i) => ownershipColorPalette[i % ownershipColorPalette.length]);

        if (ownershipLabels.length > 0) {
            new Chart(document.getElementById('ownershipTypeChart'), {
                type: 'pie',
                data: {
                    labels: ownershipLabels,
                    datasets: [{
                        data: ownershipValues,
                        backgroundColor: ownershipColors,
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 10 } }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

    });
    </script>

</x-app-layout>
