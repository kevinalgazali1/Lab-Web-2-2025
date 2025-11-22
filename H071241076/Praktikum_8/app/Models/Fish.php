<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;
    protected $table = 'fishes';

    /**
     * The attributes that aren't mass assignable.
     *
    
     * @var array<int, string>
     */
    protected $guarded = ['id'];
}