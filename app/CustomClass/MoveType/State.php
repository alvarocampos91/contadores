<?php
/**
 * Filename: State.php
 * Created: Alvaro Campos
 * Change history:
 * 21.06.2022 / Alvaro Campos
**/

namespace App\CustomClass\MoveType;

use App\Models\Contador\CoFoliosHistorialUsuario;
use App\Models\Contador\CoFoliosMovimiento;
use App\Models\Contador\CoFoliosUsuario;

abstract class State
{
    const ACTIVACION_VENTA    = 'activacion';
    const DESCONTAR_FOLIO     = 'folio';
    const DESCONTAR_EXPIRADOS = 'expiracion';
    const PASAR_FOLIOS        = 'traspasar';
    const MIGRAR_VENTA        = 'migrar';
    const REGALAR_FOLIOS      = 'regalo';
    const OTRO_MOVIMIENTO     = 'otro';

    protected ?Move $context;
    protected ?CoFoliosMovimiento $movimiento;

    /**
     * Abstract function makeChange()
     *
     * La clase que herede State debe implementar este método según el movimiento que se hará al contador o al límite
     *
     * @return void
     */
    public abstract function makeChange();

    public function __construct( CoFoliosMovimiento $move )
    {
        $this->movimiento = $move;
    }

    public function setContext( Move $context )
    {
        $this->context = $context;
    }

    /**
     * function addTotalFoliosToMove()
     *
     * Agrega el total de folios existentes contando lo del historial
     *
     * @param CoFoliosUsuario $folios
     *
     * @return void
     */
    public function addTotalFoliosToMove()
    {
        $folios = CoFoliosUsuario::find( $this->movimiento->co_folios_usuario_id ); // Buscar el contador del usuario
        $hist = CoFoliosHistorialUsuario::
            selectRaw( 'SUM(contador) AS totalContador, SUM(limite) AS totalLimite' )->
            where( 'co_folios_usuario_id', $folios->id )->groupBy( 'co_folios_usuario_id' )->get();
        $totalContador = $hist->count() <= 0? 0: $hist[0]->totalContador;

        $this->movimiento->total_contador = $folios->contador + $totalContador;
        $this->movimiento->total_limite = $folios->limite + $totalContador;
        $this->movimiento->save();
    }

    /**
     * Static function State::getState()
     *
     * Devuelve una implementación de la clase State dependiendo del tipo de movimiento que se desa realizar
     *
     * @param CoFoliosMovimiento $move
     *
     * @return State
     */
    static function getState( CoFoliosMovimiento $move ): State
    {
        switch( $move->tipo ) {
            case self::ACTIVACION_VENTA:
                return new ActivacionVenta( $move );
            break;
            case self::DESCONTAR_FOLIO:
                return new DescontarFolio( $move );
            break;
            case self::PASAR_FOLIOS:
                return new PasarFolios( $move );
            break;
            case self::MIGRAR_VENTA:
                return new MigrarVenta( $move );
            break;
            case self::REGALAR_FOLIOS:
                return new RegalarFolios( $move );
            break;
            default:
                return new DescontarFolio( $move );
        }
    }
}
