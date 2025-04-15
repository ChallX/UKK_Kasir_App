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
                'members.PoinToBeUsed',
                'members.StoredPoin',
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

        $sheet->setCellValue('A1', 'Data Penjualan Kasir Pure Cart');

        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $headers = [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan Yang Bisa Digunakan',
            'Poin Pelanggan Yang Tersimpan',
            'Produk (Qtyx)',
            'Subtotal Produk',
            'Total Harga',
            'Total Bayar',
            'Total Diskon Poin',
            'Total Kembalian',
            'Tanggal Pembelian'
        ];

        $sheet->fromArray($headers, null, 'A2');

        $row = 3;
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
            $sheet->setCellValue('C' . $row, $first->PoinToBeUsed ?? 0);
            $sheet->setCellValue('D' . $row, $first->StoredPoin ?? 0);
            $sheet->setCellValue('E' . $row, $produkGabung);
            $sheet->setCellValue('F' . $row, $subtotalGabung);
            $sheet->setCellValue('G' . $row, $first->total);
            $sheet->setCellValue('H' . $row, $first->amount_paid);
            $sheet->setCellValue('I' . $row, $first->poin_used ?? 0);
            $sheet->setCellValue('J' . $row, $first->change ?? 0);
            $sheet->setCellValue('K' . $row, $first->created_at);
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
