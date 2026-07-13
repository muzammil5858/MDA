<x-app-layout>
    <style>
        .fs-title {
            font-size: 25px;
            color: #03346E;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left;
        }

        .container {
            background: #F4F6F9;
            border: 1px solid #F4F6F9;
        }

        .card {
            margin-top: 40px;
        }

        .card-body {
            padding-top: 30px;
            background: white;
        }

        #heading {
            text-transform: uppercase;
            color: #03346E;
            font-weight: bolder;
            font-size: 1.5rem;
            text-align: center;
        }

        #subheading {
            font-size: 1.2rem;
            padding: 5px 0;
            text-align: center;
        }

        .hidden {
            display: none !important;
        }

        .file-tag {
            background: #d4f1f4;
            border: 1px solid #a8e4e8;
            border-radius: 6px;
            padding: 8px 12px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            margin-right: 8px;
        }

        .file-tag a {
            color: #0080a0;
            text-decoration: none;
        }

        .file-tag button {
            background: #3ba8ad;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 16px;
            cursor: pointer;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .owner-row {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            border-bottom: 1px solid #e9ecef;
            padding: 12px 0;
        }

        .owner-check {
            flex: 0 0 40px;
        }

        .owner-name, .owner-father, .owner-cnic {
            flex: 1;
            min-width: 150px;
        }

        .owner-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #495057;
            margin-bottom: 2px;
        }

        .owner-value {
            font-size: 1rem;
            color: #212529;
        }

        @media (max-width: 768px) {
            .owner-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

        /* Modal styles */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 420px;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .modal-header {
            background: #1c4f8a;
            color: white;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-footer {
            padding: 12px 20px;
            text-align: right;
            border-top: 1px solid #eee;
        }

        button.format-btn {
            background: #1c4f8a;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            margin-right: 8px;
        }

        /* Wrapper that holds all three previews side by side */
        #all-file-previews {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-top: 6px;
        }
    </style>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <form id="houseConstructionForm" action="{{ route('fd.houseConstructionStore', $property->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h2 id="heading">Mangla Dam Housing Authority</h2>
                    <p id="subheading">Map Approval Application</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Property Details --}}
                    <h3 class="fs-title">Property Details</h3>
                    <div class="form-row">
                        <div class="col-md-3">
                            <label>Tehsil</label>
                            <input type="text" class="form-control" value="{{ $property->center }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Locality</label>
                            <input type="text" class="form-control" value="{{ $property->locality }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Sector</label>
                            <input type="text" class="form-control" value="{{ $property->sector }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Code</label>
                            <input type="text" class="form-control" value="{{ $property->code }}" readonly>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-3">
                            <label>Plot No</label>
                            <input type="text" class="form-control" value="{{ $property->plot_no }}" readonly>
                        </div>
                    </div>

                    {{-- Owner Details --}}
                    <h3 class="fs-title mt-3">Owner Details</h3>
                    @foreach($property->owners as $key => $owner)
                        <div class="owner-row">
                            <div class="owner-check">
                                <input type="checkbox" class="select_owner" name="select_owners[]" value="{{ $owner->id }}" checked>
                            </div>
                            <div class="owner-name">
                                <div class="owner-label">Name</div>
                                <div class="owner-value">{{ $owner->name }}</div>
                            </div>
                            <div class="owner-father">
                                <div class="owner-label">Father's Name</div>
                                <div class="owner-value">{{ $owner->father_name }}</div>
                            </div>
                            <div class="owner-cnic">
                                <div class="owner-label">CNIC</div>
                                <div class="owner-value">{{ $owner->cnic }}</div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Dynamic Sections Wrapper --}}
                    <div id="formSectionsWrapper" style="display: none;">

                        {{-- Representation Type --}}
                        <h3 class="fs-title">Representation</h3>
                        <div class="form-row mb-3">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="representation_type" value="self" class="form-check-input" checked>
                                    <label class="form-check-label">Self</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="representation_type" value="attorney" class="form-check-input">
                                    <label class="form-check-label">Attorney</label>
                                </div>
                            </div>
                        </div>

                        {{-- Attorney Details (hidden by default) --}}
                        <div id="attorney_details" class="border p-3 mb-4" style="display: none;">
                            <h5>Attorney Details</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Name</label>
                                    <input type="text" name="attorney_name" class="form-control" placeholder="Full Name">
                                </div>
                                <div class="col-md-3">
                                    <label>Father Name</label>
                                    <input type="text" name="attorney_father_name" class="form-control" placeholder="Father's Full Name">
                                </div>
                                <div class="col-md-3">
                                    <label>CNIC</label>
                                    <input type="text" name="attorney_cnic" class="form-control" placeholder="CNIC Number">
                                </div>
                                <div class="col-md-3">
                                    <label>Address</label>
                                    <input type="text" name="attorney_address" class="form-control" placeholder="Full Address">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label>CNIC Front</label>
                                    <input type="file" class="form-control" name="attorney_cnic_front" accept="image/*" onchange="updateFilePreview(this, 'cnic_front_preview')">
                                    <div id="cnic_front_preview"></div>
                                </div>
                                <div class="col-md-4">
                                    <label>CNIC Back</label>
                                    <input type="file" class="form-control" name="attorney_cnic_back" accept="image/*" onchange="updateFilePreview(this, 'cnic_back_preview')">
                                    <div id="cnic_back_preview"></div>
                                </div>
                                <div class="col-md-4">
                                    <label>Attorney Letter</label>
                                    <input type="file" class="form-control" name="attorney_letter" accept=".pdf,.doc,.docx" onchange="updateFilePreview(this, 'letter_preview')">
                                    <div id="letter_preview"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Architect Information --}}
                        <h3 class="fs-title">Architect Information</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Architect Name</label>
                                <input type="text" name="architect_name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="col-md-4">
                                <label>Address</label>
                                <input type="text" name="architect_address" class="form-control" placeholder="Full Address" required>
                            </div>
                            <div class="col-md-4">
                                <label>Stamp & Signature (PDF, PNG)</label>
                                <input type="file" name="architect_stamp_signature" class="form-control" accept=".pdf,.png" onchange="updateFilePreview(this, 'architect_preview')">
                                <div id="architect_preview"></div>
                            </div>
                        </div>

                        {{-- Engineer Information --}}
                        <h3 class="fs-title mt-3">Engineer Information</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Engineer Name</label>
                                <input type="text" name="engineer_name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="col-md-4">
                                <label>Address</label>
                                <input type="text" name="engineer_address" class="form-control" placeholder="Full Address" required>
                            </div>
                            <div class="col-md-4">
                                <label>Stamp & Signature (PDF, PNG)</label>
                                <input type="file" name="engineer_stamp_signature" class="form-control" accept=".pdf,.png" onchange="updateFilePreview(this, 'engineer_preview')">
                                <div id="engineer_preview"></div>
                            </div>
                        </div>

                        {{-- Area Per Square Feet --}}
                        <h3 class="fs-title mt-3">Area Per Square Feet</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Area (sq ft)</label>
                                <input type="number" name="area_per_sqft" id="area_per_sqft" class="form-control" placeholder="Area in Square Feet" step="0.01" min="0">
                            </div>
                            <div class="col-md-4">
                                <label>Total Amount (calculated)</label>
                                <input type="number" name="total_amount" id="total_amount" class="form-control" readonly placeholder="0">
                            </div>
                        </div>

                        {{-- Map Approved Upload --}}
                        <h3 class="fs-title mt-3">Map Approved Upload</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <button type="button" class="format-btn" data-format="pdf">PDF</button>
                                    <button type="button" class="format-btn" data-format="png">IMAGE</button>
                                    <button type="button" class="format-btn" data-format="dwg">AUTO CAD</button>
                                </div>

                                {{-- ✅ One preview div per format, all sit side-by-side --}}
                                <div id="all-file-previews">
                                    <div id="file-preview-pdf"></div>
                                    <div id="file-preview-png"></div>
                                    <div id="file-preview-dwg"></div>
                                </div>

                                {{-- ✅ One hidden file input per format --}}
                                <input type="file" id="approved_map_pdf" name="approved_map_pdf" style="display:none;">
                                <input type="file" id="approved_map_png" name="approved_map_png" style="display:none;">
                                <input type="file" id="approved_map_dwg" name="approved_map_dwg" style="display:none;">
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal for Map Upload --}}
    <div id="uploadModal" class="modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Upload File</h3>
                <button type="button" class="close-modal" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body" style="padding: 16px 20px;">
                <p id="modalInstruction">Select file...</p>
                <input type="file" id="modalFileInput" style="margin: 12px 0;">
                <div id="fileError" style="color:#e74c3c; font-size:13px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()">Cancel</button>
                <button type="button" id="attachBtn" onclick="attachFile()">Attach</button>
            </div>
        </div>
    </div>

    <script>
        // ---------- Owner selection toggle ----------
        function toggleFormSections() {
            const ownerCheckboxes = document.querySelectorAll('input[name="select_owners[]"]');
            const wrapper = document.getElementById('formSectionsWrapper');
            const anyChecked = Array.from(ownerCheckboxes).some(cb => cb.checked);
            wrapper.style.display = anyChecked ? 'block' : 'none';
        }

        // ---------- Area calculation ----------
        function calculateTotalAmount() {
            const area = parseFloat(document.getElementById('area_per_sqft').value) || 0;
            const allotmentType = '{{ $property->allotment_type }}';
            let multiplier = (allotmentType === 'original_allotee') ? 4 : (allotmentType === 'transferred' ? 10 : 0);
            document.getElementById('total_amount').value = (area * multiplier).toFixed(0);
        }

        // ---------- Generic file preview (attorney / architect / engineer) ----------
        function updateFilePreview(input, previewId) {
            const container = document.getElementById(previewId);
            if (!container) return;
            container.innerHTML = '';
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const url  = URL.createObjectURL(file);
                const displayName = file.name.length > 25 ? file.name.substring(0, 25) + '...' : file.name;
                container.innerHTML = `
                    <div class="file-tag">
                        <a href="${url}" target="_blank">${displayName}</a>
                        <button type="button" onclick="removeFile(this, '${input.id}')">×</button>
                    </div>
                `;
            }
        }

        function removeFile(btn, inputId) {
            const input = document.getElementById(inputId);
            if (input) input.value = '';
            btn.closest('.file-tag')?.remove();
        }

        // ---------- Attorney toggle ----------
        function toggleAttorney() {
            const isAttorney = document.querySelector('input[name="representation_type"]:checked')?.value === 'attorney';
            document.getElementById('attorney_details').style.display = isAttorney ? 'block' : 'none';
        }

        // ---------- Map modal logic ----------
        let selectedFormat = '';
        const modalFileInput = document.getElementById('modalFileInput');
        const errorDiv       = document.getElementById('fileError');

        // Config per format
        const formatConfig = {
            pdf: {
                title  : "Upload PDF",
                accept : ".pdf",
                text   : "Please select a PDF file",
                exts   : ['pdf'],
                inputId: 'approved_map_pdf',
                prevId : 'file-preview-pdf'
            },
            png: {
                title  : "Upload Image",
                accept : ".png,.jpg,.jpeg",
                text   : "Please select an image file (PNG / JPG)",
                exts   : ['png', 'jpg', 'jpeg'],
                inputId: 'approved_map_png',
                prevId : 'file-preview-png'
            },
            dwg: {
                title  : "Upload AutoCAD",
                accept : ".dwg,.dxf",
                text   : "Please select an AutoCAD file (.dwg or .dxf)",
                exts   : ['dwg', 'dxf'],
                inputId: 'approved_map_dwg',
                prevId : 'file-preview-dwg'
            }
        };

        function openModal(format) {
            selectedFormat = format;
            const f = formatConfig[format];
            document.getElementById('modalTitle').innerText       = f.title;
            document.getElementById('modalInstruction').innerText = f.text;
            modalFileInput.accept  = f.accept;
            modalFileInput.value   = '';
            errorDiv.innerText     = '';
            document.getElementById('uploadModal').style.display  = 'flex';
        }

        function closeModal() {
            document.getElementById('uploadModal').style.display = 'none';
        }

        function attachFile() {
            const file = modalFileInput.files[0];
            if (!file) {
                errorDiv.innerText = "Please select a file first.";
                return;
            }

            const ext = file.name.split('.').pop().toLowerCase();
            const cfg = formatConfig[selectedFormat];

            if (!cfg.exts.includes(ext)) {
                errorDiv.innerText = `Wrong file type. Allowed: ${cfg.exts.map(e => '.' + e).join(', ')}`;
                return;
            }

            // ✅ Only clear & update the preview for THIS format
            const previewDiv = document.getElementById(cfg.prevId);
            const hiddenInput = document.getElementById(cfg.inputId);

            previewDiv.innerHTML = '';   // replace previous file of same format
            hiddenInput.value    = '';

            // Transfer file to this format's hidden input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            hiddenInput.files = dataTransfer.files;

            // Show preview tag for this format
            const url         = URL.createObjectURL(file);
            const displayName = file.name.length > 25 ? file.name.substring(0, 25) + '...' : file.name;
            previewDiv.innerHTML = `
                <div class="file-tag">
                    <a href="${url}" target="_blank">${displayName}</a>
                    <button type="button" onclick="removeMapFile('${cfg.inputId}', '${cfg.prevId}')">×</button>
                </div>
            `;

            closeModal();
        }

        // ✅ Remove only the specific format's file & preview
        function removeMapFile(inputId, prevId) {
            const input = document.getElementById(inputId);
            if (input) input.value = '';
            const prev = document.getElementById(prevId);
            if (prev) prev.innerHTML = '';
        }

        // ---------- Initialize all events ----------
        document.addEventListener('DOMContentLoaded', function () {

            // Owner checkboxes
            document.querySelectorAll('input[name="select_owners[]"]')
                .forEach(cb => cb.addEventListener('change', toggleFormSections));
            toggleFormSections();

            // Area calculation
            const areaInput = document.getElementById('area_per_sqft');
            if (areaInput) areaInput.addEventListener('input', calculateTotalAmount);
            calculateTotalAmount();

            // Attorney toggle
            document.querySelectorAll('input[name="representation_type"]')
                .forEach(r => r.addEventListener('change', toggleAttorney));
            toggleAttorney();

            // Map format buttons
            document.querySelectorAll('.format-btn')
                .forEach(btn => btn.addEventListener('click', () => openModal(btn.dataset.format)));

            // Clear ALL file previews on form reset
            document.querySelector('button[type="reset"]').addEventListener('click', function () {
                setTimeout(() => {
                    ['file-preview-pdf', 'file-preview-png', 'file-preview-dwg',
                     'architect_preview', 'engineer_preview',
                     'cnic_front_preview', 'cnic_back_preview', 'letter_preview']
                        .forEach(id => {
                            const el = document.getElementById(id);
                            if (el) el.innerHTML = '';
                        });
                }, 10);
            });
        });

        // Submit validation
        document.getElementById('houseConstructionForm').addEventListener('submit', function (e) {
            const selectedOwners = document.querySelectorAll('input[name="select_owners[]"]:checked');
            if (selectedOwners.length === 0) {
                e.preventDefault();
                alert('Please select at least one owner.');
            }
        });
    </script>
</x-app-layout>
