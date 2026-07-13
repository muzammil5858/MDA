<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .wrapper{
            width: 100%;
            padding-top:10px;
        }
        .card.check {
            max-width: 550px;
            width: 100%;
            border: none;
            border-radius: .4rem;
            background: #ffffff;
            padding: 2rem;
            padding-top:20px;
            margin: 0 auto;
            
        }
        .card.list{
            
            max-width: 95%;
            border: none;
            border-radius: .4rem;
            background: #ffffff;
            padding: 2rem;
            margin: 0 auto;
            margin-top:20px;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e3a8a;
            text-align: left;
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 0.75rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            height: 40px;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            height: 40px;
            line-height: 1.3;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-2px);
        }
        .result-message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            text-align: center;
            font-weight: 500;
        }
        .result-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .result-error {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 1rem auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .table {
            margin-top: 2rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="card check">
            <h2 class="card-title">Check Property by Code</h2>
            <form id="cnicForm" method="GET" action="{{ route('fd.propertycheck') }}">
            <div class="row mb-4">
                <div class="col-8">
                    <input 
                        type="text" 
                        name="code" 
                        class="form-control" 
                        placeholder="Enter Property Code" 
                        required
                    >
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Check
                    </button>
                </div>
            </div>
        </form>

        @if (isset($result))
            <div class="result-message {{ $result['exists'] ? 'result-success' : 'result-error' }}">
                {{ $result['message'] }}
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif
        
    </div>
    <div class="card list">
        <div class="loader" id="loader"></div>
        <div id="resultMessage" class="result-message d-none"></div>
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
            <tbody id="propertyList"></tbody>
        </table>
    </div>
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">Select Request Type</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select id="requestType" class="form-select" required>
                        @php
                            $type = DB::table('request_types')->get();
                        @endphp
                        <option value="" disabled selected>Select a request type</option>
                        @foreach($type as $key => $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                            
                        @endforeach
                        
                    </select>
                    <input type="hidden" id="propertyId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitRequest">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const requestModal = new bootstrap.Modal(document.getElementById('requestModal'));
            $('#cnicForm').on('submit', function(e) {
                e.preventDefault();
          
                const cnic = $('input[name="code"]').val();
                const $loader = $('#loader');
                const $resultMessage = $('#resultMessage');
                const $propertyList = $('#propertyList');

                $loader.show();
                $resultMessage.addClass('d-none');
                $propertyList.empty();
               

                $.ajax({
                    url: '{{ route("fd.propertyverify") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        code: cnic,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        $loader.hide();
                        if (response.exists) {
                            $resultMessage
                                .removeClass('d-none result-error')
                                .addClass('result-success')
                                .text(response.message);
                            if (response.properties && response.properties.length > 0) {
                                response.properties.forEach((property, index) => {
                                    $propertyList.append(`
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${property.code || '-'}</td>
                                            <td>${property.plot_no || '-'}</td>
                                            <td>${property.category || '-'}</td>
                                            <td>${property.town || '-'}</td>
                                            <td>${property.sector || '-'}</td>
                                            <td><a href="/form-detail/${property.id}"><button class="btn btn-sm btn-primary">View Detail</button></a><button class="btn btn-sm btn-primary ms-2 request-btn" data-property-id="${property.id}">
                                                    Request
                                                </button></td>
                                        </tr>
                                    `);
                                });

                                $('.request-btn').on('click', function() {
                                    const propertyId = $(this).data('property-id');
                                    $('#propertyId').val(propertyId);
                                    $('#requestType').val(''); // Reset dropdown
                                    requestModal.show();
                                });
                            } else {
                                $propertyList.append('<tr><td colspan="7">No properties found.</td></tr>');
                            }
                        } else {
                            $resultMessage
                                .removeClass('d-none result-success')
                                .addClass('result-error')
                                .text(response.message);
                            $propertyList.append('<tr><td colspan="7">No properties found.</td></tr>');
                        }
                    },
                    error: function() {
                        $loader.hide();
                        $resultMessage
                            .removeClass('d-none result-success')
                            .addClass('result-error')
                            .text('Error fetching data. Please try again.');
                        $propertyList.append('<tr><td colspan="7">Error fetching data.</td></tr>');
                    }
                });
            });

             $('#submitRequest').on('click', function() {
                const requestType = $('#requestType').val();
                const propertyCode = $('input[name="code"]').val();
                const propertyId = $('#propertyId').val();
                
                if (!requestType) {
                    alert('Please select a request type.');
                    return;
                }

                // Redirect to the appropriate route based on request type
                if (requestType == 4) {
                    window.location.href = `/house-construction/${propertyId}?type=${requestType}`;
                } else {
                    window.location.href = `/fd-property-transfer/${propertyId}?type=${requestType}&cnic=${propertyCode}`;
                }
                requestModal.hide();
            });
        });
    </script>


</x-app-layout>