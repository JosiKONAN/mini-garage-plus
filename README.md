# ============================================
# Mini Garage Plus
# Application web Full-Stack de gestion d'un garage automobile
# Projet Session 6 — Formation D-CLIC « Developpement Web niveau avance »
# Auteur : KONAN Josias
# ============================================

Mini Garage Plus est une application de gestion d'un garage automobile : suivi des
**vehicules**, des **reparations** et des **techniciens**, avec un **tableau de bord**
de synthese.

## Architecture

- **Backend** : API REST **Laravel 13** (PHP 8.3) implementation avec **Eloquent ORM**,
  validations cote serveur, JSON. Tourne sur `http://127.0.0.1:8000`.
- **Frontend** : SPA **React 18 + Vite + React Router v6**, Bootstrap 5.3 (CDN).
  Tourne sur `http://localhost:5173`.
- **Base de donnees** : SQLite en developpement, schema MySQL 8.4 fourni
  (`garage_db.sql`).

```
mini-garage-plus/
├── backend/            # API Laravel
│   ├── app/Models/     # Vehicule, Reparation, Technicien
│   ├── app/Http/Controllers/Api/
│   ├── database/migrations/
│   ├── tests/Feature/  # Tests PHPUnit
│   └── generate_sql.php
├── frontend/           # SPA React (Vite)
│   └── src/
│       ├── components/ # AppLayout, Navbar, SearchBar, Cards, Pagination…
│       └── pages/      # Dashboard, Vehicules, Reparations, Techniciens…
└── garage_db.sql       # Script SQL MySQL (schema + donnees)
```

## Fonctionnalites

| Module | Priorite | Statut |
|---|---|---|
| Gestion des vehicules (CRUD) | Indispensable | ✅ |
| Recherche vehicules (?q=) | Indispensable | ✅ |
| Gestion des reparations (CRUD + techniciens) | Indispensable | ✅ |
| Liste et fiche techniciens | Indispensable | ✅ |
| Tableau de bord (KPI) | Indispensable | ✅ |
| Pagination (9 elements/page) | Indispensable | ✅ |
| Authentification gestionnaire | Optionnel | Hors v1 |

## Contrat d'API

| Ressource | Endpoints | Remarque |
|---|---|---|
| vehicules | `GET/POST /api/vehicules` | Recherche via `?q=`, pagination `?page=` & `?per_page=` |
|           | `GET/PUT/DELETE /api/vehicules/{id}` | Fiche + reparations |
| reparations | `GET/POST /api/reparations` | Inclut vehicule + techniciens |
|            | `GET/PUT/DELETE /api/reparations/{id}` | |
| techniciens | `GET /api/techniciens` | Lecture seule (v1) |
|           | `GET /api/techniciens/{id}` | Fiche + reparations |
| dashboard | `GET /api/stats` | KPI, repartition energies, dernieres reparations |

## Installation

### 1. Backend (Laravel)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
# SQLite (dev rapide) :
touch database/database.sqlite
# ou MySQL : creer la base garage_db et importer garage_db.sql
php artisan migrate --seed
php artisan serve --port=8000
```

### 2. Frontend (React)

```bash
cd frontend
npm install
npm run dev        # → http://localhost:5173
```

L'URL de l'API est configurable via la variable d'environnement `VITE_API_URL`
(defaut : `http://127.0.0.1:8000/api`).

CORS : le backend autorise les origines de developpement locales
(`http://localhost:5173`, `http://127.0.0.1:5173`, ports de `vite preview` 4173 et tout
port localhost/127.0.0.1) — voir `backend/config/cors.php`. Un proxy `/api` est egalement
configure dans `frontend/vite.config.js`.

## Tests

```bash
cd backend
php artisan test
```

Suite PHPUnit creee pour la Semaine 6 — **15 tests, 51 assertions** (`php artisan test`) :
- pagination des vehicules (9/page),
- recherche multi-champs (immatriculation, marque, modele),
- lecture seule des techniciens,
- indicateurs du tableau de bord,
- validation des donnees (`ApiVehiculeValidationTest.php`),
- rendu des pages (`PageVehiculesTest.php`),
- non-regression sur l'audit qualite (`ApiRegressionS6Test.php`) : bornes de `per_page`,
  `kilometrage` nul normalise a 0, plafond de `duree_main_oeuvre`, refus des doublons de
  techniciens (regle `distinct` + contrainte UNIQUE de la table pivot), `duree_moyenne`
  nulle sans reparation.

## Securite, performance et eco-responsabilite

- **Securite** : validation Laravel cote serveur, Eloquent (aucune requete SQL brute),
  echappement automatique de React, erreurs API structurees (`data.errors`).
- **Performance** : pagination a 9 elements, API JSON legere (~60 Ko gzip pour le JS),
  requetes Eloquent ciblees.
- **Eco-responsabilite** : photos de vehicules optimisees et compressees (chargement
  differe `loading="lazy"`), requetes ciblees, composants React reutilisables, cout CPU
  faible, code maintenable.

## Lien

- Depot GitHub : <https://github.com/JosiKONAN/mini-garage-plus>