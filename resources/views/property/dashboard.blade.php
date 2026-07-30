<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDA Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px 30px;
        }
        .navbar-custom {
            background: #408175;
            padding: 14px 24px;
        }
        .navbar-custom h4 { color: #fff; margin: 0; font-weight: 700; }
        .navbar-custom span { color: #fff; }

        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            transition: transform .2s ease;
            cursor: pointer;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-card.active-card {
            box-shadow: 0 0 0 3px #B1D3B9;
        }
        .stat-card .label { font-size: 14px; opacity: .85; }
        .stat-card .value { font-size: 32px; font-weight: 700; }
        .icon-box { font-size: 36px; opacity: .85; }
        .primary-card {
            background: linear-gradient(135deg, #408175, #B1D3B9);
            color: #fff;
            cursor: default;
        }
        .primary-card:hover { transform: none; }
        .accent-left {
            border-left: 5px solid #B1D3B9;
        }
        .accent-left-navy {
            border-left: 5px solid #408175;
        }

        /* Group list wrapper (sector / block) */
        .group-list-section {
            display: none;
            margin-top: 24px;
        }

        /* Grid of small group cards - max 4 per row */
        .group-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }
        @media (max-width: 991px) {
            .group-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 575px) {
            .group-grid { grid-template-columns: 1fr; }
        }

        .group-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 14px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 2px solid transparent;
            transition: all .2s ease;
        }
        .group-card:hover {
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        }
        .group-card.active {
            border-color: #88BDA4;
            background: #fffaf2;
        }
        .group-card .name {
            font-weight: 600;
            color: #408175;
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .group-card .badge-count {
            background: #408175;
            color: #fff;
            font-weight: 700;
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 12px;
            margin-left: 8px;
            flex-shrink: 0;
        }

        /* Shared table panel below grid */
        .group-table-panel {
            display: none;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .group-table-panel .panel-header {
            padding: 14px 20px;
            background: #408175;
            color: #fff;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .group-table-panel table {
            margin-bottom: 0;
        }
        .group-table-panel th {
            background: #f8f9fb;
            color: #408175;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .empty-hint {
            color: #888;
            text-align: center;
            padding: 30px;
        }
.pagination-controls {
    display: flex;
    justify-content: right;
    align-items: right;
    gap: 6px;
    padding: 14px;
    flex-wrap: wrap;
}
.pagination-controls button {
    border: 1px solid #d9d9d9;
    background: #fff;
    color: #408175;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
    transition: all .15s ease;
}
.pagination-controls button:hover:not(:disabled) {
    background: #f1f5fb;
    border-color: #408175;
}
.pagination-controls button.active {
    background: #408175;
    color: #fff;
    border-color: #408175;
}
.pagination-controls button:disabled {
    opacity: .4;
    cursor: not-allowed;
}


    </style>
</head>
<body>

    <div class="navbar-custom">
        <h4>MDA <span>| MirPur Development Authority</span></h4>
    </div>

    <div class="container-fluid py-4 px-4">

        <h3 class="mb-4 fw-bold" style="color:#408175;">Dashboard</h3>

        <div class="row g-4">

            {{-- Total Properties Card --}}
            <div class="col-md-4 col-sm-6">
                <div class="card stat-card primary-card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="label mb-1">Total Properties</p>
                            <h2 class="value mb-0">{{ $totalProperties }}</h2>
                        </div>
                        <div class="icon-box">
                            <i class="fa fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sector Card --}}
            <div class="col-md-4 col-sm-6">
                <div class="card stat-card accent-left h-100" id="sectorCard" onclick="showSection('sector')">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="label text-muted mb-1">Sector</p>
                            <h2 class="value mb-0" style="color:#408175;">{{ $propertiesBySector->count() }}</h2>
                            <small class="text-muted">View sector-wise list</small>
                        </div>
                        <div class="icon-box" style="color:#B1D3B9; ">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Block Card --}}
            <div class="col-md-4 col-sm-6">
                <div class="card stat-card accent-left-navy h-100" id="blockCard" onclick="showSection('block')">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="label text-muted mb-1">Block</p>
                            <h2 class="value mb-0" style="color:#408175;">{{ $propertiesByBlock->count() }}</h2>
                            <small class="text-muted">View block-wise list</small>
                        </div>
                        <div class="icon-box" style="color:#408175;">
                            <i class="fa fa-th-large"></i>
                        </div>
                    </div>
                </div>
            </div>
                {{-- NEW: Entry User Card --}}
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card accent-left h-100" id="userCard" onclick="showSection('user')">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="label text-muted mb-1">Entry User</p>
                    <h2 class="value mb-0" style="color:#408175;">{{ $propertiesByUser->count() }}</h2>
                    <small class="text-muted">View user-wise entries</small>
                </div>
                <div class="icon-box" style="color:#B1D3B9;">
                    <i class="fa fa-user"></i>
                </div>
            </div>
        </div>
    </div>

        </div>

        {{-- ===================== SECTOR-WISE SECTION ===================== --}}
        <div id="sectorListSection" class="group-list-section">

            <h5 class="fw-bold mb-3" style="color:#408175;">Sectors</h5>

            <div class="group-grid">
                @forelse ($propertiesBySector as $sectorName => $properties)
                    <div class="group-card" data-panel="sector-panel-{{ $loop->index }}" onclick="showGroupTable(this, 'sector')">
                        <span class="name">{{ $sectorName }}</span>
                        <span class="badge-count">{{ $properties->count() }}</span>
                    </div>
                @empty
                    <p class="text-muted">No sector records found.</p>
                @endforelse
            </div>

            {{-- Hidden data tables for each sector, shown one at a time --}}
            @foreach ($propertiesBySector as $sectorName => $properties)
                <div class="group-table-panel" id="sector-panel-{{ $loop->index }}">
                    <div class="panel-header">
                        <span><i class="fa fa-map-marker-alt me-2"></i>{{ $sectorName }}</span>
                        <span class="badge-count">{{ $properties->count() }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle paginated-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Applicant Name</th>
                                    <th>Size</th>
                                    <th>Application No</th>
                                    <th>Form No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($properties as $index => $property)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $property->applicant_name ?? '-' }}</td>
                                        <td>{{ $property->size ?? '-' }}</td>
                                        <td>{{ $property->application_no ?? '-' }}</td>
                                        <td>{{ $property->form_no ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                     <div class="pagination-controls"></div>
                </div>
            @endforeach

        </div>

        {{-- ===================== BLOCK-WISE SECTION ===================== --}}
        <div id="blockListSection" class="group-list-section">

            <h5 class="fw-bold mb-3" style="color:#408175;">Blocks</h5>

            <div class="group-grid">
                @forelse ($propertiesByBlock as $blockName => $properties)
                    <div class="group-card" data-panel="block-panel-{{ $loop->index }}" onclick="showGroupTable(this, 'block')">
                        <span class="name">{{ $blockName }}</span>
                        <span class="badge-count">{{ $properties->count() }}</span>
                    </div>
                @empty
                    <p class="text-muted">No block records found.</p>
                @endforelse
            </div>

            {{-- Hidden data tables for each block, shown one at a time --}}
            @foreach ($propertiesByBlock as $blockName => $properties)
                <div class="group-table-panel" id="block-panel-{{ $loop->index }}">
                    <div class="panel-header">
                        <span><i class="fa fa-th-large me-2"></i>{{ $blockName }}</span>
                        <span class="badge-count">{{ $properties->count() }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle paginated-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Applicant Name</th>
                                    <th>Size</th>
                                    <th>Application No</th>
                                    <th>Form No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($properties as $index => $property)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $property->applicant_name ?? '-' }}</td>
                                        <td>{{ $property->size ?? '-' }}</td>
                                        <td>{{ $property->application_no ?? '-' }}</td>
                                        <td>{{ $property->form_no ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-controls"></div>
                </div>
            @endforeach

        </div>

        {{-- ===================== USER-WISE SECTION ===================== --}}
<div id="userListSection" class="group-list-section">

    <h5 class="fw-bold mb-3" style="color:#408175;">Entry Users</h5>

    <div class="group-grid">
        @forelse ($propertiesByUser as $userName => $properties)
            <div class="group-card" data-panel="user-panel-{{ $loop->index }}" onclick="showGroupTable(this, 'user')">
                <span class="name">{{ $userName }}</span>
                <span class="badge-count">{{ $properties->count() }}</span>
            </div>
        @empty
            <p class="text-muted">No user records found.</p>
        @endforelse
    </div>

    @foreach ($propertiesByUser as $userName => $properties)
        <div class="group-table-panel" id="user-panel-{{ $loop->index }}">
            <div class="panel-header">
                <span><i class="fa fa-user me-2"></i>{{ $userName }}</span>
                <span class="badge-count">{{ $properties->count() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle paginated-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Created At</th>
                            <th>Application No</th>
                            <th>Applicant Name</th>
                            <th>Form No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($properties as $index => $property)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ optional($property->created_at)->format('d-m-Y h:i A') ?? '-' }}</td>
                                <td>{{ $property->application_no ?? '-' }}</td>
                                <td>{{ $property->applicant_name ?? '-' }}</td>
                                <td>{{ $property->form_no ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-controls"></div>
        </div>
    @endforeach

</div>

    </div>

    <script>
function showSection(type) {
    const sections = {
        sector: { section: document.getElementById('sectorListSection'), card: document.getElementById('sectorCard') },
        block:  { section: document.getElementById('blockListSection'),  card: document.getElementById('blockCard') },
        user:   { section: document.getElementById('userListSection'),   card: document.getElementById('userCard') },
    };

    const target = sections[type];
    const isOpen = target.section.style.display === 'block';

    // Sab sections band karein, sab cards se active-card hatayein
    Object.values(sections).forEach(({ section, card }) => {
        section.style.display = 'none';
        card.classList.remove('active-card');
    });

    if (!isOpen) {
        target.section.style.display = 'block';
        target.card.classList.add('active-card');
        target.section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function showGroupTable(cardEl, type) {
    const containers = {
        sector: document.getElementById('sectorListSection'),
        block:  document.getElementById('blockListSection'),
        user:   document.getElementById('userListSection'),
    };

    const panelId = cardEl.getAttribute('data-panel');
    const container = containers[type];

    const wasActive = cardEl.classList.contains('active');

    // Hide all panels + unmark all cards in this section
    container.querySelectorAll('.group-table-panel').forEach(p => p.style.display = 'none');
    container.querySelectorAll('.group-card').forEach(c => c.classList.remove('active'));

    if (!wasActive) {
        document.getElementById(panelId).style.display = 'block';
        cardEl.classList.add('active');
        document.getElementById(panelId).scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}


        function paginateTable(table, perPage) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / perPage);

    const controls = table.closest('.group-table-panel')
        ? table.closest('.group-table-panel').querySelector('.pagination-controls')
        : null;

    if (totalRows <= perPage || !controls) {
        // Sab rows dikhado, pagination controls ki zaroorat nahi
        rows.forEach(r => r.style.display = '');
        if (controls) controls.innerHTML = '';
        return;
    }

    let currentPage = 1;

    function renderPage(page) {
        currentPage = page;
        const start = (page - 1) * perPage;
        const end = start + perPage;

        rows.forEach((row, i) => {
            row.style.display = (i >= start && i < end) ? '' : 'none';
        });

        renderControls();
    }

    function renderControls() {
        let html = '';

        html += `<button ${currentPage === 1 ? 'disabled' : ''} data-page="prev">&laquo; Prev</button>`;

        for (let i = 1; i <= totalPages; i++) {
            html += `<button class="${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
        }

        html += `<button ${currentPage === totalPages ? 'disabled' : ''} data-page="next">Next &raquo;</button>`;

        controls.innerHTML = html;

        controls.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function () {
                const val = this.getAttribute('data-page');
                if (val === 'prev') {
                    if (currentPage > 1) renderPage(currentPage - 1);
                } else if (val === 'next') {
                    if (currentPage < totalPages) renderPage(currentPage + 1);
                } else {
                    renderPage(parseInt(val));
                }
            });
        });
    }

    renderPage(1);
}

// Page load hote hi har table pe 15-per-page pagination laga dein
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.paginated-table').forEach(function (table) {
        paginateTable(table, 10);
    });
});
    </script>

</body>
</html>
