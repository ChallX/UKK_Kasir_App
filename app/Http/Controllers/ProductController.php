<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();

        return view('admin.product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_product' => 'required',
            'harga' => 'required',
            'stock' => 'required',
            'gambar_product' => 'required'
        ]);

        $imageName = null;
        if ($request->hasFile('gambar_product')) {
            $image = $request->file('gambar_product');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('produk/', $imageName, 'public');
        }
        product::create([
            'nama_product' => $data['nama_product'],
            'image' => $imageName,
            'harga' => $data['harga'],
            'stock' => $data['stock'],
        ]);

        return redirect()->back()->with('success', 'berhasil membuat product');
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $imageName = $product->image;

        if ($request->hasFile('gambar_product')) {
            // Hapus gambar lama dari storage (jika ada)
            if ($product->gambar_produk && Storage::disk('public')->exists('produk/' . $product->gambar_produk)) {
                Storage::disk('public')->delete('produk/' . $product->gambar_produk);
            }

            // Simpan gambar baru
            $image = $request->file('gambar_product');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('produk/', $imageName, 'public');
        }

        // Update data produk
        $product->update([
            'nama_product' => $request->nama_product,
            'harga' => $request->harga,
            'image' => $imageName,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function updateStock(Request $request, $id) {
        // dd($request->all());

        $product = Product::findOrFail($id);

        $product->update([
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', 'Stok Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product, $id)
    {
        $product =  product::findOrFail($id);

        $product->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Produk');
    }

    public function exportExcel()
    {
        $data = DB::table('products')->select(
            'nama_product',
            'harga',
            'stock',
        )->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Data Produk Kasir Pure Cart');
        
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $headers = [
            'Nama Produk',
            'Harga',
            'Stock'
        ];

        $sheet->fromArray($headers, null, 'A2');

        $row = 3;

        foreach ($data as $d ) {
            $sheet->setCellValue('A' . $row, $d->nama_product ?? 'Produk Tidak Memiliki Nama');
            $sheet->setCellValue('B' . $row, $d->harga ?? '-');
            $sheet->setCellValue('C' . $row, $d->stock ?? '-');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'product.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(),$fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
