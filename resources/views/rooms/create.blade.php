
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room | RoomMitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">

    <nav class="bg-white shadow-sm">
        <div class="max-w-5xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('rooms.index') }}"
               class="text-2xl font-bold text-indigo-600">
                RoomMitra
            </a>

            <a href="{{ route('rooms.manage') }}"
               class="text-sm font-semibold text-slate-600 hover:text-indigo-600">
                My Rooms
            </a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-10">

        <div class="mb-8">
            <p class="text-indigo-600 font-semibold text-sm">ROOM LISTING</p>
            <h1 class="text-3xl font-bold text-slate-800 mt-2">
                Add Your Room
            </h1>
            <p class="text-slate-500 mt-2">
                Enter your room details and upload a photo.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
                <p class="font-bold mb-2">Please correct these errors:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 space-y-6">

            @csrf

            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">
                    Room Title *
                </label>
                <input type="text" id="title" name="title"
                       value="{{ old('title') }}"
                       placeholder="e.g. Spacious Student Room"
                       required maxlength="255"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold text-slate-700 mb-2">
                    Location *
                </label>
                <input type="text" id="location" name="location"
                       value="{{ old('location') }}"
                       placeholder="e.g. Civil Lines, Gorakhpur"
                       required maxlength="255"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">
                        Monthly Rent (₹) *
                    </label>
                    <input type="number" id="price" name="price"
                           value="{{ old('price') }}"
                           min="0" step="0.01" required
                           placeholder="4000"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="beds" class="block text-sm font-semibold text-slate-700 mb-2">
                        Number of Beds *
                    </label>
                    <input type="number" id="beds" name="beds"
                           value="{{ old('beds', 1) }}"
                           min="1" required
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                    Room Description *
                </label>
                <textarea id="description" name="description"
                          rows="5" maxlength="5000" required
                          placeholder="Describe facilities, nearby places and room features..."
                          class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">
                    Owner Information
                </h2>

                <div class="space-y-5">
                    <div>
                        <label for="owner_name" class="block text-sm font-semibold text-slate-700 mb-2">
                            Owner Name *
                        </label>
                        <input type="text" id="owner_name" name="owner_name"
                               value="{{ old('owner_name', auth()->user()->name) }}"
                               maxlength="255" required
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="owner_phone" class="block text-sm font-semibold text-slate-700 mb-2">
                            Contact Number *
                        </label>
                        <input type="tel" id="owner_phone" name="owner_phone"
                               value="{{ old('owner_phone') }}"
                               maxlength="20" required
                               placeholder="Enter contact number"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">
                    Room Photo
                </label>

                <input type="file" id="image" name="image"
                       accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                       class="block w-full text-sm text-slate-600 border border-slate-300 rounded-xl p-3">

                <p class="text-xs text-slate-500 mt-2">
                    JPG, JPEG, PNG or WEBP. Maximum size: 2 MB.
                </p>

                <img id="photoPreview" alt="Room photo preview"
                     class="hidden mt-4 w-full max-h-72 object-cover rounded-xl">
            </div>

            <div class="bg-slate-50 rounded-xl p-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="available" value="1"
                           {{ old('available', '1') == '1' ? 'checked' : '' }}
                           class="w-5 h-5 accent-indigo-600">
                    <span class="text-sm font-semibold text-slate-700">
                        This room is currently available
                    </span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition">
                    Add Room
                </button>

                <a href="{{ route('rooms.manage') }}"
                   class="text-center border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold py-3 px-6 rounded-xl">
                    Cancel
                </a>
            </div>

        </form>
    </main>

    <script>
        const imageInput = document.getElementById('image');
        const photoPreview = document.getElementById('photoPreview');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                photoPreview.src = URL.createObjectURL(file);
                photoPreview.classList.remove('hidden');
            } else {
                photoPreview.removeAttribute('src');
                photoPreview.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
