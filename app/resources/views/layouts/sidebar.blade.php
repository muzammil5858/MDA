<style>
    .side-item:hover p{
        color:white !important;
    }
    .sidebar p{
      color:#c2c7d0 !important;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link text-center" style="pointer-events: none; opacity: 0.5;">
  <span class="brand-text font-weight-light">Dashboard</span>
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
              <p>
                Dashboard
              </p>
            </a>
          </li><li class="nav-item">
            <a href="{{route('qaFiles')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p>
              Indexed Files
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('entryFiles')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p>
              Entry Files
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('user'))
          <li class="nav-item">
            <a href="{{route('property_list')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p>
              Transfer File
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('director'))
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p>
             Dashboard
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('record-clerk'))
          <li class="nav-item">
            <a href="{{route('transferRequest_list')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-file"></i>
              <p>
              Transfer Requests
              </p>
            </a>
            <li class="nav-item">
              <a href="{{route('acceptedRequest_list')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p>
                Accepted Requests
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('rejectedRequest_list')}}" class="nav-link side-item">
                <i class="nav-icon fas fa-file"></i>
                <p>
                Rejected Requests
                </p>
              </a>
            </li>
          </li>
          @else
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link side-item">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link side-item">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Form
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/form" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/form-list" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Form List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/entries-list" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Entries List</p>
                </a>
              </li>
              
            </ul>
          </li>
          {{-- <li class="nav-item">
            <a href="#" class="nav-link side-item">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Scanning
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/scannig-form" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/scanning-form-list" class="nav-link side-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Form List</p>
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