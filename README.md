# 🔧 Projet de Stage — Numérisation du Processus de Fabrication de Jetons Caddie

## 1. Introduction

Ce projet a été réalisé dans le cadre d’un stage au **GRETA Lorraine Ouest**. Il vise à digitaliser le processus de fabrication des jetons de caddie à travers une application web développée avec Laravel et Bootstrap. L'application permet aux techniciens et superviseurs de gérer les recettes, les stocks, les jetons fabriqués et les ordres de fabrication (OF).

## 2. Prérequis Avant Démarrage

### Environnement requis :

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & npm
- Laravel 10+
- Un serveur local (comme Laragon, XAMPP ou Docker)

### Installation de la base de données :

- Un script SQL de création de la base est fourni dans le dossier `/database`.
- Exécutez-le dans votre SGBD pour créer les tables nécessaires.
- Configurez ensuite votre fichier `.env` avec vos informations MySQL.

## 3. Fonctionnalités Principales

### 🔐 Connexion Utilisateur

- Authentification par rôle : **Superviseur** ou **Technicien**.
- Utilisation de sessions et de jetons JWT pour la sécurité.
- Redirection vers les pages autorisées selon le rôle.

### 🧾 Ordres de Fabrication (OF)

- Affichage, création, modification et suppression d'OF.
- Suivi du statut de fabrication.

### 🪙 Gestion des Jetons

- Création d’un jeton à partir d’une **recette**.
- Déduction automatique des composants du stock lors de la fabrication.
- Visualisation des stocks de jetons.

### 📦 Gestion du Stock

- Suivi des matières premières disponibles.
- Mise à jour des quantités restantes après fabrication.

### 👥 Gestion du Personnel

- Le superviseur peut inscrire un nouveau technicien.
- Gestion des comptes utilisateurs.

## 4. Consignes d’Utilisation

### Format des champs :

- Date : `aaaa-mm-jj`
- Quantité : valeur entière positive
- Champs obligatoires : tous les champs de formulaire doivent être remplis correctement pour soumettre une action

### Navigation :

- Barre latérale ou de menu pour accéder aux sections : Jetons, OF, Stock, Personnel (selon le rôle).
- Les boutons permettent d’effectuer les actions classiques : ajouter, modifier, supprimer, actualiser.

## 5. Gestion des Données

### Sécurité :

- Requêtes SQL sécurisées via Eloquent ORM.
- Protection contre les injections SQL.
- Authentification basée sur des tokens (JWT) pour les API.

### Suppression des données :

- Confirmation demandée avant toute suppression.
- Les entités liées (ex. : recettes – jetons) sont prises en compte pour éviter les erreurs.

## 6. Interaction avec l’Interface Utilisateur

- Interface développée avec Blade et Bootstrap.
- Utilisation d’AJAX pour charger les contenus dynamiquement sans recharger la page.
- Affichage d’alertes de succès/erreur après chaque opération.

## 7. Recettes et Jetons

### Création de Recettes :

- Une recette associe plusieurs composants avec des quantités précises.
- Lorsqu’un jeton est fabriqué, les quantités de chaque composant sont automatiquement décrémentées.

### Ajout d’un Jeton :

- Sélection d’une recette.
- Saisie de la quantité à produire.
- Vérification du stock avant validation.

## 8. Structure Technique du Projet

