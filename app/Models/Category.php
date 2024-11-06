<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ["name"];
    public function todos() {
        return $this->hasMany(ToDo::class);
    }
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
