# Areas

Areas are the geographic entities (e.g. specific regions, districts, counties) that belong to a hierarchy level. Accessible from the management admin menu (wrench icon) under **Core Configuration → Areas** (Super Admin only).

## Importing areas

The import page provides two methods:

### Shapefile import

1. Go to the Areas page from the management admin menu and click **Import**
2. Select the **Shapefile** tab
3. Upload three files:
   - `.shp` — shapefile geometry
   - `.shx` — shapefile index
   - `.dbf` — attribute data
4. Select the **Area Level** (hierarchy) these areas belong to
5. Click **Import**

### Spreadsheet import

1. Select the **Spreadsheet** tab
2. Upload a `.csv` file
3. For each configured area hierarchy level, map two columns from your spreadsheet:
   - **Name** — the human-readable area name
   - **Code** — the unique area code
   - **Zero pad code to length** — optional padding length for the code (leave at `0` for no padding)
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
