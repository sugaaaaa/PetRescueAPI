<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetsAPI extends Model
{
    use HasFactory;
    protected $primarykey = 'id';
    protected $fillable = ['name', 'age', 'sex', 'vaccine', 'images', 'content', 'category_id'];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'category_id');
    // }

    // public function adoptions()
    // {
    //     return $this->hasMany(Adoption::class);
    // }
}