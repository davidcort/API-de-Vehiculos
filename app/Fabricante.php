<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    protected $table = 'fabricantes';
    protected $fillable = array('nombre','telefono');
    protected $hidden = ['created_at','updated_at']; //Asi evitamos mostrar estos campos en el response, pues no son necesarios

    public function vehiculos()
    {
        return $this->hasMany('App\Vehiculo'); //Relación de uno a muchos con la tabla vehiculos
    }
}