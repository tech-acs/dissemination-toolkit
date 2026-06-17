# Datasets

Datasets are collections of tabular data that power the platform. Each dataset contains indicators, dimensions, and observations. Accessible at `manage/dataset`.

## Creating a dataset

1. Navigate to `manage/dataset`
2. Click **Create**
3. Fill in the fields:
   - **Name** (multi-language)
   - **Description** (multi-language)
   - **Code** — a unique identifier
   - **Indicators** — select one or more indicators
   - **Geographic granularity** — the maximum area level
   - **Fact table** — select the database fact table
   - **Data source**
   - **Data date**
   - **Language**
   - **Dimensions** — select applicable dimensions
   - **Contributor**
   - **Format**
4. Click **Save**

## Editing a dataset

1. Click **Edit** next to a dataset
2. Update the fields
3. Click **Update**

## Importing data

1. Click **Import** next to a dataset (`manage/dataset/{dataset}/import`)
2. The Livewire `dataset-importer` component guides you through uploading data from an Excel or CSV file
3. Map columns and click **Import**

## Downloading an import template

Click **Template** next to a dataset to download a CSV template with the correct column structure for your imports.

## Truncating data

Click **Empty** to remove all observations from a dataset. This action requires confirmation.

## Publishing / unpublishing

Toggle the publish switch on a dataset row to control whether it appears on the public Datasets page.

## Deleting a dataset

1. Click **Delete** next to a dataset
2. Confirm in the dialog — this also removes associated data

A link to the **Tidy Data Maker** (`manage/tidy`) is available from the datasets index page for preparing data before import.
