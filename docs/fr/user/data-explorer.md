# Explorateur de données

L'explorateur de données est la fonctionnalité phare de la plateforme — une interface par pointage et clic pour explorer les données de recensement et d'enquêtes sans aucune programmation.

## Flux de travail

L'explorateur de données vous guide à travers un processus étape par étape :

1. **Sélectionner un thème** — choisissez un thème contenant les données dont vous avez besoin
2. **Sélectionner un jeu de données** — choisissez un jeu de données sous le thème sélectionné. Double-cliquez sur un jeu de données pour voir ses détails (indicateurs, dimensions, nombre d'observations, granularité géographique)
3. **Sélectionner des indicateurs** — choisissez un ou plusieurs indicateurs à inclure dans votre requête
4. **Sélectionner la géographie** — choisissez des zones géographiques à différents niveaux de hiérarchie (région, district, comté, etc.)
5. **Sélectionner des dimensions** — affinez votre requête par valeurs de dimension (ex. sexe, groupe d'âge). Développez chaque dimension pour sélectionner des valeurs spécifiques
6. **Tri** — choisissez une colonne pour trier les résultats
7. **Pivotage** — lorsqu'un seul indicateur est sélectionné, vous pouvez pivoter les données selon les dimensions (colonne, ligne et colonne d'imbrication facultative)
8. **Récupérer** — cliquez sur le bouton Récupérer pour obtenir les données

## Affichage des résultats

Les résultats sont affichés dans un tableau triable et paginé. Les badges de sélection au-dessus du tableau indiquent vos choix actuels.

## Téléchargement

Cliquez sur le bouton **Télécharger** pour exporter les données actuellement affichées dans un fichier Excel (`.xlsx`).

## Préremplissage via URL

Vous pouvez créer un lien direct vers l'explorateur de données avec un jeu de données ou un indicateur présélectionné :

- `?prefillDatasetId=X` — présélectionne un jeu de données
- `?prefillIndicatorId=X` — présélectionne un indicateur

## Réinitialiser

Le bouton **Réinitialiser** efface toutes les sélections et démarre une nouvelle requête.
