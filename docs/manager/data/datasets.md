# Datasets

Datasets are collections of tabular data that power the platform. Each dataset contains indicators, dimensions, and observations. Accessible from the management top navigation under **Data → Datasets**.

## Creating a dataset

1. Go to the Datasets page from the management top navigation
2. Click **Create**
3. Fill in the fields:
   - **Name** (multi-language)
   - **Description** (multi-language)
   - **Indicators** — select one or more indicators
   - **Data geographic granularity** — the finest geographic level for which data is available
   - **Fact table** — select the database fact table that will store the data
   - **Dimensions** — select applicable dimensions
     - The **year** dimension is required.
4. Click **Save**

## Editing a dataset

1. Click **Edit** next to a dataset
2. Update the fields
3. Click **Update**

## Downloading an import template

Click **Template** next to a dataset to download a CSV template. The template is generated from the dataset's configuration — it includes columns for each selected indicator, dimension, and geographic level, with codes pre-filled in the correct format. This ensures your import file matches exactly what the system expects, reducing column-mapping errors.

If your source data is in a wide format (e.g. one column per year), use the **Tidy Data Maker** to reshape it into the long format that matches the template. The Tidy Data Maker is accessible from the datasets index page.

## Importing data

1. Prepare your data using the template (see above)
2. Click **Import** next to a dataset (`manage/dataset/{dataset}/import`)
3. The dataset importer guides you through uploading an Excel or CSV file
4. Map columns and click **Import**

## Truncating data

Click **Empty** to remove all observations from a dataset. This action requires confirmation.

## Publishing / unpublishing

Toggle the publish switch on a dataset row to control whether it appears on the public Datasets page.

## Deleting a dataset

1. Click **Delete** next to a dataset
 2. Confirm in the dialog — this also removes associated data
