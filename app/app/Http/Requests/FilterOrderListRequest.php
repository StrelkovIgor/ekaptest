<?php

namespace App\Http\Requests;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterOrderListRequest extends FormRequest
{

    const FORMAT = 'Y-m-d H:i:s';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['string', Rule::in(array_keys(Order::STATUS))],
            'customer_id' => ['integer','exists:customers,id'],
            'date_from' => [Rule::date()->format(self::FORMAT)],
            'date_to' => [Rule::date()->format(self::FORMAT)],
        ];
    }

    public function getCarbonByName(string $name) :?Carbon
    {
        return $this->filled($name) ? Carbon::createFromFormat(self::FORMAT, $this->{$name}) : null;
    }
}
