<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->role === 'admin'; }
    public function rules(): array {
        return [
            'name' => ['required','string','max:120'],
            'category_id' => ['required','exists:categories,id'],
            'price' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'is_active' => ['boolean'],
        ];
    }
}
