
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RoomMitra | Find Your Perfect Room</title>
    <meta name="description" content="Find affordable rooms in Gorakhpur with RoomMitra. Search by location and monthly budget.">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Inter, Arial, sans-serif;
        }

        .hero-bg {
            background: linear-gradient(135deg, #102a43 0%, #0f766e 100%);
        }

        .room-card {
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, .12);
        }

        .search-input:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .12);
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

    @php
        $isUser = Auth::guard('web')->check();
        $isOwner = Auth::guard('owner')->check();
        $isAdmin = Auth::guard('admin')->check();

        $currentAccount = $isAdmin
            ? Auth::guard('admin')->user()
            : ($isOwner
                ? Auth::guard('owner')->user()
                : Auth::guard('web')->user());

        $isLoggedIn = $isUser || $isOwner || $isAdmin;
    @endphp

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-4 sm:px-6">

            <a href="{{ route('rooms.index') }}"
               class="shrink-0 text-2xl font-extrabold tracking-tight text-teal-700">
                RoomMitra<span class="text-orange-500">.</span>
            </a>

            <div class="flex flex-wrap items-center justify-end gap-2 text-sm font-semibold sm:gap-5">

                {{-- Home and Find Rooms: hide for Admin --}}
                @if (!$isAdmin)
                    <a href="{{ route('rooms.index') }}"
                       class="hidden text-slate-600 transition hover:text-teal-700 sm:inline">
                        Home
                    </a>

                    <a href="{{ route('rooms.index') }}#rooms"
                       class="text-slate-600 transition hover:text-teal-700">
                        Find Rooms
                    </a>
                @endif

                @if ($isLoggedIn)

                    <span class="hidden text-slate-600 sm:inline">
                        Hi, {{ $currentAccount->name }}
                    </span>

                    {{-- Room management options: Owner only --}}
                    @if ($isOwner)
                        <a href="{{ route('rooms.create') }}"
                           class="rounded-xl bg-teal-700 px-3 py-2.5 text-white transition hover:bg-teal-800 sm:px-4">
                            Add Room
                        </a>

                        <a href="{{ route('rooms.manage') }}"
                           class="rounded-xl border border-teal-700 px-3 py-2.5 text-teal-700 transition hover:bg-teal-50 sm:px-4">
                            Manage Rooms
                        </a>
                    @endif

                    {{-- Admin options --}}
                    @if ($isAdmin)
                        <a href="{{ route('admin.users') }}"
                           class="rounded-xl border border-slate-300 px-3 py-2.5 text-slate-700 transition hover:bg-slate-100">
                            Manage Users
                        </a>

                        <a href="{{ route('rooms.manage') }}"
                           class="rounded-xl border border-teal-700 px-3 py-2.5 text-teal-700 transition hover:bg-teal-50 sm:px-4">
                            Manage Rooms
                        </a>
                    @endif

                    <a href="{{ route('dashboard') }}"
                       class="hidden text-teal-700 transition hover:text-teal-900 sm:inline">
                        Dashboard
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="rounded-xl border border-slate-300 px-3 py-2.5 transition hover:bg-slate-100">
                            Logout
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}"
                       class="rounded-xl bg-teal-700 px-4 py-2.5 text-white transition hover:bg-teal-800">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="hidden rounded-xl border border-teal-700 px-4 py-2.5 text-teal-700 transition hover:bg-teal-50 sm:inline-block">
                        Register
                    </a>

                @endif

            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-bg overflow-hidden text-white">
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 sm:py-20 lg:grid-cols-2 lg:py-24">

            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-teal-50">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    Find a place to call home
                </span>

                <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                    Find a room that
                    <span class="text-orange-300">feels like home.</span>
                </h1>

                <p class="mt-5 max-w-xl text-base leading-8 text-slate-200 sm:text-lg">
                    Discover rooms that fit your location and budget.
                    Search smarter and find your next place to stay with RoomMitra.
                </p>

                <div class="mt-7 flex flex-wrap gap-3 text-sm">
                    <span class="rounded-full bg-white/10 px-4 py-2.5">
                        ✓ Budget-friendly
                    </span>
                    <span class="rounded-full bg-white/10 px-4 py-2.5">
                        ✓ Location search
                    </span>
                    <span class="rounded-full bg-white/10 px-4 py-2.5">
                        ✓ Easy to use
                    </span>
                </div>

                <a href="#rooms"
                   class="mt-8 inline-flex items-center gap-2 rounded-xl bg-orange-400 px-6 py-3.5 font-bold text-slate-900 transition hover:bg-orange-300">
                    Explore Rooms <span>→</span>
                </a>
            </div>

            <!-- SEARCH CARD -->
            <div id="search"
                 class="rounded-3xl bg-white p-6 text-slate-800 shadow-2xl sm:p-8">

                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-extrabold">Find your room</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Choose your preferred location and monthly budget.
                        </p>
                    </div>
                    <div class="rounded-2xl bg-teal-50 p-3 text-2xl">🏠</div>
                </div>

                <form action="{{ route('rooms.index') }}" method="GET" class="mt-7 space-y-5">

                    <div>
                        <label for="q" class="mb-2 block text-sm font-bold text-slate-700">
                            City, area or keyword
                        </label>
                        <input id="q" name="q" type="search"
                               value="{{ $query }}"
                               placeholder="e.g. Gorakhpur, Civil Lines"
                               class="search-input w-full rounded-xl border border-slate-300 px-4 py-3.5 outline-none transition">
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="min_price" class="mb-2 block text-sm font-bold text-slate-700">
                                Minimum rent (₹)
                            </label>
                            <input id="min_price" name="min_price" type="number" min="0" step="1"
                                   value="{{ $minPrice }}" placeholder="2000"
                                   class="search-input w-full rounded-xl border border-slate-300 px-4 py-3.5 outline-none transition">
                        </div>

                        <div>
                            <label for="max_price" class="mb-2 block text-sm font-bold text-slate-700">
                                Maximum rent (₹)
                            </label>
                            <input id="max_price" name="max_price" type="number" min="0" step="1"
                                   value="{{ $maxPrice }}" placeholder="5000"
                                   class="search-input w-full rounded-xl border border-slate-300 px-4 py-3.5 outline-none transition">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl bg-teal-700 px-5 py-4 font-bold text-white shadow-sm transition hover:bg-teal-800">
                        🔎 Search Available Rooms
                    </button>

                    <a href="{{ route('rooms.index') }}"
                       class="block text-center text-sm font-semibold text-slate-500 transition hover:text-teal-700">
                        Clear all filters
                    </a>
                </form>
            </div>

        </div>
    </section>

    <!-- ROOM LISTINGS -->
    <main id="rooms" class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:py-16">

        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[.18em] text-teal-700">
                    Explore stays
                </p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Available Rooms
                </h2>
                <p class="mt-3 text-slate-500">
                    Find a place that fits your needs and budget.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white px-5 py-3 shadow-sm">
                <span class="text-2xl font-extrabold text-teal-700">{{ $rooms->count() }}</span>
                <span class="ml-1 text-sm font-medium text-slate-500">
                    {{ $rooms->count() === 1 ? 'room found' : 'rooms found' }}
                </span>
            </div>
        </div>

        @if($query !== '' || ($minPrice !== null && $minPrice !== '') || ($maxPrice !== null && $maxPrice !== ''))
            <div class="mb-7 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-teal-100 bg-teal-50 p-4">
                <p class="text-sm font-medium text-teal-900">
                    ✓ Showing rooms matching your search filters.
                </p>
                <a href="{{ route('rooms.index') }}"
                   class="text-sm font-bold text-teal-800 underline underline-offset-4">
                    Reset search
                </a>
            </div>
        @endif

        @if($rooms->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-teal-50 text-4xl">🏠</div>
                <h3 class="mt-6 text-2xl font-extrabold text-slate-900">No rooms found</h3>
                <p class="mx-auto mt-3 max-w-md leading-7 text-slate-500">
                    Try a different location or increase your budget to discover more available rooms.
                </p>
                <a href="{{ route('rooms.index') }}"
                   class="mt-7 inline-flex rounded-xl bg-teal-700 px-6 py-3.5 font-bold text-white transition hover:bg-teal-800">
                    View All Rooms
                </a>
            </div>
        @else
            <div class="grid items-stretch gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($rooms as $room)
                    <article class="room-card group flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="relative h-56 shrink-0 overflow-hidden bg-slate-100">
                            <img
                                src="{{ !empty($room->image)
                                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($room->image)
                                    : asset('images/rooms/civil-lines.jpg') }}"
                                alt="{{ $room->title }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy"
                                onerror="this.onerror=null; this.src='{{ asset('images/rooms/civil-lines.jpg') }}';">

                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/10"></div>

                            <span class="absolute left-3 top-3 rounded-full bg-white/95 px-3 py-1.5 text-xs font-extrabold text-teal-700 shadow">
                                🏠 RoomMitra
                            </span>

                            <span class="absolute right-3 top-3 rounded-full px-3 py-1.5 text-xs font-bold shadow {{ $room->available ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ $room->available ? '● Available' : '● Unavailable' }}
                            </span>

                            <p class="absolute bottom-3 left-4 right-4 text-sm font-semibold text-white drop-shadow">
                                📍 {{ $room->location }}
                            </p>
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <h3 class="text-xl font-extrabold leading-7 text-slate-900 transition group-hover:text-teal-800">
                                {{ $room->title }}
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-slate-500">
                                {{ \Illuminate\Support\Str::limit($room->description, 110) }}
                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="rounded-xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">
                                    🛏️ {{ $room->beds }} {{ $room->beds == 1 ? 'Bed' : 'Beds' }}
                                </span>
                                <span class="rounded-xl bg-teal-50 px-3 py-2 text-sm font-semibold text-teal-700">
                                    Monthly Rental
                                </span>
                            </div>

                            <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-5">
                                <div>
                                    <p class="text-xs font-medium text-slate-500">Monthly rent</p>
                                    <p class="mt-1 text-2xl font-extrabold text-teal-800">
                                        ₹{{ number_format($room->price) }}
                                    </p>
                                    <p class="text-xs text-slate-400">per month</p>
                                </div>

                                <a href="{{ route('rooms.show', $room->id) }}"
                                   class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-4 py-3 text-sm font-bold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-100">
                                    Explore <span>→</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </main>

    <!-- FOOTER -->
    <footer class="mt-8 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 text-center sm:px-6">
            <a href="{{ route('rooms.index') }}" class="text-2xl font-extrabold text-teal-700">
                RoomMitra<span class="text-orange-500">.</span>
            </a>

            <p class="mt-3 text-sm leading-6 text-slate-500">
                Helping you find your next place to stay.
            </p>

            <div class="mt-5 flex flex-wrap justify-center gap-5 text-sm font-medium text-slate-500">
                @if (!$isAdmin)
                    <a href="{{ route('rooms.index') }}" class="hover:text-teal-700">Home</a>
                    <a href="#search" class="hover:text-teal-700">Search Rooms</a>
                @endif

                @if ($isLoggedIn)
                    <a href="{{ route('dashboard') }}" class="hover:text-teal-700">Dashboard</a>
                @endif
            </div>

            <p class="mt-6 text-xs text-slate-400">
                © {{ date('Y') }} RoomMitra. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
