<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'fabricantes';
    protected $fillable = array('nombre','telefono');

    public function vehiculos()
    {
        $this->hasMany('Vehiculo'); //Relación de uno a muchos
    }
}