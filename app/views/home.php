<header class="bg-white border-b border-gray-200">
    <div class="mx-auto max-w-6xl px-6 py-3 flex items-center justify-between">
        <!-- LOGO -->
        <div class="flex items-center gap-3">
            <div class="size-6 text-blue-600 relative rounded-sm brand-dot">
                <svg class="absolute inset-0 text-blue-600" fill="currentColor" viewBox="0 0 48 48" aria-hidden="true">
                    <path clip-rule="evenodd" d="M24 4H42V17.3333V30.6667H24V44H6V30.6667V17.3333H24V4Z" fill-rule="evenodd" />
                </svg>
            </div>
            <h2 class="text-xl font-bold tracking-tight">Portal del Barrio</h2>
        </div>

        <!-- AVATAR + LOGOUT -->
        <div class="flex items-center gap-4 ml-auto">
            <div id="avatarWrapper" class="relative">
                <div
                    id="avatarImg"
                    class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 ring-2 ring-yellow-400 cursor-pointer"
                    style='background-image:url("https://cdn-icons-png.flaticon.com/512/3135/3135715.png");'>
                </div>

                <!-- Menú de selección de avatar -->
                <div
                    id="avatarMenu"
                    class="hidden absolute right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg p-2 w-56 z-50">
                    
                    <h4 class="font-semibold text-sm mb-1">Administrador</h4>
                    <p class="text-sm"><?= $user['first_name'] ?> <?= $user['last_name'] ?></p>
                    <button onclick="window.location.href='/'"
                        class="text-blue-700 text-sm hover:underline">
                        Ir al panel de administración
                    </button>
                    <p class="text-xs font-medium mb-2 text-center text-gray-500">Elegir avatar</p>
                    <div class="flex justify-around">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Hombre"
                            class="w-10 h-10 rounded-full cursor-pointer hover:ring-2 ring-blue-500 avatar-option"
                            data-src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
                        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140047.png" alt="Mujer"
                            class="w-10 h-10 rounded-full cursor-pointer hover:ring-2 ring-pink-500 avatar-option"
                            data-src="https://cdn-icons-png.flaticon.com/512/4140/4140047.png">
                    </div>
                </div>
            </div>

            <!-- Botón cerrar sesión -->
            <?php include __DIR__ . '/partials/logout-button.php'; ?>
        </div>
    </div>
</header>

<!-- 🔸 MAIN -->
<main class="flex-1">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">

        <!-- ENCABEZADO -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h1 class="text-3xl font-bold tracking-tight">Últimas novedades del barrio</h1>
        </div>


        <!-- TARJETAS DE NOTICIAS -->
        <section class="space-y-6">
            <?php foreach ($posts as $post): ?>
                <article class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start gap-4">
                            <img class="size-12 rounded-full" alt="Avatar" src="<?= $post['author']['image_url'] ?? '' ?>" />
                            <div class="flex-1">
                                <h3 class="text-base font-semibold"><?= $post['title'] ?></h3>
                                <p class="text-sm text-gray-500">Publicado por <?= $post['author']['username'] ?> · <?= $post['updated_at_es']; ?></p>
                                <p class="mt-2 text-sm"><?= $post['body'] ?? '' ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="px-4">
                        <img class="w-full rounded-lg" alt="Imagen de la publicación" src="<?= $post['image_url'] ?? '' ?>" />
                    </div>

                    <div class="flex items-center gap-4 px-4 py-2">
                        <button class="flex items-center gap-1.5 text-gray-400 hover:text-red-500" title="Me gusta">
                            <span class="material-symbols-outlined text-xl">favorite_border</span>
                            <span class="text-sm font-medium">23</span>
                        </button>
                        <button class="flex items-center gap-1.5 text-gray-400 hover:text-blue-600" title="Comentarios">
                            <span class="material-symbols-outlined text-xl">chat_bubble_outline</span>
                            <span class="text-sm font-medium">5</span>
                        </button>
                    </div>

                    <!-- 🔹 Sección de comentarios (preparada para backend) -->
                    <div class="border-t border-gray-100 px-4 py-3 space-y-3">
                        <?php foreach ($post['comments'] as $comment): ?>
                            <div class="flex items-start gap-3">
                                <img class="w-8 h-8 rounded-full" alt="Avatar"
                                    src="<?= $comment['author']['image_url'] ?? 'https://cdn-icons-png.flaticon.com/512/1946/1946429.png' ?>" />
                                <div class="flex-1 bg-gray-50 border border-gray-100 rounded-md p-2">
                                    <p class="text-sm font-semibold text-gray-800">
                                        <?= $comment['author']['name'] ?? 'Usuario' ?>
                                        <span class="text-xs text-gray-400 ml-1">hace 1 día</span>
                                    </p>
                                    <p class="text-sm text-gray-700"><?= $comment['text'] ?? '' ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </div>
</main>

<!-- 🔹 SCRIPTS -->
<script>
    /* ===== AVATAR PERSONALIZABLE ===== */
    const avatarWrapper = document.getElementById('avatarWrapper');
    const avatarImg = document.getElementById('avatarImg');
    const avatarMenu = document.getElementById('avatarMenu');

    const savedAvatar = localStorage.getItem('selectedAvatar');
    if (savedAvatar) avatarImg.style.backgroundImage = `url('${savedAvatar}')`;

    avatarImg.addEventListener('click', () => avatarMenu.classList.toggle('hidden'));
    document.querySelectorAll('.avatar-option').forEach(option => {
        option.addEventListener('click', () => {
            const src = option.dataset.src;
            avatarImg.style.backgroundImage = `url('${src}')`;
            localStorage.setItem('selectedAvatar', src);
            avatarMenu.classList.add('hidden');
        });
    });
    document.addEventListener('click', e => {
        if (!avatarWrapper.contains(e.target)) avatarMenu.classList.add('hidden');
    });

    /* ===== CERRAR SESIÓN ===== */
    document.getElementById("logoutBtn")?.addEventListener("click", () => {
        localStorage.clear();
        sessionStorage.clear();
        document.cookie.split(";").forEach(c => {
            const [name] = c.split("=");
            if (name && name.trim())
                document.cookie = name.trim() + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
        });
        window.location.href = "login.php";
    });
</script>