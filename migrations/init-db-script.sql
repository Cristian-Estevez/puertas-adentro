-- LIMPIAR (por si algo quedó a medias)
DROP TABLE IF EXISTS likes;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;

-- ===============================
-- USERS
-- ===============================
CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    active BOOLEAN DEFAULT TRUE,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    image_url VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    updated_by BIGINT DEFAULT NULL,
    last_login_at TIMESTAMP NULL,

    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_active (active),
    INDEX idx_role (role),
    INDEX idx_created_at (created_at),

    -- SELF FK: quien actualizó el usuario; si ese usuario se borra, poner NULL
    CONSTRAINT fk_users_updated_by
      FOREIGN KEY (updated_by) REFERENCES users(id)
      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================
-- POSTS
-- ===============================
CREATE TABLE posts (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    image_url VARCHAR(512) DEFAULT NULL,
    created_by BIGINT NOT NULL,
    updated_by BIGINT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    CONSTRAINT fk_posts_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_posts_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================
-- COMMENTS
-- ===============================
CREATE TABLE comments (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(1000) NOT NULL,
    post_id BIGINT NOT NULL,
    created_by BIGINT NOT NULL,
    updated_by BIGINT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    CONSTRAINT fk_comments_post       FOREIGN KEY (post_id)    REFERENCES posts(id)  ON DELETE CASCADE,
    CONSTRAINT fk_comments_created_by FOREIGN KEY (created_by) REFERENCES users(id)  ON DELETE CASCADE,
    CONSTRAINT fk_comments_updated_by FOREIGN KEY (updated_by) REFERENCES users(id)  ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================
-- LIKES
-- ===============================
CREATE TABLE likes (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    post_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    CONSTRAINT fk_likes_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    CONSTRAINT fk_likes_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY uq_likes_post_user (post_id, user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================
-- SEED: USUARIOS
-- (password = "password", bcrypt hash de ejemplo)
-- ===============================

INSERT INTO users (email, first_name, last_name, username, password, active, role, created_at, updated_at, image_url) VALUES
('admin@ejemplo.com',      'David',   'Miller',    'admin',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'admin', NOW(), NOW(), 'https://cdn-icons-png.flaticon.com/128/3135/3135715.png'),
('santiago@ejemplo.com',   'Santiago', 'Wilson',    'santiago', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user',  NOW(), NOW(), 'https://cdn-icons-png.flaticon.com/128/4140/4140037.png'),
('miguel@ejemplo.com',     'Miguel',   'Benítez',   'miguel',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user',  NOW(), NOW(), 'https://cdn-icons-png.flaticon.com/128/4202/4202835.png'),
('sara@ejemplo.com',       'Sara',     'Paredes',   'sara',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user',  NOW(), NOW(), 'https://cdn-icons-png.flaticon.com/128/4140/4140060.png'),
('emma@ejemplo.com',       'Emma',     'Domínguez', 'emma',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user',  NOW(), NOW(), 'https://cdn-icons-png.flaticon.com/128/4139/4139951.png'),
('alex@ejemplo.com',       'Alex',     'Gómez',     'alex',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user',  NOW(), NOW(), 'https://cdn-icons-png.flaticon.com/128/4526/4526437.png'),
('sofia@ejemplo.com',      'Sofía',    'Andrade',   'sofia',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user',  NOW(), NOW(), 'https://cdn-icons-png.flaticon.com/128/3135/3135789.png');

-- ===============================
-- SEED: POSTS
-- ===============================
INSERT INTO posts (title, body, image_url, created_by, updated_by, created_at, updated_at) VALUES
('Paisaje montañoso majestuoso', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla viverra tempor augue, non vehicula nisi. Sed consectetur metus at tellus pharetra, at tristique lorem varius. Proin consequat augue nec nulla tincidunt, at ultricies eros accumsan. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.', 'https://imgs.search.brave.com/92Cwfu0yu96sWWC-SJhvqOoEep1rNeWE6GVpXYlT-UY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvOTQ0/ODEyNTQwL3Bob3Rv/L21vdW50YWluLWxh/bmRzY2FwZS1wb250/YS1kZWxnYWRhLWlz/bGFuZC1hem9yZXMu/anBnP3M9NjEyeDYx/MiZ3PTAmaz0yMCZj/PW1iUzhYNGd0Smtp/M2dHRGpmQzBzRzNy/c3o3RDBubHM1M2Ew/YjRPUFhMbkU9', 2, 2, NOW(), NOW()),

('Sendero de montaña al atardecer', 'Mauris consectetur felis vitae justo tincidunt, at gravida nunc pulvinar. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae. Fusce vehicula consectetur metus, vitae tincidunt nisl ultrices vel. Sed eleifend urna sit amet elit varius, vel tincidunt nisi faucibus. Curabitur at tellus vel nunc tincidunt varius.', 'https://imgs.search.brave.com/c0JBZI4jFk_Z6mMlwaOFceHs0MuvGAU128JAmD0dXec/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMjEw/MTE3NTQ2Mi9waG90/by90cmVra2luZy1w/YXRoLWluLW1vdW50/YWlucy1hdC1zdW1t/ZXItc3Vuc2V0Lmpw/Zz9zPTYxMng2MTIm/dz0wJms9MjAmYz1B/dGRzRnYtUEh6Tkxu/cW1wQXVTZmpFbTBa/TENLWFpvWUo0djZR/RlJLWWs0PQ', 3, 3, NOW(), NOW()),

('Vista de amanecer dorado', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'https://imgs.search.brave.com/tCrdnR4xDG7bov7Rt1UN7ISG-n0gUcwRGGxRn6EP24U/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvNTA2/NDcyMzExL3Bob3Rv/L3N1bnJpc2UuanBn/P3M9NjEyeDYxMiZ3/PTAmaz0yMCZjPVN1/RGVkVTBLT0VlMTlo/ay16RkFWN0N1VW1P/THJ1ZHhxandqTHR6/WTUzRWM9', 4, 4, NOW(), NOW()),

('Panorama montañoso al anochecer', 'Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent.', 'https://imgs.search.brave.com/_MJrm8dYfkZPyftRR22ndLSiL75aX_DHKlJxZ4CWQWQ/rs:fit:0:180:1:0/g:ce/aHR0cHM6Ly90aHVt/YnMuZHJlYW1zdGlt/ZS5jb20vYi9wYW5v/cmFtYS1tb3VudGFp/bi1sYW5kc2NhcGUt/c3Vuc2V0LXNsb3Zh/a2lhLXZyc2F0ZWMt/NDAzNzAyNjIuanBn', 5, 5, NOW(), NOW()),

('Aventura de senderismo en la montaña', 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst. Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat. Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae.', 'https://imgs.search.brave.com/3d0jIdbuBpc5Doi7iX1sNZVRPEfZQFEWXe_qnY5Tgoo/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvMTQ0/MzI4NzM2Mi9waG90/by93b21hbi1oaWtp/bmctaW4tbW91bnRh/aW5zLW9uLXRoZS1i/YWNrZ3JvdW5kLW9m/LWx5c2Vmam9yZGVu/LmpwZz9zPTYxMng2/MTImdz0wJms9MjAm/Yz1LdmpYLTVxY3kw/UTNkTTAzc0JsOENZ/a3Z0RjNnMVpuNzdL/ZDh1SGRPWGxBPQ', 2, 2, NOW(), NOW()),

('Serenidad de atardecer costero', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.', 'https://imgs.search.brave.com/PK4X0Rgr0UHm0NgTftyaElw9OXADjmDH-q7LYD9X1XU/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/cHJlbWl1bS1waG90/by9zY2VuaWMtdmll/dy1zZWEtc3Vuc2V0/XzEwNDg5NDQtOTQz/MDQ0LmpwZz9zZW10/PWFpc19oeWJyaWQm/dz03NDAmcT04MA', 3, 3, NOW(), NOW()),

('Vista del valle al crepúsculo', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus. Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel.', 'https://imgs.search.brave.com/ifalLWkJlqHkD4ZfhnCUw9UdeSAKu2J7DdYaMihSi78/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/cHJlbWl1bS1waG90/by9zY2VuaWMtdmll/dy1sYW5kc2NhcGUt/YWdhaW5zdC1za3kt/c3Vuc2V0XzEwNDg5/NDQtMzAwMDcxMzcu/anBnP3NlbXQ9YWlz/X2h5YnJpZCZ3PTc0/MCZxPTgw', 4, 4, NOW(), NOW()),

('Amanecer sobre las colinas', 'Fusce consequat. Nulla nisl. Nunc nisl. Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum. In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo.', 'https://imgs.search.brave.com/tCrdnR4xDG7bov7Rt1UN7ISG-n0gUcwRGGxRn6EP24U/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvNTA2/NDcyMzExL3Bob3Rv/L3N1bnJpc2UuanBn/P3M9NjEyeDYxMiZ3/PTAmaz0yMCZjPVN1/RGVkVTBLT0VlMTlo/ay16RkFWN0N1VW1P/THJ1ZHhxandqTHR6/WTUzRWM9', 5, 5, NOW(), NOW());

-- ===============================
-- SEED: LIKES
-- ===============================
INSERT INTO likes (post_id, user_id, created_at, updated_at) VALUES
(1, 3, NOW(), NOW()),
(1, 4, NOW(), NOW()),
(2, 2, NOW(), NOW()),
(3, 5, NOW(), NOW()),
(3, 2, NOW(), NOW()),
(4, 3, NOW(), NOW()),
(5, 4, NOW(), NOW()),
(6, 5, NOW(), NOW());

-- ===============================
-- SEED: COMMENTS
-- ===============================
INSERT INTO comments (text, post_id, created_by, updated_by, created_at, updated_at) VALUES
-- Comentarios para el Post 1 (Paisaje montañoso majestuoso)
('¡Gran publicación! ¡La vista de la montaña es impresionante!', 1, 3, 3, NOW(), NOW()),
('¡Gracias por compartir este paisaje asombroso!', 1, 4, 4, NOW(), NOW()),
('¿Dónde fue tomada? ¡Las montañas se ven increíbles!', 1, 5, 5, NOW(), NOW()),
('¡Necesito visitar este lugar! ¿Puedes compartir la ubicación?', 1, 6, 6, NOW(), NOW()),
('Las nubes le agregan mucho dramatismo a la escena.', 1, 7, 7, NOW(), NOW()),

-- Comentarios para el Post 2 (Sendero de montaña al atardecer)
('Los colores del atardecer aquí son increíbles.', 2, 2, 2, NOW(), NOW()),
('¡Iluminación perfecta para una caminata de montaña!', 2, 4, 4, NOW(), NOW()),
('Esto me recuerda a mi última caminata.', 2, 5, 5, NOW(), NOW()),
('El sendero parece desafiante pero vale la pena.', 2, 3, 3, NOW(), NOW()),

-- Comentarios para el Post 3 (Vista de amanecer dorado)
('¡Este amanecer dorado es absolutamente impresionante!', 3, 5, 5, NOW(), NOW()),
('La naturaleza en su mejor momento.', 3, 2, 2, NOW(), NOW()),
('¡La hora dorada es mágica!', 3, 6, 6, NOW(), NOW()),
('Las fotos a primera hora de la mañana siempre son las mejores.', 3, 4, 4, NOW(), NOW()),
('¿Qué configuración de cámara usaste?', 3, 7, 7, NOW(), NOW()),

-- Comentarios para el Post 4 (Panorama montañoso al anochecer)
('La vista panorámica es hipnotizante.', 4, 2, 2, NOW(), NOW()),
('¡Esta perspectiva lo es todo!', 4, 3, 3, NOW(), NOW()),
('El anochecer es el momento perfecto para paisajes.', 4, 6, 6, NOW(), NOW()),
('La composición es perfecta.', 4, 5, 5, NOW(), NOW()),

-- Comentarios para el Post 5 (Aventura de senderismo en la montaña)
('¡Me encanta el sendero! Parece una gran aventura.', 5, 3, 3, NOW(), NOW()),
('¡Esto me inspira a ir de excursión!', 5, 4, 4, NOW(), NOW()),
('¡Qué hermoso día para una caminata!', 5, 7, 7, NOW(), NOW()),
('Las montañas al fondo son impresionantes.', 5, 2, 2, NOW(), NOW()),
('¿Es un sendero difícil?', 5, 6, 6, NOW(), NOW()),

-- Comentarios para el Post 6 (Serenidad de atardecer costero)
('El atardecer costero es muy pacífico.', 6, 4, 4, NOW(), NOW()),
('¡Esos colores son irreales!', 6, 2, 2, NOW(), NOW()),
('Los atardeceres en la playa son los mejores.', 6, 5, 5, NOW(), NOW()),
('Final perfecto para un día.', 6, 7, 7, NOW(), NOW()),
('El reflejo en el agua es hermoso.', 6, 3, 3, NOW(), NOW()),

-- Comentarios para el Post 7 (Vista del valle al crepúsculo)
('¡Esta vista del valle es absolutamente mágica!', 7, 5, 5, NOW(), NOW()),
('La profundidad en esta toma es increíble.', 7, 3, 3, NOW(), NOW()),
('Me encanta cómo cae la luz sobre el paisaje.', 7, 2, 2, NOW(), NOW()),
('¡La naturaleza nunca decepciona!', 7, 6, 6, NOW(), NOW()),

-- Comentarios para el Post 8 (Amanecer sobre las colinas)
('La luz de la mañana en esta toma es perfecta.', 8, 2, 2, NOW(), NOW()),
('El amanecer es un momento muy pacífico.', 8, 4, 4, NOW(), NOW()),
('Los suaves colores de la mañana son hermosos.', 8, 7, 7, NOW(), NOW()),
('¡Esto me dan ganas de levantarme temprano!', 8, 5, 5, NOW(), NOW()),
('¡Preciosa captura matutina!', 8, 3, 3, NOW(), NOW());
