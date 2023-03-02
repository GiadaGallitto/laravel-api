<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'argument', 'description', 'author', 'start_date', 'concluded', 'image', 'type_id'];
    
    public function type(){
        return $this->belongsTo(Type::class); 
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(){
        return 'slug';
    }

    public function isImageUrl(){
        return filter_var($this->image, FILTER_VALIDATE_URL);
    }

    public function technologies(){
        return $this->belongsToMany(Technology::class);
    }
}
