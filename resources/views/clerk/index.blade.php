<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        i{
            position: relative;
            font-size:16px;
        }
        .detail{
            font-size:18px;
        }
        .delete{
          font-size:18px;
        }
        i:hover{
            cursor: pointer;

        }

    </style>
<style>
/* Modal background */
.modern-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background-color: rgba(0,0,0,0.5);
}

/* Modal box */
.modern-modal-content {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    max-width: 350px;
    margin: 10% auto;
    position: relative;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    text-align: center;
    animation: fadeIn 0.3s ease-in-out;
}

/* Close button */
.modern-close {
    position: absolute;
    top: 10px; right: 15px;
    font-size: 24px;
    color: #007bff;
    cursor: pointer;
}

/* Input */
#appointment {
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-top: 15px;
    font-size: 14px;
}

/* Save button */
.modern-save-btn {
    background: #007bff;
    border: none;
    padding: 10px 20px;
    color: white;
    font-size: 14px;
    border-radius: 6px;
    margin-top: 15px;
    cursor: pointer;
}
.modern-save-btn:hover {
    background: #0056b3;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-10px);}
    to {opacity: 1; transform: translateY(0);}
}

</style>
<style>

.loader {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #007bff;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 0.8s linear infinite;
    margin: 0 auto;
}
@keyframes spin {
    0% { transform: rotate(0deg);}
    100% { transform: rotate(360deg);}
}

/* Message colors */
#appointmentMessage.error { color: red; }
#appointmentMessage.success { color: green; }

/* Message styles */
#appointmentMessage.error {
    color: red;
}
#appointmentMessage.success {
    color: green;
}
</style>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="card">
                            <div class="card-header">
                              <h3 class="text-center">Properties List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              @if(session('success'))
                                  <div class="alert alert-success">
                                      {{ session('success') }}
                                  </div>
                              @endif

                              <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                  <th style="width:50px !important;">#</th>
                                  <th>Applicant Name</th>
                                  <th>Applicant CNIC</th>
                                  <th>Code</th>
                                  <th>Request Type</th>
                                  <th>Plot No</th>
                                  <th>Town</th>
                                  <th>Sector</th>
                            
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($properties as $dat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dat->participants->map(fn($owner) => $owner->owner->name ?? 'N/A')->implode(', ') ?? 'N/A' }}</td>
                                    <td>{{ $dat->participants->map(fn($owner) => $owner->owner->cnic ?? 'N/A')->implode(', ') ?? 'N/A' }}</td>
                                    <td>{{ $dat->property ? $dat->property->code : '' }}</td>
                                    @php
                                      $Request = DB::table('request_types')->where('id',$dat->request_type)->first();
                                    @endphp
                                    <td>{{ $Request->name }}</td>
                                    <td>
                                        @if($dat->request_type == 4)
                                      <a href="/dd-transfer-verification/{{$dat->id}}/{{$dat->request_type}}">
                                          {{ $dat->property ? $dat->property->plot_no : '' }}
                                      </a>
                                      @else
                                      <a href="/transferfile-detail/{{$dat->id}}">
                                          {{ $dat->property ? $dat->property->plot_no : '' }}
                                      </a>
                                      @endif
                                    </td>
                                    <td>{{ $dat->property->township->name ?? 'N/A' }}</td>
                                    <td>Sector {{ $dat->property->sector ?? 'N/A' }}</td>



                                </tr>
                                @endforeach
                            </tbody>
                              </table>
                            </div>
                            <!-- /.card-body -->
                          </div>
                          <!-- Appointment Modal -->
<!-- Appointment Modal -->
<!-- Appointment Modal -->
<div id="appointmentModal" class="modern-modal">
    <div class="modern-modal-content">
        <span class="modern-close" onclick="closeAppointmentModal()">&times;</span>

        <h3>Set Appointment</h3>
        <p>Select the date & time for this appointment:</p>

        <!-- Error / Success Message -->
        <div id="appointmentMessage" style="display:none; margin-bottom:10px; font-size:14px;"></div>

        <!-- Appointment Form -->
        <form id="appointmentForm">
            @csrf
            <input type="hidden" id="request_id" name="request_id">

            <!-- Single timestamp field -->
            <input type="datetime-local" id="appointment" name="appointment" required>

            <!-- Loader -->
            <div id="appointmentLoader" style="display:none; margin-top:10px;">
                <div class="loader"></div>
            </div>

            <button type="submit" class="modern-save-btn">Save</button>
        </form>
    </div>
</div>



                    </div>

                </div>
            </div>

            <script src="../../plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- DataTables  & Plugins -->
            <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
            <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../../dist/js/adminlte.min.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../../dist/js/demo.js"></script>
            <!-- Page specific script -->
            <script>
              $(function () {
                $("#example1").DataTable({
                  "responsive": true, "lengthChange": false, "autoWidth": false,

                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

              });
            </script>
<script>
function openAppointmentModal(requestId) {
    // Reset form and messages
    document.getElementById("appointmentForm").reset();
    document.getElementById("appointmentMessage").style.display = "none";
    document.getElementById("appointmentLoader").style.display = "none";

    // Set request ID
    document.getElementById("request_id").value = requestId;

    // Show modal
    document.getElementById("appointmentModal").style.display = "block";
}

function closeAppointmentModal() {
    document.getElementById("appointmentModal").style.display = "none";
}

// Close modal if clicked outside
window.onclick = function(event) {
    if (event.target.id === "appointmentModal") {
        closeAppointmentModal();
    }
}

// Handle form submit
document.getElementById("appointmentForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    let loader = document.getElementById("appointmentLoader");
    let messageBox = document.getElementById("appointmentMessage");

    // Show loader, hide messages
    loader.style.display = "block";
    messageBox.style.display = "none";

    fetch("{{ route('save.appointment') }}", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: formData
    })
    .then(async res => {
        loader.style.display = "none";
        let data = await res.json();

        if (!res.ok) {
            // Show error
            messageBox.textContent = data.message || "An error occurred.";
            messageBox.className = "error";
            messageBox.style.display = "block";
        } else {
            // Show success
            messageBox.textContent = data.message;
            messageBox.className = "success";
            messageBox.style.display = "block";

            // Close modal & refresh page after 1 second
            setTimeout(() => {
                closeAppointmentModal();
                location.reload();
            }, 1000);
        }
    })
    .catch(err => {
        loader.style.display = "none";
        messageBox.textContent = "Network error: " + err.message;
        messageBox.className = "error";
        messageBox.style.display = "block";
    });
});
</script>



    </div>
</x-app-layout>
