-- ############################################
-- DROP TABLES IF THEY EXIST (in correct order)
-- Ensures clean setup without FK constraint errors
-- ############################################

DROP TABLE IF EXISTS likes;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;

-- ############################################
-- DATABASE SCHEMA: User System with Posts, Comments, Likes
-- Enhanced with BIGINT IDs and timestamped soft-deletion
-- ############################################

-- ===============================
-- USERS TABLE
-- Stores all user accounts (both admins and regular users)
-- ===============================
CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,                        -- Unique user ID
    email VARCHAR(255) NOT NULL UNIQUE,                         -- Unique email address
    first_name VARCHAR(100) NOT NULL,                           -- First name of the user
    last_name VARCHAR(100) NOT NULL,                            -- Last name of the user
    username VARCHAR(32) NOT NULL UNIQUE,                       -- Unique username
    password VARCHAR(255) NOT NULL,                             -- Hashed password (bcrypt, Argon2, etc.)
    active BOOLEAN DEFAULT TRUE,                                -- Whether the account is active or disabled
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',         -- Role of the user (limited set)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,             -- Account creation timestamp
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Last update timestamp
    last_login_at TIMESTAMP NULL,                               -- Last time the user logged in (nullable)

    -- Helpful indexes for search/filtering
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_active (active),
    INDEX idx_role (role),
    INDEX idx_created_at (created_at)
);

-- ===============================
-- POSTS TABLE
-- Represents posts created by users
-- ===============================
CREATE TABLE posts (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,                        -- Unique post ID
    title VARCHAR(255) NOT NULL,                                -- Title of the post
    body TEXT NOT NULL COMMENT 'Content of the post',           -- Main content of the post
    created_by BIGINT NOT NULL,                                 -- FK to user who created the post
    updated_by BIGINT DEFAULT NULL,                             -- FK to user who last updated it (optional)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,             -- Creation timestamp
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Last update timestamp
    deleted_at TIMESTAMP NULL DEFAULT NULL,                     -- Timestamp when post was soft-deleted

    -- Define foreign key relationships
    CONSTRAINT fk_posts_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_posts_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ===============================
-- COMMENTS TABLE
-- Stores comments on posts
-- ===============================
CREATE TABLE comments (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,                        -- Unique comment ID
    text VARCHAR(1000) NOT NULL,                                -- Comment content (up to 1000 characters)
    post_id BIGINT NOT NULL,                                    -- FK to the post this comment belongs to
    created_by BIGINT NOT NULL,                                 -- FK to user who wrote the comment
    updated_by BIGINT DEFAULT NULL,                             -- FK to user who last edited the comment
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,             -- Creation timestamp
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Last update timestamp
    deleted_at TIMESTAMP NULL DEFAULT NULL,                     -- Soft-delete timestamp

    -- Foreign key constraints
    CONSTRAINT fk_comments_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    CONSTRAINT fk_comments_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_comments_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ===============================
-- LIKES TABLE
-- Stores user likes on posts
-- ===============================
CREATE TABLE likes (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,                        -- Unique like ID
    post_id BIGINT NOT NULL,                                    -- FK to the liked post
    user_id BIGINT NOT NULL,                                    -- FK to the user who liked it
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,             -- When the like was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- When the like was updated
    deleted_at TIMESTAMP NULL DEFAULT NULL,                     -- Soft-delete timestamp (if needed)

    -- Foreign key constraints
    CONSTRAINT fk_likes_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    CONSTRAINT fk_likes_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

    -- Enforce that a user can like a post only once
    UNIQUE KEY uq_likes_post_user (post_id, user_id)
);

-- ===============================
-- INSERT DEFAULT/DUMMY USERS
-- One admin and one regular user
-- ===============================
-- Note: password = "password", hashed using bcrypt

INSERT INTO users (email, first_name, last_name, username, password, active, role, created_at, updated_at) VALUES
('admin@example.com', 'Admin', 'User', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'admin', NOW(), NOW()),
('user@example.com', 'User', 'User', 'user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user', NOW(), NOW()),
('alice@example.com', 'Alice', 'Wonderland', 'alice', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user', NOW(), NOW()),
('bob@example.com', 'Bob', 'Builder', 'bob', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user', NOW(), NOW()),
('charlie@example.com', 'Charlie', 'Brown', 'charlie', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, 'user', NOW(), NOW());

-- ===============================
-- INSERT 10 POSTS
-- Assume users have auto-increment IDs starting from 1
-- ===============================
INSERT INTO posts (title, body, created_by, updated_by, created_at, updated_at) VALUES
('Post 1', 'Content of post 1', 2, 2, NOW(), NOW()),
('Post 2', 'Content of post 2', 3, 3, NOW(), NOW()),
('Post 3', 'Content of post 3', 4, 4, NOW(), NOW()),
('Post 4', 'Content of post 4', 5, 5, NOW(), NOW()),
('Post 5', 'Content of post 5', 2, 2, NOW(), NOW()),
('Post 6', 'Content of post 6', 3, 3, NOW(), NOW()),
('Post 7', 'Content of post 7', 4, 4, NOW(), NOW()),
('Post 8', 'Content of post 8', 5, 5, NOW(), NOW()),
('Post 9', 'Content of post 9', 2, 2, NOW(), NOW()),
('Post 10', 'Content of post 10', 3, 3, NOW(), NOW());

-- ===============================
-- INSERT SOME LIKES
-- User IDs 2–5 liking various posts
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
