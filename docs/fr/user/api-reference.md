# API REST

Le Dissemination Toolkit expose une API HTTP en lecture seule conforme à la spécification JSON:API. Elle permet aux applications externes et aux scripts de consommer les données publiées du catalogue de manière programmatique.

Tous les endpoints nécessitent une authentification et retournent des réponses au format JSON:API.

## Authentification

Authentifiez-vous en utilisant l'une des méthodes suivantes :

| Méthode | Description |
|---|---|
| **Jeton Sanctum** | Passez `Authorization: Bearer {token}` dans l'en-tête de la requête |
| **Cookie de session** | Les requêtes provenant d'un navigateur authentifié sont automatiquement authentifiées |

Pour obtenir un jeton Sanctum, un administrateur doit en créer un via le tableau de bord ou via la ligne de commande.

## URL de base

```
https://votre-domaine.com/api
```

## Endpoints

### Jeux de données

| Méthode | Chemin | Description |
|---|---|---|
| `GET` | `/api/datasets` | Lister les jeux de données publiés |
| `GET` | `/api/datasets/{id}` | Afficher un jeu de données |
| `GET` | `/api/datasets/{id}/observations` | Observations paginées d'un jeu de données |
| `GET` | `/api/datasets/{id}/metadata` | Métadonnées d'un jeu de données |
| `GET` | `/api/datasets/{id}/download` | Télécharger un jeu de données au format CSV |

### Indicateurs

| Méthode | Chemin | Description |
|---|---|---|
| `GET` | `/api/indicators` | Lister les indicateurs |
| `GET` | `/api/indicators/{id}` | Afficher un indicateur |

### Thèmes

| Méthode | Chemin | Description |
|---|---|---|
| `GET` | `/api/topics` | Lister les thèmes |
| `GET` | `/api/topics/{id}` | Afficher un thème |

### Dimensions

| Méthode | Chemin | Description |
|---|---|---|
| `GET` | `/api/dimensions` | Lister les dimensions |
| `GET` | `/api/dimensions/{id}` | Afficher une dimension |
| `GET` | `/api/dimensions/{id}/values` | Lister les valeurs d'une dimension |

## Format de réponse

Toutes les réponses suivent la spécification [JSON:API](https://jsonapi.org) :

- **Les endpoints de liste** retournent un tableau `data` contenant des objets ressources, ainsi que `jsonapi` et optionnellement `meta` et `links`.
- **Les endpoints mono-ressource** retournent un objet `data` avec `type`, `id`, `attributes` et `links`.
- **Les métadonnées / observations** retournent les données sous une clé `meta`.

Chaque réponse inclut une clé `jsonapi` de premier niveau :

```json
{
  "jsonapi": {
    "version": "1.1"
  }
}
```

## Paramètres

### Pagination

Les endpoints de liste acceptent la pagination standard JSON:API via `page[size]` :

```
GET /api/datasets?page[size]=10
```

La taille de page par défaut est de 20.

### Ensembles de champs restreints (sparse fieldsets)

Limitez les attributs retournés avec `fields[typeRessource]` :

```
GET /api/datasets?fields[datasets]=code,published
```

### Documents composés

Incluez des ressources liées avec le paramètre `include` :

```
GET /api/datasets/{id}?include=topics,indicators
```

## Exemples

### Lister les jeux de données publiés

```bash
curl -H "Authorization: Bearer VOTRE_JETON" \
  https://votre-domaine.com/api/datasets
```

### Afficher un jeu de données avec ses ressources liées

```bash
curl -H "Authorization: Bearer VOTRE_JETON" \
  https://votre-domaine.com/api/datasets/1?include=topics,indicators,dimensions
```

### Télécharger un jeu de données au format CSV

```bash
curl -H "Authorization: Bearer VOTRE_JETON" \
  https://votre-domaine.com/api/datasets/1/download
```

### Récupérer les métadonnées d'un jeu de données

```bash
curl -H "Authorization: Bearer VOTRE_JETON" \
  https://votre-domaine.com/api/datasets/1/metadata
```

### Lister les valeurs d'une dimension

```bash
curl -H "Authorization: Bearer VOTRE_JETON" \
  https://votre-domaine.com/api/dimensions/1/values
```

## Réponses d'erreur

| Statut | Signification |
|---|---|
| `401` | Non authentifié — jeton manquant ou invalide |
| `404` | Ressource introuvable ou non publiée |
| `422` | Erreur de validation (paramètres invalides) |
| `500` | Erreur serveur |
