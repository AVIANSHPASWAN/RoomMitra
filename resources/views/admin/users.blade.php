
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | RoomMitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen">

<header class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">RoomMitra</h1>
            <p class="text-sm text-slate-500 mt-1">Admin Panel / User Management</p>
        </div>

        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-100">
            ← Back to Dashboard
        </a>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <div class="mb-7">
        <h2 class="text-3xl font-bold">User Management</h2>
        <p class="text-slate-500 mt-2">
            View registered users and manage their roles.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <section class="bg-white rounded-2xl border border-slate-200 p-6 mb-7">
        <p class="text-sm font-medium text-slate-500">Total Registered Users</p>
        <div class="flex items-end gap-3 mt-2">
            <span class="text-4xl font-bold">{{ $users->count() }}</span>
            <span class="text-sm text-slate-500 mb-1">accounts</span>
        </div>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="font-semibold text-lg">Registered Users</h3>
            <p class="text-sm text-slate-500 mt-1">
                Account details and assigned roles
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-semibold">ID</th>
                        <th class="px-6 py-4 font-semibold">User</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold">Role</th>
                        <th class="px-6 py-4 font-semibold">Registered</th>
                        <th class="px-6 py-4 font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 text-slate-500">
                                #{{ $user->id }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">
                                        {{ $user->name }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="inline-flex rounded-full bg-purple-100 text-purple-700 px-3 py-1 text-xs font-semibold">
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-semibold">
                                        Owner
                                    </span>
                                @endif
                            </td>

                            
<td class="px-6 py-4 text-slate-500 whitespace-nowrap">
    {{ $user->created_at?->format('d M Y') ?? 'N/A' }}
</td>

<td class="px-6 py-4">
    @if(false)
        <span class="text-slate-500 text-xs font-medium">
            Current Admin
        </span>
    @else

                                    <form
                                        action="{{ route('admin.users.updateRole', $user->id) }}"
                                        method="POST"
                                        class="flex flex-wrap items-center gap-2"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <select
                                            name="role"
                                            class="rounded-lg border border-slate-300 px-3 py-2 bg-white"
                                            aria-label="Role for {{ $user->name }}"
                                        >
                                            <option value="owner" @selected($user->role === 'owner')>
                                                Owner
                                            </option>
                                            <option value="admin" @selected($user->role === 'admin')>
                                                Admin
                                            </option>
                                        </select>

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-slate-300 px-3 py-2 font-medium hover:bg-slate-100"
                                        >
                                            Update
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="font-semibold text-slate-700">No users found</p>
                                <p class="text-slate-500 mt-1">
                                    Registered accounts will appear here.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4 text-sm text-slate-500">
            Showing {{ $users->count() }} registered users
        </div>

    </section>
</main>

<footer class="text-center text-sm text-slate-400 py-6">
    © {{ date('Y') }} RoomMitra
</footer>

</body>
</html>
