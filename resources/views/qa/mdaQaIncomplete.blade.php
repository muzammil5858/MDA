<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('MDA QA List (Verified)') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    /* Pagination ko left align aur properly styled karne ke liye */
    .dataTables_wrapper .dataTables_paginate {
        float: right !important;
        text-align: right !important;
        margin-top: 15px;
    }
    .dataTables_wrapper .dataTables_info {
        float: right !important;
        margin-top: 15px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 12px;
        margin-right: 3px;
        border-radius: 4px;
        border: 1px solid #ddd;
        cursor: pointer;
        color: #03346E !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #03346E !important;
        color: #fff !important;
        border: 1px solid #03346E;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f1f1f1;
        border: 1px solid #ccc;
        color: #03346E !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.5;
        cursor: default;
    }
    .qa-status-badge {
    white-space: normal !important;
    word-break: break-word;
    display: inline-block;
    max-width: 100%;
    line-height: 1.3;
    text-align: center;
}

@media (max-width: 768px) {
    .qa-status-badge {
        font-size: 11px;
        padding: 4px 8px;
    }
}
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">{{ $heading }}</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th style="width:50px !important;">#</th>
                                        <th>Applicant Name</th>
                                        <th>Application No</th>
                                        <th>Plot No</th>
                                        <th>Sector</th>
                                        <th>Block</th>
                                        <th>QA Status</th>
                                        <th>Checked By</th>
                                        <th>Checked On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $dat)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dat->applicant_name ?? 'N/A' }}</td>
                                            <td>{{ $dat->application_no ?? 'N/A' }}</td>
                                            <td>{{ $dat->plot_no ?? 'N/A' }}</td>
                                            <td>{{ $dat->sector->name ?? 'N/A' }}</td>
                                            <td>{{ $dat->block->name ?? 'N/A' }}</td>
<td>
        <span class="badge badge-warning qa-status-badge">{{ $dat->qaStatus->issue ?? 'N/A' }}</span>
</td>
                                            <td>{{ $dat->qaStatus->user->name ?? 'N/A' }}</td>
                                            <td>{{ $dat->qaStatus->updated_at ? \Carbon\Carbon::parse($dat->qaStatus->updated_at)->format('d-m-Y H:i') : 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('mdaQaDetail', $dat->id) }}">
                                                    <i class="fa fa-eye" title="View Detail" style="font-size:18px; cursor:pointer;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="alert alert-info">No incomplete entries found.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(function () {
        $("#example2").DataTable({   // mdaQaList.blade.php mein "#example2" rakhna
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "dom": '<"top"f>rt<"bottom"ip><"clear">',   // f=search, i=info, p=pagination — sab left column mein
        });
    });
</script>
</x-app-layout>
