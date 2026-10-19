
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room | RoomMitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-5 py-4">
            <a href="{{ route('rooms.index') }}"
               class="text-2xl font-extrabold text-teal-700">
                RoomMitra
            </a>

            <a href="{{ route('rooms.manage') }}"
               class="rounded-lg border border-slate-300 px-4 py-2 font-semibold hover:bg-slate-50">
                Back to My Rooms
            </a>
        </div>
    </nav>

    <main class="mx-auto max-w-3xl px-5 py-10">

        <div class="mb-6">
            <h1 class="text-3xl font-extrabold">Edit Room</h1>
            <p class="mt-2 text-slate-600">
                Update your room information below.
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-bold">Please correct these errors:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('rooms.update', $room) }}"
            method="POST"
            class="space-y-6 rounded-2xl bg-white p-6 shadow-sm sm:p-8"
        >
            @csrf
            @method('PUT')

            <!-- Room Title -->
            <div>
                <label for="title" class="mb-2 block font-semibold">
                    Room Title *
                </label>

                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title', $room->title) }}"
                    required
                    maxlength="255"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                >
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="mb-2 block font-semibold">
                    Location *
                </label>

                <input
                    id="location"
                    type="text"
                    name="location"
                    value="{{ old('location', $room->location) }}"
                    required
                    maxlength="255"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                >
            </div>

            <!-- Monthly Rent -->
            <div>
                <label for="price" class="mb-2 block font-semibold">
                    Monthly Rent (₹) *
                </label>

                <input
                    id="price"
                    type="number"
                    name="price"
                    value="{{ old('price', $room->price) }}"
                    min="0"
                    step="0.01"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                >
            </div>

            <!-- Beds -->
            <div>
                <label for="beds" class="mb-2 block font-semibold">
                    Number of Beds
                </label>

                <input
                    id="beds"
                    type="number"
                    name="beds"
                    value="{{ old('beds', $room->beds) }}"
                    min="1"
                    step="1"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                >
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="mb-2 block font-semibold">
                    Room Description *
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                >{{ old('description', $room->description) }}</textarea>
            </div>

            <!-- Owner Name -->
            <div>
                <label for="owner_name" class="mb-2 block font-semibold">
                    Owner Name
                </label>

                <input
                    id="owner_name"
                    type="text"
                    name="owner_name"
                    value="{{ old('owner_name', $room->owner_name) }}"
                    maxlength="255"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                >
            </div>

            <!-- Owner Phone -->
            <div>
                <label for="owner_phone" class="mb-2 block font-semibold">
                    Owner Phone Number
                </label>

                <input
                    id="owner_phone"
                    type="tel"
                    name="owner_phone"
                    value="{{ old('owner_phone', $room->owner_phone) }}"
                    maxlength="20"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                >
            </div>

            <!-- Availability -->
            <div>
                <label for="available" class="mb-2 block font-semibold">
                    Room Availability *
                </label>

                <select
                    id="available"
                    name="available"
                    required
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                >
                    <option value="1"
                        {{ (string) old('available', (int) $room->available) === '1' ? 'selected' : '' }}>
                        Available
                    </option>

                    <option value="0"
                        {{ (string) old('available', (int) $room->available) === '0' ? 'selected' : '' }}>
                        Unavailable
                    </option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 sm:flex-row">

                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-teal-700 px-5 py-3 font-bold text-white transition hover:bg-teal-800"
                >
                    Save Changes
                </button>

                <a
                    href="{{ route('rooms.manage') }}"
                    class="flex-1 rounded-xl border border-slate-300 px-5 py-3 text-center font-bold hover:bg-slate-50"
                >
                    Cancel
                </a>

            </div>

        </form>

        <p class="mt-4 text-sm text-slate-500">
            * Required fields. Your existing room photo will remain unchanged.
        </p>

    </main>

</body>
</html>
