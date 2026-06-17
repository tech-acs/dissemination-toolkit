# Visualizations

The visualizations management section lets you create, edit, publish, and manage interactive data visualizations. Accessible from the management top navigation by selecting **Visualizations**.

## Creating a visualization

1. Go to the Visualizations page from the management top navigation
2. Click **Create New Visualization**
3. A popover appears with four visualization types: **Chart**, **Table**, **Map**, **Scorecard**

### Creating a visualization — 3-step flow

All four types follow the same three-step workflow:

**Step 1 — Data selection**
Use the data selection panel to select a dataset, indicators, dimensions, and geographic areas for your visualization.

**Step 2 — Customize**

| Type | Editor |
|---|---|
| **Chart** | Plotly editor with trace types: bar, line, scatter, pie, histogram, box, area, sunburst |
| **Table** | Table options panel — show/hide columns, enable filtering and sorting per column, set default sort order, and enable pagination, movable columns, and hover highlighting |
| **Map** | Map options — displayed indicator, zoom level, base map style, legend orientation, legend type, legend position, show legend, steps, color palette (37 options) |
| **Scorecard** | Scorecard options — title, title alignment, value alignment, background color, font color, width, height |

**Step 3 — Metadata**
Fill in:
- **Title** (multi-language)
- **Description** (multi-language)
- **Filterable by geography** — toggle to let users filter by area
- **Reviewable** — toggle to allow ratings and reviews
- **Tags**

Topics are inherited automatically from the indicators you selected in Step 1.

Click **Save** to store the visualization. It is saved as a draft; publishing is done separately from the visualization list.

## Editing a visualization

1. Click **Edit** next to a visualization
2. The editor reopens with your saved selections, allowing you to modify any step

## Publishing / unpublishing

Toggle the publish switch on a visualization row to control its visibility on the public Visualizations page. Requires the `publish-and-unpublish:viz` permission.

## Restricting / sharing

Toggle the restrict switch to limit a visualization to its owner only, or make it accessible to all users. Requires the `edit:viz` permission.

## Deleting a visualization

1. Click **Delete** next to a visualization
2. Confirm in the dialog. Requires the `delete:viz` permission.
