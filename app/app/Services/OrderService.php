<?php


namespace App\Services;


use App\Contracts\OrderServiceContract;
use App\DTO\CreateOrderDTO;
use App\Jobs\ExportOrderJob;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService implements OrderServiceContract
{

    public function create(CreateOrderDTO $createOrderDTO): Order
    {
        return DB::transaction(function () use ($createOrderDTO) {

            $order = Order::create([
                'customer_id' => $createOrderDTO->customerId,
                'status' => 'new',
                'total_amount' => 0
            ]);

            $total = 0;

            foreach ($createOrderDTO->items as $item) {

                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'stock' => 'Not enough stock'
                    ]);
                }

                $product->decrement('stock_quantity', $item['quantity']);

                $price = $product->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $price
                ]);

                $total += $price;
            }

            $order->update([
                'total_amount' => $total
            ]);

            return $order;
        });
    }

    public function updateStatus(Order $order, string $newStatus): Order
    {
        if (!in_array($newStatus, $order->getNextStatus() ?? [])) {
            throw ValidationException::withMessages([
                'status' => 'Invalid transition'
            ]);
        }

        $order->update(['status' => $newStatus]);

        if ($newStatus === 'confirmed') {
            ExportOrderJob::dispatch($order);
        }

        return $order;
    }
}
