<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    <link rel="stylesheet" href="css/app.css">
    <title>Data Keterlambatan Siswa</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-lg fixed-top " style="background-color:#A0C3D2;">
        <div class="container-fluid ">
            <a class="navbar-brand text-white" href="#">Rekam Keterlambatan</a>
            <button class="btn" id="sidebar-toggle" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse navbar">
                <ul class="navbar">
                    <li class="nav-item dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        @if (Auth::user()->role == 'admin')
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown" style="margin-right: 20px;">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Administrator
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout-></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            </div>
        @endif
        @if (Auth::user()->role == 'ps')
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown" style="margin-right: 20px;">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Pembimbing Siswa
                            {{-- PS {{ Auth::rayon()->rayon }} --}}
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout-></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            </div>
        @endif
    </nav>
    <div class="wrapper shadow-lg" style="margin-top: 50px;">
        <aside id="sidebar">
            
            <ul class="sidebar-nav " style="margin-top: 15px;">
                <li class="sidebar-item">
                    <a href="{{ URL('/dashboard') }}" class="sidebar-link"><ion-icon name="apps-outline"></ion-icon>
                        Dashboard</a>
                </li>
                

                @if (Auth::user()->role == 'admin')
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse"
                        aria-expanded="false"><ion-icon name="document-text-outline"></ion-icon> Data Master</a>
                    <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <ol class="sidebar-item">
                            <a href="{{ route('rombel.index') }}" class="sidebar-link">Data Rombel</a>
                        </ol>
                        <ol class="sidebar-item">
                            <a href="{{ route('rayon.index') }}" class="sidebar-link">Data Rayon</a>
                        </ol>

                        <ol class="sidebar-item">
                            <a href="{{ route('user.index') }}" class="sidebar-link">Data User</a>
                        </ol>
                        
                         
                        <ol class="sidebar-item">
                            <a href="{{ route('admin.student.index') }}" class="sidebar-link">Data Siswa</a>
                        </ol>
                        @endif

                        {{-- @if (Auth::user()->role == "ps")
                        <ol class="sidebar-item">
                            <a href="{{ route('ps.student.data') }}" class="sidebar-link">Data Siswa</a>
                        </ol>
                        @endif --}}
                    </ul>
                </li>
            </ul>

            @if (Auth::user()->role == 'ps')
                <li class="sidebar-item">
                    <a href="{{ route('ps.student.data') }}" class="sidebar-link"><ion-icon name="document-text-outline"></ion-icon>
                        Data Siswa</a>
                </li>
            @endif
            
            @if (Auth::user()->role == 'admin')
                <li class="sidebar-item">
                    <a href="{{ route('admin.late.index') }}" class="sidebar-link"><ion-icon
                            name="reader-outline"></ion-icon>
                        Data Keterlambatan</a>
                </li>
            @endif
            @if (Auth::user()->role == 'ps')
                <li class="sidebar-item">
                    <a href="{{ route('ps.late.index') }}" class="sidebar-link"><ion-icon
                            name="reader-outline"></ion-icon>
                        Data Keterlambatan</a>
                </li>
            @endif
        </aside>
        <div class="main">
            @yield('content')
        </div>

    </div>
    <style>
        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        .main {
            margin-top:10px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 0.87;
            opacity: 1;
            overflow-y: scroll;
            margin: 0;
        }

        a {
            cursor: pointer;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        /* .dropdown-menu:hover {
            background-color: #A0C3D2;
        } */
        .dropdown-item:hover {
            background-color: #b4ccd7;
        }

        a.navbar-brand {
            color: white;
        }

        li {
            list-style: none;
        }

        .wrapper {
            align-items: stretch;
            display: flex;
            width: 100%;

        }

        #sidebar {
            max-width: 264px;
            min-width: 264px;
            background: var(--bs--light);
            transition: all 0.35s ease-in-out;
            margin-top: 20px;
        }

        .main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
            width: 100%;
            background-color: #f5f5f5;
        }

        .sidebar-logo {
            padding: 1.15rem;
        }

        .sidebar-logo a {
            color: white;
            font-size: 1.15rem;
            font-weight: 600;
        }

        .sidebar-nav {
            flex-grow: 1;
            list-style: none;
            margin-bottom: 0;
            padding-left: 0;
            margin-left: 0;
        }

        .sidebar-header {
            color: white;
            font-size: .75rem;
            padding: 1.5rem 1.5rem .375rem;
        }

        a.sidebar-link {
            padding: .625rem 1.625rem;
            color: aliceblue;
            position: relative;
            display: block;
            font-size: 0.905rem;
        }

        .sidebar-item a {
            color: black;
            font-size: 17px;
        }

        .sidebar-item {
            margin-left: 15px;
        }

        .sidebar-link[data-bs-toggle="collapse"]::after {
            border: solid;
            border-width: 0 .075rem .075rem 0;
            content: "";
            display: inline-block;
            padding: 2px;
            position: absolute;
            right: 1.5rem;
            top: 1.4rem;
            transform: rotate(-135deg);
            transition: all .2s ease-out;
        }

        #sidebar.collapsed {
            margin-left: -264px;
        }

        .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
            transform: rotate(45deg);
            transition: all .2s ease-in-out;
        }

        .navbar-brand {
            margin-left: 30px;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarToggle = document.getElementById("sidebar-toggle");
            const sidebar = document.getElementById("sidebar");

            sidebarToggle.addEventListener("click", function() {
                sidebar.classList.toggle("collapsed");
            });
        });
    </script>

    {{-- // <div class="wrapper">
    //     <aside id="sidebar">
    //         <div class="h-100">
    //             <div class="sidebar-logo">
            // <a href="#">Rekam Keterlambatan</a>
    //             </div>
    //             <ul class="sidebar-nav">
    //                 <li class="sidebar-item">
    //                   <a href="#" class="sidebar-link">
    //                     <i class="fa-solid fa-list">
    //                     </i><ion-icon name="apps-outline"></ion-icon> Dashboard
    //                   </a>
    //                 </li>
    //                 <li class="sidebar-item">
    //                   <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse" aria-expanded="false"><ion-icon name="document-text-outline"></ion-icon> Data Master</a>
    //                   <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
    //                     <ol class="sidebar-item">
    //                       <a href="" class="sidebar-link">Data Rombel</a>
    //                     </ol>
    //                     <ol class="sidebar-item">
    //                       <a href="" class="sidebar-link">Data Rayon</a>
    //                     </ol>
    //                     <ol class="sidebar-item">
    //                       <a href="" class="sidebar-link">Data Siswa</a>
    //                     </ol>
    //                     <ol class="sidebar-item">
    //                       <a href="" class="sidebar-link">Data User</a>
    //                     </ol>
    //                   </ul>
    //                 </li>
    //                 <li class="sidebar-item">
    //                   <a href="#" class="sidebar-link">
    //                     <i class="fa-solid fa-list">
    //                     </i><ion-icon name="apps-outline"></ion-icon> Data Keterlambatan
    //                   </a>
    //                 </li>
    //             </ul>
    //         </div>
    //     </aside>
    //     <div class="main">
    //         <nav class="navbar navbar-expand px-3 border-bottom">
    //             <button class="btn" id="sidebar-toggle" type="button">
    //                 <span class="navbar-toggler-icon"></span>
    //             </button>
    //             <div class="navbar-collapse navbar">
    //               <ul class="navbar">
    //                 <li class="nav-item dropdown">
    //                   <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                        
    //                   </a>
    //                 </li>
    //               </ul>
    //             </div>
    //         </nav>
    //     </div>
    // </div> --}}

    <script src="js/script.js"></script>
    @stack('script')
</body>

</html>
