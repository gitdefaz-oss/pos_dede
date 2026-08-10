<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ItemPenjualanController extends Controller
{
    /**
     * Tambah produk ke keranjang.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {
            // Cari transaksi status OPEN milik kasir, buat jika belum ada
            $sale = Penjualan::firstOrCreate(
                ['user_id' => Auth::id(), 'status' => 'OPEN'],
                ['total_pembayaran' => 0, 'metode_pembayaran' => 'CASH']
            );

            $product = Produk::where('id', $request->product_id)->lockForUpdate()->firstOrFail();

            // Cek stok
            if ($product->stok < $request->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok produk tidak mencukupi.'
                ]);
            }

            // Kurangi stok
            $product->decrement('stok', $request->quantity);

            // Cek apakah item sudah ada di keranjang
            $item = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->first();

            if ($item) {
                $item->update([
                    'kuantitas' => $item->kuantitas + $request->quantity,
                    'subtotal'  => ($item->kuantitas + $request->quantity) * $product->harga
                ]);
            } else {
                ItemPenjualan::create([
                    'penjualan_id' => $sale->id,
                    'produk_id'    => $product->id,
                    'kuantitas'    => $request->quantity,
                    'harga_satuan' => $product->harga,
                    'subtotal'     => $request->quantity * $product->harga
                ]);
            }

            // Update total pembayaran transaksi
            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal') ?? 0
            ]);
        });

        return back()->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Update jumlah item di keranjang.
     */
    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request, $itempenjualan) {
            $produk = $itempenjualan->produk()->lockForUpdate()->first();
            $selisih = $request->quantity - $itempenjualan->kuantitas;

            if ($selisih > 0) {
                if ($produk->stok < $selisih) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Stok tidak mencukupi.'
                    ]);
                }
                $produk->decrement('stok', $selisih);
            }

            if ($selisih < 0) {
                $produk->increment('stok', abs($selisih));
            }

            $itempenjualan->update([
                'kuantitas' => $request->quantity,
                'subtotal'  => $request->quantity * $itempenjualan->harga_satuan
            ]);

            $itempenjualan->penjualan->update([
                'total_pembayaran' => $itempenjualan->penjualan->itemPenjualan()->sum('subtotal') ?? 0
            ]);
        });

        return back()->with('success', 'Jumlah item berhasil diperbarui.');
    }

    /**
     * Hapus item dari keranjang.
     */
    public function destroy(ItemPenjualan $itempenjualan)
    {
        DB::transaction(function () use ($itempenjualan) {
            $produk = $itempenjualan->produk;
            $sale   = $itempenjualan->penjualan;

            $produk->increment('stok', $itempenjualan->kuantitas);
            $itempenjualan->delete();

            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal') ?? 0
            ]);
        });

        return back()->with('success', 'Item berhasil dihapus.');
    }
}