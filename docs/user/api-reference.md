# REST API

The Dissemination Toolkit exposes a read-only JSON:API-compliant HTTP API. It allows external applications and scripts to consume published catalogue data programmatically.

All endpoints require authentication and return responses in the JSON:API format.

## Authentication

Authenticate using one of the following methods:

| Method | Description |
|---|---|
| **Sanctum token** | Pass `Authorization: Bearer {token}` in the request header |
| **Session cookie** | Same-origin requests from an authenticated browser session are automatically authenticated |

To obtain a Sanctum token, an administrator must create one through the management dashboard or via the command line.

## Base URL

```
https://your-domain.com/api
```

## Endpoints

### Datasets

| Method | Path | Description |
|---|---|---|
| `GET` | `/api/datasets` | List published datasets |
| `GET` | `/api/datasets/{id}` | Show a single dataset |
| `GET` | `/api/datasets/{id}/observations` | Paginated observations for a dataset |
| `GET` | `/api/datasets/{id}/metadata` | Metadata for a dataset |
| `GET` | `/api/datasets/{id}/download` | Download dataset as CSV |

### Indicators

| Method | Path | Description |
|---|---|---|
| `GET` | `/api/indicators` | List indicators |
| `GET` | `/api/indicators/{id}` | Show a single indicator |

### Topics

| Method | Path | Description |
|---|---|---|
| `GET` | `/api/topics` | List topics |
| `GET` | `/api/topics/{id}` | Show a single topic |

### Dimensions

| Method | Path | Description |
|---|---|---|
| `GET` | `/api/dimensions` | List dimensions |
| `GET` | `/api/dimensions/{id}` | Show a single dimension |
| `GET` | `/api/dimensions/{id}/values` | List values for a dimension |

## Response format

All responses follow the [JSON:API](https://jsonapi.org) specification:

- **List endpoints** return a `data` array containing resource objects, plus `jsonapi` and optionally `meta` and `links`.
- **Single-resource endpoints** return a `data` object with `type`, `id`, `attributes`, and `links`.
- **Metadata / observations** return the relevant data under a `meta` key.

Every response includes a top-level `jsonapi` key:

```json
{
  "jsonapi": {
    "version": "1.1"
  }
}
```

## Parameters

### Pagination

List endpoints accept JSON:API-standard pagination via `page[size]`:

```
GET /api/datasets?page[size]=10
```

The default page size is 20.

### Sparse fieldsets

Limit which attributes are returned using `fields[resourceType]`:

```
GET /api/datasets?fields[datasets]=code,published
```

### Compound documents

Include related resources with the `include` parameter:

```
GET /api/datasets/{id}?include=topics,indicators
```

## Examples

### List published datasets

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://your-domain.com/api/datasets
```

### Show a single dataset with related resources

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://your-domain.com/api/datasets/1?include=topics,indicators,dimensions
```

### Download a dataset as CSV

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://your-domain.com/api/datasets/1/download
```

### Fetch metadata for a dataset

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://your-domain.com/api/datasets/1/metadata
```

### List dimension values

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://your-domain.com/api/dimensions/1/values
```

## Error responses

| Status | Meaning |
|---|---|
| `401` | Unauthenticated — missing or invalid token |
| `404` | Resource not found or unpublished |
| `422` | Validation error (invalid parameters) |
| `500` | Server error |
