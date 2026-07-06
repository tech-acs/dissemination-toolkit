# Jeux de données

Les jeux de données sont des collections de données tabulaires qui alimentent la plateforme. Chaque jeu de données contient des indicateurs, des dimensions et des observations. Accessibles depuis la navigation supérieure de gestion sous **Données → Jeux de données**.

## Création d'un jeu de données

1. Allez à la page Jeux de données depuis la navigation supérieure de gestion
2. Cliquez sur **Créer**
3. Remplissez les champs :
   - **Nom** (multilingue)
   - **Description** (multilingue)
   - **Indicateurs** — sélectionnez un ou plusieurs indicateurs
   - **Granularité géographique des données** — le niveau géographique le plus fin pour lequel des données sont disponibles
   - **Table de faits** — sélectionnez la table de faits de la base de données qui stockera les données
   - **Dimensions** — sélectionnez les dimensions applicables
     - La dimension **année** est requise.
4. Cliquez sur **Enregistrer**

## Modification d'un jeu de données

1. Cliquez sur **Modifier** à côté d'un jeu de données
2. Mettez à jour les champs
3. Cliquez sur **Mettre à jour**

## Téléchargement d'un modèle d'importation

Cliquez sur **Modèle** à côté d'un jeu de données pour télécharger un modèle CSV. Le modèle est généré à partir de la configuration du jeu de données — il comprend des colonnes pour chaque indicateur, dimension et niveau géographique sélectionné, avec des codes pré-remplis au bon format. Cela garantit que votre fichier d'importation correspond exactement à ce que le système attend, réduisant les erreurs de mappage de colonnes.

Si vos données sources sont en format large (ex. une colonne par année), utilisez l'**Outil de mise en forme de données** pour les remodeler au format long qui correspond au modèle. L'outil de mise en forme est accessible depuis la page d'index des jeux de données.

## Importation de données

1. Préparez vos données à l'aide du modèle (voir ci-dessus)
2. Cliquez sur **Importer** à côté d'un jeu de données (`manage/dataset/{dataset}/import`)
3. L'importateur de jeu de données vous guide pour télécharger un fichier Excel ou CSV
4. Mappez les colonnes et cliquez sur **Importer**

## Tronquer les données

Cliquez sur **Vider** pour supprimer toutes les observations d'un jeu de données. Cette action nécessite une confirmation.

## Publication / dépublication

Basculez l'interrupteur de publication sur une ligne de jeu de données pour contrôler s'il apparaît sur la page publique Jeux de données.

## Suppression d'un jeu de données

1. Cliquez sur **Supprimer** à côté d'un jeu de données
2. Confirmez dans la boîte de dialogue — cela supprime également les données associées
