# 🎓 AskCampus — Plateforme d'entraide académique

## Stack
- Laravel 12 + Blade + Tailwind CSS
- MySQL
- PHP 8

---

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Adapter le `.env` à son environnement :
```env
DB_DATABASE=askcampus
DB_USERNAME=root          ← ton username MySQL
DB_PASSWORD=              ← ton mot de passe MySQL
```

Créer la base de données dans MySQL ou phpMyAdmin :
```sql
CREATE DATABASE askcampus;
```

```bash
php artisan migrate
php artisan db:seed --class=TagSeeder
php artisan db:seed --class=UserSeeder
npm run build
php artisan serve
```

Ouvrir **http://localhost:8000**

---

## Si tu clones le projet

Ces fichiers ne sont pas sur GitHub et doivent être recréés :

| Fichier / Dossier | Commande |
|-------------------|----------|
| `.env` | `cp .env.example .env` |
| `vendor/` | `composer install` |
| `node_modules/` | `npm install` |

> C'est normal, ils sont dans le `.gitignore`. Chaque personne les recrée sur sa machine.

---

## Comptes

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Modérateur | *(défini dans UserSeeder)* | *(défini dans UserSeeder)* |

Pour promouvoir un compte étudiant en modérateur :
```bash
php artisan tinker
App\Models\User::where('email', 'email@exemple.com')->update(['role' => 'moderator']);
```

---

## Fonctionnalités
- Poser / répondre / voter sur des questions
- Tags, recherche, filtres
- Système de réputation automatique
- Meilleure réponse mise en avant visuellement
- Espace modération (fermer, supprimer, gérer les tags)

---

## Auteur
Groupe 2 — Projet 5 : AskCampus