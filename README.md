# Projet de Stage — Numérisation du Processus de Fabrication de Jetons Caddie

## 1. Introduction

Ce projet a été réalisé dans le cadre d’un stage au **GRETA Lorraine Ouest**. Il vise à digitaliser le processus de fabrication des jetons de caddie à travers une application web développée avec Laravel et Bootstrap. L'application permet aux techniciens et superviseurs de gérer les recettes, les stocks, les ordres de fabrication (OF), les controles de qualité et les fiches de livraison.

## 2. Prérequis Avant Démarrage

### Environnement requis :

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Laravel 10+
- Un serveur local 

### Installation de la base de données :

- Un script SQL de création de la base est fourni dans la racine du projet`.
- Exécutez-le dans votre SGBD pour créer les tables nécessaires.
- Configurez ensuite votre fichier `.env` avec vos informations MySQL.

## 3. Fonctionnalités Principales

### 🔐 Connexion Utilisateur

- Authentification par rôle : **Superviseur** ou **Technicien**.
- Utilisation de sessions et de jetons JWT pour la sécurité.
- Redirection vers les pages autorisées selon le rôle.
 - *Identifiant par défaut* : admin
  - *Mot de passe par défaut* : admin
  
### Produit
- Création et affichage de produits avec leurs quantités. 
- Ces produits sont des matières premières permettant de fabriquer des jetons.

### Recette
  
- Création de recettes à partir de produits existants.
- Chaque recette peut contenir plusieurs composants avec des quantités précises
    
    
### Ordres de Fabrication (OF)

- Affichage, création et modification d'OF.
- Suivi du statut de fabrication (en cours, terminé, annulé).
  

### Controle de qualité

- formulaire permettant de saisir les caractéristiques (épaisseur, diamètre, couleur) des 4 premiers jetons produits pour chaque OF. 
- En fonction des valeurs de chaque caractéristique, le système donne automatiquement le résultat de conformité .
  

### Fiche de livraison
- Création d’une fiche de livraison pour chaque OF terminé, avec la date de fin et le technicien responsable.

### Gestion du Stock

- Suivi des matières premières disponibles.
- Mise à jour des quantités restantes après fabrication.

### 👥 Gestion du Personnel

- Le superviseur peut inscrire un nouveau technicien.
- Gestion des comptes utilisateurs.

## 4. Consignes d’Utilisation

### Format des champs :

- Date : `jj-mm-aaaa`
- Quantité : valeur décimale
- Champs obligatoires : tous les champs de formulaire doivent être remplis correctement pour soumettre une action

### Navigation :

- Barre latérale ou de menu pour accéder aux sections : OF, Stock, Personnel (selon le rôle).
- Les boutons permettent d’effectuer les actions classiques : ajouter, modifier, supprimer, actualiser.

## 5. Gestion des Données

### Sécurité :

- Requêtes SQL sécurisées via Eloquent ORM.
- Protection contre les injections SQL.
- Authentification basée sur des tokens (JWT) pour les API.

### Suppression des données :

- Confirmation demandée avant toute suppression.
- Les entités liées (ex. : recettes – ordreFabrication) sont prises en compte pour éviter les erreurs.

## 6. Interaction avec l’Interface Utilisateur

- Interface développée avec Blade et Bootstrap.
- Utilisation d’AJAX pour charger les contenus dynamiquement sans recharger la page.
- Affichage d’alertes de succès/erreur après chaque opération.


