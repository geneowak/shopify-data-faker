<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Osiset\ShopifyApp\Contracts\ShopModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AfterShopifyAuthentication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected readonly User|ShopModel $shop)
    {
    }

    public function handle(): void
    {
        if ($this->shop->force_scope_update) {
            $this->shop->force_scope_update = false;

            $this->shop->save();
        }
    }
}
