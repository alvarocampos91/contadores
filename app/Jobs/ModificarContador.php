<?php

namespace App\Jobs;

use App\CustomClass\MoveType\Move;
use App\CustomClass\MoveType\State;
use App\Models\Contador\CoFoliosHistorialUsuario;
use App\Models\Contador\CoFoliosMovimiento;
use App\Models\Contador\CoFoliosUsuario;
use Carbon\Carbon;
use CloudCreativity\LaravelJsonApi\Queue\ClientDispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ModificarContador implements ShouldQueue
{
    use ClientDispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( CoFoliosMovimiento $movimiento )
    {
        $this->movimiento = $movimiento;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try
        {
            $now = Carbon::now();
            Storage::disk('public')->put( $now->timestamp.'-'.$this->movimiento->id.'_i.json', json_encode( $this->movimiento ) );

            $move = new Move( State::getState( $this->movimiento ) );
            $move->makeChange();
            $this->didCreate($this->movimiento);

            $now = Carbon::now();
            Storage::disk('public')->put( $now->timestamp.'-'.$this->movimiento->id.'_f.json', json_encode( $this->movimiento ) );
        }
        catch(\Throwable $e)
        {
            dd($e);
        }
    }
}
