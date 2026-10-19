<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Permission Helper
    |--------------------------------------------------------------------------
    */

    private function ensureCanManageRooms(): void
    {
        abort_unless(
            Auth::guard('owner')->check() ||
            Auth::guard('admin')->check(),
            403,
            'You are not allowed to manage rooms.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $totalRooms = Room::count();

        $availableRooms = Room::where('available', true)->count();

        $recentRooms = Room::latest()->take(6)->get();

        return view('dashboard', compact(
            'totalRooms',
            'availableRooms',
            'recentRooms'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Homepage and Room Search
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));

        $minPrice = $request->input('min_price');

        $maxPrice = $request->input('max_price');

        $rooms = Room::query()
            ->where('available', true)

            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($search) use ($query) {
                    $search->where('title', 'like', "%{$query}%")
                        ->orWhere('location', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                });
            })

            ->when(
                $minPrice !== null && $minPrice !== '',
                fn ($builder) => $builder->where('price', '>=', $minPrice)
            )

            ->when(
                $maxPrice !== null && $maxPrice !== '',
                fn ($builder) => $builder->where('price', '<=', $maxPrice)
            )

            ->orderBy('price')
            ->get();

        return view('rooms.index', [
            'rooms' => $rooms,
            'query' => $query,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Individual Room Details
    |--------------------------------------------------------------------------
    */

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /*
    |--------------------------------------------------------------------------
    | Add Room Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->ensureCanManageRooms();

        return view('rooms.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store New Room
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $this->ensureCanManageRooms();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0'],
            'beds' => ['required', 'integer', 'min:1'],
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_phone' => ['required', 'string', 'max:20'],
            'available' => ['nullable', 'boolean'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $room = new Room();

        $room->title = $validated['title'];
        $room->location = $validated['location'];
        $room->description = $validated['description'];
        $room->price = $validated['price'];
        $room->beds = $validated['beds'];
        $room->owner_name = $validated['owner_name'];
        $room->owner_phone = $validated['owner_phone'];
        $room->available = $request->boolean('available');

        // Assign the room to the logged-in Owner.
        // Admin-created rooms remain unassigned unless linked separately.
        if (Auth::guard('owner')->check()) {
            $room->owner_id = Auth::guard('owner')->id();
        }

        // Upload the room image to public storage.
        if ($request->hasFile('image')) {
            $room->image = $request->file('image')
                ->store('rooms', 'public');
        }

        $room->save();

        return redirect()
            ->route('rooms.manage')
            ->with('success', 'Room added successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | My Rooms
    |--------------------------------------------------------------------------
    */

    public function myRooms()
    {
        $this->ensureCanManageRooms();

        if (Auth::guard('admin')->check()) {
            // Admin can see every room.
            $rooms = Room::latest()->get();
        } else {
            // Owner can see only rooms linked to their owner_id.
            $rooms = Room::where(
                'owner_id',
                Auth::guard('owner')->id()
            )->latest()->get();
        }

        return view('rooms.manage', compact('rooms'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Room Form
    |--------------------------------------------------------------------------
    */

    public function edit(Room $room)
    {
        $this->ensureCanManageRooms();

        if (
            Auth::guard('owner')->check() &&
            (int) $room->owner_id !== (int) Auth::guard('owner')->id()
        ) {
            abort(403, 'You can edit only your own rooms.');
        }

        return view('rooms.edit', compact('room'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Room
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Room $room)
    {
        $this->ensureCanManageRooms();

        if (
            Auth::guard('owner')->check() &&
            (int) $room->owner_id !== (int) Auth::guard('owner')->id()
        ) {
            abort(403, 'You can update only your own rooms.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0'],
            'beds' => ['nullable', 'integer', 'min:1'],
            'available' => ['required', 'boolean'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'owner_phone' => ['nullable', 'string', 'max:20'],
        ]);

        $room->update($validated);

        return redirect()
            ->route('rooms.manage')
            ->with('success', 'Room updated successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Room
    |--------------------------------------------------------------------------
    */

    public function destroy(Room $room)
    {
        $this->ensureCanManageRooms();

        if (
            Auth::guard('owner')->check() &&
            (int) $room->owner_id !== (int) Auth::guard('owner')->id()
        ) {
            abort(403, 'You can delete only your own rooms.');
        }

        // Delete the stored photo, if one exists.
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()
            ->route('rooms.manage')
            ->with('success', 'Room deleted successfully!');
    }
}
