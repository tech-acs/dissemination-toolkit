# Introduction

Le tableau de bord de gestion est l'endroit où les utilisateurs autorisés créent, gèrent et publient du contenu sur le Dissemination Toolkit. L'accès est contrôlé par un système de permissions basé sur les rôles.

Les comptes de gestionnaires sont généralement créés lors de la configuration/déploiement, mais peuvent également être créés en ligne de commande (CLI) à tout moment par la suite.

## Connexion

Cliquez sur le bouton **Connexion** dans le coin supérieur droit du site public (page d'accueil). Après vous être connecté avec vos identifiants, vous êtes redirigé vers le tableau de bord de gestion à l'adresse `/manage/home`.

## Modèle de permissions

La boîte à outils utilise des permissions granulaires. Chaque action (créer, modifier, supprimer, publier) sur chaque type de contenu (thèmes, indicateurs, dimensions, jeux de données, récits, visualisations, documents) est contrôlée par une permission spécifique. Les utilisateurs sont affectés à des **rôles**, et les rôles se voient accorder des permissions.

Un rôle **Super Admin** contourne toutes les vérifications de permissions et a accès à tout, y compris la gestion des utilisateurs, la configuration des rôles, la gestion des zones et les paramètres de l'organisation.

## Aperçu du tableau de bord

La page d'accueil de gestion présente une grille de cartes organisées en deux groupes :

### Données

- **Gérer les thèmes** — organiser les indicateurs, visualisations et récits en catégories sémantiques
- **Gérer les indicateurs** — créer, mettre à jour et affecter des indicateurs à des thèmes
- **Gérer les dimensions** — définir les attributs descriptifs utilisés pour découper les données
- **Gérer les jeux de données** — importer et gérer des collections de données tabulaires

### Contenu

- **Gérer les visualisations** — créer, personnaliser et partager des visualisations de données interactives
- **Gérer les récits** — créer des récits basés sur les données à l'aide du concepteur de récits
- **Gérer les documents** — télécharger des tableaux de recensement avec des métadonnées Dublin Core
- **Gérer les étiquettes** — les étiquettes vous aident à catégoriser et filtrer les artefacts pour une découverte et une organisation plus faciles

## Navigation

La barre de navigation supérieure fournit des liens rapides organisés en menus déroulants :

### Navigation principale

| Menu | Éléments |
|---|---|
| **Données** | Thèmes, Indicateurs, Dimensions, Jeux de données |
| **Contenu** | Visualisations, Récits de données, Documents, Étiquettes |

### Menu Gérer

Le menu déroulant **Gérer** (visible uniquement par les utilisateurs Super Admin) donne accès à la configuration avancée :

- **Contrôle d'accès** — Utilisateurs et Rôles
- **Configuration principale** — Hiérarchie des zones et Zones
- **Annonces**
- **Paramètres** — Détails de l'organisation et image de marque
