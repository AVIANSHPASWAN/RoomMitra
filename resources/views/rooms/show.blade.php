
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $room->title }} | RoomMitra</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
        }

        .room-image {
            transition: transform 0.4s ease;
        }

        .room-image:hover {
            transform: scale(1.02);
        }
    </style>
</head>

<body class="text-slate-800">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4">
            <a href="{{ route('rooms.index') }}"
               class="text-2xl font-extrabold text-teal-700">
                RoomMitra<span class="text-slate-800">.</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('rooms.index') }}"
                   class="rounded-lg px-3 py-2 text-sm font-semibold hover:bg-slate-100">
                    All Rooms
                </a>

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-5 py-8">

        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-wrap items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('rooms.index') }}" class="hover:text-teal-700">Home</a>
            <span>/</span>
            <span class="font-medium text-slate-800">{{ $room->title }}</span>
        </div>

        <!-- Room Heading -->
        <div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <span class="mb-3 inline-block rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-700">
                    ROOM DETAILS
                </span>

                <h1 class="text-3xl font-extrabold md:text-4xl">
                    {{ $room->title }}
                </h1>

                <p class="mt-3 text-slate-500">📍 {{ $room->location }}</p>
            </div>

            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">Monthly Rent</p>
                <p class="text-3xl font-extrabold text-teal-700">
                    ₹{{ number_format((float) $room->price) }}
                    <span class="text-sm font-medium text-slate-500">/ month</span>
                </p>
            </div>
        </div>

        <!-- Room Photo -->
        <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="relative h-72 overflow-hidden bg-slate-200 sm:h-96 lg:h-[480px]">
                <img
                  src="{{ $room->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($room->image) : asset('images/rooms/civil-lines.jpg') }}"
                    alt="{{ $room->title }}"
                    class="room-image h-full w-full object-cover"
                    onerror="this.onerror=null; this.src='{{ asset('images/rooms/civil-lines.jpg') }}';"
                >

                <div class="absolute left-5 top-5">
                    @if($room->available)
                        <span class="rounded-full bg-emerald-500 px-4 py-2 text-sm font-bold text-white shadow">
                            ✓ Available
                        </span>
                    @else
                        <span class="rounded-full bg-rose-500 px-4 py-2 text-sm font-bold text-white shadow">
                            Currently Unavailable
                        </span>
                    @endif
                </div>
            </div>

            <!-- Details and Contact -->
            <div class="grid gap-8 p-6 md:grid-cols-3 md:p-8">

                <!-- Description -->
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold">About This Room</h2>

                    <p class="mt-4 whitespace-pre-line leading-8 text-slate-600">{{ $room->description ?: 'Room description has not been added yet.' }}</p>

                    <div class="mt-8">
                        <h3 class="text-xl font-bold">Room Information</h3>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-sm text-slate-500">📍 Location</p>
                                <p class="mt-1 font-semibold">{{ $room->location }}</p>
                            </div>

                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-sm text-slate-500">💰 Monthly Rent</p>
                                <p class="mt-1 font-semibold">
                                    ₹{{ number_format((float) $room->price) }} / month
                                </p>
                            </div>

                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-sm text-slate-500">🏠 Property</p>
                                <p class="mt-1 font-semibold">Room Rental</p>
                            </div>

                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-sm text-slate-500">📋 Availability</p>
                                <p class="mt-1 font-semibold">
                                    {{ $room->available ? 'Available for rent' : 'Not currently available' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Room Owner -->
                <aside>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                        <h3 class="text-xl font-bold">Contact Room Owner</h3>

                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            Room ke rent, availability aur visit ke baare mein owner se baat karein.
                        </p>

                        @if($room->owner_name)
                            <div class="mt-5 rounded-xl border border-slate-200 bg-white p-4">
                                <p class="text-sm text-slate-500">Owner Name</p>
                                <p class="mt-1 font-bold">{{ $room->owner_name }}</p>
                            </div>
                        @endif

                        @if($room->owner_phone)
                            <div class="mt-3 rounded-xl border border-slate-200 bg-white p-4">
                                <p class="text-sm text-slate-500">Phone Number</p>
                                <p class="mt-1 font-bold">{{ $room->owner_phone }}</p>
                            </div>

                            @php
                                $whatsappNumber = preg_replace('/\D/', '', $room->owner_phone);

                                if (strlen($whatsappNumber) === 10) {
                                    $whatsappNumber = '91' . $whatsappNumber;
                                }
                            @endphp

                            @if($room->available)
                                <a
                                    href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Hello, I am interested in your room: ' . $room->title . ' at ' . $room->location . '. Please share more details.') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-4 block rounded-xl bg-green-600 px-5 py-3 text-center font-bold text-white hover:bg-green-700"
                                >
                                    Chat on WhatsApp
                                </a>

                                <a
                                    href="tel:{{ $room->owner_phone }}"
                                    class="mt-3 block rounded-xl border border-slate-300 bg-white px-5 py-3 text-center font-bold hover:bg-slate-100"
                                >
                                    Call Owner
                                </a>
                            @else
                                <p class="mt-4 rounded-xl bg-amber-50 p-3 text-sm text-amber-800">
                                    This room is currently unavailable.
                                </p>
                            @endif
                        @else
                            <div class="mt-5 rounded-xl bg-amber-50 p-4 text-sm leading-6 text-amber-800">
                                Owner contact details have not been added for this room yet.
                            </div>
                        @endif

                        <a
                            href="{{ route('rooms.index') }}"
                            class="mt-4 block rounded-xl border border-slate-300 bg-white px-5 py-3 text-center font-bold hover:bg-slate-100"
                        >
                            ← Back to All Rooms
                        </a>

                        <p class="mt-4 text-xs leading-5 text-slate-500">
                            Rent, deposit aur room ki availability verify karne ke baad hi payment karein.
                        </p>
                    </div>
                </aside>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="mt-12 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-6 text-center text-sm text-slate-500">
            © {{ date('Y') }} RoomMitra. Find a room that feels like home.
        </div>
    </footer>

</body>
</html>
