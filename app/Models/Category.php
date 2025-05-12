<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  // Tambahkan ini
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;  // Tambahkan ini

    protected $fillable = ['title', 'user_id'];

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
    public function getTodosCountAttribute()
    {
        return $this->todos()->count();
    }
}