<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\FakeData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DeleteFakeProducts implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected readonly User $shop)
    {
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return $this->shop->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->shop->fakeData()->each(function (FakeData $fakeProduct) {
            $response = $this->shop->api()->rest('DELETE', '/admin/api/products/'.$fakeProduct->shopify_id.'.json');

            if (empty($response['errors']) || $response['status'] === 404) {
                $fakeProduct->delete();
            } else {
                report($response['exception']);
            }
        });
    }
}
