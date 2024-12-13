<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['markup'];

    protected $casts = [
        'markup' => 'array'
    ];

    public function markup(): Attribute
    {
        return Attribute::get(fn($value) => json_decode($value));
    }
}
