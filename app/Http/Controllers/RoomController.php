<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Room::with('hotel', 'typeRoom', 'accommodation')->get(), 200);
        } catch (\Exception $e) {
            return response()->json(['error', $e->getMessage()], 400);
        }
    }

    /**
     * display a listing of the resource by hotel.
     */
    public function roomsByHotel($id)
    {
        try {
            return response()->json(Room::with('hotel', 'typeRoom', 'accommodation')->where('id_hotel', $id)->get(), 200);
        } catch (\Exception $e) {
            return response()->json(['error', $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'id_hotel' => 'required|exists:hotels,id',
                'id_type_room' => 'required|exists:room_types,id',
                'id_accommodation' => 'required|exists:accommodations,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $hotel = Hotel::findOrFail($data['id_hotel']);
            $currentRooms = Room::where('id_hotel', $data['id_hotel'])->sum('quantity');

            if ($currentRooms + $data['quantity'] > $hotel->number_rooms) {
                return response()->json([
                    'error' => 'La cantidad de habitaciones supera el máximo permitido para este hotel'
                ], 400);
            }

            $duplicateRoom = Room::where('id_hotel', $data['id_hotel'])
                ->where('id_type_room', $data['id_type_room'])
                ->where('id_accommodation', $data['id_accommodation'])
                ->where('quantity', $data['quantity'])
                ->exists();

            if ($duplicateRoom) {
                return response()->json([
                    'error' => 'Ya existe una habitación con las mismas características en el hotel'
                ], 400);
            }

            $room = Room::create($data);

            return response()->json($room, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la habitación, valida los datos y recuerda que no puedes repetir habitaciones con una misma acomodación',
                'status' => 400,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            return response()->json(Room::with('hotel', 'typeRoom', 'accommodation')->findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error', $e->getMessage()], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'id_hotel' => 'required|exists:hotels,id',
                'id_type_room' => 'required|exists:room_types,id',
                'id_accommodation' => 'required|exists:accommodations,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $room = Room::findOrFail($id);

            $room->update($data);

            return response()->json($room, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la habitación, valida los datos y recuerda que no puedes repetir habitaciones con una misma acomodación',
                'status' => 400,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        $room->delete();

        return response()->json($room, 200);
    }
}
