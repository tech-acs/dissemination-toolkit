# Data Explorer

The Data Explorer is the platform's flagship feature — a point-and-click interface for exploring census and survey data without any programming.

## Workflow

The Data Explorer guides you through a step-by-step process:

1. **Select a Topic** — choose a topic that contains the data you need
2. **Select a Dataset** — pick a dataset under the chosen topic. Double-click a dataset to see its details (indicators, dimensions, observation count, geographic granularity)
3. **Select Indicators** — choose one or more indicators to include in your query
4. **Select Geography** — pick geographic areas at various hierarchy levels (region, district, county, etc.)
5. **Select Dimensions** — refine your query by dimension values (e.g. sex, age group). Expand each dimension to select specific values
6. **Sorting** — choose a column to sort the results by
7. **Pivoting** — when a single indicator is selected, you can pivot the data across dimensions (column, row, and optional nesting column)
8. **Fetch** — click the Fetch button to retrieve the data

## Viewing results

Results are displayed in a sortable, paginated table. Selection badges above the table show your current choices.

## Download

Click the **Download** button to export the currently displayed data as an Excel (`.xlsx`) file.

## Prefill via URL

You can link directly to the Data Explorer with a specific dataset or indicator pre-selected:

- `?prefillDatasetId=X` — pre-selects a dataset
- `?prefillIndicatorId=X` — pre-selects an indicator

## Reset

The **Reset** button clears all selections and starts a fresh query.
