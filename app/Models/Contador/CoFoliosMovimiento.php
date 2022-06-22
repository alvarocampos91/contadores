<?php

namespace App\Models\Contador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoFoliosMovimiento extends Model
{
    use HasFactory;

    public $fillable = [
        'co_folios_usuario_id',
        'folios_modificados',
        'total_contador',
        'total_limite',
        'descripcion',
        'origen',
        'tipo',
        'estatus',
        'id_usuario_registra',
        'id_acceso_registra',
        'registrado_por'
    ];
}
