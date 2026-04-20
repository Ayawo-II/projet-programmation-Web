# AskCampus — Plateforme d'entraide académique

## Stack
- Laravel 12 + Blade + Tailwind CSS
- MySQL
- PHP 8.4

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Configurer `.env` :
```env
DB_DATABASE=askcampus
DB_USERNAME=root
DB_PASSWORD=abel
```

```bash
php artisan migrate
php artisan db:seed --class=TagSeeder
php artisan db:seed --class=UserSeeder
npm run build
php artisan serve
```

## Compte modérateur

Rôle : Modérateur
Email : kossiayawoabel@gmail.com
Mot de passe : kossiayawo


## Fonctionnalités
- Poser / répondre / voter sur des questions
- Tags, recherche, filtres
- Système de réputation
- Espace modération

## Auteur
Groupe 2 — Projet AskCampus