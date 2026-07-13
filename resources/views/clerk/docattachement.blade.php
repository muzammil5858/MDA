<x-app-layout>
    <style>
        /* Container & Card Styling */
        .container {
            background: #fdfdfd;
            border: 1px solid #F4F6F9;
            margin-top: 20px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h2#heading {
            text-transform: uppercase;
            color: #03346E;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: 1.5px;
        }

        p#subheading {
            font-size: 1rem;
            text-align: center;
            color: #555;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* File Upload Styles */
        .file-drop-area {
            border: 2px dashed #7da2d9;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            border-radius: 8px;
            background-color: #f9fbff;
            transition: background 0.25s ease-in-out, border-color 0.25s ease-in-out;
            position: relative;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .file-drop-area:hover {
            background-color: #e6f0ff;
            border-color: #5b8def;
        }

        .file-drop-area.dragover {
            background-color: #cce0ff;
            border-color: #3a65d8;
        }

        .file-drop-area span {
            font-size: 0.8rem;
            color: #3a3a3a;
            user-select: none;
        }

        input[type="file"] {
            display: none;
        }

        .img-preview {
            max-height: 120px;
            max-width: 100%;
            margin-top: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            object-fit: contain;
        }

        label {
            font-weight: 600;
            color: #03346E;
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        button[type="submit"] {
            background-color: #03346E;
            border: none;
            color: white;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            font-weight: 600;
        }

        button[type="submit"]:hover {
            background-color: #021f4a;
        }

        /* Layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .col-md-3 {
            flex: 1 1 calc(25% - 30px);
            max-width: calc(25% - 30px);
        }

        @media (max-width: 991px) {
            .col-md-3 {
                flex: 1 1 calc(50% - 30px);
                max-width: calc(50% - 30px);
            }
        }

        @media (max-width: 575px) {
            .col-md-3 {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }

        /* Paid fields */
        .payment-fields {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .payment-fields input {
            padding: 7px 10px;
            font-size: 0.85rem;
            border: 1px solid #d1d9e6;
            border-radius: 5px;
            background: #f9fbff;
        }

        .payment-fields input:focus {
            outline: none;
            border-color: #5b8def;
            box-shadow: 0 0 0 2px rgba(91, 141, 239, 0.15);
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('transferRequestAttachDone') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h2 id="heading">Required File Attachments Form</h2>
                        <p id="subheading">File Transfer Request</p>
                        @if ($errors->any())
    <div class="alert alert-danger">
        <h5 class="alert-heading">Please fix the following errors:</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                        @php
                        $attachments = [
                        'transferfee_attach' => 'Deposit Slip of Transfer Fee',
                        'klc_attach' => 'Deposit Slip of KLC',
                        'incometax_attach' => 'Deposit Slip Income Tax',
                        'educess_attach' => 'Deposit Slip of Education Cess',
                        'stampduty_attach' => 'Stamp Duty',
                        'other' => 'Any Other Document (PDF)',
                        ];
                        @endphp
                        <input type="hidden" name="request_id" value="{{ $data->id }}">
                        <input type="hidden" name="town_id" value="{{ $data->town }}">
                        <input type="hidden" name="property_id" value="{{ $data->property_id }}">
                        <div class="row">
    @foreach ($attachments as $name => $label)
    <div class="col-md-3">
        <label>{{ $label }}</label>

        <div class="file-drop-area" id="drop-area-{{ $name }}"
            onclick="triggerFileInput('{{ $name }}')" ondrop="handleDrop(event, '{{ $name }}')"
            ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">

            <input type="file" name="{{ $name }}" id="{{ $name }}"
                accept="{{ $name === 'other' ? 'application/pdf' : 'image/*' }}"
                onchange="previewImage(event, '{{ $name }}')">

            <span>Drag & Drop or Click to Upload</span>
            <img id="preview-{{ $name }}" class="img-preview d-none">
        </div>

        @if($name !== 'other')
        <div class="payment-fields">
            @if($name == 'stampduty_attach')
            <input type="text" name="stamp_no" placeholder="Stamp No">
            @else
            <input type="text" name="{{ $name }}_challan_no" placeholder="Challan No">
            @endif
            <input type="number" name="{{ $name }}_paid_amount" placeholder="Paid Amount" min="0" step="0.01">
            <input type="date" name="{{ $name }}_paid_date">
        </div>
        @endif
    </div>
    @endforeach
    <div class="col-md-3">
        
    </div>
</div>

                        <button type="submit">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function triggerFileInput(id) {
            document.getElementById(id).click();
        }

        function previewImage(event, id) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview-' + id);
            const dropArea = document.getElementById('drop-area-' + id);

            dropArea.querySelectorAll('.file-info').forEach(e => e.remove());

            if (!file) return;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('d-none');
                const info = document.createElement('div');
                info.className = 'file-info';
                info.innerHTML = `📄 <strong>${file.name}</strong>`;
                dropArea.appendChild(info);
            }
        }

        function handleDrop(event, id) {
            event.preventDefault();
            document.getElementById(id).files = event.dataTransfer.files;
            previewImage({ target: document.getElementById(id) }, id);
            event.currentTarget.classList.remove('dragover');
        }

        function handleDragOver(event) {
            event.preventDefault();
            event.currentTarget.classList.add('dragover');
        }

        function handleDragLeave(event) {
            event.currentTarget.classList.remove('dragover');
        }
    </script>
</x-app-layout>