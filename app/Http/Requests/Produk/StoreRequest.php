<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_produk' => 'required|string|max:255',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
            'stok'        => 'required|numeric',
        ];
    }
}