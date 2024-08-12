
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
      <a class="sidebar-brand brand-logo" href="{{ url('/') }}" ><img src="/images/logo.png" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="/images/logo.png" alt="logo" /></a>
    </div>
    <ul class="nav">
      <li class="nav-item profile">
        <div class="profile-desc">
          <div class="profile-pic">
            <div class="count-indicator">
              <span class="count bg-success"></span>
            </div>
            <div class="profile-name">
              <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
              <!-- @if(Auth::user()->user_status)  -->
              <span>Gold Member</span>
              <!-- @endif -->
            </div>
          </div>
          <a href="#" id="profile-dropdown" data-bs-toggle="dropdown">
            <i class="mdi mdi-dots-vertical"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
            
            <div class="dropdown-divider"></div>
            <a href="{{ route('change-password') }}" class="dropdown-item preview-item">

              <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                  <i class="mdi mdi-onepassword  text-info"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
              </div>
            </a>
            
        </div>
      </li>
    
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('admin-dashboard') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

   
      @canany(['create-user', 'edit-user', 'delete-user'])
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('users.index') }}">
          <span class="menu-icon">
            <span class="mdi mdi-account-group"></span>
          </span>
          <span class="menu-title">Users</span>
        </a>
      </li>
      @endcan
      @canany(['create-permission', 'edit-permission', 'delete-permission'])
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('permissions.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-playlist-play"></i>
          </span>
          <span class="menu-title">Permissions</span>
        </a>
      </li>
      @endcan
      @canany(['create-role', 'edit-role', 'delete-role'])
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('roles.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-playlist-play"></i>
          </span>
          <span class="menu-title">Roles</span>
        </a>
      </li>
      @endcan
   
      @can(['create-product', 'edit-product', 'delete-product','view-product' ])
     
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('products.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-playlist-play"></i>
          </span>
          <span class="menu-title">Products</span>
        </a>
      </li>

      @endcan

  
      @canany(['create-order', 'edit-order', 'delete-order','view-order'])

      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('orders.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-playlist-play"></i>
          </span>
          <span class="menu-title">Orders</span>
        </a>
      </li>
      @endcan
      @canany(['create-category', 'edit-category', 'delete-category','view-category'])
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('categories.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-playlist-play"></i>
          </span>
          <span class="menu-title">Categories</span>
        </a>
      </li>
      @endcan
     
      
    </ul>
  </nav>