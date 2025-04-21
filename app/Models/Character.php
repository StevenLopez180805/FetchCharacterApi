<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = ['id', 'name', 'status', 'species', 'image', 'type', 'gender', 'fk_origin'];

    public function origin()
    {
        return $this->belongsTo(Origin::class, 'fk_origin');
    }
}
