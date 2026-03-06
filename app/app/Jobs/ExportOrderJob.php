<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class ExportOrderJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

//        Http::post(
//            config('services.order_export.url'),
//            [
//                'order_id' => $this->order->id,
//                'customer_id' => $this->order->customer_id,
//                'status' => $this->order->status,
//                'total_amount' => $this->order->total_amount,
//                'items' => $this->order->items->map(fn($item) => [
//                    'product_id' => $item->product_id,
//                    'quantity' => $item->quantity,
//                    'unit_price' => $item->unit_price,
//                ])
//            ]
//        )->throw();
    }

    public function backoff(): array
    {
        return [10, 30, 60];
    }
}
