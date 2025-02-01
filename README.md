# Projet de Gestion des Réservations pour Chambres d'Hôtes

Bienvenue dans l'application de réservation pour chambres d'hôtes. Ce projet comprend une API backend en Symfony, une interface utilisateur (frontend) en React, et une application mobile en React Native. L'objectif est de fournir une solution intuitive pour gérer les réservations, les disponibilités et les interactions avec les clients.

## Table des Matières

- [Prérequis](#prérequis)
- [Installation](#installation)
  - [Backend (Symfony)](#backend-symfony)
- [Fonctionnalités](#fonctionnalités)
- [Technologies Utilisées](#technologies-utilisées)
- [Contribution](#contribution)
- [Licence](#licence)

---

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre système :

- PHP 8.2 ou plus
- Composer
- Node.js (version 18 ou plus)
- npm ou yarn
- Docker (optionnel)

---

## Installation

### Backend (Symfony)

1. Clonez le dépôt du projet :
   ```bash
   git clone https://github.com/votre-utilisateur/votre-repo.git
   ```

2. Installez les dépendances PHP avec Composer :
   ```bash
   composer install
   ```

3. Configurez votre fichier `.env` :
   ```bash
   cp .env.example .env
   ```

4. Gérez la base de données :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. Lancez le serveur de développement :
   ```bash
   symfony server:start
   ```
---

## Fonctionnalités

- **Réservations en ligne** : Les utilisateurs peuvent rechercher et réserver des chambres disponibles.
- **Gestion des disponibilités** : Les propriétaires peuvent mettre à jour leurs calendriers.
- **Notifications** : Envoi d'emails pour confirmer les réservations et rappels.
- **Tableau de bord** : Interface intuitive pour suivre les réservations et les statistiques.

---

## Technologies Utilisées

- **Backend** : Symfony 7.2
- **Base de données** : MySQL
- **Frontend** : React
- **Mobile** : React Native avec Expo

---
