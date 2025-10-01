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
INSERT INTO users (email, first_name, last_name, username, password, active, role, created_at, updated_at) VALUES
('admin@example.com',  'Admin',  'User',  'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'admin', NOW(), NOW()),
('user@example.com',   'User',   'User',  'user',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user',  NOW(), NOW()),
('alice@example.com',  'Alice',  'Wonderland', 'alice', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user', NOW(), NOW()),
('bob@example.com',    'Bob',    'Builder',    'bob',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user', NOW(), NOW()),
('charlie@example.com','Charlie','Brown',      'charlie','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user', NOW(), NOW());

-- ===============================
-- SEED: POSTS
-- ===============================
INSERT INTO posts (title, body, created_by, updated_by, created_at, updated_at) VALUES
('Post 1',  'Content of post 1', 2, 2, NOW(), NOW()),
('Post 2',  'Content of post 2', 3, 3, NOW(), NOW()),
('Post 3',  'Content of post 3', 4, 4, NOW(), NOW()),
('Post 4',  'Content of post 4', 5, 5, NOW(), NOW()),
('Post 5',  'Content of post 5', 2, 2, NOW(), NOW()),
('Post 6',  'Content of post 6', 3, 3, NOW(), NOW()),
('Post 7',  'Content of post 7', 4, 4, NOW(), NOW()),
('Post 8',  'Content of post 8', 5, 5, NOW(), NOW()),
('Post 9',  'Content of post 9', 2, 2, NOW(), NOW()),
('Post 10', 'Content of post 10',3, 3, NOW(), NOW());

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
