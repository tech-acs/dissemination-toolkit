# Dimensions

Dimensions (also referred to as variables) are descriptive attributes used to slice and filter data, such as sex, age group, or education level. In the Data Explorer and visualizations, users can pivot and filter by dimension values to break down indicators across different categories. Accessible from the management top navigation under **Data → Dimensions**.

## Creating a dimension

1. Go to the Dimensions page from the management top navigation
2. Click **Create**
3. Fill in the fields:
    - **Name** (multi-language)
    - **Description** (multi-language)
    - **Applies to** — select which fact tables (datasets) this dimension applies to
4. Click **Save**

The underlying database table is created automatically. Its name is derived from the dimension name by converting it to lowercase snake_case (e.g. "Age Group" becomes `age_group`).

## Managing dimension values

Once the dimension is saved, click **Values** on a dimension row to manage its values:

- **Create** — add a new value (e.g. "Male", "Female")
- **Edit** — update an existing value
- **Delete** — remove a value
- **Import** — bulk import values from a file (`manage/dimension/{dimension}/import-values`)
- **Delete All** — truncate all values for this dimension

## Editing a dimension

1. Click **Edit** next to a dimension
2. Update the fields as needed
3. Click **Update**

## Deleting a dimension

1. Click **Delete** next to a dimension
2. Confirm in the dialog

## Example: Sex dimension

Consider a **Sex** dimension. After creating it, you manage its dimension values:

| Code | Name | Rank |
|------|------|------|
| `_T` | Total | 0 |
| `M` | Male | 1 |
| `F` | Female | 2 |

Each value has a **code** (a stable, unique identifier) and a **name** (the human-readable label).

### Why codes matter

- **Dataset imports** — the importer matches dimension values by code, not name. This avoids issues from spelling differences, typos, or inconsistent naming between datasets.
- **Multi-language support** — the same code can have different display names per language (e.g. code `M` maps to "Male" in English and "Hombre" in Spanish), while keeping the underlying reference stable.

### The `_T` (Total) value

One value with code `_T` is required to mark the dimension as complete — the dimension list shows an incomplete icon until it exists. When a user explores data without filtering by this dimension, the system uses the `_T` value to return aggregate totals, which is essential for correct results when slicing and dicing in the Data Explorer.
