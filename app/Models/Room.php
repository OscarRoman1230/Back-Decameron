<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    use HasFactory;

    protected $table = "rooms"; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'id_hotel',
        'id_type_room',
        'id_accommodation',
        'quantity',
    ];

    public static function boot () {
        parent::boot();

        // Validación: evitar que la suma de habitaciones exceda el máximo permitido
        static::creating(function ($room) {
            $hotel = Hotel::findOrFail($room->id_hotel);
            $currentRooms = Room::where('id_hotel', $room->id_hotel)->sum('quantity');
            if ($currentRooms + $room->quantity > $hotel->number_rooms) {
                throw new \Exception('La cantidad de habitaciones supera el máximo permitido para este hotel');
            }
        });
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotel');
    }

    public function typeRoom()
    {
        return $this->belongsTo(RoomType::class, 'id_type_room');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'id_accommodation');
    }
}
