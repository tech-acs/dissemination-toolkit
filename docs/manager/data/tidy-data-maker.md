# Tidy Data Maker

The Tidy Data Maker reshapes non-tidy data into a long, import-ready format. It is useful when your source data has values spread across multiple columns (for example, one column per year or per sex). Accessible from the datasets index page by clicking the **Tidy Data Maker** link.

## Using the Tidy Data Maker

1. Go to the Tidy Data Maker page from the datasets index page
2. Paste your data into the text area. The tool accepts comma-, tab-, or semicolon-delimited data
3. Select the columns you want to **melt** (reshape from wide to long)
4. Provide names for the two new columns:
   - **Dimension column** — the name of the dimension the melted headers represent (for example, `Year` or `Sex`)
   - **Value column** — the name of the indicator value (for example, `Population`)
5. The preview shows the reshaped tidy data
6. Click **Download CSV** to save the tidy file, or **Download Codified CSV** to replace dimension and area labels with their database codes
7. Import the resulting file via the **Datasets** page

The tool warns you if any labels cannot be matched to existing dimension or area codes, and can optionally skip unmatched rows when generating the codified output.
