# Visualisations

La section de gestion des visualisations vous permet de créer, modifier, publier et gérer des visualisations de données interactives. Accessible depuis la navigation supérieure de gestion sous **Contenu → Visualisations**.

## Création d'une visualisation

1. Allez à la page Visualisations depuis la navigation supérieure de gestion
2. Cliquez sur **Créer une nouvelle visualisation**
3. Une fenêtre popover apparaît avec quatre types de visualisation : **Graphique**, **Tableau**, **Carte**, **Fiche synthétique**

### Étape 1 — Préparer les données

Le panneau de sélection de données vous guide à travers la configuration des données qui alimentent votre visualisation.

| Section | Description |
|---|---|
| **Thèmes** | Sélectionnez un thème. Les jeux de données et indicateurs sont filtrés par cette sélection. |
| **Jeux de données** | Sélectionnez un jeu de données dans le thème choisi. Double-cliquez sur une ligne pour voir les détails (indicateurs, dimensions, nombre d'observations). |
| **Indicateurs** | Sélectionnez un ou plusieurs indicateurs à inclure. |
| **Géographie** | Arbre hiérarchique des zones (ex. pays → province → commune). Chaque niveau a un bouton **Sélectionner tout** ; les zones individuelles peuvent être sélectionnées par case à cocher. |
| **Dimensions** | Cases à cocher pour chaque dimension disponible (ex. Sexe, Année). Développez une dimension pour sélectionner des valeurs spécifiques. La dimension **Année** est requise. |
| **Tri** | Après avoir sélectionné les dimensions, développez pour choisir les colonnes de tri et la direction. |
| **Pivotage** | Combobox **Colonne** et **Ligne** alimentés par les dimensions et la géographie sélectionnées. Disponible lorsqu'un seul indicateur est sélectionné. |

Après avoir configuré vos sélections, cliquez sur **Récupérer** pour obtenir et prévisualiser les données. Le bouton **Réinitialiser** efface toutes les sélections.

### Étape 2 — Conception

Les quatre types utilisent le même panneau d'étape 1 mais chacun a un éditeur de conception différent. L'indicateur d'étape en haut de la page montre votre position actuelle dans le flux de travail.

#### Graphique

L'éditeur de graphique est une interface de configuration Plotly complète avec les sections suivantes :

**Traces (Séries)**
Plusieurs traces peuvent être ajoutées (`+`), dupliquées (`⧉`), supprimées (`×`) et réorganisées (`↑↓`). Chaque trace a ses propres paramètres :

| Groupe | Options |
|---|---|
| **Type** | barres, lignes, nuage de points, secteurs, histogramme, boîte à moustaches, aires |
| **Données** | Colonne X, Colonne Y, Orientation (verticale / horizontale) |
| **Barres** | Couleur, Couleur de ligne, Largeur de ligne, Opacité (curseur) |
| **Position des barres** | Base, Décalage, Largeur |
| **Texte** | Colonne de texte, Position du texte (intérieur / extérieur / auto / aucun), Modèle de texte, Angle (curseur), Famille de polices, Taille, Couleur |
| **Survol** | Niveau d'info (tout / x / y / x+y / texte / nom / ignorer / aucun), Modèle, Fond d'étiquette, Bordure d'étiquette, Format de survol X/Y |
| **Légende** | Afficher dans la légende (case à cocher), Groupe de légende |
| **Disposition des barres** | Mode (groupé / empilé / superposé / relatif), Normalisation (fraction / pourcentage), Espacement (curseur), Espacement de groupe (curseur) |

**Axes**
Basculez entre **Axe X** et **Axe Y** pour configurer :
- Texte du titre
- Quadrillages

**Canevas, Titre et Légende**
- **Titre / Sous-titre** — cliquez directement sur le graphique pour modifier en ligne, ou configurez via le panneau
- **Légende** — placement et style

**Annotations**
Ajoutez des annotations textuelles au graphique.

**Barre de mode** (sur le graphique lui-même)
Télécharger le graphique en PNG, Zoomer, Déplacer, Zoom avant, Zoom arrière, Réinitialiser les axes.

**Barre d'outils inférieure**
Tout effacer, Exporter, Voir les données.

#### Tableau

| Option | Description |
|---|---|
| **Afficher / Masquer les colonnes** | Basculer la visibilité des colonnes |
| **Filtrage** | Activer les filtres par colonne |
| **Tri** | Activer le tri par colonne et définir l'ordre de tri par défaut |
| **Pagination** | Activer les lignes paginées |
| **Colonnes déplaçables** | Permettre aux utilisateurs de réorganiser les colonnes par glisser-déposer |
| **Surlignage au survol** | Surligner les lignes au survol |

#### Carte

| Option | Description |
|---|---|
| **Indicateur** | Sélectionner l'indicateur affiché sur la carte |
| **Niveau de zoom** | Niveau de zoom initial |
| **Style de carte de base** | Style des tuiles de carte |
| **Légende** | Orientation (horizontale / verticale), Type, Position, Afficher/masquer, Étapes |
| **Palette de couleurs** | 37 options de palette |

#### Fiche synthétique

| Option | Description |
|---|---|
| **Titre** | Titre affiché et son alignement |
| **Alignement de la valeur** | Alignement de la valeur affichée |
| **Couleur de fond** | Couleur de remplissage |
| **Couleur de police** | Couleur du texte |
| **Largeur / Hauteur** | Dimensions de la carte |

### Étape 3 — Ajouter des métadonnées et enregistrer

Remplissez les métadonnées de votre visualisation :

- **Titre** (multilingue)
- **Description** (multilingue)
- **Filtrable par géographie** — basculer pour permettre aux utilisateurs de filtrer par zone
- **Évaluable** — basculer pour autoriser les évaluations et avis
- **Étiquettes**

Les thèmes sont hérités automatiquement des indicateurs sélectionnés à l'étape 1.

Cliquez sur **Enregistrer** pour stocker la visualisation. Elle est enregistrée comme brouillon ; la publication se fait séparément depuis la liste des visualisations.

## Modification d'une visualisation

1. Cliquez sur **Modifier** à côté d'une visualisation
2. L'éditeur s'ouvre avec vos sélections enregistrées, vous permettant de modifier n'importe quelle étape

## Publication / dépublication

Basculez l'interrupteur de publication sur une ligne de visualisation pour contrôler sa visibilité sur la page publique Visualisations. Nécessite la permission **Publier et dépublier**.

## Restriction / partage

Basculez l'interrupteur de restriction pour limiter une visualisation à son propriétaire uniquement, ou la rendre accessible à tous les utilisateurs. Nécessite la permission **Modifier**.

## Suppression d'une visualisation

1. Cliquez sur **Supprimer** à côté d'une visualisation
2. Confirmez dans la boîte de dialogue. Nécessite la permission **Supprimer**.
