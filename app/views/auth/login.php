<div class="flex min-h-screen relative">
  <?php include __DIR__ . '/../partials/decorative-bee.php'; ?>

  <!-- Panel izquierdo con imagen -->
  <div class="hidden lg:block lg:basis-7/12 relative">
    <img src="assets/images/puerta_abierta.png"
         alt="Puerta abierta"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-[var(--primary-blue)]/60"></div>
  </div>

  <!-- Panel derecho -->
  <div class="w-full lg:basis-5/12 flex items-center justify-center p-6 sm:p-12 bg-white">
    <div class="w-full max-w-md">
      <header class="flex flex-col items-center justify-center text-center mb-8">
        <div class="flex items-center gap-3 text-gray-800 mb-4">
          <div class="size-10 rounded-md flex items-center justify-center"
               style="background: linear-gradient(135deg, var(--primary-blue) 50%, var(--accent-yellow) 50%);">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
          </div>
          <h1 class="text-2xl font-bold tracking-tight text-[var(--primary-blue)]">Puertas Adentro</h1>
        </div>
        <h2 class="text-3xl font-bold text-gray-900">¡Bienvenidos!</h2>
        <p class="text-gray-600 mt-2">El portal de tu barrio privado.</p>
      </header>

      <form method="post" action="#">
        <div>
          <label for="login" class="block text-sm font-medium text-gray-700">Usuario o Email</label>
          <input type="text" id="login" name="login" required autocomplete="username"
                 placeholder="tu@ejemplo.com"
                 class="form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--accent-yellow)] focus:ring-[var(--accent-yellow)] sm:text-sm h-12 px-4" />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input id="password" name="password" type="password" required autocomplete="current-password"
                 placeholder="••••••••"
                 class="form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--accent-yellow)] focus:ring-[var(--accent-yellow)] sm:text-sm h-12 px-4" />
        </div>

        <div class="flex items-center justify-end">
          <div class="text-sm">
            <a href="./forgot-password.php"
               class="font-medium text-[var(--primary-blue)] hover:text-[var(--accent-yellow)]">
              ¿Olvidaste tu contraseña?
            </a>
          </div>
        </div>

        <button type="submit"
                class="w-full flex justify-center py-3 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-[var(--primary-blue)] hover:bg-[var(--accent-yellow)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--accent-yellow)]">
          Iniciar sesión
        </button>
      </form>

      <p class="mt-6 text-center text-sm text-gray-600">
        ¿No tenés cuenta?
        <a href="./register.php"
           class="font-medium text-[var(--primary-blue)] hover:text-[var(--accent-yellow)]">
          Registrate aquí
        </a>
      </p>
    </div>
  </div>
</div>
