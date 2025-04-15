<?php $__env->startSection('content'); ?>
    <h1 class="text-2xl font-bold mb-10">Penjualan</h1>

    <form action="<?php echo e(route('petugas.penjualan.checkout')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="border gap-4 w-[1000px] border-gray-200 grid grid-cols-3 justify-end rounded p-10">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border border-gray-200 rounded p-4 flex items-center justify-center text-center">
                    <div>
                        <img class="rounded-md mb-2 mx-auto" width="200" height="100"
                            src="<?php echo e(asset('storage/produk/' . $product->image)); ?>" alt="">
                        <p class="text-gray-500 font-semibold"><?php echo e($product->nama_product); ?></p>
                        <p class="text-sm text-gray-400 font-semibold">Stok : 
                            <span id="stok-<?php echo e($product->id); ?>"><?php echo e($product->stock); ?></span>
                        </p>
                        <p class="font-bold text-gray-500"><?php echo e($product->harga); ?></p>

                        <div class="flex text-gray-500 font-semibold gap-2 justify-center items-center mt-2">
                            <button type="button" onclick="decreaseQty(<?php echo e($product->id); ?>)">-</button>
                            <p id="qty-<?php echo e($product->id); ?>">0</p>
                            <button type="button" onclick="increaseQty(<?php echo e($product->id); ?>, <?php echo e($product->stock); ?>)">+</button>
                        </div>

                        <input type="hidden" name="produk[<?php echo e($product->id); ?>]" id="input-qty-<?php echo e($product->id); ?>" value="0">
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="flex justify-center mt-10">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Selanjutnya
            </button>
        </div>
    </form>

    <script>
        function increaseQty(id, stok) {
            const qtyEl = document.getElementById(`qty-${id}`);
            const inputQtyEl = document.getElementById(`input-qty-${id}`);
            let currentQty = parseInt(qtyEl.innerText);

            if (currentQty < stok) {
                currentQty += 1;
                qtyEl.innerText = currentQty;
                inputQtyEl.value = currentQty;
            } else {
                alert('Stok Barang Habis');
            }
        }

        function decreaseQty(id) {
            const qtyEl = document.getElementById(`qty-${id}`);
            const inputQtyEl = document.getElementById(`input-qty-${id}`);
            let currentQty = parseInt(qtyEl.innerText);

            if (currentQty > 0) {
                currentQty -= 1;
                qtyEl.innerText = currentQty;
                inputQtyEl.value = currentQty;
            } else {
                alert('Minimal pembelian adalah 1');
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\UKK_Kasir_App\resources\views/staff/sales/create.blade.php ENDPATH**/ ?>