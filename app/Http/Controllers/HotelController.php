<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Hotel::with("rooms")->get(), 200);
        } catch (\Exception $e) {
            return response()->json(['error', $e->getMessage()],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|unique:hotels,name',
                'address' => 'required|string',
                'city' => 'required|string',
                'nit' => 'required|string',
                'number_rooms' => 'required|integer|min:1',
            ]);

            $hotel = Hotel::create($data);

            return response()->json($hotel, 201);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            return response()->json(Hotel::with('rooms')->findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error', $e->getMessage()],400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|unique:hotels,name',
                'address' => 'required|string',
                'city' => 'required|string',
                'nit' => 'required|string',
                'number_rooms' => 'required|integer|min:1',
            ]);

            $hotel = Hotel::findOrFail($id);

            $hotel->update($data);

            return response()->json($hotel,200);

        } catch (\Exception $e) {
            return response()->json(['error', $e->getMessage()],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);

        $hotel->delete();

        return response()->json($hotel);
    }
}
