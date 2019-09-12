<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    const ACTIVO = '1';
    const INACTIVO = 0;
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion','condicion'];
}
