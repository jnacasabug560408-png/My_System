<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // ITO ANG MAGIC CODE:
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }
}