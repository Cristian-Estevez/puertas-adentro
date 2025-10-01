<div class="relative flex min-h-screen flex-col justify-center overflow-hidden py-10">
  <svg class="pointer-events-none absolute bottom-0 left-0 w-full h-28" viewBox="0 0 1440 200" preserveAspectRatio="none">
    <path d="M0,160 C240,120 480,200 720,160 C960,120 1200,40 1440,90 L1440,200 L0,200 Z" fill="var(--accent-yellow)"></path>
  </svg>

  <div class="relative mx-auto w-full max-w-lg">
    <div class="relative rounded-xl bg-white px-6 pb-8 pt-10 shadow-xl ring-1 ring-gray-900/5 sm:px-10">

      <?php include __DIR__ . '/../partials/decorative-bee.php'; ?>

      <div class="mx-auto max-w-md text-center">
        <h1 class="text-xl font-bold text-[var(--primary-blue)]">Puertas Adentro</h1>
        <h2 class="mt-2 text-3xl font-extrabold text-gray-900">¿Olvidaste tu contraseña?</h2>
        <p class="mt-2 text-gray-600">Ingresá tu email y te enviaremos instrucciones.</p>
      </div>

      <form class="mx-auto mt-8 max-w-md space-y-6" method="post" action="#">
        <div>
          <label for="login" class="block text-sm font-medium text-gray-700">Usuario o Email</label>
          <input type="text" id="login" name="login" required placeholder="tu@ejemplo.com"
                 class="form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--accent-yellow)] focus:ring-[var(--accent-yellow)] sm:text-sm h-12 px-4" />
        </div>

        <button type="submit"
                class="w-full py-3 rounded-md bg-[var(--primary-blue)] text-white hover:bg-[var(--accent-yellow)]">
          Restablecer contraseña
        </button>
      </form>

      <p class="mt-8 text-center text-sm text-gray-500">
        ¿Recordaste tu contraseña?
        <a class="font-semibold text-[var(--primary-blue)] hover:text-[var(--accent-yellow)]" href="./login.php">
          Iniciá sesión aquí
        </a>
      </p>
    </div>
  </div>
</div>
