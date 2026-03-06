<?php

namespace App\Contracts;

use App\DTO\CreateOrderDTO;
use App\Models\Order;

interface OrderServiceContract
{
    public function create(CreateOrderDTO $createOrderDTO) :Order;
    public function updateStatus(Order $order, string $newStatus) :Order;
}
