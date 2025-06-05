<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

     public function user(){
        return $this->belongsTo(User::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class)
        ->withTimestamps()->withPivot('cantidad', 'precio_venta', 'descuento');
    }    

    
}
