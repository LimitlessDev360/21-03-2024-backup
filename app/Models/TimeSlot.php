<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['day_id', 'start_time', 'end_time'];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
