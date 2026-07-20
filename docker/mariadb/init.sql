CREATE TABLE users (
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    prename VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    email VARCHAR(254) NOT NULL,
    password VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL,
    sex VARCHAR(32) NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE posts (
    post_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    timestamp DATETIME NOT NULL,
    author_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    PRIMARY KEY (post_id),
    KEY posts_author_timestamp_index (author_id, timestamp),
    CONSTRAINT posts_author_foreign_key
        FOREIGN KEY (author_id) REFERENCES users (user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE following (
    user_id INT UNSIGNED NOT NULL,
    following_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, following_id),
    KEY following_target_index (following_id),
    CONSTRAINT following_user_foreign_key
        FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE,
    CONSTRAINT following_target_foreign_key
        FOREIGN KEY (following_id) REFERENCES users (user_id) ON DELETE CASCADE,
    CONSTRAINT following_not_self CHECK (user_id <> following_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
