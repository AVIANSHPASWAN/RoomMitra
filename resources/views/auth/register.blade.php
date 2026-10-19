
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | RoomMitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-center text-slate-800">
            Create Account
        </h1>

        <p class="text-center text-slate-500 mt-2 mb-6">
            Join RoomMitra
        </p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="account_type"
                    class="block text-sm font-medium mb-1">
                    Account type
                </label>

                <select id="account_type"
                    name="account_type"
                    required
                    class="w-full border rounded-lg p-3 bg-white">

                    <option value="user"
                        {{ old('account_type', 'user') === 'user' ? 'selected' : '' }}>
                        Normal User
                    </option>

                    <option value="owner"
                        {{ old('account_type') === 'owner' ? 'selected' : '' }}>
                        Room Owner
                    </option>
                </select>
            </div>

            <div>
                <label for="name"
                    class="block text-sm font-medium mb-1">
                    Full Name
                </label>

                <input id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    class="w-full border rounded-lg p-3"
                    placeholder="Enter your name">
            </div>

            <div>
                <label for="email"
                    class="block text-sm font-medium mb-1">
                    Email
                </label>

                <input id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="w-full border rounded-lg p-3"
                    placeholder="Enter your email">
            </div>

            <div>
                <label for="password"
                    class="block text-sm font-medium mb-1">
                    Password
                </label>

                <input id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full border rounded-lg p-3"
                    placeholder="Create a password">
            </div>

            <div>
                <label for="password_confirmation"
                    class="block text-sm font-medium mb-1">
                    Confirm Password
                </label>

                <input id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full border rounded-lg p-3"
                    placeholder="Confirm your password">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg p-3">
                Create Account
            </button>
        </form>

        <p class="text-center text-sm text-slate-600 mt-6">
            Already registered?
            <a href="{{ route('login') }}"
                class="text-blue-600 font-semibold">
                Login
            </a>
        </p>
    </div>

</body>
</html>
