<?php
/**
 * Filename: ActivacionVenta.php
 * Created: Alvaro Campos
 * Change history:
 * 21.06.2022 / Alvaro Campos
**/

namespace App\CustomClass\MoveType;

use App\Models\Contador\CoFoliosHistorialUsuario;
use App\Models\Contador\CoFoliosUsuario;
use Carbon\Carbon;

class ActivacionVenta extends State
{
    /**
     * Implements makeChange().
     *
     * Agrega los folios según los timbres de la venta, y reinicia el contador.
     *
     * @return void
     */
    public function makeChange()
    {
        $now = Carbon::now();

        $folios = CoFoliosUsuario::find($this->movimiento->co_folios_usuario_id); // Buscar el contador del usuario
        if( $folios->limite != 0 )
        {
            $descontados = $this->verifyExpirationDate( $folios ); // Valida la fecha de expiración y hace los movimientos correspondientes
            CoFoliosHistorialUsuario::insert( array_merge( collect($folios->toArray())->except('id')->all(), [
                'co_folios_usuario_id' => $folios->id,
                'id_venta'             => 0,
                'folios_descontados'   => $descontados,
                'created_at'           => $now,
                'updated_at'           => $now
            ] ) ); // Copia los datos del contador para guardarlos en el historial
        }

        $total = $folios->limite - $folios->contador; // Número de folios restantes
        $folios->contador            = 0; // Reseteo del contador
        $folios->limite              = $this->movimiento->folios_modificados + $total; // Se suman los folios restantes a los folios de la venta
        $folios->fecha_expiracion    = $now->addYears(2); // Agregar la fecha de expiración a 2 años posteriores
        $folios->id_usuario_registra = $this->movimiento->id_usuario_registra;
        $folios->id_acceso_registra  = $this->movimiento->id_acceso_registra;
        $folios->registrado_por      = $this->movimiento->registrado_por;

        $folios->save();
    }

    /**
     * Function verifyExpirationDate().
     *
     * Valida que no se haya pasado la fecha de expiración, si es así se divide el número de folios restantes.
     * Se pasa la variable folios como referencia para actualizar los datos si es necesario.
     * Devuelve el número de folios descontados.
     *
     * @param CoFoliosUsuario &$folios
     *
     * @return Int
     */
    private function verifyExpirationDate( CoFoliosUsuario &$folios ): int
    {
        $exp = new Carbon( $folios->fecha_expiracion );
        $now = Carbon::now();
        if( $now->gt( $exp ) ) // Validando que la fecha de expiració no se haya pasado
        {
            $total = $folios->limite - $folios->contador;
            $descontados = intval( $total / 2 );

            $newMov = $this->movimiento->replicate(); // Duplica los datos del row que se guardó en $this->movimiento
            $newMov->folios_modificados = -$descontados;
            $newMov->descripcion        = 'Descuento de folios por fecha de expiración';
            $newMov->tipo               = State::DESCONTAR_EXPIRADOS;
            $newMov->save();

            $move = new Move( new DescontarExpirados( $newMov ) );
            $move->makeChange(); // Se encarga de restar el número de folios correspondiente

            // Se intenta actualizar la variable con los datos del contador, si falla fresh se hace una busqueda en la base
            try
            {
                $folios = $folios->fresh();
            }
            catch( \Throwable $e )
            {
                $folios = CoFoliosUsuario::find( $this->movimiento->co_folios_usuario_id );
            }

            return $descontados;
        }

        return 0; // no se desconto ningún folio
    }
}
