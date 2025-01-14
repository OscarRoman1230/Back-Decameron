<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'id_accommodation');
    }

    public function validations() {
        return $this->hasMany(RoomTypeValidation::class,'id_accommodation');
    }
}
