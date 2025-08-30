<!DOCTYPE html>
@if (App::getLocale() == 'ar')
    <html dir="rtl">
@else
    <html dir="ltr">
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.head')
</head>

<style>
    /* Overlay يغطي كامل الصفحة */
    #loader-overlay {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #ffffff;
        /* خلفية بيضاء */
        z-index: 9999;
        justify-content: center;
        align-items: center;
        opacity: 1;
        transition: opacity 0.6s ease;
        /* تأثير Fade Out */
    }

    /* Loader المثلث الأحمر */
    .triangle-loader {
        width: 0;
        height: 0;
        border-left: 30px solid transparent;
        border-right: 30px solid transparent;
        border-top: 50px solid red;
        animation: moveUpDown 0.3s ease-in-out infinite alternate;
    }

    @keyframes moveUpDown {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-6px);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('loader-overlay');
        let minTimePassed = false;
        let pageLoaded = false;

        // دالة لإخفاء الـ overlay عند تحقق الشرطين
        function tryHideOverlay() {
            if (minTimePassed && pageLoaded) {
                overlay.style.opacity = 0;
                overlay.addEventListener('transitionend', function handler() {
                    overlay.style.display = 'none';
                    overlay.removeEventListener('transitionend', handler);
                });
            }
        }

        // الحد الأدنى: ثانية واحدة
        setTimeout(() => {
            minTimePassed = true;
            tryHideOverlay();
        }, 1000);

        // عند اكتمال تحميل الصفحة بالكامل
        window.addEventListener('load', () => {
            pageLoaded = true;
            tryHideOverlay();
        });

        // عند إرسال أي نموذج
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                overlay.style.display = 'flex';
                overlay.style.opacity = 1;
                minTimePassed = false;
                pageLoaded = false;
                setTimeout(() => {
                    minTimePassed = true;
                    tryHideOverlay();
                }, 1000);
            });
        });
    });
</script>


<body>
    <div id="app">
        <!-- HTML -->
        <div id="loader-overlay">
            <div class="triangle-loader"></div>
        </div>

        @if (auth()->user()->type_user == 'admin')
            @include('layouts.main-sidebar.main-sidebar-admin')
        @elseif (auth()->user()->type_user == 'client')
            @include('layouts.main-sidebar.main-sidebar-client')
        @elseif (auth()->user()->type_user == 'service_provider')
            @include('layouts.main-sidebar.main-sidebar-service_provider')
        @endif
        <div id="main">
            <header>
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            @yield('page-header')
        </div>
    </div>
    @include('layouts.footer-scripts')
</body>

</html>
