-- ============================================
-- Mini Garage Plus — MySQL 8.4 compatible
-- Base de données : garage_db
-- Généré le 2026-09-16 16:07:51
-- ============================================

CREATE DATABASE IF NOT EXISTS garage_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE garage_db;

-- Table: vehicules
CREATE TABLE IF NOT EXISTS vehicules (
  id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  immatriculation VARCHAR(20)  NOT NULL UNIQUE,
  marque          VARCHAR(50)  NOT NULL,
  modele          VARCHAR(50)  NOT NULL,
  couleur         VARCHAR(30)  NULL,
  annee           YEAR         NOT NULL,
  kilometrage     INT UNSIGNED NOT NULL DEFAULT 0,
  carrosserie     VARCHAR(30)  NULL,
  energie         VARCHAR(20)  NOT NULL DEFAULT 'essence',
  boite           VARCHAR(20)  NOT NULL DEFAULT 'manuelle',
  image           VARCHAR(255) NULL,
  created_at      TIMESTAMP    NULL,
  updated_at      TIMESTAMP    NULL
) ENGINE=InnoDB;

-- Table: reparations
CREATE TABLE IF NOT EXISTS reparations (
  id                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  vehicule_id         BIGINT UNSIGNED NOT NULL,
  date                DATE           NOT NULL,
  duree_main_oeuvre   DECIMAL(5,2)   NOT NULL,
  objet_reparation    VARCHAR(255)   NOT NULL,
  created_at          TIMESTAMP      NULL,
  updated_at          TIMESTAMP      NULL,
  FOREIGN KEY (vehicule_id) REFERENCES vehicules(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table: techniciens
CREATE TABLE IF NOT EXISTS techniciens (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom         VARCHAR(60)     NOT NULL,
  prenom      VARCHAR(60)     NOT NULL,
  specialite  VARCHAR(80)     NOT NULL,
  created_at  TIMESTAMP       NULL,
  updated_at  TIMESTAMP       NULL
) ENGINE=InnoDB;

-- Table pivot: reparation_technicien
CREATE TABLE IF NOT EXISTS reparation_technicien (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  reparation_id   BIGINT UNSIGNED NOT NULL,
  technicien_id   BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (reparation_id)  REFERENCES reparations(id)  ON DELETE CASCADE,
  FOREIGN KEY (technicien_id)  REFERENCES techniciens(id)  ON DELETE CASCADE,
  UNIQUE KEY pivot_unique (reparation_id, technicien_id)
) ENGINE=InnoDB;
-- Données : migrations
INSERT INTO migrations (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO migrations (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO migrations (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO migrations (`id`, `migration`, `batch`) VALUES (4, '2026_09_06_020420_create_vehicules_table', 1);
INSERT INTO migrations (`id`, `migration`, `batch`) VALUES (5, '2026_09_06_020421_create_reparations_table', 1);
INSERT INTO migrations (`id`, `migration`, `batch`) VALUES (6, '2026_09_06_020422_create_techniciens_table', 1);
INSERT INTO migrations (`id`, `migration`, `batch`) VALUES (7, '2026_09_06_020423_create_reparation_technicien_table', 1);
INSERT INTO migrations (`id`, `migration`, `batch`) VALUES (8, '2026_09_16_155254_add_image_to_vehicules_table', 2);

-- Données : reparation_technicien
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (1, 1, 9);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (2, 2, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (3, 3, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (4, 3, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (5, 4, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (6, 5, 5);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (7, 5, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (8, 5, 8);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (9, 6, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (10, 7, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (11, 7, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (12, 8, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (13, 9, 4);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (14, 10, 5);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (15, 10, 8);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (16, 11, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (17, 12, 5);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (18, 13, 4);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (19, 13, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (20, 13, 10);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (21, 14, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (22, 14, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (23, 14, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (24, 15, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (25, 15, 8);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (26, 15, 10);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (27, 16, 9);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (28, 17, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (29, 17, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (30, 17, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (31, 18, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (32, 18, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (33, 18, 8);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (34, 19, 9);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (35, 20, 1);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (36, 20, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (37, 20, 9);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (38, 21, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (39, 21, 8);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (40, 22, 1);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (41, 22, 4);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (42, 22, 5);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (43, 23, 5);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (44, 24, 1);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (45, 24, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (46, 24, 9);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (47, 25, 5);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (48, 25, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (49, 26, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (50, 26, 4);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (51, 26, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (52, 27, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (53, 27, 9);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (54, 28, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (55, 28, 4);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (56, 28, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (57, 29, 1);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (58, 29, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (59, 29, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (60, 30, 5);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (61, 30, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (62, 30, 10);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (63, 31, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (64, 32, 8);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (65, 33, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (66, 34, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (67, 34, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (68, 35, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (69, 35, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (70, 35, 8);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (71, 36, 2);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (72, 36, 5);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (73, 36, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (74, 37, 1);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (75, 37, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (76, 37, 4);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (77, 38, 4);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (78, 38, 7);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (79, 39, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (80, 39, 10);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (81, 40, 3);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (82, 40, 6);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (83, 41, 1);
INSERT INTO reparation_technicien (`id`, `reparation_id`, `technicien_id`) VALUES (84, 41, 2);

-- Données : reparations
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (1, 12, '2026-08-11', 0.5, 'Révision générale (freins, plaquettes)', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (2, 6, '2025-12-05', 1.5, 'Remplacement des pneus avant', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (3, 14, '2026-05-29', 1, 'Diagnostic électronique et reprogrammation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (4, 7, '2026-06-18', 4, 'Remplacement de la batterie', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (5, 20, '2026-03-23', 2.5, 'Diagnostic électronique et reprogrammation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (6, 8, '2026-02-04', 1, 'Remplacement de l''embrayage', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (7, 17, '2026-01-11', 1.5, 'Remplacement des pneus avant', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (8, 6, '2026-06-16', 2, 'Remplacement de l''embrayage', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (9, 17, '2026-06-13', 3, 'Changement des plaquettes et disques de frein', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (10, 9, '2026-01-08', 2, 'Contrôle de la climatisation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (11, 17, '2026-03-23', 4, 'Diagnostic électronique et reprogrammation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (12, 12, '2026-02-19', 4, 'Changement des plaquettes et disques de frein', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (13, 13, '2026-04-18', 4, 'Contrôle de la climatisation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (14, 20, '2026-03-04', 2.5, 'Remplacement de l''embrayage', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (15, 6, '2026-01-24', 1, 'Entretien moteur et courroie de distribution', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (16, 8, '2025-09-24', 2, 'Remplacement de l''embrayage', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (17, 9, '2025-09-25', 1, 'Remplacement de l''embrayage', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (18, 6, '2025-12-12', 2, 'Diagnostic électronique et reprogrammation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (19, 12, '2026-02-23', 3, 'Remplacement de l''embrayage', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (20, 8, '2026-02-08', 3, 'Remplacement de l''embrayage', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (21, 6, '2026-07-04', 0.5, 'Entretien moteur et courroie de distribution', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (22, 10, '2026-09-05', 0.5, 'Vidange et changement de filtre à huile', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (23, 13, '2026-06-26', 0.5, 'Réparation de la boîte de vitesses', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (24, 17, '2026-06-03', 0.5, 'Remplacement de la batterie', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (25, 19, '2026-07-10', 5, 'Vidange et changement de filtre à huile', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (26, 16, '2026-04-19', 3, 'Diagnostic électronique et reprogrammation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (27, 1, '2026-05-09', 5, 'Révision générale (freins, plaquettes)', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (28, 1, '2026-05-04', 2.5, 'Vidange et changement de filtre à huile', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (29, 7, '2026-06-13', 2, 'Réparation de la boîte de vitesses', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (30, 15, '2026-02-19', 1.5, 'Diagnostic électronique et reprogrammation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (31, 1, '2025-10-27', 1.5, 'Remplacement de l''embrayage', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (32, 2, '2025-12-29', 5, 'Changement des plaquettes et disques de frein', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (33, 12, '2026-02-11', 0.5, 'Remplacement de la batterie', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (34, 4, '2025-12-02', 4, 'Révision générale (freins, plaquettes)', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (35, 10, '2026-09-16', 0.5, 'Changement des plaquettes et disques de frein', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (36, 17, '2026-08-01', 1, 'Vidange et changement de filtre à huile', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (37, 10, '2026-06-07', 2.5, 'Remplacement de la batterie', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (38, 14, '2026-03-19', 2, 'Remplacement de la batterie', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (39, 14, '2026-08-22', 5, 'Vidange et changement de filtre à huile', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (40, 15, '2026-04-28', 3, 'Révision générale (freins, plaquettes)', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO reparations (`id`, `vehicule_id`, `date`, `duree_main_oeuvre`, `objet_reparation`, `created_at`, `updated_at`) VALUES (41, 6, '2026-09-16', 2.5, 'Remplacement de la batterie', '2026-09-16 13:34:44', '2026-09-16 13:34:44');

-- Données : sqlite_sequence
INSERT INTO sqlite_sequence (`name`, `seq`) VALUES ('migrations', 8);
INSERT INTO sqlite_sequence (`name`, `seq`) VALUES ('vehicules', 20);
INSERT INTO sqlite_sequence (`name`, `seq`) VALUES ('techniciens', 10);
INSERT INTO sqlite_sequence (`name`, `seq`) VALUES ('reparations', 41);
INSERT INTO sqlite_sequence (`name`, `seq`) VALUES ('reparation_technicien', 84);

-- Données : techniciens
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (1, 'Dooley', 'Vincent', 'Climatisation', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (2, 'Reinger', 'Neoma', 'Carrosserie', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (3, 'Hickle', 'Eldridge', 'Boîte de vitesses', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (4, 'Corwin', 'Crystal', 'Boîte de vitesses', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (5, 'Hauck', 'Margot', 'Mécanique générale', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (6, 'Parisian', 'Genevieve', 'Carrosserie', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (7, 'Powlowski', 'Robin', 'Mécanique générale', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (8, 'Hamill', 'Justen', 'Boîte de vitesses', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (9, 'Windler', 'Willy', 'Mécanique générale', '2026-09-16 13:27:46', '2026-09-16 13:27:46');
INSERT INTO techniciens (`id`, `nom`, `prenom`, `specialite`, `created_at`, `updated_at`) VALUES (10, 'Hayes', 'Emil', 'Diagnostic informatique', '2026-09-16 13:27:46', '2026-09-16 13:27:46');

-- Données : vehicules
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (1, 'VL-117-YD', 'Mercedes-Benz', 'Classe C', 'Rouge', 2017, 43855, 'Pick-up', 'hybride', 'automatique', '2026-09-16 13:27:45', '2026-09-16 13:27:45', 'images/vehicules/mercedes_classe_c.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (2, 'BO-253-ET', 'Kia', 'Sorento', 'Vert', 2012, 15689, 'Citadine', 'diesel', 'automatique', '2026-09-16 13:27:45', '2026-09-16 13:27:45', 'images/vehicules/kia_sorento.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (3, 'DT-700-IY', 'Peugeot', 'Partner', 'Argent', 2012, 91894, 'SUV', 'hybride', 'automatique', '2026-09-16 13:27:45', '2026-09-16 13:27:45', 'images/vehicules/peugeot_partner.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (4, 'LW-152-LI', 'Renault', 'Megane', 'Argent', 2023, 211239, 'Pick-up', 'electrique', 'manuelle', '2026-09-16 13:27:45', '2026-09-16 13:27:45', 'images/vehicules/renault_megane.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (5, 'UI-726-UC', 'Peugeot', 208, 'Argent', 2024, 123817, 'SUV', 'diesel', 'automatique', '2026-09-16 13:27:45', '2026-09-16 13:27:45', 'images/vehicules/peugeot_208.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (6, 'GG-261-UE', 'Toyota', 'RAV4', 'Bleu', 2019, 73251, 'Pick-up', 'electrique', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/toyota_rav4.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (7, 'RL-521-DO', 'Renault', 'Megane', 'Bleu', 2016, 187013, 'Citadine', 'hybride', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/renault_megane.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (8, 'LE-266-HO', 'Toyota', 'Corolla', 'Vert', 2020, 228708, 'Utilitaire', 'electrique', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/toyota_corolla.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (9, 'BN-860-WL', 'Hyundai', 'Tucson', 'Vert', 2017, 68475, 'Utilitaire', 'hybride', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/hyundai_tucson.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (10, 'XK-409-EV', 'Mercedes-Benz', 'Sprinter', 'Rouge', 2017, 170634, 'Break', 'electrique', 'automatique', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/mercedes_sprinter.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (11, 'KM-121-AZ', 'Hyundai', 'Elantra', 'Rouge', 2022, 248631, 'Berline', 'electrique', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/hyundai_elantra.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (12, 'UH-936-YP', 'Renault', 'Kangoo', 'Argent', 2024, 106628, 'Utilitaire', 'diesel', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/renault_kangoo.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (13, 'ZA-767-BB', 'Mercedes-Benz', 'Sprinter', 'Bleu', 2013, 201305, 'Citadine', 'diesel', 'automatique', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/mercedes_sprinter.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (14, 'BI-412-OJ', 'Kia', 'Sorento', 'Blanc', 2014, 248027, 'Berline', 'electrique', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/kia_sorento.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (15, 'ZY-772-HO', 'Hyundai', 'i10', 'Vert', 2013, 155633, 'Utilitaire', 'electrique', 'automatique', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/hyundai_i10.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (16, 'RB-711-QD', 'Renault', 'Duster', 'Blanc', 2022, 57047, 'Pick-up', 'electrique', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/renault_duster.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (17, 'TK-846-KV', 'Kia', 'Picanto', 'Vert', 2014, 179907, 'Berline', 'hybride', 'automatique', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/kia_picanto.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (18, 'XL-936-ZB', 'Mercedes-Benz', 'Classe A', 'Rouge', 2022, 75112, 'Citadine', 'essence', 'automatique', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/mercedes_classe_a.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (19, 'OS-813-VW', 'Mercedes-Benz', 'Classe C', 'Vert', 2025, 233534, 'Utilitaire', 'hybride', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/mercedes_classe_c.jpg');
INSERT INTO vehicules (`id`, `immatriculation`, `marque`, `modele`, `couleur`, `annee`, `kilometrage`, `carrosserie`, `energie`, `boite`, `created_at`, `updated_at`, `image`) VALUES (20, 'XH-583-KH', 'Toyota', 'Yaris', 'Rouge', 2013, 114496, 'Citadine', 'hybride', 'manuelle', '2026-09-16 13:27:46', '2026-09-16 13:27:46', 'images/vehicules/toyota_yaris.jpg');

