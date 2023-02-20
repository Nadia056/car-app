<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $client;
    protected $random;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $random)
    {
        $this->client = $user;
        $this->random = $random;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Http::post('https://rest.nexmo.com/sms/json', [
            "from" => "Nadia",
            "api_key" => "5609180c",
            "api_secret" => "oYKxEjOOz42VHvEp",
            "to" => 52 . $this->client->phone,
            "text" => "Tu codigo de verificacion es: " . $this->random . " tienes 20 minutos para verificar tu cuenta"
        ]);
    }
}
