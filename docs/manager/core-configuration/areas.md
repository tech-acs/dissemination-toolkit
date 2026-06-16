# Areas

Areas are the geographic entities (e.g. specific regions, districts, counties) that belong to a hierarchy level. Accessible at `manage/area` (Super Admin only).

## Importing areas

The import page provides two methods:

### Shapefile import

1. Navigate to `manage/area` and click **Import**
2. Select the **Shapefile** tab
3. Upload three files:
   - `.shp` — shapefile geometry
   - `.shx` — shapefile index
   - `.dbf` — attribute data
4. Select the **Area Level** (hierarchy) these areas belong to
5. Click **Import**

### Spreadsheet import

1. Select the **Spreadsheet** tab
2. Use the Livewire `area-spreadsheet-importer` component to upload your data
3. Map columns to the expected fields
4. Click **Import**

## Editing an area

1. Click **Edit** next to an area in the list
2. Update the multi-language **Name**
3. Click **Update**

## Downloading an import template

Click **Download Import Template** on the areas index page to get a CSV template with the correct column structure for spreadsheet imports.

## Deleting all areas

1. Click **Delete All** on the areas index page
2. Confirm in the dialog
3. This truncates all area records — individual area deletion is not supported
