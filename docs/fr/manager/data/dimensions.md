# Dimensions

Les dimensions (aussi appelées variables) sont des attributs descriptifs utilisés pour découper et filtrer les données, tels que le sexe, le groupe d'âge ou le niveau d'éducation. Dans l'explorateur de données et les visualisations, les utilisateurs peuvent pivoter et filtrer par valeurs de dimension pour décomposer les indicateurs selon différentes catégories. Accessibles depuis la navigation supérieure de gestion sous **Données → Dimensions**.

## Création d'une dimension

1. Allez à la page Dimensions depuis la navigation supérieure de gestion
2. Cliquez sur **Créer**
3. Remplissez les champs :
    - **Nom** (multilingue)
    - **Description** (multilingue)
    - **S'applique à** — sélectionnez les tables de faits (jeux de données) auxquelles cette dimension s'applique
4. Cliquez sur **Enregistrer**

La table de base de données sous-jacente est créée automatiquement. Son nom est dérivé du nom de la dimension en le convertissant en snake_case minuscule (ex. « Groupe d'âge » devient `groupe_d_age`).

## Gestion des valeurs de dimension

Une fois la dimension enregistrée, cliquez sur **Valeurs** sur une ligne de dimension pour gérer ses valeurs :

- **Créer** — ajouter une nouvelle valeur (ex. « Homme », « Femme »)
- **Modifier** — mettre à jour une valeur existante
- **Supprimer** — supprimer une valeur
- **Importer** — importer en masse des valeurs depuis un fichier (`manage/dimension/{dimension}/import-values`)
- **Tout supprimer** — tronquer toutes les valeurs de cette dimension

## Modification d'une dimension

1. Cliquez sur **Modifier** à côté d'une dimension
2. Mettez à jour les champs si nécessaire
3. Cliquez sur **Mettre à jour**

## Suppression d'une dimension

1. Cliquez sur **Supprimer** à côté d'une dimension
2. Confirmez dans la boîte de dialogue

## Exemple : dimension Sexe

Considérez une dimension **Sexe**. Après l'avoir créée, vous gérez ses valeurs :

| Code | Nom | Rang |
|------|------|------|
| `_T` | Total | 0 |
| `M` | Homme | 1 |
| `F` | Femme | 2 |

Chaque valeur a un **code** (un identifiant stable et unique) et un **nom** (le libellé lisible).

### Pourquoi les codes sont importants

- **Importations de jeux de données** — l'importateur correspond aux valeurs de dimension par code, et non par nom. Cela évite les problèmes liés aux différences d'orthographe, aux coquilles ou au nommage incohérent entre les jeux de données.
- **Support multilingue** — le même code peut avoir des noms d'affichage différents selon la langue (ex. le code `M` correspond à « Homme » en français et « Male » en anglais), tout en gardant la référence sous-jacente stable.

### La valeur `_T` (Total)

Une valeur avec le code `_T` est requise pour marquer la dimension comme complète — la liste des dimensions affiche une icône incomplète tant qu'elle n'existe pas. Lorsqu'un utilisateur explore les données sans filtrer par cette dimension, le système utilise la valeur `_T` pour renvoyer les totaux agrégés, ce qui est essentiel pour des résultats corrects lors du découpage dans l'explorateur de données.
