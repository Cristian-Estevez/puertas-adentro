<div class="relative flex min-h-screen flex-col justify-center overflow-hidden py-10">
    <!-- Onda decorativa amarilla inferior -->
    <svg class="pointer-events-none absolute bottom-0 left-0 w-full h-28" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,160 C240,120 480,200 720,160 C960,120 1200,40 1440,90 L1440,200 L0,200 Z" fill="var(--accent-yellow)"></path>
    </svg>

    <div class="relative mx-auto w-full max-w-lg">
        <div class="relative rounded-xl bg-white px-6 pb-8 pt-10 shadow-xl ring-1 ring-gray-900/5 sm:px-10 overflow-visible">
            <!-- Abejita flotando dentro de la tarjeta -->
            <?php include __DIR__ . '/../partials/decorative-bee.php'; ?>

            <div class="mx-auto max-w-md text-center">
                <!-- mini logo -->
                <div class="mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-md"
                    style="background:linear-gradient(135deg,var(--primary-blue) 50%,var(--accent-yellow) 50%);">
                    <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                </div>

                <h1 class="text-xl font-bold text-[var(--primary-blue)]">Puertas Adentro</h1>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900">¿Olvidaste tu contraseña?</h2>
                <p class="mt-2 text-gray-600">No te preocupes, te enviaremos instrucciones para recuperarla.</p>
            </div>

            <form id="forgotForm" class="mx-auto mt-8 max-w-md space-y-6" method="post" action="<?= $this->url('forgot-password') ?>">
                <?php if (!empty($errors)): ?>
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-red-500">
                            <?php foreach ($errors as $error): ?>
                                <li><?= $this->escape($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div>
                        <p class="mb-4 list-disc list-inside text-green-600">Contraseña actualizada correctamente.</p>
                        <p class="font-semibold text-[var(--primary-blue)] hover:text-[#0b3c86]">Volver al <a href="<?= $this->url('login') ?>">Login
                            </a></p>
                    </div>
                <?php else: ?>
                    <div>
                        <label for="login" class="block text-sm font-medium text-gray-700">Usuario o Email</label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            value="<?= $this->escape($oldLogin ?? '') ?>"
                            required
                            autocomplete="username"
                            placeholder="tu@ejemplo.com"
                            class="form-input block w-full rounded-md border-gray-300 shadow-sm
                          focus:border-[var(--accent-yellow)] focus:ring-[var(--accent-yellow)]
                          sm:text-sm h-12 px-4" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="••••••••"
                            class="form-input block w-full rounded-md border-gray-300 shadow-sm
                          focus:border-[var(--accent-yellow)] focus:ring-[var(--accent-yellow)]
                          sm:text-sm h-12 px-4" />
                    </div>

                    <button id="submitBtn" type="submit"
                        class="flex w-full justify-center rounded-md bg-[var(--primary-blue)] px-4 py-3
                         text-sm font-semibold text-white shadow-sm
                         hover:bg-[#0b3c86] focus-visible:outline focus-visible:outline-2
                         focus-visible:outline-offset-2 focus-visible:outline-[var(--accent-yellow)]">
                        Restablecer contraseña
                    </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-500">
                ¿Recordaste tu contraseña?
                <a class="font-semibold text-[var(--primary-blue)] hover:text-[#0b3c86]" href="<?= $this->url('login') ?>">Inicia sesión aquí</a>
            </p>
        <?php endif; ?>

        </div>
    </div>
</div>