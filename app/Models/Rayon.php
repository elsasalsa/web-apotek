<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rayon extends Model
{
    use HasFactory;

    protected $fillable = [
        'rayon',
        'user_id',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    
    }
    public function rayon() {
        return $this->hasMany(Rayon::class, 'rayon_id', 'id');
    }
    
    public function student() {
        return $this->hasMany(Student::class, 'rayon_id', 'id');
    }
    
}
