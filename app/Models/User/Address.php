<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'user_addresses';
    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_phone',
        'address',
        'latitude',
        'longitude',
        'address_type',
        'is_default',
    ];
}
