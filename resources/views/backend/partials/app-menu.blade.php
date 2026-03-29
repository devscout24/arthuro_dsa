 <!-- ========== App Menu ========== -->
 <div class="app-menu navbar-menu">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
             <span class="logo-sm">
                 @if (!empty($systemSetting->mini_logo))
                     <img src="{{ asset($systemSetting->mini_logo) }}" alt="Logo" height="22">
                 @endif
             </span>
             <span class="logo-lg">
                 @if (!empty($systemSetting->logo))
                     <img src="{{ asset($systemSetting->logo) }}" alt="Logo" height="35">
                 @endif
             </span>
         </a>
         <!-- Light Logo-->
         <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
             <span class="logo-sm">
                 @if (!empty($systemSetting->mini_logo))
                     <img src="{{ asset($systemSetting->mini_logo) }}" alt="Logo" height="22">
                 @endif
             </span>
             <span class="logo-lg">
                 @if (!empty($systemSetting->logo))
                     <img src="{{ asset($systemSetting->logo) }}" alt="Logo" height="35">
                 @endif
             </span>
         </a>
         <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
             id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <!-- sidebar-user -->
     <div class="dropdown sidebar-user m-1 rounded">
         <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <span class="d-flex align-items-center gap-2">
                 <img class="rounded header-profile-user"
                     src="{{ auth()->user()?->avatar ? asset(auth()->user()?->avatar) : asset('backend/assets/images/users/avatar-1.jpg') }}"
                     alt="Header Avatar">
                 <span class="text-start">
                     <span class="d-block fw-medium sidebar-user-name-text">{{ auth()->user()?->name }}</span>
                     <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                             class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                             class="align-middle">Online</span></span>
                 </span>
             </span>
         </button>
         <div class="dropdown-menu dropdown-menu-end">
             <!-- item-->
             <h6 class="dropdown-header">Welcome {{ auth()->user()?->name }}!</h6>
             <a class="dropdown-item" href="{{ route('admin.profile-settings.edit') }}"><i
                     class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Profile</span></a>
             <!-- Logout -->
             <form method="POST" action="{{ route('logout') }}">
                 @csrf
                 <button type="submit" class="dropdown-item">
                     <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                     <span class="align-middle" data-key="t-logout">Logout</span>
                 </button>
             </form>
         </div>
     </div>

     <!-- sidebar -->
     <div id="scrollbar">
         <div class="container-fluid">

             <div id="two-column-menu">
             </div>
             <ul class="navbar-nav" id="navbar-nav">

                 <!--  Menu -->
                 <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                 <!-- Dashboard -->
                 <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                         href="{{ route('admin.dashboard') }}">
                         <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                     </a>
                 </li>

                 {{-- banner --}}
                 <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"
                         href="{{ route('admin.banner.index') }}">
                         <i class="ri-image-add-line"></i> <span>Banner</span>
                     </a>
                 </li>

                 {{-- carrer --}}
                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.carrers.*') ? 'active' : '' }}"
                         href="{{ route('admin.carrer.index') }}">
                         <i class="ri-image-add-line"></i> <span>Career</span>
                     </a>
                 </li>

                 {{-- family --}}

                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.families.*') ? 'active' : '' }}"
                         href="{{ route('admin.family.index') }}">
                         <i class="ri-image-add-line"></i> <span>Family</span>
                     </a>
                 </li>

                 {{-- partner --}}

                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}"
                         href="{{ route('admin.partner.index') }}">
                         <i class="ri-image-add-line"></i> <span>Partner</span>
                     </a>
                 </li>

                 {{-- horizon   --}}

                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.horizons.*') ? 'active' : '' }}"
                         href="{{ route('admin.horizon.index') }}">
                         <i class="ri-image-add-line"></i> <span>Horizon</span>
                     </a>
                 </li>

                 {{-- work --}}

                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.works.*') ? 'active' : '' }}"
                         href="{{ route('admin.work.index') }}">
                         <i class="ri-image-add-line"></i> <span>Work</span>
                     </a>
                 </li>

                 {{-- anything --}}

                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.anythings.*') ? 'active' : '' }}"
                         href="{{ route('admin.anything.index') }}">
                         <i class="ri-image-add-line"></i> <span>Anything</span>
                     </a>
                 </li>

                 {{-- Explore --}}

                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.explores.*') ? 'active' : '' }}"
                         href="{{ route('admin.explore.index') }}">
                         <i class="ri-image-add-line"></i> <span>Explore</span>
                     </a>
                 </li>

                 {{-- Founder  --}}

                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.founders.*') ? 'active' : '' }}"
                         href="{{ route('admin.founder.index') }}">
                         <i class="ri-image-add-line"></i> <span>Founder</span>
                     </a>
                 </li>

                 {{-- team --}}

                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}"
                         href="{{ route('admin.team.index') }}">
                         <i class="ri-image-add-line"></i> <span>Team</span>
                     </a>
                 </li>

                 {{-- terms --}}
                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.term.*') ? 'active' : '' }}"
                         href="{{ route('admin.term.index') }}">
                         <i class="ri-image-add-line"></i> <span>Terms</span>
                     </a>
                 </li>

                 {{-- privacy --}}
                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.privacy-policy.*') ? 'active' : '' }}"
                         href="{{ route('admin.privacy-policy.index') }}">
                         <i class="ri-image-add-line"></i> <span>Privacy</span>
                     </a>
                 </li>

                 {{-- all user  --}}
                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}"
                         href="{{ route('admin.user.index') }}">
                         <i class="ri-image-add-line"></i> <span>Users</span>
                     </a>
                 </li>

                 {{-- contact --}}
                 <li>
                     <a class="nav-link menu-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}"
                         href="{{ route('admin.contact.index') }}">
                         <i class="ri-image-add-line"></i> <span>Contact</span>
                     </a>
                 </li>


                 {{-- Category Menu --}}
                 {{-- <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->routeIs('admin.categories.*') ? '' : 'collapsed' }}" href="#sidebarCategory" data-bs-toggle="collapse" role="button"
                         aria-expanded="{{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }}" aria-controls="sidebarCategory">
                         <i class="ri-folder-line"></i> <span>Category</span>
                     </a>
                     <div class="collapse menu-dropdown {{ request()->routeIs('admin.categories.*') ? 'show' : '' }}" id="sidebarCategory">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('admin.categories.create') }}" class="nav-link {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                                     Add Category
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                                     All Categories
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </li> --}}

                 {{-- Product Menu --}}
                 {{-- <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->routeIs('admin.products.*') ? '' : 'collapsed' }}" href="#sidebarProduct" data-bs-toggle="collapse" role="button"
                         aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}" aria-controls="sidebarProduct">
                         <i class="ri-shopping-bag-3-line"></i> <span>Product</span>
                     </a>
                     <div class="collapse menu-dropdown {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="sidebarProduct">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('admin.products.create') }}" class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                     Add Product
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                     All Products
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </li> --}}

                 {{-- <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li> --}}

                 {{-- nested drop down menu  --}}
                 {{-- <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                         <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Authentication</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarAuth">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSignIn" data-key="t-signin"> Sign
                                     In
                                 </a>
                                 <div class="collapse menu-dropdown" id="sidebarSignIn">
                                     <ul class="nav nav-sm flex-column">
                                         <li class="nav-item">
                                             <a href="auth-signin-basic.html" class="nav-link" data-key="t-basic"> Basic
                                             </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="auth-signin-cover.html" class="nav-link" data-key="t-cover"> Cover
                                             </a>
                                         </li>
                                     </ul>
                                 </div>
                             </li>
                         </ul>
                     </div>
                 </li> --}}

                 {{-- Settings --}}
                 <li class="menu-title"><span data-key="t-menu">Settings</span></li>

                 {{-- Settings Section --}}
                 <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->routeIs('admin.system-settings.*') || request()->routeIs('admin.mail-settings.*') || request()->routeIs('admin.profile-settings.*') || request()->routeIs('admin.payment-settings.*') ? '' : 'collapsed' }}"
                         href="#sidebarSettings" data-bs-toggle="collapse" role="button"
                         aria-expanded="{{ request()->routeIs('admin.system-settings.*') || request()->routeIs('admin.mail-settings.*') || request()->routeIs('admin.profile-settings.*') || request()->routeIs('admin.payment-settings.*') ? 'true' : 'false' }}"
                         aria-controls="sidebarSettings">
                         <i class="ri-settings-3-line"></i> <span>Settings</span>
                     </a>

                     <div class="collapse menu-dropdown {{ request()->routeIs('admin.stripe-settings.*') || request()->routeIs('admin.system-settings.*') || request()->routeIs('admin.mail-settings.*') || request()->routeIs('admin.profile-settings.*') || request()->routeIs('admin.payment-settings.*') || request()->routeIs('admin.social-settings.*') ? 'show' : '' }}"
                         id="sidebarSettings">

                         <ul class="nav nav-sm flex-column">
                             {{-- Profile Settings --}}
                             <li class="nav-item">
                                 <a href="{{ route('admin.profile-settings.edit') }}"
                                     class="nav-link {{ request()->routeIs('admin.profile-settings.*') ? 'active' : '' }}">
                                     <i class="ri-user-settings-line"></i> <span>Profile Settings</span>
                                 </a>
                             </li>

                             {{-- Social Settings --}}
                             <li class="nav-item">
                                 <a href="{{ route('admin.social-settings.edit') }}"
                                     class="nav-link {{ request()->routeIs('admin.social-settings.*') ? 'active' : '' }}">
                                     <i class="ri-share-line"></i> <span>Social Settings</span>
                                 </a>
                             </li>

                             {{-- Stripe Settings --}}
                             {{-- <li class="nav-item">
                                 <a href="{{ route('admin.stripe-settings.edit') }}"
                                     class="nav-link {{ request()->routeIs('admin.stripe-settings.*') ? 'active' : '' }}">
                                     <i class="ri-mail-settings-line"></i> <span>Stripe Settings</span>
                                 </a>
                             </li> --}}

                             {{-- System Settings --}}
                             <li class="nav-item">
                                 <a href="{{ route('admin.system-settings.edit') }}"
                                     class="nav-link {{ request()->routeIs('admin.system-settings.*') ? 'active' : '' }}">
                                     <i class="ri-settings-3-line"></i> <span>System Settings</span>
                                 </a>
                             </li>

                             {{-- Mail Settings --}}
                             {{-- <li class="nav-item">
                                 <a href="{{ route('admin.mail-settings.edit') }}"
                                     class="nav-link {{ request()->routeIs('admin.mail-settings.*') ? 'active' : '' }}">
                                     <i class="ri-mail-settings-line"></i> <span>Mail Settings</span>
                                 </a>
                             </li> --}}
                         </ul>
                     </div>
                 </li>

             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
