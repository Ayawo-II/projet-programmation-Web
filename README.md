# AskCampus

Application web Laravel développée pour un projet d'équipe de 4 développeurs.

## Description

AskCampus est une application Laravel qui propose une authentification utilisateur, un tableau de bord sécurisé et une gestion de profil. Le projet utilise Laravel, PHP, Tailwind CSS et Vite.

## Fonctionnalités principales

- Authentification et enregistrement des utilisateurs
- Tableau de bord sécurisé accessible uniquement aux utilisateurs connectés
- Gestion du profil utilisateur (édition, mise à jour et suppression)
- Affichage du rôle, de la réputation et du nombre de questions de l'utilisateur
- Front-end stylé avec Tailwind CSS et Vite

## Ma contribution

Ma partie a consisté à :

- gérer l’inscription et la connexion des utilisateurs
- attribuer automatiquement le rôle “étudiant” et une réputation initiale
- afficher et modifier le profil utilisateur (infos, réputation, activités)
- gérer l’accès aux fonctionnalités selon le rôle (étudiant / modérateur)
- implémenter la route `/dashboard` et l'accès protégé par le middleware `auth`
- développer l'interface de tableau de bord dans `resources/views/dashboard.blade.php`
- ajouter la gestion du profil utilisateur via `ProfileController`
- assurer la cohérence des pages d'authentification et du workflow utilisateur

## Équipe

Le projet est développé par 4 personnes. Chacun travaille sur une fonctionnalité ou un module spécifique pour avancer en parallèle.

## Branches et workflow Git

- Idéalement, on travaille sur une branche de fonctionnalité (`feature/...` ou `dev/...`) et on fusionne ensuite vers `main` via une Pull Request.
- J'ai terminé ma partie sur la branche `dev1-auth-users`.
- Pour envoyer sur `main`, il faut généralement :
  1. s'assurer que `main` est à jour (`git checkout main` puis `git pull`)
  2. rebaser ou fusionner la branche de travail sur `main`
  3. ouvrir une Merge Request / Pull Request pour révision

> Remarque : il est préférable de ne pas développer directement sur `main`. Travailler sur une branche dédiée permet de garder `main` stable.

## Installation

1. Copier `.env.example` en `.env`
2. Exécuter `composer install`
3. Exécuter `npm install`
4. Exécuter `php artisan key:generate`
5. Exécuter `php artisan migrate`
6. Exécuter `npm run dev`

## Notes

- Vous pouvez tester l'authentification et l'accès au tableau de bord.
- Si vous avez déjà poussé vos modifications sur `main`, signalez-le à l'équipe et vérifiez l'historique des commits.
