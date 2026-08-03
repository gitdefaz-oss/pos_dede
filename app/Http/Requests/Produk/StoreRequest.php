<?php

namespace App\Http\Requests\Produk;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    { 
        return [
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name'           => 'required|string|max:255',
            'purchase_price' => 'required|integer|min:0',
            'selling_price'  => 'required|integer|min:0',
            'stock'          => 'required|integer|min:0',
        ];
    }

    /**
     * Custom message for validation errors.
     */
    public function messages(): array
    {
        return [
            'foto.image'             => 'File yang diupload harus gambar.',
            'foto.mimes'             => 'Ekstensi gambar harus JPG, JPEG, PNG.',
            'foto.max'               => 'Maksimal ukuran gambar 2MB.',
            'name.required'          => 'Nama wajib diisi.',
            'purchase_price.required'=> 'Harga beli wajib diisi.',
            'purchase_price.integer' => 'Harga beli harus diisi angka.',
            'selling_price.required' => 'Harga jual wajib diisi.',
            'selling_price.integer'  => 'Harga jual harus diisi angka.',
            'stock.required'         => 'Stok wajib diisi.',
            'stock.integer'          => 'Stok harus diisi angka.',
        ];
    }
}