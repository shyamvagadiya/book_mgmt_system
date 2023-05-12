<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Book extends Model
{
    use HasFactory,Searchable;
    protected $guarded=[];
    
    public function toSearchableArray()
    {
        return [
            'title'=>$this->title,
            'author'=>$this->author,
            'genre'=>$this->genre,
            'description'=>$this->description,
            'isbn'=>$this->isbn,
            'published'=>$this->published,
            'publisher'=>$this->publisher
        ];
    }
}
