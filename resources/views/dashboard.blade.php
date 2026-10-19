
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | RoomMitra</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-slate-50 text-slate-800" style="font-family: Inter, sans-serif;">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-5 py-4 flex flex-wrap justify-between items-center gap-4">

            <a href="{{ route('rooms.index') }}"
               class="text-2xl font-extrabold text-teal-700">
                RoomMitra<span class="text-orange-500">.</span>
            </a>

            <div class="flex flex-wrap items-center gap-4">

                <a href="{{ route('rooms.index') }}"
                   class="text-sm font-semibold text-slate-700 hover:text-teal-700">
                    Find Rooms
                </a>

                <a href="{{ route('rooms.manage') }}"
                   class="text-sm font-semibold text-slate-700 hover:text-teal-700">
                    My Rooms
                </a>

                <a href="{{ route('rooms.create') }}"
                   class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
                    + Add Room
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users') }}"
                       class="text-sm font-semibold text-slate-700 hover:text-teal-700">
                        User Management
                    </a>
                @endif

                <span class="hidden sm:block text-sm text-slate-600">
                    {{ auth()->user()->name ?? 'User' }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-5 py-10">

        <!-- Welcome -->
        <section class="mb-9 rounded-3xl bg-gradient-to-r from-teal-800 to-teal-600 p-7 sm:p-10 text-white">

            <p class="text-sm font-semibold text-teal-100">
                YOUR ROOMMITRA DASHBOARD
            </p>

            <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold">
                Welcome back, {{ auth()->user()->name ?? 'User' }}!
            </h1>

            <p class="mt-3 max-w-xl text-teal-50">
                Find a comfortable room that fits your needs and budget.
                Your next place to stay is just a search away.
            </p>

            <a href="{{ route('rooms.index') }}"
               class="mt-6 inline-block rounded-xl bg-white px-5 py-3 font-bold text-teal-800 hover:bg-teal-50">
                Explore Rooms →
            </a>
        </section>

        <!-- Statistics -->
        <section class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-10">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Rooms
                        </p>

                        <h2 class="mt-2 text-4xl font-extrabold text-slate-900">
                            {{ $totalRooms }}
                        </h2>
                    </div>

                    <div class="rounded-2xl bg-teal-50 p-4 text-2xl">
                        🏠
                    </div>
                </div>

                <p class="mt-4 text-sm text-slate-500">
                    Rooms listed on RoomMitra
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Available Rooms
                        </p>

                        <h2 class="mt-2 text-4xl font-extrabold text-emerald-600">
                            {{ $availableRooms }}
                        </h2>
                    </div>

                    <div class="rounded-2xl bg-emerald-50 p-4 text-2xl">
                        ✅
                    </div>
                </div>

                <p class="mt-4 text-sm text-slate-500">
                    Currently marked as available
                </p>
            </div>

        </section>

        <!-- Recent Rooms -->
        <section>

            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">
                        Recently Listed Rooms
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Explore the latest room listings.
                    </p>
                </div>

                <a href="{{ route('rooms.index') }}"
                   class="font-bold text-teal-700 hover:text-teal-900">
                    View All Rooms →
                </a>
            </div>

            @if($recentRooms->isEmpty())

                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
                    <p class="text-lg font-bold text-slate-800">
                        No rooms available yet
                    </p>

                    <p class="mt-2 text-sm text-slate-500">
                        Please check again later.
                    </p>

                    <a href="{{ route('rooms.index') }}"
                       class="mt-5 inline-block rounded-xl bg-teal-700 px-5 py-3 font-bold text-white hover:bg-teal-800">
                        Browse Rooms
                    </a>
                </div>

            @else

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($recentRooms as $room)

                        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                            <!-- Room Photo -->
                            <div class="h-48 overflow-hidden bg-slate-100">

                                <img
                                    src="{{ !empty($room->image)
                                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($room->image)
                                        : asset('images/rooms/civil-lines.jpg') }}"
                                    alt="{{ $room->title }}"
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                    onerror="this.onerror=null; this.src='{{ asset('images/rooms/civil-lines.jpg') }}';"
                                >

                            </div>

                            <!-- Room Information -->
                            <div class="p-5">

                                <p class="text-sm font-medium text-teal-700">
                                    📍 {{ $room->location }}
                                </p>

                                <h3 class="mt-2 text-lg font-bold text-slate-900">
                                    {{ $room->title }}
                                </h3>

                                <p class="mt-2 text-sm text-slate-500">
                                    {{ \Illuminate\Support\Str::limit($room->description, 90) }}
                                </p>

                                <div class="mt-5 flex items-center justify-between gap-2 border-t border-slate-100 pt-4">

                                    <p class="text-xl font-extrabold text-slate-900">
                                        ₹{{ number_format($room->price) }}
                                        <span class="text-sm font-normal text-slate-500">
                                            /month
                                        </span>
                                    </p>

                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $room->available ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $room->available ? 'Available' : 'Unavailable' }}
                                    </span>

                                </div>
                            </div>

                        </article>

                    @endforeach

                </div>

            @endif

        </section>

        <!-- Footer -->
        <footer class="mt-12 border-t border-slate-200 py-6 text-center text-sm text-slate-500">
            © {{ date('Y') }} RoomMitra. Find your place, feel at home.
        </footer>

    </main>

</body>
</html>
