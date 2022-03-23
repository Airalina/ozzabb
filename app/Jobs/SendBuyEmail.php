<?php

namespace App\Jobs;

use App\Models\BuyOrder;
use App\Mail\BuyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBuyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $ordenes;
    protected $email;
    public function __construct($ordenes)
    {
        $this->ordenes=$ordenes;
        $this->email=$ordenes->provider->email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email=new BuyEmail($this->ordenes);
        Mail::to($this->email)->send($email);
        $this->ordenes->state=1;
        $this->ordenes->save();
    }
}
