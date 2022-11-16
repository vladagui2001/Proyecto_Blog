<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use Searchable;
    // añadido el 04/10/22
    protected $fillable=['name','Apellidos','Avatar'];
    //
}
