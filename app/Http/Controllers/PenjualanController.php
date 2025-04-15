<?php

namespace App\Http\Controllers;

use App\Models\member;
use App\Models\penjualan;
use App\Models\penjualan_detail;
use App\Models\product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = penjualan::with('member', 'penjualanDetails.product', 'user')->get();

        return view('staff.sales.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = product::get();
        return view('staff.sales.create', compact('products'));
    }

    public function checkout(Request $request)
    {
        $produkDipilih = $request->input('produk', []);
        $produkDenganQty = [];
        foreach ($produkDipilih as $id => $qty) {
            if ((int) $qty > 0) {
                $produk = product::find($id);
                if ($produk) {
                    $produk->jumlah_dipilih = (int) $qty;
                    $produkDenganQty[] = $produk;
                }
            }
        }
        return view('staff.sales.checkout', compact('produkDenganQty'));
    }

    public function paymentHandle(Request $request)
    {
        $request->validate([
            'total' => 'required',
            'produk' => 'required|array',
            'member' => 'required',
            'no_telp' => 'nullable',
            'amount_paid' => 'required',
        ]);

        $penjualan = penjualan::create([
            'user_id' => Auth::user()->id,
            'total' => $request->total,
            'amount_paid' => $request->amount_paid,
            'change' => $request->amount_paid - $request->total,
        ]);

        foreach ($request->input('produk') as $productData) {
            penjualan_detail::create([
                'penjualan_id' => $penjualan->id,
                'product_id' => $productData['id'],
                'qty' => $productData['jumlah_dipilih'],
                'subtotal' => $productData['subtotal']
            ]);
        }

        if ($request->member == 'member') {
            $member = member::where('no_telp', $request->no_telp)->first();
            $newPoints = $request->total / 100;

            if (!$member) {
                $member = member::create([
                    'status_member' => 'member',
                    'no_telp' => $request->no_telp,
                    'StoredPoin' => $newPoints,
                    'PoinToBeUsed' => 0,
                ]);
            } else {
                $member->increment('StoredPoin', $newPoints);
            }

            $penjualan->update([
                'member_id' => $member->id
            ]);

            session([
                'penjualan_id' => $penjualan->id,
            ]);

            return redirect()->route('petugas.penjualan.memberHandle');
        } else {
            $penjualan->update([
                'totalafterpoin' => $request->total,
                'poin_used' => 0
            ]);

            foreach ($penjualan->penjualanDetails as $detail) {
                $product = $detail->product;
                $product->stock -= $detail->qty;
                $product->save();
            }

            return redirect()->route('petugas.penjualan.receipt', ['id' => $penjualan->id]);
        }
    }

    public function memberHandle(Request $request)
    {
        $penjualan = penjualan::with('member')->findOrFail(session('penjualan_id'));
        $penjualan_details = penjualan_detail::with('product')->where('penjualan_id', $penjualan->id)->get();
        $member = $penjualan->member;

        $totalTransaksi = penjualan::where('member_id', $member->id)->count();
        $isFirstTransaction = $totalTransaksi <= 1;

        return view('staff.sales.member', compact('penjualan', 'penjualan_details', 'member', 'isFirstTransaction'));
    }

    public function memberUpdate(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualans,id',
            'nama_member' => 'required|string|max:255',
            'member_id' => 'required|exists:members,id',
        ]);
    
        $penjualan = Penjualan::with('penjualanDetails.product')->findOrFail($request->penjualan_id);
        $member = Member::findOrFail($request->member_id);
    
        if (empty($member->nama_pelanggan)) {
            $member->update([
                'nama_pelanggan' => $request->nama_member,
            ]);
        }
    
        $totalHarga = (int) $penjualan->total;
        $poinDigunakan = 0;
    
        if ($request->has('gunakan_poin') && $member->PoinToBeUsed > 0) {
            $poinDigunakan = min($member->PoinToBeUsed, $totalHarga);
            $totalHarga -= $poinDigunakan;
    
            $member->PoinToBeUsed -= $poinDigunakan;
            $member->save();
        }
    
        $amountPaid = (int) $penjualan->amount_paid;
        $change = $amountPaid - $totalHarga;
    
        $penjualan->totalafterpoin = $totalHarga;
        $penjualan->change = $change;
        $penjualan->poin_used = $poinDigunakan;
        $penjualan->save();
    
        foreach ($penjualan->penjualanDetails as $detail) {
            $product = $detail->product;
            $product->stock -= $detail->qty;
            $product->save();
        }
    
        $member->PoinToBeUsed += $member->StoredPoin;
        $member->StoredPoin = 0;
        $member->save();
    
        return redirect()->route('petugas.penjualan.receipt', ['id' => $penjualan->id])
            ->with('success', 'Berhasil Membuat Penjualan');
    }

    public function receipt($id)
    {
        $penjualan = penjualan::with('member', 'user')->findOrFail($id);

        $penjualan_detail = penjualan_detail::with('product')->where('penjualan_id', $id)->get();

        return view('staff.sales.receipt', compact('penjualan', 'penjualan_detail'));
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
