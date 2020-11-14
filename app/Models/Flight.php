<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = "flight";

    public function departure() {
        return $this->belongsTo(Airport::class);
    }

    public function arrival() {
        return $this->belongsTo(Airport::class);
    }
}
