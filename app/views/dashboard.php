<!-- 🔹 HEADER PRINCIPAL -->
<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- LOGO -->
        <div class="flex items-center gap-3">
            <img src="https://cdn-icons-png.flaticon.com/512/561/561127.png"
                alt="Logo Puertas Adentro" class="size-8">
            <h1 class="text-lg font-bold text-blue-800 tracking-tight">
                Administración Puertas Adentro
            </h1>
        </div>

        <!-- Usuario admin + Panel -->
        <div class="relative flex items-center gap-4">
            <div id="avatarContainer" class="relative">
                <div id="avatarImg"
                    class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 ring-2 ring-blue-500 cursor-pointer"
                    style='background-image:url("https://cdn-icons-png.flaticon.com/512/3135/3135715.png");'>
                </div>

                <!-- Panel emergente -->
                <div id="adminPanel"
                    class="hidden absolute right-0 mt-3 w-64 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-50">
                    <h4 class="font-semibold text-sm mb-1">Administrador</h4>
                    <p class="text-sm">Emanuel García</p>
                    <p class="text-xs text-gray-500 mb-3">Último acceso: hoy 21:47</p>
                    <button onclick="window.location.href='../home.php'"
                        class="text-blue-700 text-sm hover:underline">
                        Ir al portal público
                    </button>
                </div>
            </div>

            <!-- Botón logout -->
            <?php include __DIR__ . '/partials/logout-button.php'; ?>
        </div>
    </div>
</header>


<!-- 🔸 CONTENIDO PRINCIPAL -->
<main id="mainContent" class="flex-1 px-6 py-8 max-w-7xl mx-auto space-y-10">
    
    <section id="inicio">
        <h2 class="text-xl font-semibold mb-6">Resumen general</h2>
        
        <!-- Tarjetas resumen -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <p class="text-sm text-gray-500">Noticias publicadas</p>
                <h3 class="text-2xl font-bold text-blue-700"><?php echo count($posts); ?></h3>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <p class="text-sm text-gray-500">Usuarios registrados</p>
                <h3 class="text-2xl font-bold text-green-600"><?php echo count($users); ?></h3>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <p class="text-sm text-gray-500">Comentarios</p>
                <h3 class="text-2xl font-bold text-gray-600"><?php echo count($comments); ?></h3>
            </div>
        </div>
    </section>

    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 py-2 flex items-center gap-6 text-sm font-medium">
            <button class="nav-tab text-blue-700 border-b-2 border-blue-700 pb-2" data-section="usuarios">Usuarios</button>
            <button class="nav-tab text-gray-600 hover:text-blue-700 pb-2" data-section="posts">Noticias</button>
        </div>
    </nav>

    <section id="usuarios" class="section">
        <h2 class="text-xl font-semibold mb-6">Usuarios registrados</h2>
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Usuario</th>
                        <th class="px-4 py-2">Correo</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Apellido</th>
                        <th class="px-4 py-2 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-4 py-2"><?= $user['username'] ?></td>
                            <td class="px-4 py-2"><?= $user['email'] ?></td>
                            <td class="px-4 py-2"><?= $user['first_name'] ?></td>
                            <td class="px-4 py-2"><?= $user['last_name'] ?></td>
                            <td class="px-4 py-2 text-right">
                                <button class="text-red-600 hover:underline delete-user">Borrar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section id="posts" class="section hidden">
        <h2 class="text-xl font-semibold mb-6">Posts publicados</h2>
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Autor</th>
                        <th class="px-4 py-2">Título</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody id="postsTable">
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td class="px-4 py-2"><?= $post['first_name'] ?> <?= $post['last_name'] ?></td>
                            <td class="px-4 py-2"><?= $post['title'] ?></td>
                            <td class="px-4 py-2"><?= $post['updated_at'] ?></td>
                            <td class="px-4 py-2 text-right">
                                <button class="text-blue-600 hover:underline mr-3">Ver</button>
                                <button class="text-red-600 hover:underline delete-post">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script>
    // Mostrar / ocultar panel admin
    const avatar = document.getElementById("avatarImg");
    const panel = document.getElementById("adminPanel");
    avatar.addEventListener("click", () => {
        panel.classList.toggle("hidden");
    });
    document.addEventListener("click", (e) => {
        if (!avatar.contains(e.target) && !panel.contains(e.target)) {
            panel.classList.add("hidden");
        }
    });

    // Tabs navegación
    document.querySelectorAll(".nav-tab").forEach(tab => {
        tab.addEventListener("click", () => {
            document.querySelectorAll(".section").forEach(sec => sec.classList.add("hidden"));
            document.getElementById(tab.dataset.section).classList.remove("hidden");
            document.querySelectorAll(".nav-tab").forEach(t => t.classList.remove("text-blue-700", "border-blue-700", "border-b-2"));
            tab.classList.add("text-blue-700", "border-blue-700", "border-b-2");
        });
    });

    // Eliminar usuario
    document.querySelectorAll(".delete-user").forEach(btn => {
        btn.addEventListener("click", e => e.target.closest("tr").remove());
    });

    // Eliminar post
    document.querySelectorAll(".delete-post").forEach(btn => {
        btn.addEventListener("click", e => e.target.closest("tr").remove());
    });
</script>