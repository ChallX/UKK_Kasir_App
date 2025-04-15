<?php $__env->startSection('content'); ?>
    <h1 class="text-2xl font-bold mb-10">Penjualan</h1>

    <div class="border w-[1000px] gap-4 bg-gray-200 border-gray-200 rounded p-5">

        <div class="bg-white p-8 rounded">
            <div class="flex mb-5">
                <a href="<?php echo e(route('petugas.penjualan.printPDF' , $penjualan->id)); ?>"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Unduh</a>
                <a href="<?php echo e(route('petugas.penjualan.index')); ?>"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Kembali</a>
            </div>
            <div class="flex justify-between">
                <div class="text-gray-500">
                    <?php if($penjualan->member): ?>
                    <p class="font-bold"><?php echo e($penjualan->member->no_telp); ?></p>
                    <p>Member Sejak : <?php echo e($penjualan->member->created_at); ?></p>
                    <p>Member Poin Tersisa : <?php echo e($penjualan->member->StoredPoin); ?></p>
                    <?php endif; ?>
                </div>
                <div class="text-gray-500">
                    <p>Invoice - #<?php echo e($penjualan->id); ?></p>
                    <p><?php echo e($penjualan->created_at); ?></p>
                </div>
            </div>

            <table class="mt-10 w-full text-sm text-center text-gray-700 border border-collapse border-gray-200">
                <thead class="text-xs text-gray-500 uppercase border-b border-gray-300">
                    <tr>
                        <th scope="col" class="py-3 px-4">Produk</th>
                        <th scope="col" class="py-3 px-4">Harga</th>
                        <th scope="col" class="py-3 px-4">Quantity</th>
                        <th scope="col" class="py-3 px-4">Sub Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php $__currentLoopData = $penjualan_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b border-gray-200">
                            <td class="py-2 px-4"><?php echo e($product->product->nama_product); ?></td>
                            <td class="py-2 px-4">Rp. <?php echo e(number_format($product->product->harga, 0, ',', '.')); ?></td>
                            <td class="py-2 px-4"><?php echo e($product->qty); ?></td>
                            <td class="py-2 px-4">Rp. <?php echo e(number_format($product->subtotal, 0, ',', '.')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="flex justify-between">
                <div class="bg-gray-200 gap-4 w-full p-5">
                    <div class="flex gap-20">
                        <div class="">
                            <p class="text-xs">POIN DIGUNAKAN</p>
                            <p class="font-bold text-lg"><?php echo e($penjualan->poin_used); ?></p>
                        </div>
                        <div class="">
                            <p class="text-xs">KASIR</p>
                            <p class="font-bold text-lg"><?php echo e($penjualan->user->name); ?></p>
                        </div>
                        <div class="">
                            <p class="text-xs">KEMBALIAN</p>
                            <p class="font-bold text-lg"><?php echo e($penjualan->change); ?></p>
                        </div>
                    </div>
    
                </div>
                <div class="bg-black p-5 w-[400px] text-gray-200">
                    <p class="text-xs">TOTAL</p>
                    <p class="text-3xl">Rp<?php echo e($penjualan->totalafterpoin); ?></p>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\UKK_Kasir_App\resources\views\staff\sales\receipt.blade.php ENDPATH**/ ?>