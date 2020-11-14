<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $table = "airport";

    public function flights() {
        return $this->hasMany(Flight::class, 'departure_id');
    }
}
