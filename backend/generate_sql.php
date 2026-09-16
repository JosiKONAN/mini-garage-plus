<?php

define('DB_PATH', __DIR__ . '/database/database.sqlite');
define('OUTPUT',  __DIR__ . '/garage_db.sql');

$pdo = new PDO('sqlite:' . DB_PATH);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$rows = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);

$ddl = <<<'SQL'
-- ============================================
-- Mini Garage Plus — MySQL 8.4 compatible
-- Base de données : garage_db
-- Généré le %s
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

SQL;

$sql = sprintf($ddl, date('Y-m-d H:i:s'));

function escape(string $val): string
{
    return $pdo->quote($val);
}

foreach ($rows as $table) {
    $stmt = $pdo->query("SELECT * FROM [$table]");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$data) continue;

    $sql .= "-- Données : $table\n";
    foreach ($data as $row) {
        $cols = [];
        $vals = [];
        foreach ($row as $col => $v) {
            $cols[] = "`$col`";
            if ($v === null) {
                $vals[] = 'NULL';
            } elseif (is_numeric($v)) {
                $vals[] = $v;
            } else {
                $vals[] = $pdo->quote((string) $v);
            }
        }
        $sql .= sprintf("INSERT INTO %s (%s) VALUES (%s);\n",
            $table,
            implode(', ', $cols),
            implode(', ', $vals)
        );
    }
    $sql .= "\n";
}

file_put_contents(OUTPUT, $sql);
echo "SQL exporté → " . OUTPUT . "\n";
echo "Lignes     : " . substr_count($sql, "\n") . "\n";