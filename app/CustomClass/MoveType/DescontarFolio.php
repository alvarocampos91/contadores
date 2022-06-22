<?php
/**
 * Filename: DescontarFolio.php
 * Created: Alvaro Campos
 * Change history:
 * 21.06.2022 / Alvaro Campos
 */

namespace App\CustomClass\MoveType;

use App\Models\Contador\CoFoliosUsuario;

class DescontarFolio extends State
{
    /**
     * Implements makeChange().
     *
     * Descuenta un folio al contador del usuario, el cual debe estar asociado a un documento específico.
     *
     * @return void
     */
    public function makeChange()
    {
        $folios = CoFoliosUsuario::find($this->movimiento->co_folios_usuario_id); // Buscar el contador del usuario
        $folios->contador += -$this->movimiento->folios_modificados; // folios_modificados debera estar en negativo para descontar el folio
        $folios->save();
    }
}
