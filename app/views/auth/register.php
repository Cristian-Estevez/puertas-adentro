<div class="relative flex size-full min-h-screen flex-col overflow-x-hidden">
    <div class="flex flex-col lg:flex-row h-full grow">

        <!-- Panel izquierdo (formulario) -->
        <div class="lg:w-1/2 flex flex-col justify-center items-center p-8 relative">

            <!-- Abejita flotando -->
            <?php include __DIR__ . '/../partials/decorative-bee.php'; ?>

            <div class="max-w-md w-full">
                <div class="flex items-center gap-4 text-gray-800 mb-8 justify-center">
                    <div class="size-10 rounded-md flex items-center justify-center"
                        style="background:linear-gradient(135deg,var(--primary-blue) 50%,var(--accent-yellow) 50%);">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2a10 10 0 100 20 10 10 0 000-20z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight text-[var(--primary-blue)]">Puertas Adentro</h2>
                </div>

                <form
                    class="bg-gray-50 p-8 rounded-xl shadow-lg border border-gray-200"
                    method="POST"
                    action="<?= $this->url('register') ?>">
                    <h2 class="text-2xl font-bold text-center mb-1 text-gray-900">Crea tu cuenta</h2>
                    <p class="text-gray-600 text-center mb-6">¡Bienvenido! Completá los datos para registrarte.</p>

                    <?php if (!empty($errors)): ?>
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-red-500">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $this->escape($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                for="first_name">
                                Nombre
                            </label>
                            <input
                                class="form-input bg-white border-gray-300 text-gray-900 block w-full py-3 rounded-md focus:ring-[var(--accent-yellow)] focus:border-[var(--accent-yellow)] sm:text-sm"
                                id="first_name"
                                name="first_name"
                                placeholder="nombre"
                                type="text" />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                for="last_name">
                                Apellido
                            </label>
                            <input
                                class="form-input bg-white border-gray-300 text-gray-900 block w-full py-3 rounded-md focus:ring-[var(--accent-yellow)] focus:border-[var(--accent-yellow)] sm:text-sm"
                                id="last_name"
                                name="last_name"
                                placeholder="Apellido"
                                type="text" />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                for="username">
                                Nombre de usuario
                            </label>
                            <input
                                class="form-input bg-white border-gray-300 text-gray-900 block w-full py-3 rounded-md focus:ring-[var(--accent-yellow)] focus:border-[var(--accent-yellow)] sm:text-sm"
                                id="username"
                                name="username"
                                placeholder="usuario123"
                                type="text" />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                for="email">
                                Correo electrónico
                            </label>
                            <input
                                class="form-input bg-white border-gray-300 text-gray-900 block w-full py-3 rounded-md focus:ring-[var(--accent-yellow)] focus:border-[var(--accent-yellow)] sm:text-sm"
                                id="email"
                                name="email"
                                placeholder="tu@ejemplo.com"
                                type="email" />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                for="confirm_email">
                                Repetir correo
                            </label>
                            <input
                                class="form-input bg-white border-gray-300 text-gray-900 block w-full py-3 rounded-md focus:ring-[var(--accent-yellow)] focus:border-[var(--accent-yellow)] sm:text-sm"
                                id="confirm_email"
                                name="confirm_email"
                                placeholder="Reingresá tu correo"
                                type="email" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700"
                                for="password">
                                Contraseña
                            </label>
                            <input
                                class="form-input bg-white border-gray-300 text-gray-900 block w-full py-3 rounded-md focus:ring-[var(--accent-yellow)] focus:border-[var(--accent-yellow)] sm:text-sm"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                type="password" />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                for="confirm_password">
                                Repetir contraseña
                            </label>
                            <input
                                class="form-input bg-white border-gray-300 text-gray-900 block w-full py-3 rounded-md focus:ring-[var(--accent-yellow)] focus:border-[var(--accent-yellow)] sm:text-sm"
                                id="confirm_password"
                                name="confirm_password"
                                placeholder="••••••••"
                                type="password" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="text-sm text-[var(--primary-blue)] hover:text-[var(--accent-yellow)]" href="<?= $this->url('login') ?>">¿Olvidaste tu contraseña?</a>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[var(--primary-blue)] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--accent-yellow)]">
                            Registrarme
                        </button>
                    </div>
                </form>

                <p class="mt-8 text-center text-sm text-gray-600">
                    ¿Ya tenés cuenta?
                    <a class="font-medium text-[var(--primary-blue)] hover:text-[var(--accent-yellow)]" href="<?= $this->url('login') ?>">Iniciá sesión</a>
                </p>
            </div>
        </div>

        <!-- Panel derecho (imagen de fondo) -->
        <div class="hidden lg:block lg:basis-7/12 relative">
            <img src="<?= $this->asset('images/porton_cerrado.png') ?>"
                alt="Puerta abierta"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-[var(--primary-blue)]/60"></div>
        </div>

    </div>
</div>