@extends('layouts.apprp')

@section('content')
<style>
    .file-drop-area {
            border: 2px dashed #7da2d9;
            padding: 10px;
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
        .img-preview {
            max-height: 120px;
            max-width: 100%;
            margin-top: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            object-fit: contain;
        }
</style>
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-person-plus-fill me-2"></i> Create New User
        </h3>
        <a class="btn btn-outline-secondary btn-sm shadow-sm" href="{{ route('users.index') }}">
            <i class="bi bi-arrow-left me-1"></i> Back to Users
        </a>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> Something went wrong. Please check the fields below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    
                    <div class="col-md-6">
                        <h5 class="mb-3 text-secondary border-bottom pb-2">Personal Information</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Name:</label>
                            <input type="text" name="name" id="name" placeholder="Full Name" 
                                class="form-control @error('name') is-invalid @enderror">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email:</label>
                            <input type="email" name="email" id="email" placeholder="user@example.com" 
                                class="form-control @error('email') is-invalid @enderror">
                        </div>
                        <div class="mb-3">
                            <label for="cnic" class="form-label fw-semibold">CNIC / National ID:</label>
                            <input type="text" name="cnic" id="cnic" placeholder="e.g., 1234567890123" 
                                class="form-control @error('cnic') is-invalid @enderror">
                        </div>
                        <div class="mb-3">
                            <label for="phoneno" class="form-label fw-semibold">Phone Number:</label>
                            <input type="tel" name="phoneno" id="phoneno" placeholder="e.g., 03001234567" 
                                class="form-control @error('phoneno') is-invalid @enderror">
                        </div>
                        
                        <div class="mb-3">
                            <label for="town" class="form-label fw-semibold">Associated Towns:</label>
                            <select name="town[]" id="town" class="form-select form-control" multiple data-placeholder="Select one or more towns">
                                <option value="" disabled>Select Town(s)</option>
                                <option value="1">Town Lahore</option>
                                <option value="2">Town Karachi</option>
                                <option value="3">Town Islamabad</option>
                            </select>
                        </div>

                    </div>
                    
                    <div class="col-md-6">
                        <h5 class="mb-3 text-secondary border-bottom pb-2">Security & Roles</h5>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password:</label>
                            <input type="password" name="password" id="password" placeholder="Enter Password" 
                                class="form-control @error('password') is-invalid @enderror">
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label fw-semibold">Confirm Password:</label>
                            <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" 
                                class="form-control">
                        </div>

                        <div class="mb-4">
                            <label for="roles" class="form-label fw-semibold">Assign Role:</label>
                            <select name="roles" id="roles" class="form-select form-control" data-placeholder="Select a single role">
                                <option value="" disabled selected>Select Role</option>
                                @foreach ($roles as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        
                        <h5 class="mb-3 text-secondary border-bottom pb-2">Biometric Registration</h5>
                        <div class="border p-3 rounded-3 bg-light">
                            <label class="form-label fw-semibold">Fingerprint Template:</label>
                            <div class="file-drop-area pasteButton" 
                                         
                                        data-target-img="biometric-user"
                                        data-target-input="biometric-user"
                                        data-target="biometric-user"
                                        >
                                        <span>CLick to add or update Biometric</span>
                                        <img id="biometric-user" class="img-preview" src="#"
                                             />
                                        </div> 
                        </div>
                        
                    </div>
                    <input type="hidden" name="biometric" id="biometric">
                    <div class="col-12 mt-4 text-center">
                        <button type="submit" class="btn btn-primary btn-md px-5 shadow-lg">
                            <i class="bi bi-save me-2"></i> Submit User
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="thumbModal" tabindex="-1" aria-labelledby="thumbModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-center p-4">
                                    <div id="modalIcon" class="mb-3">
                                        <!-- Icons will be injected here -->
                                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                                    </div>
                                    <div id="modalMessage" class="fs-5 fw-semibold">Please place thumb on device...</div>
                                    </div>
                                </div>
                                </div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {

    // Make sure thumbData exists
    window.thumbData = window.thumbData || {};

    // Correct button selection
    const buttons = document.querySelectorAll('.pasteButton');

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const imgId = this.getAttribute('data-target');
        

            const cnicInput = document.getElementById('cnic');
            const imgElement = document.getElementById(imgId);
           

            const cnic = cnicInput ? cnicInput.value : '';

            // Bootstrap modal
            const modal = new bootstrap.Modal(document.getElementById('thumbModal'));
            const modalIcon = document.getElementById('modalIcon');
            const modalMessage = document.getElementById('modalMessage');

            modalIcon.innerHTML = `
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
            `;
            modalMessage.textContent = 'Please place thumb on device...';
            modal.show();

            // Button loading UI
            this.disabled = true;
            this.querySelector('span').textContent = 'Processing...';

            fetch('http://localhost:9099/api/GetImage', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.Status && data.ImgBase64) {

                        const base64Img = `data:image/bmp;base64,${data.ImgBase64}`;

                        // Show images
                        if (imgElement) imgElement.src = base64Img;
                        

                        

                        thumbData[0] = {
                            image: data.ImgBase64,
                            cnic: cnic,
                            code: data.Code,
                            template: data.TemplateBase64 || null,
                            deviceType: data.DeviceType || 'Unknown',
                            status: true,
                            timestamp: new Date().toISOString()
                        };

                        // Update hidden form input
                        document.getElementById('biometric').value = JSON.stringify(thumbData);

                        // Success UI
                        modalIcon.innerHTML = `<i class="fas fa-check-circle icon-check"></i>`;
                        modalMessage.textContent = 'Thumb captured successfully! ✅';

                    } else {
                        modalIcon.innerHTML = `<i class="fas fa-times-circle icon-cross"></i>`;
                        modalMessage.textContent = data.Message || 'Failed to capture thumb';
                    }
                })
                .catch(error => {
                    modalIcon.innerHTML = `<i class="fas fa-times-circle icon-cross"></i>`;
                    modalMessage.textContent = 'Device not responding ❌';
                    console.error('AJAX Error:', error);
                })
                .finally(() => {
                    setTimeout(() => {
                        modal.hide();
                        button.disabled = false;
                        button.querySelector('span').textContent = 'Click to update Picture';
                    }, 1500);
                });

        });
    });

});
</script>


@endsection