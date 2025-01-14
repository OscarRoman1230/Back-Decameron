<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTypeValidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_type_room',
        'id_accommodation',
    ];

    public function typeRoom()
    {
        return $this->belongsTo(RoomType::class, 'id_type_room');
    }

    public function acomodacion()
    {
        return $this->belongsTo(Accommodation::class, 'id_accommodation');
    }
}
