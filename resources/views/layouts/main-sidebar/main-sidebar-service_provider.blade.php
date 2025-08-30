<style>
    .sidebar-header {
        border-bottom: 1px solid #e0e0e0;
        background: linear-gradient(135deg, #e9f2ff, #ffffff);
        /* تدرج أزرق ناعم */
        padding: 1.2rem;
        border-radius: 0 0 15px 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: background 0.4s ease, box-shadow 0.4s ease;
    }

    .sidebar-header:hover {
        background: linear-gradient(135deg, #dbe9ff, #f9fbff);
        box-shadow: 0 6px 16px rgba(0, 123, 255, 0.15);
    }

    .profile-image {
        position: relative;
        transition: transform 0.3s ease;
    }

    .profile-image img {
        border-radius: 50%;
        border: 3px solid #007bff;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-image img:hover {
        transform: scale(1.12);
        box-shadow: 0 6px 18px rgba(0, 123, 255, 0.35);
    }

    .profile-info h6 {
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .profile-info h6:hover {
        color: #0056b3;
        transform: translateX(5px);
    }
</style>

<div id="sidebar" class="sidebar-desktop">
    <div class="sidebar-wrapper active ps ps--active-y">
        <div class="sidebar-header d-flex align-items-center p-3 shadow-sm">
            <div class="profile-image me-3 position-relative">
                <img src="{{ URL::asset('assets/image/Profile/' . auth()->user()->image) }}" alt="Logo"
                    class="rounded-circle border border-primary" style="width: 60px; height: 60px;">
            </div>
            <div class="profile-info flex-grow-1">
                <a href="{{ route('Profiles.index') }}" class="text-decoration-none text-dark">
                    <h6 class="fs-5 fw-bold mb-1">{{ auth()->user()->name }}</h6>
                    <h6 class="text-muted mb-0" style="font-size: 0.8rem;">{{ auth()->user()->email }}</h6>
                </a>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">

                <li class="sidebar-title">{{ trans('dashboard.mune') }}</li>

                <li class="sidebar-item {{ Route::is('service_provider.dashboard') ? 'active' : '' }} ">
                    <a href="{{ route('service_provider.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-speedometer2"></i> <span>{{ trans('dashboard.dashboard') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('Profiles.index') ? 'active' : '' }}">
                    <a href="{{ route('Profiles.index') }}" class="sidebar-link">
                        <i class="bi bi-person-circle"></i><span>{{ trans('dashboard.profile') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('MyWork.index') ? 'active' : '' }}">
                    <a href="{{ route('MyWork.index') }}" class="sidebar-link">
                        <i class="bi bi-collection-fill"></i>
                        <span>{{ trans('dashboard.MyWork') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('service_provider.transactions') ? 'active' : '' }}">
                    <a href="{{ route('service_provider.transactions') }}" class="sidebar-link">
                        <i class="fa-solid fa-money-bill-transfer"></i> <span>{{ trans('dashboard.transactions') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('user.disputes.index') ? 'active' : '' }}">
                    <a href="{{ route('user.disputes.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-scale-balanced"></i> <span>{{ trans('dashboard.disputes') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('service_provider.withdraw') ? 'active' : '' }}">
                    <a href="{{ route('service_provider.withdraw') }}" class="sidebar-link">
                        <i class="fa-solid fa-money-bill-wave"></i> <span>{{ trans('dashboard.withdraw_funds') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('chat.index') ? 'active' : '' }}">
                    <a href="{{ route('chat.index') }}" class="sidebar-link">
                        <i class="bi bi-chat-dots-fill"></i> <span>{{ trans('dashboard.chat') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('projects.index') ? 'active' : '' }}">
                    <a href="{{ route('projects.index') }}" class="sidebar-link">
                        <i class="bi bi-kanban-fill"></i><span>{{ trans('dashboard.projects') }}</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('logout') }}" class="btn btn-danger w-100 mt-1">
                        <i class="bi bi-box-arrow-right"></i> <span>{{ trans('dashboard.log_out') }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 655px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 243px;"></div>
        </div>
    </div>
</div>
