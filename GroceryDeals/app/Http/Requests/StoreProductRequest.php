<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidDiscount;
use App\Models\Product; // Adjust model path if different

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                function ($attribute, $value, $fail) {
                    // MongoDB-compatible unique check — replaces unique:products
                    // Route uses {id} so we use $this->route('id')
                    $query = Product::where('name', $value);

                    $currentId = $this->route('id'); // e.g. /admin/products/{id}
                    if ($currentId) {
                        $query->where('_id', '!=', $currentId);
                    }

                    if ($query->exists()) {
                        $fail('A product with this name already exists.');
                    }
                }
            ],
            'price'          => 'required|numeric|min:0.01',
            'original_price' => 'required|numeric|gte:price',
            'discount'       => ['nullable', 'numeric', 'min:0', new ValidDiscount()],
            'category'       => 'required|in:fruits,vegetables,dairy,bakery,beverages,snacks',
            'stock'          => 'required|integer|min:0',
            // Image is required only on create (when no {id} param present in route)
            'image'          => $this->route('id')
                                    ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                                    : 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description'    => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A product name is essential for listing an item.',
            'original_price.gte' => 'The original price must be greater than or equal to the discounted price.',
            'category.in' => 'Please select a valid product category.',
            'image.required' => 'An image is required when creating a new product.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png, webp.',
        ];
    }
}
