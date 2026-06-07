<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New";}
            </style>
        @endif
    </head>
    <body class="bg-slate-50 text-slate-900 min-h-screen">
        <div class="min-h-screen flex flex-col">
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur-md">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-600 text-lg font-semibold text-white shadow-sm">
                            ES
                        </div>
                        <div>
                            <p class="text-lg font-semibold">E-School Management</p>
                            <p class="text-xs text-slate-500">Manage students, teachers, classes and attendance</p>
                        </div>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center gap-3 text-sm">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-full border border-slate-300 bg-white px-4 py-2 text-slate-900 shadow-sm transition hover:bg-slate-50">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-full border border-slate-300 bg-white px-4 py-2 text-slate-900 shadow-sm transition hover:bg-slate-50">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-full bg-sky-600 px-4 py-2 text-white shadow-sm transition hover:bg-sky-700">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </header>

            <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-10 lg:px-8 lg:py-16">
                <section class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                    <div class="space-y-6">
                        <span class="inline-flex items-center gap-2 rounded-full bg-sky-100 px-3 py-1 text-sm font-medium text-sky-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-sky-500"></span>
                            School management made simple
                        </span>

                        <div class="space-y-3">
                            <h1 class="text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">
                                Build a smarter school experience for students, teachers and administrators.
                            </h1>
                            <p class="max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
                                Organize class schedules, attendance, student records and school resources in one elegant Laravel-powered dashboard.
                            </p>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">
                                Get started
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">
                                    Create account
                                </a>
                            @endif
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                <p class="text-3xl font-semibold text-slate-900">4.8/5</p>
                                <p class="mt-2 text-sm text-slate-500">Teacher satisfaction score</p>
                            </div>
                            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                <p class="text-3xl font-semibold text-slate-900">12K+</p>
                                <p class="mt-2 text-sm text-slate-500">Student profiles managed</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] bg-gradient-to-br from-sky-600 via-sky-500 to-slate-900 p-8 text-white shadow-2xl">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between rounded-3xl bg-white/10 p-5">
                                <div>
                                    <p class="text-sm uppercase tracking-[0.2em] text-sky-100/80">School summary</p>
                                    <p class="mt-2 text-2xl font-semibold">One dashboard</p>
                                </div>
                                <span class="inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-white/90">Live</span>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-3xl bg-white/10 p-5">
                                    <p class="text-sm text-sky-100/80">Students</p>
                                    <p class="mt-3 text-3xl font-semibold">1,280</p>
                                </div>
                                <div class="rounded-3xl bg-white/10 p-5">
                                    <p class="text-sm text-sky-100/80">Teachers</p>
                                    <p class="mt-3 text-3xl font-semibold">86</p>
                                </div>
                                <div class="rounded-3xl bg-white/10 p-5">
                                    <p class="text-sm text-sky-100/80">Classes</p>
                                    <p class="mt-3 text-3xl font-semibold">42</p>
                                </div>
                                <div class="rounded-3xl bg-white/10 p-5">
                                    <p class="text-sm text-sky-100/80">Attendance</p>
                                    <p class="mt-3 text-3xl font-semibold">98%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-slate-950">Student records</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Track academic performance, contact details and class history for every student.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-slate-950">Teacher planner</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Organize schedules, assign courses and communicate with staff in one place.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-slate-950">Attendance</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Monitor daily attendance, generate reports and share summaries with parents.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-slate-950">School events</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Publish announcements, manage exams and keep everyone informed.</p>
                    </div>
                </section>
            </main>

            <footer class="border-t border-slate-200 bg-white/90 px-6 py-6 text-sm text-slate-500 backdrop-blur-md">
                <div class="mx-auto flex w-full max-w-7xl flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <p>© {{ date('Y') }} E-School Management. Built with Laravel.</p>
                    <p>Simple, modern and school-ready front end.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
