<?php


namespace App\DTO;


class CreateOrderDTO
{
    public function __construct(
        public int $customerId,
        public array $items
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            customerId: $data['customer_id'],
            items: $data['items']
        );
    }
}
