<?php

namespace App\Mail;

use App\Models\BuyOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BuyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $ordenes;
    
    public function __construct(BuyOrder $ordenes)
    {
        $this->ordenes=$ordenes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('emiliano@phpgroup.com.ar','Emiliano Muñoz')
                    ->subject('Orden de Compra')
                    ->view('emial.buymail');
    }
}
