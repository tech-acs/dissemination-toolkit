# Visualizations

The visualizations management section lets you create, edit, publish, and manage interactive data visualisations. Accessible at `manage/visualization`.

## Creating a visualization

1. Navigate to `manage/visualization`
2. Click **Create New Visualization**
3. A popover appears with four visualisation types: **Chart**, **Table**, **Map**, **Scorecard**

### Viz Builder — 3-step wizard

All four types follow the same three-step wizard workflow:

**Step 1 — Data selection**
Use the **Data Shaper** component to select a dataset, indicators, dimensions, and geographic areas for your visualisation.

**Step 2 — Customise**

| Type | Editor |
|---|---|
| **Chart** | Plotly editor with trace types: bar, line, scatter, pie, histogram, box, area, sunburst |
| **Table** | Table options panel — column visibility, reordering |
| **Map** | Map options — displayed indicator, zoom level, base map style, legend position, colour palette (36 options) |
| **Scorecard** | Scorecard options — title, alignment, background colour, font colour, dimensions |

**Step 3 — Metadata**
Fill in:
- **Title** (multi-language)
- **Description** (multi-language)
- **Filterable by geography** — toggle to let users filter by area
- **Reviewable** — toggle to allow ratings and reviews
- **Tags**

Click **Save** to publish the visualisation.

## Editing a visualization

1. Click **Edit** next to a visualisation
2. The wizard reopens with your saved selections, allowing you to modify any step

## Publishing / unpublishing

Toggle the publish switch on a visualisation row to control its visibility on the public Visualizations page. Requires the `publish-and-unpublish:viz` permission.

## Restricting / sharing

Toggle the restrict switch to limit a visualisation to its owner only, or make it accessible to all users. Requires the `edit:viz` permission.

## Deleting a visualization

1. Click **Delete** next to a visualisation
2. Confirm in the dialog. Requires the `delete:viz` permission.
