<?php

namespace App\Models\Contador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoFoliosUsuario extends Model
{
    use HasFactory;

    public function Historial() {
        return $this->hasMany( CoFoliosHistorialUsuario::class );
    }
}
