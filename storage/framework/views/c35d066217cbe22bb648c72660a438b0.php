<!-- component -->
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8f4f3]">
            <div>
                <a href="/">
                    <h2 class="font-bold text-3xl">PURE <span
                            class="bg-green-500 text-white px-2 rounded-md">CART</span></h2>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form action="<?php echo e(route('loginHandle')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="py-8">
                        <center>
                            <span class="text-2xl font-semibold">Log In</span>
                        </center>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="email" value="Email" />
                        <input type='email' name='email' placeholder='Email'
                            class="w-full rounded-md py-2.5 px-4 border text-sm outline-green-500" />
                    </div>


                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700" for="password" value="Password" />
                        <div class="relative">
                            <input id="password" type="password" name="password" placeholder="Password" required
                                autocomplete="current-password"
                                class = 'w-full rounded-md py-2.5 px-4 border text-sm outline-green-500'>

                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                <button type="button" id="togglePassword"
                                    class="text-gray-500 focus:outline-none focus:text-gray-600 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"
                                        style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                        <path
                                            d="M12 4.998c-1.836 0-3.356.389-4.617.971L3.707 2.293 2.293 3.707l3.315 3.316c-2.613 1.952-3.543 4.618-3.557 4.66l-.105.316.105.316C2.073 12.382 4.367 19 12 19c1.835 0 3.354-.389 4.615-.971l3.678 3.678 1.414-1.414-3.317-3.317c2.614-1.952 3.545-4.618 3.559-4.66l.105-.316-.105-.316c-.022-.068-2.316-6.686-9.949-6.686zM4.074 12c.103-.236.274-.586.521-.989l5.867 5.867C6.249 16.23 4.523 13.035 4.074 12zm9.247 4.907-7.48-7.481a8.138 8.138 0 0 1 1.188-.982l8.055 8.054a8.835 8.835 0 0 1-1.763.409zm3.648-1.352-1.541-1.541c.354-.596.572-1.28.572-2.015 0-.474-.099-.924-.255-1.349A.983.983 0 0 1 15 11a1 1 0 0 1-1-1c0-.439.288-.802.682-.936A3.97 3.97 0 0 0 12 7.999c-.735 0-1.419.218-2.015.572l-1.07-1.07A9.292 9.292 0 0 1 12 6.998c5.351 0 7.425 3.847 7.926 5a8.573 8.573 0 0 1-2.957 3.557z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button
                            class = 'ms-4 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>
                            Sign In
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?php echo e(session('success')); ?>',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '<?php echo e(session('error')); ?>',
                showConfirmButton: true
            });
        </script>
    <?php endif; ?>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    </script>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\UKK_Kasir_App\resources\views/auth/login.blade.php ENDPATH**/ ?>