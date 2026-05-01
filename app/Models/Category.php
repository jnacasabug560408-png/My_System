<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function create()
{
    $categories = Category::all();

    return view('posts.create', compact('categories'));
}

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function getRouteKeyName()
{
    return 'slug';
}
}