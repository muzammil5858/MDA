<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        /* ====================================================
           TOKENS
        ==================================================== */
        :root {
            --c-primary: #3b8db0;
            --c-accent: #4EC9DF;
            --c-green: #5f9e6e;
            --c-blue: #647FBC;
            --c-danger: #EF4444;
            --c-bg: #F1F5F9;
            --c-bg-dark: #E2E8F0;
            --c-border: #E2E8F0;
            --c-text: #0f172a;
            --c-muted: #64748B;
            --g-danger: linear-gradient(135deg, #EF4444, #DC2626);
            --g-slate: linear-gradient(135deg, #64748B, #475569);
            --r-lg: 16px;
            --r-md: 12px;
            --shadow-sm: 0 2px 8px rgba(0,0,0,.06);
            --shadow-card: 0 4px 24px rgba(0,0,0,.06);
            --shadow-hover: 0 12px 40px rgba(0,0,0,.10);
        }

        /* ====================================================
           BASE
        ==================================================== */
        html, body { overflow-x: hidden; max-width: 100%; }
        body {
            background: linear-gradient(135deg, var(--c-bg), var(--c-bg-dark)) !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }
        .d-none { display: none !important; }

        .dash {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: .5rem clamp(.5rem, 2vw, 1.25rem) 2rem;
            color: var(--c-text);
        }
        .dash *, .dash *::before, .dash *::after { box-sizing: border-box; }
        .dash :is(button, a, input, select):focus-visible {
            outline: 2px solid var(--c-accent);
            outline-offset: 2px;
        }

        .dash-title {
            text-align: center;
            font-weight: 800;
            line-height: 1.25;
            color: var(--c-primary);
            font-size: clamp(1.05rem, .6rem + 2vw, 2rem);
            margin: .75rem 0 1rem;
        }

        /* ====================================================
           TABS
        ==================================================== */
        .dash-tabs {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .5rem;
            margin-bottom: 1rem;
        }
        .dash-tab {
            border: 0;
            border-radius: var(--r-md);
            padding: .7rem .5rem;
            background: #fff;
            color: var(--c-text);
            font-weight: 600;
            font-size: clamp(.72rem, .55rem + .8vw, .95rem);
            line-height: 1.25;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }
        .dash-tab:not(:disabled):hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }
        .dash-tab.active {
            background: var(--c-primary);
            color: #fff;
            box-shadow: 0 8px 24px rgba(59,141,176,.35);
            transform: translateY(-2px);
        }
        .dash-tab:disabled { opacity: .5; cursor: not-allowed; color: #fff; filter: grayscale(.3); }
        .dash-tab--green { background: var(--c-green); }
        .dash-tab--blue  { background: var(--c-blue); }

        /* ====================================================
           STAT CARDS
        ==================================================== */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        .stat {
            min-height: 110px;
            padding: .75rem 1rem;
            border-radius: var(--r-lg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            text-align: center;
            color: #fff;
            box-shadow: var(--shadow-sm);
            transition: transform .2s, box-shadow .2s;
        }
        .stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-hover); }
        .stat[data-action], .stat[data-files] { cursor: pointer; }
        .stat--info   { background: var(--c-primary); }
        .stat--green  { background: var(--c-green); }
        .stat--blue   { background: var(--c-blue); }
        .stat--slate  { background: var(--g-slate); }
        .stat--danger { background: var(--g-danger); }
        .stat.active-status { outline: 3px solid #fff; outline-offset: -3px; }

        .stat-title { margin: 0; font-weight: 700; font-size: clamp(1.05rem, .9rem + .5vw, 1.4rem); color: #fff; }
        .stat-title:empty { display: none; }
        .stat-body {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: .4rem .6rem;
            width: 100%;
            font-size: .92rem;
            color: rgba(255,255,255,.92);
        }
        .stat-body > div { width: 100%; }
        .stat-count { font-size: 1.2rem; font-weight: 700; }

        .chip {
            border: 0;
            font: inherit;
            font-size: .78rem;
            font-weight: 600;
            color: inherit;
            padding: .25rem .7rem;
            border-radius: 8px;
            background: rgba(255,255,255,.18);
            cursor: pointer;
            transition: background .2s;
        }
        .chip:hover { background: rgba(255,255,255,.3); }

        /* ====================================================
           PANELS
        ==================================================== */
        .panel { margin-bottom: 1.5rem; animation: fadeIn .3s ease; }
        .panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: .5rem;
            margin-bottom: .75rem;
        }
        .panel-title { margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--c-primary); }
        .state-msg { padding: 1.5rem; text-align: center; }

        .pill-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: .6rem;
        }
        .size-pill {
            padding: .7rem;
            text-align: center;
            font-weight: 700;
            color: #000;
            background: #fff;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            box-shadow: var(--shadow-sm);
        }

        .btn-pill {
            border-radius: 100px;
            font-size: .85rem;
            font-weight: 600;
            padding: .35rem 1rem;
        }
        #backToSectorsBtn {
            border: 2px solid var(--c-accent);
            color: var(--c-primary);
            background: transparent;
            transition: all .2s;
        }
        #backToSectorsBtn:hover { background: var(--c-primary); color: #fff; border-color: var(--c-primary); }

        /* ====================================================
           TABLES
        ==================================================== */
        .table-wrap {
            overflow-x: auto;
            background: #fff;
            border-radius: var(--r-md);
            box-shadow: var(--shadow-card);
            -webkit-overflow-scrolling: touch;
        }
        .table-wrap--narrow { max-width: 1000px; margin-inline: auto; }

        .dash-table { width: 100%; min-width: 560px; border-collapse: separate; border-spacing: 0; font-size: .92rem; }
        .dash-table.min-md { min-width: 720px; }
        .dash-table.min-lg { min-width: 900px; }
        .dash-table th {
            background: var(--c-primary);
            color: #fff;
            font-weight: 600;
            font-size: .85rem;
            padding: .7rem .9rem;
            text-align: center;
            white-space: nowrap;
        }
        .dash-table td {
            padding: .6rem .9rem;
            text-align: center;
            vertical-align: middle;
            font-weight: 500;
            color: var(--c-text);
            border-bottom: 1px solid var(--c-bg);
        }
        .dash-table th.text-start, .dash-table td.text-start { text-align: left; }
        .dash-table tbody tr:hover td { background: #F8FAFC; }

        .sector-row { cursor: pointer; }
        .sector-row td { font-weight: 600; }
        .sector-row.is-empty td, .block-row.is-empty td { color: #999; font-weight: 400; }
        .block-row td { background: #FAFBFC; }
        .block-row td:first-child { padding-left: 2rem; }
        .row-arrow {
            display: inline-block;
            margin-left: .4rem;
            font-size: .7rem;
            color: var(--c-muted);
            transition: transform .2s;
        }
        .sector-row.open .row-arrow { transform: rotate(90deg); }

        .btn-view { border-radius: 8px; white-space: nowrap; }

        .num-chip {
            display: inline-block;
            min-width: 2.5rem;
            padding: .25rem .7rem;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: filter .2s;
        }
        .num-chip:hover { filter: brightness(.94); }
        .num-chip--info { background: rgba(37,99,235,.08); color: #03346E; }
        .num-chip--ok   { background: rgba(16,185,129,.12); color: #10B981; }
        .num-chip--bad  { background: rgba(239,68,68,.12);  color: #EF4444; }

        /* Toolbar + pagination */
        .toolbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: .75rem;
            background: #f8f9fa;
            padding: .75rem;
            border-radius: 8px;
            margin-bottom: .75rem;
        }
        .toolbar-group { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
        .toolbar-search { flex: 1 1 260px; }
        .toolbar-search .form-control { flex: 1; min-width: 0; max-width: 320px; height: 36px; border-radius: 8px; font-size: .9rem; }
        .toolbar .form-select { width: auto; height: 36px; border-radius: 8px; font-size: .9rem; padding: 2px 30px 2px 10px; }
        .toolbar .btn-primary { height: 36px; border-radius: 8px; background: var(--c-primary); border: 0; }
        .toolbar-info { font-size: .88rem; color: var(--c-muted); }

        .pager { display: flex; justify-content: flex-end; margin-top: .75rem; }
        .pager .pagination { margin: 0; flex-wrap: wrap; }
        .dash .page-link { color: var(--c-primary); }
        .dash .page-item.active .page-link { background: var(--c-primary); border-color: var(--c-primary); color: #fff; }

        /* Entry creation */
        .entry-date-btn {
            display: inline-flex;
            align-items: center;
            background: var(--c-primary);
            color: #fff;
            border: 0;
            border-radius: 100px;
            padding: .4rem 1rem;
            font-size: .85rem;
            font-weight: 600;
        }
        .entry-date-btn:hover, .entry-date-btn:focus { background: var(--c-primary); color: #fff; }
        .entry-date-btn::after { display: none; }
        .entry-date-menu { max-height: 300px; overflow-y: auto; border: 0; border-radius: var(--r-md); box-shadow: var(--shadow-hover); }
        .entry-date-menu .dropdown-item.active { background: var(--c-primary); }

        .date-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.1rem 0 .5rem;
            padding: .6rem 1rem;
            background: var(--c-bg);
            color: #03346E;
            font-weight: 700;
            border-radius: 10px;
        }
        .date-toggle {
            border: 0;
            border-radius: 8px;
            padding: .15rem .65rem;
            background: rgba(37,99,235,.10);
            color: var(--c-primary);
            cursor: pointer;
        }
        .date-toggle:hover { background: rgba(37,99,235,.20); }

        /* ====================================================
           CHARTS
        ==================================================== */
.chart-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.chart-grid > * { min-width: 0; }              /* grid item ko shrink hone dein */
.chart-grid .span-2 { grid-column: span 2; }

.chart-card {
    --line: var(--c-accent);
    display: flex;
    flex-direction: column;
    height: 100%;
    min-width: 0;
    overflow: hidden;
    background: #fff;
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-card);
}

.chart-card-body {
    flex: 1;
    min-width: 0;                              /* flex overflow fix */
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}

.chart-box {
    position: relative;
    width: 100%;
    max-width: 100%;
    min-width: 0;                              /* canvas ko container se bahar na jaane de */
    margin-inline: auto;
    height: clamp(250px, 55vw, 360px);
}
.chart-box canvas { display: block; max-width: 100%; }

.chart-scroll { width: 100%; min-width: 0; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .chart-scroll-inner { position: relative; width: 100%; height: clamp(320px, 65vw, 520px); }

        /* ====================================================
           MISC
        ==================================================== */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--c-bg); border-radius: 8px; }
        ::-webkit-scrollbar-thumb { background: var(--c-primary); border-radius: 8px; }

        @media (prefers-reduced-motion: reduce) {
            .panel { animation: none; }
            .stat, .dash-tab, .row-arrow { transition: none; }
            .stat:hover, .dash-tab:hover { transform: none; }
        }

        /* ====================================================
           RESPONSIVE
        ==================================================== */
        @media (max-width: 991.98px) {
            .chart-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .chart-grid .span-2 { grid-column: 1 / -1; }
        }
        @media (max-width: 767.98px) {
            .toolbar-group:last-child { width: 100%; justify-content: space-between; }
        }
        @media (max-width: 575.98px) {
            .chart-card-body { padding: .5rem; }
.chart-box { height: clamp(260px, 80vw, 340px); }
.chart-card-head { padding: .75rem .9rem; }
            .chart-grid { grid-template-columns: 1fr; }
            .dash-table th, .dash-table td { padding: .45rem .5rem; font-size: .8rem; }
            .stat { min-height: 96px; }
            .panel-title { font-size: 1rem; }
            .pager { justify-content: center; }
            .toolbar-search .form-control { max-width: none; }
        }
    </style>

    <div class="dash">

        <h1 class="dash-title">MIRPUR DEVELOPMENT AUTHORITY (MDA)</h1>

        <!-- TABS -->
        <nav class="dash-tabs" id="dashTabs">
            <button type="button" class="dash-tab" data-tab="properties">Properties</button>
            <button type="button" class="dash-tab dash-tab--green" data-tab="transfer" disabled>Transfer &amp; Other Requests</button>
            <button type="button" class="dash-tab dash-tab--blue" data-tab="complaints" disabled>Complaints/Suggestions</button>
        </nav>

        <!-- 4 CARDS (content is filled by JS per tab) -->
        <div class="stat-grid" id="cardRow">
            <div class="stat stat--info"  id="card-1"><h3 class="stat-title"></h3><div class="stat-body"></div></div>
            <div class="stat stat--green" id="card-2"><h3 class="stat-title"></h3><div class="stat-body"></div></div>
            <div class="stat stat--blue"  id="card-3"><h3 class="stat-title"></h3><div class="stat-body"></div></div>
            <div class="stat stat--slate" id="card-4"><h3 class="stat-title"></h3><div class="stat-body"></div></div>
        </div>

        <!-- FILES STATUS (Uploaded / Remaining) -->
        <div id="files-status-row" class="stat-grid d-none">
            <div class="stat stat--green" data-files="uploaded">
                <h3 class="stat-title">Uploaded Files</h3>
                <div class="stat-count">Total: {{ $filesUploadedCount }}</div>
            </div>
            <div class="stat stat--danger" data-files="remaining">
                <h3 class="stat-title">Remaining Files</h3>
                <div class="stat-count">Total: {{ $filesRemainingCount }}</div>
            </div>
        </div>

        <!-- SIZE BREAKDOWN -->
        <section id="size-breakdown-row" class="panel d-none">
            <div class="pill-grid">
                @foreach ($sizeCounts as $label => $count)
                    <div class="size-pill">{{ $label }}: {{ $count }}</div>
                @endforeach
            </div>
        </section>

        <!-- ALLOTMENT -->
        <section id="allotment-row" class="panel d-none"></section>

        <!-- FILES DETAIL -->
        <section id="files-detail-row" class="panel panel-x d-none">
            <div class="panel-head">
                <h4 class="panel-title" id="filesTitle">Uploaded Files</h4>
                <button type="button" id="closeFilesDetail" class="btn btn-sm btn-outline-secondary btn-pill">&larr; Back</button>
            </div>
            <div class="table-wrap">
                <table class="dash-table min-lg">
                    <thead>
                        <tr>
                            <th>#</th><th>Applicant Name</th><th>Application No</th><th>Plot No</th>
                            <th>Sector</th><th>Block</th><th>Uploaded By</th><th>Uploaded At</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="filesBody"></tbody>
                </table>
            </div>
            <div class="pager"><ul class="pagination" id="filesPager"></ul></div>
        </section>

        <!-- ENTRY CREATION -->
        <section id="entry-creation-row" class="panel panel-x d-none">
            <div class="panel-head">
                <h4 class="panel-title">Entry Creation (Date Wise)</h4>
                <div class="dropdown">
                    <button class="btn btn-sm entry-date-btn dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <span id="entryDateLabel">Last 5 Dates</span>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end entry-date-menu" id="entryDateMenu"></ul>
                </div>
            </div>
            <div id="entryCreationBody"></div>
        </section>

        <!-- REQUEST TABLES (Transfer tab) -->
        @foreach ($tables as $status => $cfg)
            <section class="panel panel-x d-none" id="{{ $status }}-table">
                <h3 class="panel-title text-center mb-3">{{ $cfg['label'] }}</h3>
                <div class="table-wrap table-wrap--narrow">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th class="text-start">Sector</th>
                                <th>Total</th>
                                <th>Original Allottee</th>
                                <th>Transfer Allottee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sectorRequestStats as $sector)
                                @php
                                    $key    = $status . '-' . $sector->sector_id;
                                    $blocks = $sectorBlockWiseDetails->where('sector_id', $sector->sector_id)->whereNotNull('block_id');
                                @endphp
                                <tr class="sector-row" data-toggle-blocks="{{ $key }}">
                                    <td class="text-start">
                                        {{ $sector->sector_name }}
                                        <i class="bi bi-chevron-right row-arrow"></i>
                                    </td>
                                    <td>{{ $sector->{$cfg['sector_total']} ?? 0 }}</td>
                                    <td>{{ $sector->{$cfg['sector_original']} ?? 0 }}</td>
                                    <td>{{ $sector->{$cfg['sector_transfer']} ?? 0 }}</td>
                                </tr>
                                @foreach ($blocks as $block)
                                    <tr class="block-row d-none" data-parent="{{ $key }}">
                                        <td class="text-start"><i class="bi bi-dot"></i>{{ $block->block_name }}</td>
                                        <td>{{ $block->total_properties ?? 0 }}</td>
                                        <td>{{ $block->plot_count ?? 0 }}</td>
                                        <td>{{ $block->house_count ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endforeach

        <!-- SECTOR WISE DETAIL -->
        <section class="panel panel-x d-none" id="sector-wise-detail-row">
            <div class="toolbar">
                <div class="toolbar-group toolbar-search">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" id="sectorSearch" class="form-control" placeholder="Search sectors...">
                    <button type="button" class="btn btn-primary btn-sm" id="searchSectorBtn">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                </div>
                <div class="toolbar-group">
                    <label for="sectorPerPage" class="mb-0 fw-semibold">Show:</label>
                    <select id="sectorPerPage" class="form-select">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="toolbar-info" id="sectorInfo"></span>
                </div>
            </div>

            <div class="table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th class="text-start">Sector</th><th>Properties</th><th>Plots</th><th>House</th><th>Commercial</th>
                        </tr>
                    </thead>
                    <tbody id="sectorBody"></tbody>
                </table>
            </div>
            <div class="pager"><ul class="pagination" id="sectorPager"></ul></div>
        </section>

        <!-- DATA REVIEW -->
        <section class="panel panel-x d-none" id="data-review-row">
            <h3 class="panel-title text-center mb-3">DATA REVIEW - QA USERS</h3>
            <div class="table-wrap">
                <table class="dash-table min-md">
                    <thead>
                        <tr>
                            <th>QA User</th><th>Assigned Sectors</th><th>Forms in Sectors</th>
                            <th>Total Checked</th><th>Verified</th><th>Issue</th>
                        </tr>
                    </thead>
                    <tbody id="reviewBody"></tbody>
                </table>
            </div>
        </section>

        <!-- CHARTS -->
        <div class="chart-grid">
            <div class="span-2">
               <div class="chart-card">
    <div class="chart-card-head" style="background-color: #0f2d59;">
        <h3 class="chart-card-title px-4 py-3"
            style="color: white; margin: 0;">
            MDA-Total Representation
        </h3>
    </div>

    <div class="chart-card-body">
        <div class="chart-box">
            <canvas id="pieChart"></canvas>
        </div>
    </div>
</div>
            </div>
            <div>

    <div class="chart-card chart-card--danger">
    <div class="chart-card-head" style="background-color: #0F766E;">
        <h3 class="chart-card-title px-4 py-3"
            style="color: white; margin: 0;">Allotment Type</h3></div>
                    <div class="chart-card-body"><div class="chart-box"><canvas id="allotmentTypeChart"></canvas></div></div>
                </div>
            </div>
            <div>
                <div class="chart-card chart-card--warning">
    <div class="chart-card-head" style="background-color: #164E63;">
        <h3 class="chart-card-title px-4 py-3"
            style="color: white; margin: 0;">Ownership Type</h3></div>
                    <div class="chart-card-body"><div class="chart-box"><canvas id="ownershipTypeChart"></canvas></div></div>
                </div>
            </div>
        </div>

        <!-- SECTOR WISE CHART -->
        <div class="chart-card">
            <div class="chart-card-head"style="background-color: #6B213E;">
                <h3 class="chart-card-title px-4 py-3" style="color: white; margin: 0;" id="titleGraph">MDA - Sector Wise</h3>
                <button type="button" id="backToSectorsBtn" class="btn btn-sm btn-pill d-none">&larr; Back to Sectors</button>
            </div>
            <div class="chart-card-body">
                <div class="chart-scroll">
                    <div class="chart-scroll-inner" id="barInner"><canvas id="bar"></canvas></div>
                </div>
            </div>
        </div>

        <!-- DATA REVIEW MODAL -->
        <div class="modal fade" id="dataReviewDetailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content" style="border-radius:12px;">
                    <div class="modal-header" style="background:var(--c-primary); color:#fff;">
                        <h5 class="modal-title" id="dataReviewModalTitle">List</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-wrap">
                            <table class="dash-table min-lg">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Applicant Name</th><th>Application No</th><th>Plot No</th>
                                        <th>Sector</th><th>Block</th><th>Status</th><th>Checked By</th><th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="dataReviewDetailBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @php
    $dash = [
        'totalProperties' => $totalProperties,
        'entryCount'      => $entryCreationCount,
        'files'           => [
            'uploaded'  => $filesUploadedCount,
            'remaining' => $filesRemainingCount,
        ],
        'stats'           => $stats,
        'categories'      => $categories,
        'categoryData'    => $categoryData,
        'sectors'         => $sectorSummary,
        'blocks'          => $sectorBlockData,
        'allotment'       => $allotmentTypeDistribution,
        'ownership'       => $ownershipTypeDistribution,
        'routes'          => [
            'reviewStats' => route('data.review.stats'),
            'entries'     => route('entry.creation.details'),
        ],
    ];
@endphp

    <script>
        window.DASH = @json($dash);
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const D = window.DASH;

        /* ====================================================
           HELPERS
        ==================================================== */
        const $  = (sel, root = document) => root.querySelector(sel);
        const $$ = (sel, root = document) => [...root.querySelectorAll(sel)];
        const n  = v => Number(v) || 0;
        const esc = (v, fallback = '-') => String(v ?? fallback).replace(/[&<>"']/g,
            m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
        const debounce = (fn, ms = 200) => { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; };
        const scrollToEl = el => el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        const isNarrow = () => window.matchMedia('(max-width: 767.98px)').matches;

        const getJson = url => fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        }).then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); });

        const msgRow = (cols, text, cls = '') => `<tr><td colspan="${cols}" class="${cls}">${text}</td></tr>`;
        const viewLink = url => `<a href="${esc(url, '#')}" class="btn btn-sm btn-outline-primary btn-view"><i class="bi bi-eye"></i> View</a>`;

        function renderPager(el, data, goTo) {
            const cur  = data.current_page || 1;
            const last = data.last_page || 1;
            const item = (p, label, { disabled = false, active = false } = {}) =>
                `<li class="page-item${disabled ? ' disabled' : ''}${active ? ' active' : ''}"><a class="page-link" href="#" data-page="${p}">${label}</a></li>`;
            const dots = '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';

            const from = Math.max(1, cur - 2);
            const to   = Math.min(last, cur + 2);
            let html = item(cur - 1, '&laquo;', { disabled: cur <= 1 });
            if (from > 1) { html += item(1, 1); if (from > 2) html += dots; }
            for (let i = from; i <= to; i++) html += item(i, i, { active: i === cur });
            if (to < last) { if (to < last - 1) html += dots; html += item(last, last); }
            html += item(cur + 1, '&raquo;', { disabled: cur >= last });

            el.innerHTML = html;
            el.onclick = e => {
                const a = e.target.closest('[data-page]');
                if (!a) return;
                e.preventDefault();
                const p = parseInt(a.dataset.page, 10);
                if (p >= 1 && p <= last && p !== cur) goTo(p);
            };
        }

        Chart.defaults.color = '#000';

        /* ====================================================
           PANELS (only one "panel-x" visible at a time)
        ==================================================== */
        const panels = $$('.panel-x');
        let activePanel = null;

        function showPanel(el) {
            panels.forEach(p => p.classList.add('d-none'));
            el.classList.remove('d-none');
            activePanel = el;
        }
        function togglePanel(el) {
            if (activePanel === el) {
                el.classList.add('d-none');
                activePanel = null;
                return false;
            }
            showPanel(el);
            return true;
        }
        function hideAllPanels() {
            panels.forEach(p => p.classList.add('d-none'));
            activePanel = null;
        }

        const panelSector = $('#sector-wise-detail-row');
        const panelReview = $('#data-review-row');
        const panelEntry  = $('#entry-creation-row');
        const panelFiles  = $('#files-detail-row');
        const sizeRow      = $('#size-breakdown-row');
        const allotmentRow = $('#allotment-row');

        // Expand / collapse block rows (works for request tables and sector detail)
        document.addEventListener('click', e => {
            const row = e.target.closest('[data-toggle-blocks]');
            if (!row) return;
            row.classList.toggle('open');
            const open = row.classList.contains('open');
            $$(`.block-row[data-parent="${row.dataset.toggleBlocks}"]`).forEach(r => r.classList.toggle('d-none', !open));
        });

        /* ====================================================
           FILES STATUS
        ==================================================== */
        const filesStatusRow = $('#files-status-row');
        const filesBody  = $('#filesBody');
        const filesPager = $('#filesPager');
        let filesOpen = false;

        function hideFiles() {
            filesStatusRow.classList.add('d-none');
            panelFiles.classList.add('d-none');
            $$('[data-files]').forEach(c => c.classList.remove('active-status'));
            filesOpen = false;
        }
        function toggleFilesStatus() {
            if (filesOpen) return hideFiles();
            filesStatusRow.classList.remove('d-none');
            panelFiles.classList.add('d-none');
            filesOpen = true;
            scrollToEl(filesStatusRow);
        }

        function loadFiles(type, page = 1) {
            $('#filesTitle').textContent = type === 'uploaded' ? 'Uploaded Files' : 'Remaining Files';
            filesBody.innerHTML = msgRow(9, 'Loading...');
            $$('[data-files]').forEach(c => c.classList.toggle('active-status', c.dataset.files === type));

            getJson(`/files-status/${type}?page=${page}`)
                .then(res => {
                    const rows = res.data || [];
                    if (!rows.length) {
                        filesBody.innerHTML = msgRow(9, 'No records found');
                        filesPager.innerHTML = '';
                        return;
                    }
                    const base = ((res.current_page || 1) - 1) * (res.per_page || rows.length);
                    filesBody.innerHTML = rows.map((r, i) => `
                        <tr>
                            <td>${base + i + 1}</td>
                            <td>${esc(r.applicant_name)}</td>
                            <td>${esc(r.application_no)}</td>
                            <td>${esc(r.plot_no)}</td>
                            <td>${esc(r.sector)}</td>
                            <td>${esc(r.block)}</td>
                            <td>${esc(r.uploaded_by)}</td>
                            <td>${esc(r.uploaded_at)}</td>
                            <td>${viewLink(r.detail_url)}</td>
                        </tr>`).join('');
                    renderPager(filesPager, res, p => loadFiles(type, p));
                })
                .catch(err => {
                    console.error('Files load error:', err);
                    filesBody.innerHTML = msgRow(9, 'Error loading data', 'text-danger');
                });
        }

        filesStatusRow.addEventListener('click', e => {
            const card = e.target.closest('[data-files]');
            if (!card) return;
            showPanel(panelFiles);
            loadFiles(card.dataset.files, 1);
            scrollToEl(panelFiles);
        });
        $('#closeFilesDetail').addEventListener('click', () => {
            panelFiles.classList.add('d-none');
            activePanel = null;
            $$('[data-files]').forEach(c => c.classList.remove('active-status'));
        });

        /* ====================================================
           SECTOR WISE DETAIL (table)
        ==================================================== */
        const sector = { page: 1, perPage: 10, q: '' };
        const sectorBody  = $('#sectorBody');
        const sectorPager = $('#sectorPager');
        const sectorInfo  = $('#sectorInfo');
        const sectorSearch = $('#sectorSearch');

        const countCells = o => `
            <td>${n(o.total_properties)}</td><td>${n(o.plot_count)}</td>
            <td>${n(o.house_count)}</td><td>${n(o.commercial_count)}</td>`;
        const hasCounts = o => n(o.total_properties) || n(o.plot_count) || n(o.house_count) || n(o.commercial_count);

        function sectorRows(s) {
            const blocks = s.block_data || [];
            const key = `sw-${s.id}`;
            let html = `
                <tr class="sector-row${hasCounts(s) ? '' : ' is-empty'}"${blocks.length ? ` data-toggle-blocks="${key}"` : ''}>
                    <td class="text-start">${esc(s.name, '')}${blocks.length ? '<i class="bi bi-chevron-right row-arrow"></i>' : ''}</td>
                    ${countCells(s)}
                </tr>`;
            html += blocks.map(b => `
                <tr class="block-row d-none${hasCounts(b) ? '' : ' is-empty'}" data-parent="${key}">
                    <td class="text-start"><i class="bi bi-dot"></i>${esc(b.block, 'Unknown')}</td>
                    ${countCells(b)}
                </tr>`).join('');
            return html;
        }

        function loadSectors() {
            sectorBody.innerHTML = msgRow(5, 'Loading...', 'text-muted');
            const qs = `page=${sector.page}&per_page=${sector.perPage}&search=${encodeURIComponent(sector.q)}`;

            getJson(`/sector-wise-details?${qs}`)
                .then(res => {
                    if (!res || !res.data) {
                        sectorBody.innerHTML = msgRow(5, 'Invalid response', 'text-danger');
                        return;
                    }
                    sectorBody.innerHTML = res.data.length ? res.data.map(sectorRows).join('') : msgRow(5, 'No sectors found');

                    const total = res.total || 0;
                    const start = total ? (res.current_page - 1) * res.per_page + 1 : 0;
                    const end   = Math.min(res.current_page * res.per_page, total);
                    sectorInfo.textContent = `Showing ${start} to ${end} of ${total} sectors`;
                    renderPager(sectorPager, res, p => { sector.page = p; loadSectors(); });
                })
                .catch(err => {
                    console.error('Sector load error:', err);
                    sectorBody.innerHTML = msgRow(5, `<i class="bi bi-exclamation-triangle"></i> Data load nahi ho saka (${esc(err.message)})`, 'text-danger');
                });
        }

        const runSectorSearch = () => { sector.q = sectorSearch.value.trim(); sector.page = 1; loadSectors(); };
        $('#searchSectorBtn').addEventListener('click', runSectorSearch);
        sectorSearch.addEventListener('keydown', e => { if (e.key === 'Enter') runSectorSearch(); });
        $('#sectorPerPage').addEventListener('change', e => { sector.perPage = parseInt(e.target.value, 10); sector.page = 1; loadSectors(); });

        /* ====================================================
           ENTRY CREATION
        ==================================================== */
        const entry = { groups: {}, dates: [], sel: 'last5' };
        const entryBody  = $('#entryCreationBody');
        const entryMenu  = $('#entryDateMenu');
        const entryLabel = $('#entryDateLabel');

        function loadEntries() {
            entryBody.innerHTML = '<div class="state-msg">Loading...</div>';
            getJson(D.routes.entries)
                .then(res => {
                    entry.groups = res.groups || {};
                    entry.dates  = Object.keys(entry.groups); // latest first (controller order)
                    entry.sel    = 'last5';
                    renderEntryMenu();
                    renderEntries();
                })
                .catch(err => {
                    console.error('Entry load error:', err);
                    entryBody.innerHTML = '<div class="state-msg text-danger">Data load nahi ho saka</div>';
                });
        }

        function renderEntryMenu() {
            entryLabel.textContent = entry.sel === 'last5' ? 'Last 5 Dates' : entry.sel;
            const opt = (value, label) => `<li><a class="dropdown-item${entry.sel === value ? ' active' : ''}" href="#" data-date="${esc(value)}">${label}</a></li>`;
            let html = opt('last5', 'Last 5 Dates');
            if (entry.dates.length) {
                html += '<li><hr class="dropdown-divider"></li>';
                html += entry.dates.map(d => opt(d, `${esc(d)} (${entry.groups[d].length})`)).join('');
            }
            entryMenu.innerHTML = html;
        }

        function renderEntries() {
            const dates = entry.sel === 'last5' ? entry.dates.slice(0, 5) : [entry.sel];
            if (!dates.length || !entry.groups[dates[0]]) {
                entryBody.innerHTML = '<div class="state-msg">No records found</div>';
                return;
            }
            entryBody.innerHTML = dates.map(date => `
                <div class="date-card">
                    <div class="date-heading">
                        <span><i class="bi bi-calendar3 me-2"></i>${esc(date)}</span>
                        <button type="button" class="date-toggle" title="Show / Hide" aria-label="Show or hide ${esc(date)}">
                            <i class="bi bi-chevron-up"></i>
                        </button>
                    </div>
                    <div class="date-table-wrap table-wrap">
                        <table class="dash-table min-md">
                            <thead>
                                <tr>
                                    <th>#</th><th>User</th><th>Applicant Name</th><th>Plot No</th>
                                    <th>Sector</th><th>Block</th><th>Sub Block</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${(entry.groups[date] || []).map((r, i) => `
                                    <tr>
                                        <td>${i + 1}</td>
                                        <td>${esc(r.user_name)}</td>
                                        <td>${esc(r.applicant_name)}</td>
                                        <td>${esc(r.plot_no)}</td>
                                        <td>${esc(r.sector)}</td>
                                        <td>${esc(r.block)}</td>
                                        <td>${esc(r.sub_block)}</td>
                                        <td>${viewLink(r.detail_url)}</td>
                                    </tr>`).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>`).join('');
        }

        entryMenu.addEventListener('click', e => {
            const item = e.target.closest('.dropdown-item');
            if (!item) return;
            e.preventDefault();
            entry.sel = item.dataset.date;
            renderEntryMenu();
            renderEntries();
        });
        entryBody.addEventListener('click', e => {
            const btn = e.target.closest('.date-toggle');
            if (!btn) return;
            const wrap = btn.closest('.date-card').querySelector('.date-table-wrap');
            wrap.classList.toggle('d-none');
            btn.querySelector('i').className = wrap.classList.contains('d-none') ? 'bi bi-chevron-down' : 'bi bi-chevron-up';
        });

        /* ====================================================
           DATA REVIEW
        ==================================================== */
        const reviewBody = $('#reviewBody');
        const detailBody = $('#dataReviewDetailBody');
        const detailModal = bootstrap.Modal.getOrCreateInstance($('#dataReviewDetailModal'));

        function loadReviewStats() {
            reviewBody.innerHTML = msgRow(6, 'Loading...');
            getJson(D.routes.reviewStats)
                .then(res => {
                    const rows = res.data || [];
                    if (!rows.length) { reviewBody.innerHTML = msgRow(6, 'No QA users found'); return; }
                    reviewBody.innerHTML = rows.map(u => {
                        const uid = u.is_summary ? 'all' : u.id;
                        const chip = (type, label, value, variant) =>
                            `<td><span class="num-chip num-chip--${variant}" data-uid="${esc(uid)}" data-type="${type}" data-title="${esc(u.name, '')} - ${label}">${n(value)}</span></td>`;
                        return `
                            <tr>
                                <td><strong>${esc(u.name)}</strong></td>
                                <td>${esc(u.sectors)}</td>
                                ${chip('forms',   'Total Forms in Sectors', u.sector_total_forms, 'info')}
                                ${chip('checked', 'Total Checked',          u.total_checked,      'info')}
                                ${chip('verified','Verified',               u.verified,           'ok')}
                                ${chip('issue',   'Issue',                  u.issue,              'bad')}
                            </tr>`;
                    }).join('');
                })
                .catch(err => {
                    console.error('Review stats error:', err);
                    reviewBody.innerHTML = msgRow(6, 'Error loading data', 'text-danger');
                });
        }

        function openReviewDetail(userId, type, title) {
            sessionStorage.setItem('dataReviewState', JSON.stringify({ userId, type, title }));
            $('#dataReviewModalTitle').textContent = title;
            detailBody.innerHTML = msgRow(9, 'Loading...');
            detailModal.show();

            getJson(`/data-review-details?user_id=${encodeURIComponent(userId)}&type=${encodeURIComponent(type)}`)
                .then(res => {
                    const rows = res.data || [];
                    if (!rows.length) { detailBody.innerHTML = msgRow(9, 'No records found'); return; }
                    detailBody.innerHTML = rows.map((r, i) => `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${esc(r.applicant_name)}</td>
                            <td>${esc(r.application_no)}</td>
                            <td>${esc(r.plot_no)}</td>
                            <td>${esc(r.sector)}</td>
                            <td>${esc(r.block)}</td>
                            <td>${esc(r.status)}</td>
                            <td>${esc(r.checked_by)}</td>
                            <td>${viewLink(r.detail_url)}</td>
                        </tr>`).join('');
                })
                .catch(err => {
                    console.error('Review detail error:', err);
                    detailBody.innerHTML = msgRow(9, 'Error loading data', 'text-danger');
                });
        }

        reviewBody.addEventListener('click', e => {
            const el = e.target.closest('.num-chip');
            if (el) openReviewDetail(el.dataset.uid, el.dataset.type, el.dataset.title);
        });
        $('#dataReviewDetailModal').addEventListener('hidden.bs.modal', () => sessionStorage.removeItem('dataReviewState'));

        // Detail page se back aane par modal wapas kholo
        window.addEventListener('pageshow', () => {
            const raw = sessionStorage.getItem('dataReviewState');
            if (!raw) return;
            let st;
            try { st = JSON.parse(raw); } catch (e) { return; }
            showPanel(panelReview);
            loadReviewStats();
            openReviewDetail(st.userId, st.type, st.title);
        });

        /* ====================================================
           CARDS + TABS
        ==================================================== */
        const cards = [1, 2, 3, 4].map(i => ({
            el: $(`#card-${i}`), title: $(`#card-${i} .stat-title`), body: $(`#card-${i} .stat-body`)
        }));
        const chip = (action, text) => `<button type="button" class="chip" data-action="${action}">${text}</button>`;

        function setCard(i, title, body, action = null) {
            const c = cards[i - 1];
            c.title.textContent = title;
            c.body.innerHTML = body;
            if (action) c.el.dataset.action = action; else delete c.el.dataset.action;
        }

        const reqPanel = id => () => togglePanel($(`#${id}-table`));
        const actions = {
            'sector-detail': () => { if (togglePanel(panelSector)) loadSectors(); },
            size:      () => sizeRow.classList.toggle('d-none'),
            allotment: () => allotmentRow.classList.toggle('d-none'),
            review:    () => { if (togglePanel(panelReview)) loadReviewStats(); },
            entry:     () => { hideFiles(); if (togglePanel(panelEntry)) { loadEntries(); scrollToEl(panelEntry); } },
            files:     toggleFilesStatus,
            'req-new': reqPanel('new'),
            'req-completed': reqPanel('completed'),
            'req-rejected':  reqPanel('rejected'),
            'req-inprocess': reqPanel('inprocess'),
            'req-pending':   reqPanel('pending'),
            'req-overdue':   reqPanel('overdue'),
        };

        $('#cardRow').addEventListener('click', e => {
            const t = e.target.closest('[data-action]');
            if (t) actions[t.dataset.action]?.();
        });

        function updateCardContent(tab) {
            hideAllPanels();
            hideFiles();
            sizeRow.classList.add('d-none');
            allotmentRow.classList.add('d-none');

            if (tab === 'properties') {
                setCard(1, 'Properties', `<span>Total: ${n(D.totalProperties)}</span>${chip('sector-detail', 'Sector Wise Detail')}`);
                setCard(2, '', chip('size', 'Size Wise Breakdown') + chip('allotment', 'Allotment'));
                setCard(3, '', chip('entry', `Entry Correction: ${n(D.entryCount)}`) + chip('review', 'Data Review'));
                setCard(4, 'Files Status',
                    `<div>Uploaded: ${n(D.files.uploaded)}</div><div>Remaining: ${n(D.files.remaining)}</div>`, 'files');

            } else if (tab === 'transfer') {
                const s = D.stats || {};
                setCard(1, 'Requests',   chip('req-new', `Total Requests: ${n(s.total_requests)}`));
                setCard(2, 'Completed',  chip('req-completed', `Completed: ${n(s.completed_count)}`) + chip('req-rejected', `Rejected: ${n(s.rejected_count)}`));
                setCard(3, 'In Process', chip('req-inprocess', `In Process: ${n(s.in_process_count)}`));
                setCard(4, 'Pending',    chip('req-pending', `Pending: ${n(s.pending_new_count)}`) + chip('req-overdue', `Overdue (5+ Days): ${n(s.pending_overdue_count)}`));

            } else {
                setCard(1, 'Complaints',  '<span>Total: 0</span>');
                setCard(2, 'Suggestions', '<span>Total: 0</span>');
                setCard(3, 'Resolved',    '<span>Total: 0</span>');
                setCard(4, 'Pending',     '<span>Total: 0</span>');
            }
        }

        const tabs = $$('#dashTabs .dash-tab');
        tabs.forEach(tab => tab.addEventListener('click', () => {
            if (tab.disabled) return;
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            updateCardContent(tab.dataset.tab);
        }));

        /* ====================================================
           PIE CHARTS
        ==================================================== */
        function makePie(id, labels, values, colors, legendPos) {
            const canvas = document.getElementById(id);
            if (!canvas || !labels.length) return;
            new Chart(canvas, {
                type: 'pie',
                data: { labels, datasets: [{ data: values, backgroundColor: colors, borderColor: '#fff', borderWidth: 2 }] },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                     legend: {
    position: isNarrow() ? 'bottom' : legendPos,
    labels: { boxWidth: 12, font: { size: 11 }, padding: 10 }
},
                        tooltip: {
                            callbacks: {
                                label: ctx => {
                                    const total = ctx.dataset.data.reduce((a, b) => a + Number(b), 0);
                                    const pct = total ? (ctx.parsed / total * 100).toFixed(1) : '0.0';
                                    return `${ctx.label}: ${ctx.parsed} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
        const palette = (list, size) => Array.from({ length: size }, (_, i) => list[i % list.length]);

        makePie('pieChart', ['House', 'Commercial', 'Plot'],
            [n(D.categoryData.House), n(D.categoryData.Commercial), n(D.categoryData.Plot)],
            ['#0AA1DD', '#D0E8F2', '#E5D1FA'], 'top');

        const allotLabels = Object.keys(D.allotment || {});
        makePie('allotmentTypeChart', allotLabels, Object.values(D.allotment || {}),
            palette(['#F97316', '#06B6D4', '#8B5CF6', '#22C55E', '#EF4444', '#EC4899'], allotLabels.length), 'bottom');

        const ownLabels = Object.keys(D.ownership || {});
        makePie('ownershipTypeChart', ownLabels, Object.values(D.ownership || {}),
            palette(['#7C9D96', '#EAB308', '#0EA5E9', '#14B8A6', '#F97316', '#8B5CF6'], ownLabels.length), 'bottom');

        /* ====================================================
           SECTOR WISE BAR CHART (responsive + scrollable on small screens)
        ==================================================== */
        const barColors = {
            Plot:       { bg: '#E5D1FA', border: '#E5D1FA' },
            Commercial: { bg: '#00E0FF', border: '#00E0FF' },
            House:      { bg: '#3b8db0', border: '#1D4ED8' },
        };
        const barCanvas = $('#bar');
        const barInner  = $('#barInner');
        const titleEl   = $('#titleGraph');
        const backBtn   = $('#backToSectorsBtn');
        let barChart = null;
        let barView  = { type: 'sector' };

        function barDatasets(items, getValue) {
            return D.categories.map(cat => {
                const c = barColors[cat] || { bg: '#95A5A6', border: '#7f8c8d' };
                return {
                    label: cat,
                    data: items.map(item => n(getValue(item, cat))),
                    backgroundColor: c.bg,
                    borderColor: c.border,
                    borderWidth: 1,
                    barPercentage: .8,
                    categoryPercentage: .8,
                };
            });
        }

        function drawBar(labels, datasets, { onClick = null, tooltipTitle = null } = {}) {
            barChart?.destroy();
            // Zyada labels hon to chart ke andar horizontal scroll (har screen par readable)
            barInner.style.minWidth = `${labels.length * (isNarrow() ? 64 : 40)}px`;

            barChart = new Chart(barCanvas, {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: (e, els) => { if (onClick && els.length) onClick(els[0].index); },
                    onHover: (e, els) => { e.native.target.style.cursor = onClick && els.length ? 'pointer' : 'default'; },
                    plugins: {
                        legend: { position: 'top', labels: { boxWidth: 14, font: { size: isNarrow() ? 11 : 13 } } },
                        tooltip: { mode: 'index', intersect: false, callbacks: tooltipTitle ? { title: tooltipTitle } : {} },
                    },
                    scales: {
                        x: { ticks: { autoSkip: false, maxRotation: 60, minRotation: isNarrow() ? 45 : 0, font: { size: isNarrow() ? 10 : 12 } } },
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });
        }

        function renderSectorChart() {
            barView = { type: 'sector' };
            titleEl.textContent = 'MDA - Sector Wise';
            backBtn.classList.add('d-none');
            drawBar(
                D.sectors.map(s => s.name),
                barDatasets(D.sectors, (s, cat) => (s.counts || {})[cat]),
                { onClick: i => D.sectors[i] && renderBlockChart(D.sectors[i].id, D.sectors[i].name) }
            );
        }

        function renderBlockChart(sectorId, sectorName) {
            barView = { type: 'block', id: sectorId, name: sectorName };
            titleEl.textContent = `MDA - ${sectorName} (Block Wise)`;
            backBtn.classList.remove('d-none');

            const blocks = (D.blocks[sectorId] || {}).blocks || {};
            const names = Object.keys(blocks);
            if (!names.length) {
                drawBar(['No blocks found'], []);
                return;
            }
            drawBar(names, barDatasets(names, (b, cat) => blocks[b][cat]), { tooltipTitle: ctx => `Block ${ctx[0].label}` });
        }

        backBtn.addEventListener('click', renderSectorChart);

        // Screen size category badle (mobile <-> desktop) to chart dobara draw karo
        let wasNarrow = isNarrow();
        window.addEventListener('resize', debounce(() => {
            if (isNarrow() === wasNarrow) return;
            wasNarrow = isNarrow();
            barView.type === 'block' ? renderBlockChart(barView.id, barView.name) : renderSectorChart();
        }));

        /* ====================================================
           INIT
        ==================================================== */
        tabs[0].classList.add('active');
        updateCardContent('properties');
        renderSectorChart();
    });
    </script>

</x-app-layout>
