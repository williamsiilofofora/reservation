<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id', 
        'home_id', 
        'start', 
        'rented', 
        'end', 
        'limit'
    ];
    protected $appends = ['display'];

    public function getDisplayAttribute()
    {
        return 'background';
    }
    public function home()
    {
        return $this->belongsTo(Home::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}