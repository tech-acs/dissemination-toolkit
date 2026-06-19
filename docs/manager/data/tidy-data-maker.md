# Tidy Data Maker

The Tidy Data Maker reshapes non-tidy data into a long, import-ready format. It is useful when your source data has values spread across multiple columns (for example, one column per year or per sex). Accessible from the datasets index page by clicking the **Tidy Data Maker** link.

## Using the Tidy Data Maker

### 1. Paste wide format data (CSV/TSV)

Paste your data into the text area. The tool accepts comma-, tab-, or semicolon-delimited data.

### 2. Select columns to melt/pivot

Checkboxes appear for each column in your pasted data. **Checked columns** are melted into variable/value rows. **Unchecked columns** remain as columns in the output.

Select the dimension and indicator to use for the melted columns:

- **New "Dimension" column name** — pick the dimension the melted column headers represent (e.g. Year, Sex)
- **New "Value" column name** — pick the indicator the values represent (e.g. Population count)

If any checked columns are named after an existing dimension or area hierarchy level, values will automatically be **codified** (labels replaced by database codes) in the Codified CSV output.

Click **Apply** to generate the reshaped data.

### 3. Tidy data (long format)

The reshaped data is displayed in a preview table and text area. From here you can:

- **Download CSV** — saves the tidy file with human-readable labels
- **Download Codified CSV** — saves the tidy file with dimension and area labels replaced by their database codes, ready for import

## Unmatched values

If any values in the checked columns cannot be matched to existing dimension or area codes, a warning is shown listing the unmapped values. You can optionally check **Exclude unmatched rows from all CSVs** to skip those rows in the output. After adjusting, click **Apply** again and download the file.

## Next step

Import the resulting file via the **Datasets** page (see [Importing data](/manager/data/datasets)).
