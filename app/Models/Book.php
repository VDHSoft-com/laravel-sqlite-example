<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	// En ajoutant ces attributs à $fillable, vous permettez à Laravel d'effectuer une assignation de masse sur ces champs en utilisant la méthode create.
    protected $fillable = [
        'title',
        'author',
        'description',
    ];
}
