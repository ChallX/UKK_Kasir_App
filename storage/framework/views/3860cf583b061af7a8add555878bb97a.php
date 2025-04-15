<?php $__env->startSection('content'); ?>
    <h1 class="text-2xl font-bold mb-10"> Penjualan </h1>

    <div class="border w-[1000px] border-gray-200 rounded p-10">
        <div class="flex justify-between">
            <a href="<?php echo e(route('petugas.penjualan.exportExcel')); ?>"
                class=" text-white bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:ring-blue-200 font-medium rounded-md text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Export
                Penjualan (.xlsx)</a>
            <a href="<?php echo e(route('petugas.penjualan.create')); ?>"
                class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Tambah
                Penjualan</a>
        </div>
        <table id="search-table">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            Nama Pelanggan
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Tanggal Penjualan
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Total Harga
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Dibuat Oleh
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Action
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $penjualans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penjualan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if($penjualan->member): ?>
                            <td><?php echo e($penjualan->member->nama_pelanggan); ?></td>
                        <?php else: ?>
                            <td>NON-MEMBER</td>
                        <?php endif; ?>
                        <td><?php echo e($penjualan->created_at); ?></td>
                        <td>Rp<?php echo e($penjualan->total); ?></td>
                        <td><?php echo e($penjualan->user->name); ?></td>
                        <td>
                            <button type="button" data-modal-target="default-modal-<?php echo e($penjualan->id); ?>"
                                data-modal-toggle="default-modal-<?php echo e($penjualan->id); ?>"
                                class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Lihat</button>
                            <a href="<?php echo e(route('petugas.penjualan.printPDF', $penjualan->id )); ?>"
                                class="text-black bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                Unduh Bukti
                            </a>
                        </td>
                    </tr>

                    <!-- Main modal -->
                    <div id="default-modal-<?php echo e($penjualan->id); ?>" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-3xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Detail Penjualan
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="default-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <?php if($penjualan->member): ?>
                                        <div class="flex justify-between">
                                            <div class="text-sm">
                                                <p>Member Status : <?php echo e($penjualan->member->status_member); ?></p>
                                                <p>No Hp : <?php echo e($penjualan->member->no_telp); ?></p>
                                                <p>Poin : <?php echo e($penjualan->member->poin); ?></p>
                                            </div>
                                            <div class="text-sm">
                                                <p>Bergabung Sejak : <?php echo e($penjualan->member->created_at); ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="mt-4">
                                        <div class="grid grid-cols-4 font-semibold border-b pb-2 mb-2">
                                            <p>Nama Produk</p>
                                            <p>Qty</p>
                                            <p>Harga</p>
                                            <p>Subtotal</p>
                                        </div>
                                        <?php $__currentLoopData = $penjualan->penjualanDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="grid grid-cols-4 py-2 border-b text-sm">
                                                <p><?php echo e($product->product->nama_product); ?></p>
                                                <p><?php echo e($product->qty); ?></p>
                                                <p>Rp<?php echo e(number_format($product->product->harga, 0, ',', '.')); ?></p>
                                                <p>Rp<?php echo e(number_format($product->subtotal, 0, ',', '.')); ?></p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex">
                                            <p class="ml-auto font-bold text-lg">Total : Rp<?php echo e($penjualan->totalafterpoin); ?>

                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <p>Dibuat pada: <?php echo e($penjualan->created_at); ?></p>
                                            <p>Oleh: <?php echo e($penjualan->user->name); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\UKK_Kasir_App\resources\views\staff\sales\index.blade.php ENDPATH**/ ?>