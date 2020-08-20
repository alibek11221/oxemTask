<?php

namespace App\Http\Requests;

use App\Rules\OrderDirections;
use App\Rules\ProductsOrder;
use Illuminate\Foundation\Http\FormRequest;

class ProductsIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderby'   => [new ProductsOrder()],
            'direction' => [new OrderDirections()],
        ];
    }
}
