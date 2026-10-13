<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Skyraan Associates</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --navbar-height: 64px;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 72px;
        }

        html,
        body {
            overflow-x: hidden !important;
        }

        body {
            margin: 0;
            background-color: rgb(231, 235, 236);
        }

        .navbar {
            height: var(--navbar-height);
            /* background: linear-gradient(135deg, #2E1065 0%, #4C1D95 50%, #1D4ED8 100%); */
            background: #2d2d2d;
            border-bottom-right-radius: 20px;
            border-bottom: 2px solid black;
            z-index: 1100;
        }

        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: #2d2d2d;
            color: white;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: width 0.35s ease, transform 0.35s ease;
            z-index: 1050;
            border-right: 2px solid black;
            border-bottom-right-radius: 20px;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar a,
        .sidebar button {
            color: white;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            white-space: nowrap;
            border: none;
            background: none;
            width: 100%;
            transition: background .2s ease, color .2s ease;
        }

        .sidebar a:hover {
            background: rgb(136, 136, 139);
            color: rgb(8, 8, 5);
             border-radius: 10px;
            border: 2px solid rgb(81, 80, 79);
            
        }

        .sidebar a.active {
            background: rgb(217, 217, 218);
            color: rgb(11, 11, 10);
            border-radius: 10px;
            border: 2px solid rgb(81, 80, 79);
        }

        .sidebar i {
            font-size: 1.25rem;
            min-width: 32px;
            text-align: center;
        }

        .menu-text {
            transition: opacity 0.25s ease, width 0.25s ease;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .collapse {
            display: none !important;
        }

        .sidebar .arrow {
            transition: transform 0.3s ease;
            font-size: 14px;
        }

        .sidebar a[aria-expanded="true"] .arrow {
            transform: rotate(180deg);
        }

        .arrow i {
            font-size: 0.7rem;
            transition: transform .25s ease;
        }

        .sidebar>a,
        .sidebar>.collapse {
            flex-shrink: 0;
        }

        .sidebar .menu-scroll {
            flex: 1;
            overflow-y: auto;
        }

        .sidebar .menu-scroll::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }

        .sidebar-logout .btn:hover {
            background: #2d2d2d;
            color: #ff6b6b !important;
        }


        .main-content {
            margin-top: var(--navbar-height);
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin-left 0.35s ease;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed a,
        .sidebar.collapsed button {
            justify-content: center;
            padding: 14px 10px;
        }

        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .arrow {
            display: none !important;
        }

        .sidebar.collapsed .collapse {
            display: none !important;
        }

        .sidebar.collapsed i {
            font-size: 1.35rem;
        }

        .sidebar .menu-scroll {
            overscroll-behavior: contain;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: var(--sidebar-width);
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

        }

        #sidebarToggle {
            width: 42px;
            height: 42px;
            padding: 0;
            border: none;
            border-radius: 8px;
            background-color: #dddddd;
            color: black;
            font-size: 22px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        /* #sidebarToggle:hover {
            background-color: rgb(240, 241, 222);
        } */

        #sidebarToggle:active {
            transform: scale(0.95);
        }

    </style>
</head>

<body>

    @include('partials.sidebar')

    <div id="mainContent" class="main-content">
        @include('partials.navbar')

        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            toggleBtn.addEventListener('click', function() {

                if (window.innerWidth < 992) {
                    sidebar.classList.toggle('open');
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed');

                    sidebar.classList.remove('open');
                }

            });

        });
    </script>

    @stack('scripts')

</body>

</html>
