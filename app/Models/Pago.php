<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cantidad',
        'fecha',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
