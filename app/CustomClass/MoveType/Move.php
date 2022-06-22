<?php
/**
 * Filename: Move.php
 * Created: Alvaro Campos
 * Change history:
 * 21.06.2022 / Alvaro Campos
**/

namespace App\CustomClass\MoveType;

class Move
{
    private ?State $state;

    public function __construct( State $initial ){
        $this->state = $initial;
        $this->state->setContext( $this );
    }

    public function makeChange()
    {
        $this->state->makeChange();
        $this->state->addTotalFoliosToMove();
    }
}
