# Dimensions

Dimensions are descriptive attributes used to slice and filter data, such as sex, age group, or education level. Accessible at `manage/dimension`.

## Creating a dimension

1. Navigate to `manage/dimension`
2. Click **Create**
3. Fill in the fields:
   - **Name** (multi-language)
   - **Description** (multi-language)
   - **Code** — a unique identifier
   - **Applies to** — select which fact tables (datasets) this dimension applies to
4. Click **Save**

## Creating a dimension table

After creating a dimension, you must create its database table before adding values:

1. In the dimension list, click **Create Table** for the dimension
2. The system creates the underlying database table for storing dimension values

## Managing dimension values

Once the table exists, click **Values** on a dimension row to manage its values:

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
