<?php

namespace App\Jobs;

use stdClass;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;

class CustomersDataRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  ShopDomain  $shopDomain  The shop's myshopify domain
     * @param  stdClass  $webhook  The webhook data (JSON decoded)
     * @return self
     */
    public function __construct(protected readonly ShopDomain $shopDomain, protected readonly stdClass $data)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
