# Zones

Les zones sont les entités géographiques (ex. régions spécifiques, districts, comtés) qui appartiennent à un niveau de hiérarchie. Accessibles depuis le menu déroulant **Gérer** de la gestion sous **Configuration principale → Zones** (Super Admin uniquement).

## Importation de zones

La page d'importation propose deux méthodes :

### Importation par shapefile

1. Allez à la page Zones depuis le menu d'administration de gestion et cliquez sur **Importer**
2. Sélectionnez l'onglet **Shapefile**
3. Téléchargez trois fichiers :
   - `.shp` — géométrie du shapefile
   - `.shx` — index du shapefile
   - `.dbf` — données attributaires
4. Sélectionnez le **Niveau de zone** (hiérarchie) auquel ces zones appartiennent
5. Cliquez sur **Importer**

### Importation par tableur

1. Sélectionnez l'onglet **Tableur**
2. Téléchargez un fichier `.csv`
3. Pour chaque niveau de hiérarchie de zone configuré, mappez deux colonnes de votre tableur :
   - **Nom** — le nom lisible de la zone
   - **Code** — le code unique de la zone
   - **Remplir le code avec des zéros jusqu'à la longueur** — longueur de remplissage facultative pour le code (laisser à `0` pour aucun remplissage)
4. Cliquez sur **Importer**

## Modification d'une zone

1. Cliquez sur **Modifier** à côté d'une zone dans la liste
2. Mettez à jour le **Nom** multilingue
3. Cliquez sur **Mettre à jour**

## Téléchargement d'un modèle d'importation

Cliquez sur **Télécharger le modèle d'importation** sur la page d'index des zones pour obtenir un modèle CSV avec la structure de colonnes correcte pour les importations par tableur.

## Suppression de toutes les zones

1. Cliquez sur **Tout supprimer** sur la page d'index des zones
2. Confirmez dans la boîte de dialogue
3. Cela tronque tous les enregistrements de zone — la suppression individuelle de zones n'est pas prise en charge
