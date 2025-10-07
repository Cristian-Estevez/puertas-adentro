<div class="relative flex min-h-screen flex-col overflow-x-hidden">
  <!-- HEADER -->
  <header class="bg-white border-b border-[var(--border)]">
    <div class="mx-auto max-w-6xl px-6 py-3 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="size-6 text-[var(--primary-blue)] relative rounded-sm brand-dot">
          <svg class="absolute inset-0 text-[var(--primary-blue)]" fill="currentColor" viewBox="0 0 48 48" aria-hidden="true">
            <path clip-rule="evenodd" d="M24 4H42V17.3333V30.6667H24V44H6V30.6667V17.3333H24V4Z" fill-rule="evenodd" />
          </svg>
        </div>
        <h2 class="text-xl font-bold tracking-tight">Portal del Barrio</h2>
      </div>
      <!-- Solo avatar -->
      <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 ring-2 ring-[var(--accent-yellow)]"
        style='background-image:url("https://lh3.googleusercontent.com/aida-public/AB6AXuA1QRsUPYSYbswP98UjaiyEPnVk55Do2VHhd0tgMMhilI0G7q7M9g3BQ1Q1O48BUkFc2Ab07qePBVLlzKerFvzEMvDoxYlbiMx_GCbkNZCfda-GGevsw0-Tvbt5JcBTLiKzrDGEtg6XFgUFH7KFAyXaUMBPRd_48aIkAx-wLCYOJkd9L5NWQWAuDAqINmI7fUwvZAMnQ06xEf2T2LAlKIwcoQyHMwrZ2EdhdobGWiHQNPRzGmA6TeYXm3xqIp5TweU_jhHT5eQApds");'>
      </div>
    </div>
  </header>

  <!-- MAIN -->
  <main class="flex-1">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-3xl font-bold tracking-tight">Últimas novedades del barrio</h1>
        <button class="btn-primary inline-flex items-center gap-2 h-10 px-4 rounded-md text-sm font-medium shadow-sm">
          <span class="material-symbols-outlined">add</span>
          <span>Crear noticia</span>
        </button>
      </div>

      <!-- Buscador -->
      <div class="mb-6">
        <div class="relative">
          <span class="material-symbols-outlined pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[var(--muted)]">search</span>
          <input class="search w-full rounded-md border border-[var(--border)] bg-white py-2 pl-10 pr-4 placeholder:text-[var(--muted)]"
            placeholder="Buscar por autor, título o contenido" />
        </div>
      </div>

      <!-- Único filtro -->
      <div class="mb-6">
        <button class="btn-chip chip-primary">Todas las novedades</button>
      </div>

      <!-- Tarjeta -->
      <section class="space-y-6">
        <?php foreach ($posts as $post): ?>
          <article class="card">
            <div class="p-4">
              <div class="flex items-start gap-4">
                <img class="size-12 rounded-full" alt="Avatar" src="<?= $post['author']['image_base64'] ?? '' ?>" />
                <div class="flex-1">
                  <h3 class="text-base font-semibold"><?= $post['title'] ?></h3>
                  <p class="text-sm text-[var(--muted)]">Publicado por <?= $post['created_by'] ?> · hace 2 días</p>
                  <p class="mt-2 text-sm">
                    <?= $post['body'] ?? '' ?>
                  </p>
                </div>
                <button class="text-[var(--muted)] hover:text-[var(--text)]" title="Más opciones">
                  <span class="material-symbols-outlined">more_vert</span>
                </button>
              </div>
            </div>
            <div class="px-4">
              <img class="w-full rounded-lg" alt="Imagen de la publicación"
                src="<?= $post['image_base64'] ?? '' ?>" />
            </div>
            <div class="flex items-center gap-4 px-4 py-2">
              <button class="flex items-center gap-1.5 text-[var(--muted)] hover:text-red-500" title="Me gusta">
                <span class="material-symbols-outlined text-xl">favorite_border</span>
                <span class="text-sm font-medium">23</span>
              </button>
              <button class="flex items-center gap-1.5 text-[var(--muted)] hover:text-[var(--primary-blue)]" title="Comentarios">
                <span class="material-symbols-outlined text-xl">chat_bubble_outline</span>
                <span class="text-sm font-medium">5</span>
              </button>
            </div>
            <?php foreach ($post['comments'] as $comment): ?>
              <div class="divider"></div>
              <div class="p-4">
                <div class="flex items-start gap-3">
                  <img class="size-8 rounded-full" alt="Avatar"
                    src="<?= $comment['author']['image_base64'] ?? '' ?>" />
                  <div class="flex-1">
                    <div class="flex items-baseline gap-2">
                      <p class="text-sm font-semibold"><?= $comment['autor']['image_bse64'] ?? '' ?></p>
                      <p class="text-xs text-[var(--muted)]">hace 1 día</p>
                    </div>
                    <p class="text-sm"><?= $comment['text'] ?? '' ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </article>
        <?php endforeach; ?>
      </section>
    </div>
  </main>
</div>