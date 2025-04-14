<?php

namespace App\Http\Controllers;

use App\Models\penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class adminPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = penjualan::with('member', 'penjualanDetails.product', 'user')->get();

        return view('admin.sales.index', compact('penjualans'));
    }


    public function exportExcelPenjualan()
    {
        $data = DB::table('penjualans')
            ->leftJoin('members', 'penjualans.member_id', '=', 'members.id')
            ->join('penjualan_details', 'penjualans.id', '=', 'penjualan_details.penjualan_id')
            ->join('products', 'penjualan_details.product_id', '=', 'products.id')
            ->select(
                'penjualans.id as penjualan_id',
                'members.nama_pelanggan',
                'members.no_telp',
                'members.poin',
                'products.nama_product',
                'penjualan_details.qty',
                'penjualan_details.subtotal',
                'penjualans.total',
                'penjualans.amount_paid',
                'penjualans.poin_used',
                'penjualans.change',
                'penjualans.created_at'
            )
            ->get()
            ->groupBy('penjualan_id');
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        $headers = [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Produk (Qtyx)',
            'Subtotal Produk',
            'Total Harga',
            'Total Bayar',
            'Total Diskon Poin',
            'Total Kembalian',
            'Tanggal Pembelian'
        ];
    
        $sheet->fromArray($headers, null, 'A1');
    
        $row = 2;
        foreach ($data as $penjualan) {
            $first = $penjualan->first();
    
            $produkGabung = $penjualan->map(function ($item) {
                return $item->nama_product . ' ' . $item->qty . 'x';
            })->implode(', ');
    
            $subtotalGabung = $penjualan->map(function ($item) {
                return number_format($item->subtotal, 0, ',', '.');
            })->implode(', ');
    
            $sheet->setCellValue('A' . $row, $first->nama_pelanggan ?? 'Bukan Member');
            $sheet->setCellValue('B' . $row, $first->no_telp ?? '-');
            $sheet->setCellValue('C' . $row, $first->poin ?? 0);
            $sheet->setCellValue('D' . $row, $produkGabung);
            $sheet->setCellValue('E' . $row, $subtotalGabung);
            $sheet->setCellValue('F' . $row, $first->total);
            $sheet->setCellValue('G' . $row, $first->amount_paid);
            $sheet->setCellValue('H' . $row, $first->poin_used ?? 0);
            $sheet->setCellValue('I' . $row, $first->change ?? 0);
            $sheet->setCellValue('J' . $row, $first->created_at);
            $row++;
        }
    
        $writer = new Xlsx($spreadsheet);
        $fileName = 'penjualan.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
    
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function downloadPDF($id)
    {
        $penjualan = penjualan::with(['member', 'penjualanDetails.product', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('staff.sales.pdf', compact('penjualan'))
            ->setPaper('A5', 'portrait');

        return $pdf->download('bukti-pembelian-' . $penjualan->id . '.pdf');
    }
}
