<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'nit',
        'number_rooms',
    ];

    public function rooms() {
        return $this->hasMany(Room::class, 'id_hotel');
    }
}
