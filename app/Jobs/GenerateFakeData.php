<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GenerateFakeData implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected readonly User $shop, protected readonly int $productCount = 0, protected readonly int $customerCount = 0)
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
        $this->generateFakeProducts();
        $this->generateFakeCustomers();
    }

    protected function generateFakeProducts(): void
    {
        if ($this->productCount <= 0) {
            return;
        }

        $products = [];

        for ($i = 0; $i < $this->productCount; $i++) {
            $productResource = [
                'body_html' => 'Product Description '.$i,
                'title' => 'Product Title '.$i,
            ];

            $response = $this->shop->api()->rest('POST', '/admin/api/products.json', ['product' => $productResource]);

            if (! empty($response['errors'])) {
                throw $response['exception'];
            }

            $products[] = ['shopify_id' => $response['body']['product']['id']];
        }

        $this->shop->fakeData()->createMany($products);
    }

    protected function generateFakeCustomers(): void
    {
        if ($this->customerCount <= 0) {
            return;
        }

        $customers = [];

        for ($i = 0; $i < $this->customerCount; $i++) {
            $customerResource = [
                'first_name' => 'First Name '.$i,
                'last_name' => 'Last Name '.$i,
                'email' => fake()->unique()->safeEmail(),
            ];

            $response = $this->shop->api()->rest('POST', '/admin/api/customers.json', ['customer' => $customerResource]);

            if (! empty($response['errors'])) {
                throw $response['exception'];
            }

            $customers[] = ['shopify_id' => $response['body']['customer']['id']];
        }

        $this->shop->fakeData()->createMany($customers);
    }
}
