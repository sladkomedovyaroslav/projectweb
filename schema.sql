CREATE DATABASE IF NOT EXISTS restaurant_app
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE restaurant_app;

-- Пользователи

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Администраторы

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Типы столиков

CREATE TABLE table_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

INSERT INTO table_types (name)
VALUES
('У окна'),
('На террасе'),
('VIP-зал'),
('Семейный'),
('Стандарт');

-- Бронирования

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    full_name VARCHAR(255) NOT NULL,

    phone VARCHAR(50) NOT NULL,

    email VARCHAR(255) NOT NULL,

    reservation_date DATE NOT NULL,

    guests_count INT NOT NULL,

    comment TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- Связь бронирования и типов столиков

CREATE TABLE reservation_tables (
    reservation_id INT NOT NULL,
    table_type_id INT NOT NULL,

    PRIMARY KEY (
        reservation_id,
        table_type_id
    ),

    FOREIGN KEY (reservation_id)
        REFERENCES reservations(id)
        ON DELETE CASCADE,

    FOREIGN KEY (table_type_id)
        REFERENCES table_types(id)
        ON DELETE CASCADE
);
