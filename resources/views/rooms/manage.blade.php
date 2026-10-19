
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms | RoomMitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="{{ route('rooms.index') }}"
               class="text-2xl font-bold text-indigo-600">
                RoomMitra
            </a>

<a href="{{ route('rooms.create') }}">
    + A
@if (Auth::guard('owner')->check())
    <a href="{{ route('rooms.create') }}">
        + Add Room
    </a>
@endif

</a>

            <a href="{{ route('dashboard') }}"
               class="text-indigo-600 hover:underline">
                Dashboard
            </a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6">

        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            Manage Rooms
        </h1>

        <p class="text-gray-600 mb-6">
            @if(auth()->user()->role === 'admin')
                Admin: Manage all rooms.
            @else
                Owner: Manage your own rooms.
            @endif
        </p>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-5">
                {{ session('success') }}
            </div>
        @endif

        @if($rooms->isEmpty())
            <div class="bg-white p-8 rounded-xl shadow text-center">
                <h2 class="text-xl font-semibold mb-2">No rooms found</h2>
                <p class="text-gray-600">
                    No rooms are currently assigned to your account.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($rooms as $room)
                    <div class="bg-white rounded-xl shadow overflow-hidden">

                        @if($room->image)
                            <img
                               src="{{ $room->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($room->image) : asset('images/rooms/civil-lines.jpg') }}"
                                alt="{{ $room->title }}"
                                class="w-full h-48 object-cover"
                            >
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                No Image
                            </div>
                        @endif

                        <div class="p-5">

                            <h2 class="text-xl font-bold text-gray-800">
                                {{ $room->title }}
                            </h2>

                            <p class="text-gray-600 mt-1">
                                {{ $room->location }}
                            </p>

                            <p class="text-indigo-600 font-bold text-lg mt-3">
                                ₹{{ number_format($room->price) }}
                                <span class="text-sm font-normal text-gray-500">
                                    / month
                                </span>
                            </p>

                            <p class="mt-2">
                                Status:
                                @if($room->available)
                                    <span class="text-green-600 font-semibold">
                                        Available
                                    </span>
                                @else
                                    <span class="text-red-600 font-semibold">
                                        Unavailable
                                    </span>
                                @endif
                            </p>

                            <div class="flex flex-wrap gap-2 mt-5">

                                {{-- View Room --}}
                                <a
                                    href="{{ route('rooms.show', $room) }}"
                                    class="flex-1 text-center border border-gray-300 rounded-lg px-3 py-2 hover:bg-gray-50"
                                >
                                    View
                                </a>

                                {{-- Edit Room --}}
                                <a
                                    href="{{ route('rooms.edit', $room) }}"
                                    class="flex-1 text-center bg-indigo-600 text-white rounded-lg px-3 py-2 hover:bg-indigo-700"
                                >
                                    Edit
                                </a>

                                {{-- Delete Room --}}
                                @if(auth()->user()->role === 'admin' ||
                                    (int) $room->user_id === (int) auth()->id())

                                    <form
                                        action="{{ route('rooms.destroy', $room) }}"
                                        method="POST"
                                        class="flex-1"
                                        onsubmit="return confirm('Are you sure you want to delete this room? This action cannot be undone.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="w-full bg-red-600 text-white rounded-lg px-3 py-2 hover:bg-red-700"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                @endif

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        @endif

    </main>

</body>
</html>
