<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalTime extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subinstance()
    {
        return $this->belongsTo(SubInstance::class);
    }
}
