<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $guarded = [];
    protected $casts = [
        'due_date' => 'datetime',
    ];
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function getFormattedDateAttribute() {
        return $this->due_date ? $this->due_date->format('D, d M Y h:i A') : null;
    }

    protected $hidden = [
        'category_id',
        'user_id',
        'created_at',
        'updated_at',
    ];
    
}
