<style>
    .side-item:hover p{
        color:white !important;
    }
    .sidebar .nav-heading{
      color:#ffffff !important;
    }
    .sidebar-color{
      background: rgb(5, 68, 104);
    }
    .sidebar ul a{
      display: block;
      padding: 13px 10px;
      border-bottom: 1px solid #10558d;
      color: rgb(241, 237, 237);
      font-size: 15px;
      position: relative;
      cursor: pointer;
    }
    .nav-icon{
      color:white;
    }
     .sidebar ul  a:hover,
     .sidebar ul  a.active{
      background:white;
      border-right: 2px solid rgb(5, 68, 104);

      }


      .sidebar ul li a:hover .nav-icon,
      .sidebar ul li a:hover .nav-heading,
      .sidebar ul li a:active .nav-heading,
      .sidebar ul li a:active .nav-icon
      {
        color:rgb(5, 68, 104) !important;
      }
      .brand-link{
        color:white;
      }
</style>
<aside class="main-sidebar sidebar-color elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link text-center">

      <span class="brand-text font-weight-light" >Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->



          @if(auth()->user()->hasRole('QA'))
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Dashboard
              </p>
            </a>
          </li><li class="nav-item">
            <a href="{{route('qaFiles')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Indexed Files
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('entryFiles')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Entry Files
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('user'))
          <li class="nav-item">
            <a href="{{route('property_list')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Transfer File
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('trackApplication')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Track Application
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('AppointmentBook')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Book Appointment
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('record-clerk'))

          <li class="nav-item">
            <a href="{{route('transferRequest_list')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Requests
              </p>
            </a>
            </li>
            <li class="nav-item">
              <a href="{{route('acceptedRequest_list')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p class="nav-heading">
                Accepted Requests
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('rejectedRequest_list')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p class="nav-heading">
                Rejected Requests
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('objectionRequest_list')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p class="nav-heading">
                Objection Requests
                </p>
              </a>
            </li>


          <li class="nav-item">
            <a href="#" class="nav-link side-item">
              <i class="nav-icon fa fa-calendar"></i>
              <p class="nav-heading">
                Appointment

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a  href="{{route('scheduleAppointment')}}" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Book Appointment
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('list.appointment')}}" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Appointment List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('rescheduleAppointment')}}" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Re-Schedule Appointment</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item">
              <a href="{{route('transferRequestList')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p class="nav-heading">
                Documents Attachements
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('attachedFileList')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p class="nav-heading">
                Attached Docs List
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('addedDetailFiles')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p class="nav-heading">
                Final Files
                </p>
              </a>
            </li>

          <li class="nav-item">
            <a href="{{route('filesQA')}}" class="nav-link side-item">
              <i class="nav-icon fa fa-calendar"></i>
              <p class="nav-heading">
                Files
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('Qafiles')}}" class="nav-link side-item">
              <i class="nav-icon fa fa-calendar"></i>
              <p class="nav-heading">
                Files QA
              </p>
            </a>
          </li>
        </li>
          @elseif(auth()->user()->hasRole('DD'))
          <li class="nav-item">
            <a href="{{route('transferRequest_list')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Transfer Requests
              </p>
            </a>
          </li>
            <li class="nav-item">
              <a href="{{route('acceptedRequest_list')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p class="nav-heading">
                Accepted Requests
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('rejectedRequest_list')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p class="nav-heading">
                Rejected Requests
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('scheduleAppointment')}}" class="nav-link side-item">
                <i class="nav-icon fa fa-calendar"></i>
                <p class="nav-heading">
                  Appointment
                </p>
              </a>
            </li>
          </li>
          @elseif(auth()->user()->hasRole('director'))
          <li class="nav-item">
            <a href="{{ route('dashboard') }}"
              class="nav-link side-item"
              style="color: white;"
              onmouseover="this.style.setProperty('color', 'blue', 'important'); this.querySelector('p').style.setProperty('color', 'blue', 'important'); this.querySelector('i').style.setProperty('color', 'blue', 'important');"
              onmouseout="this.style.setProperty('color', 'white', 'important'); this.querySelector('p').style.setProperty('color', 'white', 'important'); this.querySelector('i').style.setProperty('color', 'white', 'important');">
              <i class="nav-icon fas fa-file"></i>
              <p>Dashboard</p>
            </a>

          </li>
          <li class="nav-item">
            <a href="{{route('ddTransfer')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
            Property Transfer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('transferOrderStatement')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Statement
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('transferedFile')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
            Transfered Property
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('completedRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
            Completed Requests
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('propertyVerification')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
            Old Property Transfer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('oldTransferList')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
            Old Transfers
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('assistant-director') || auth()->user()->hasRole('deputy-director'))

          <li class="nav-item">
            <a href="{{route('ddTransfer')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
            Property Transfer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('transferOrderStatement')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
              Statement
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('transferedFile')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
            Transfered Property
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('completedRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p class="nav-heading">
            Completed Requests
              </p>
            </a>
          </li>

          @elseif(auth()->user()->hasRole('mdhaQA'))
          <li class="nav-item">
            <a href="{{ route('dashboard') }}"
              class="nav-link side-item"
              style="color: white;"
              onmouseover="this.style.setProperty('color', 'blue', 'important'); this.querySelector('p').style.setProperty('color', 'blue', 'important'); this.querySelector('i').style.setProperty('color', 'blue', 'important');"
              onmouseout="this.style.setProperty('color', 'white', 'important'); this.querySelector('p').style.setProperty('color', 'white', 'important'); this.querySelector('i').style.setProperty('color', 'white', 'important');">
              <i class="nav-icon fas fa-file"></i>
              <p>Dashboard</p>
            </a>

          </li>
          <li class="nav-item">
            <a href="{{route('property.list')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-home"></i>
              <p class="nav-heading">
              MDHA
              </p>
            </a>
            <li class="nav-item">
              <a href="{{route('propertyArea',0)}}" class="nav-link side-item">
                <i class="nav-icon fas fa-home"></i>
                <p class="nav-heading">
                  New Small Town Siakh
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('propertyArea',1)}}" class="nav-link side-item">
                <i class="nav-icon fas fa-home"></i>
                <p class="nav-heading">
                  New Small Town Dudyal
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('propertyArea',2)}}" class="nav-link side-item">
                <i class="nav-icon fas fa-home"></i>
                <p class="nav-heading">
                  New City Mirpur
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('propertyArea',3)}}" class="nav-link side-item">
                <i class="nav-icon fas fa-home"></i>
                <p class="nav-heading">
                  New Small Town Islamgarh
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('propertyArea',4)}}" class="nav-link side-item">
                <i class="nav-icon fas fa-home"></i>
                <p class="nav-heading">
                  New Small Town Chaksawari
                </p>
              </a>
            </li>
          @elseif(auth()->user()->hasRole('front-desk'))
          {{-- <li class="nav-item">
            <a href="#" class="nav-link side-item">
              <i class="nav-icon fas fa-user-alt"></i>
              <p class="nav-heading">
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/create/user" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Create User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/users-list" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Users List</p>
                </a>
              </li>
            </ul>
          </li> --}}
          <li class="nav-item">
            <a href="/frontdesk-property-check" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Check Property
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/frontdesk-check-requests" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Requests
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/frontdesk-objection-requests" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Objection Requests
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('head-clerk'))
          @elseif(auth()->user()->hasRole('HDM'))
           <li class="nav-item">
            <a href="{{route('hdm.pendingRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Pending Requests
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{route('hdm.approvedRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Approved Requests
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('sub-engineer'))
           <li class="nav-item">
            <a href="{{route('engineer.pendingRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Pending Requests
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{route('engineer.approvedRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Approved Requests
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{route('engineer.map-approvals-list')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Map Approvals
              </p>
            </a>
          </li>

          @elseif(auth()->user()->hasRole('AD-Civil'))
           <li class="nav-item">
            <a href="{{route('ad-civil.pendingRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Pending Requests
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{route('ad-civil.approvedRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Approved Requests
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('DD-Civil'))
           <li class="nav-item">
            <a href="{{route('dd-civil.pendingRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Pending Requests
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{route('dd-civil.approvedRequests')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Approved Requests
              </p>
            </a>
          </li>
          @else
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p class="nav-heading">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link side-item">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p class="nav-heading">
                Form
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/form" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/form-list" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Form List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/entries-list" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Entries List</p>
                </a>
              </li>

            </ul>
          </li>
          {{-- <li class="nav-item">
            <a href="#" class="nav-link side-item">
              <i class="nav-icon fas fa-th"></i>
              <p class="nav-heading">
                Scanning
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/scannig-form" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/scanning-form-list" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="nav-heading">Form List</p>
                </a>
              </li>

            </ul>
          </li> --}}
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
