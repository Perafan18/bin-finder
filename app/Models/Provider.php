<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'enabled'];

    public function bins()
    {
        return $this->hasMany(Bin::class);
    }
}
