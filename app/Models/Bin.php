<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bin extends Model
{
    use HasFactory;

    protected $fillable = [
        'bin', 'type', 'brand', 'bank', 'country', 'provider_id',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
