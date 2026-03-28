-- Script de création de la base de données pour le projet Journal "Le Monde"

-- Suppression des tables si elles existent déjà
DROP TABLE IF EXISTS `articles`;
DROP TABLE IF EXISTS `users`;

-- Table des utilisateurs (BackOffice)
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL, -- Stocker des hash (BCRYPT)
    `email` VARCHAR(100) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion d'un utilisateur admin par défaut (password: admin123)
-- Le mot de passe sera hashé via PHP, mais ici on met un exemple clair
INSERT INTO `users` (`username`, `password`) VALUES ('admin', '$2y$10$vWf5R2D8rG.5z.q8z5z5.O.5z.q8z5z5.O.5z.q8z5z5.O.5z.q8z5z5.O');

-- Table des articles
CREATE TABLE `articles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `chapeau` TEXT NOT NULL, -- Utilisé aussi pour meta_description
    `corps` LONGTEXT NOT NULL,
    `image_principale` VARCHAR(255) DEFAULT NULL,
    `image_alt` VARCHAR(255) DEFAULT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `meta_title` VARCHAR(255) DEFAULT NULL, -- SEO Spécifique
    `date_publication` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indexation pour recherche et SEO
CREATE INDEX idx_slug ON articles(slug);
CREATE INDEX idx_date_pub ON articles(date_publication);
