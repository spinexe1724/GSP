<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title')
    </title>


    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>


    {{-- Plus Jakarta Sans --}}
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- Material Icons --}}
    <link
        href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet"
    >


    {{-- Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="bg-[#F8F9FA] font-['Plus_Jakarta_Sans'] text-slate-800 antialiased">

    <div class="flex min-h-screen">


        {{-- =========================================================
            SIDEBAR
        ========================================================== --}}
        <aside
            class="w-64 bg-[#F1F3F5] border-r border-slate-200
                   flex flex-col justify-between
                   p-5 fixed h-full z-20 shadow-xl"
        >

            <div class="space-y-8">


                {{-- =================================================
                    LOGO
                ================================================== --}}
                <div class="flex items-center gap-3 px-2">

                    <div
                        class="w-9 h-9 bg-[#800000]
                               rounded-xl
                               flex items-center justify-center
                               text-white font-black
                               shadow-lg shadow-black/20"
                    >
                        G
                    </div>

                    <div>
                        <span class="block text-xl font-black text-black tracking-wider">
                            GSP
                        </span>
                        <span class="block text-[9px] font-semibold text-slate-400 uppercase tracking-[0.18em]">
                            Admin Portal
                        </span>
                    </div>

                </div>



                {{-- =========================================================
                    DASHBOARD
                    Dashboard berdiri sendiri, di luar section MAIN MENU.
                ========================================================== --}}
                <div class="mb-7">
                    {{-- =================================================
                        DASHBOARD
                    ================================================= --}}
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="
                            flex items-center gap-3
                            px-4 py-3
                            rounded-xl
                            text-xs font-bold
                            transition-all duration-200

                            {{ request()->routeIs('admin.dashboard')
                                ? 'bg-[#800000] text-white shadow-md shadow-[#800000]/15'
                                : 'text-slate-600 hover:bg-white hover:text-[#800000]' }}
                        "
                    >

                        <svg
                            class="w-4 h-4 flex-shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1"
                            />
                        </svg>


                        <span>
                            Dashboard
                        </span>

                    </a>



                </div>


                {{-- =========================================================
                    MAIN MENU
                ========================================================== --}}
                <nav class="space-y-1.5">

                    <p
                        class="px-3
                               text-[10px]
                               font-black
                               text-slate-400
                               uppercase
                               tracking-wider
                               mb-3"
                    >
                        Main Menu
                    </p>


                    {{-- =================================================
                        UPLOAD DATA
                    ================================================== --}}
                    <a
                        href="{{ route('admin.upload-data') }}"
                        class="
                            flex items-center gap-3
                            px-4 py-3
                            rounded-xl
                            text-xs font-bold
                            transition-all duration-200

                            {{ request()->routeIs('admin.upload-data')
                                ? 'bg-[#800000] text-white shadow-md shadow-[#800000]/15'
                                : 'text-slate-600 hover:bg-white hover:text-[#800000]' }}
                        "
                    >

                        <svg
                            class="w-4 h-4 flex-shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V3m0 0L8 7m4-4l4 4"
                            />
                        </svg>

                        <span>
                            Upload Data
                        </span>

                    </a>


                    {{-- =================================================
                        MONITORING
                    ================================================== --}}
                    <a
                        href="{{ route('showrooms.monitoring') }}"
                        class="
                            flex items-center gap-3
                            px-4 py-3
                            rounded-xl
                            text-xs font-bold
                            transition-all duration-200

                            {{ request()->routeIs('showrooms.monitoring')
                                ? 'bg-[#800000] text-white shadow-md shadow-[#800000]/15'
                                : 'text-slate-600 hover:bg-white hover:text-[#800000]' }}
                        "
                    >

                        <svg
                            class="w-4 h-4 flex-shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 19V6m0 0l3-3 3 3m-6 0h6v13"
                            />
                        </svg>


                        <span>
                            Monitoring
                        </span>

                    </a>



                    {{-- =================================================
                        PHOTO REVIEW
                    ================================================== --}}
                    <a
                        href="{{ route('admin.cars.photo_review') }}"
                        class="
                            flex items-center gap-3
                            px-4 py-3
                            rounded-xl
                            text-xs font-bold
                            transition-all duration-200

                            {{ request()->routeIs('admin.cars.photo_review')
                                || request()->routeIs('admin.cars.photo_review.*')
                                ? 'bg-[#800000] text-white shadow-md shadow-[#800000]/15'
                                : 'text-slate-600 hover:bg-white hover:text-[#800000]' }}
                        "
                    >

                        <svg
                            class="w-4 h-4 flex-shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 14l2.5-3 2 2.5L15 10l3 4"
                            />

                        </svg>


                        <span>
                            Photo Review
                        </span>

                    </a>



                    {{-- =================================================
                        CAR REVIEW
                    ================================================== --}}
                    <a
                        href="{{ route('admin.cars.review') }}"
                        class="
                            flex items-center gap-3
                            px-4 py-3
                            rounded-xl
                            text-xs font-bold
                            transition-all duration-200

                            {{ request()->routeIs('admin.cars.review')
                                || request()->routeIs('admin.cars.review.*')
                                ? 'bg-[#800000] text-white shadow-md shadow-[#800000]/15'
                                : 'text-slate-600 hover:bg-white hover:text-[#800000]' }}
                        "
                    >

                        <svg
                            class="w-4 h-4 flex-shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 7h16M4 17h16"
                            />

                        </svg>


                        <span>
                            Car Review
                        </span>

                    </a>

                </nav>

            </div>



            {{-- =========================================================
                LOGOUT
            ========================================================== --}}
            <div class="pt-5 border-t border-slate-200">
                <div class="px-3 mb-3 text-[9px] font-bold uppercase tracking-[0.16em] text-slate-400">
                    Account
                </div>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="
                            w-full
                            flex items-center
                            justify-center gap-2
                            px-4 py-2.5
                            bg-white
                            hover:bg-rose-50
                            border border-slate-200
                            hover:border-rose-200
                            text-rose-700
                            text-xs font-bold
                            rounded-xl
                            transition-all duration-200
                        "
                    >

                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>

                        Logout

                    </button>

                </form>

            </div>

        </aside>



        {{-- =========================================================
            CONTENT AREA
        ========================================================== --}}
        <main
            class="flex-1 ml-64 min-h-screen p-8 bg-[#F8F9FA]"
        >

            @yield('content')

        </main>

    </div>

</body>

