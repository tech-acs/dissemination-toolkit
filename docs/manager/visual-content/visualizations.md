# Visualizations

The visualizations management section lets you create, edit, publish, and manage interactive data visualizations. Accessible from the management top navigation under **Content → Visualizations**.

## Creating a visualization

1. Go to the Visualizations page from the management top navigation
2. Click **Create New Visualization**
3. A popover appears with four visualization types: **Chart**, **Table**, **Map**, **Scorecard**

### Step 1 — Prepare data

The data selection panel guides you through configuring the data that powers your visualization.

| Section | Description |
|---|---|
| **Topics** | Select a topic. Datasets and indicators are filtered by this selection. |
| **Datasets** | Select a dataset from the chosen topic. Double-click a row to see details (indicators, dimensions, observation count). |
| **Indicators** | Select one or more indicators to include. |
| **Geography** | Hierarchical area tree (e.g. country → province → commune). Each level has a **Select all** toggle; individual areas can be selected by checkbox. |
| **Dimensions** | Checkboxes for each available dimension (e.g. Sex, Year). Expand a dimension to select specific values. The **Year** dimension is required. |
| **Sorting** | After selecting dimensions, expand to choose sort columns and direction. |
| **Pivoting** | **Column** and **Row** comboboxes populated from selected dimensions and geography. Available when a single indicator is selected. |

After configuring your selections, click **Fetch** to retrieve and preview the data. The **Reset** button clears all selections.

### Step 2 — Design

All four types use the same Step 1 panel but each has a different design editor. The step indicator at the top of the page shows your current position in the workflow.

#### Chart

The chart editor is a full Plotly configuration interface with the following sections:

**Traces (Series)**
Multiple traces can be added (`+`), duplicated (`⧉`), deleted (`×`), and reordered (`↑↓`). Each trace has its own settings:

| Group | Options |
|---|---|
| **Type** | bar, line, scatter, pie, histogram, box, area |
| **Data** | X column, Y column, Orientation (vertical / horizontal) |
| **Bars** | Color, Line color, Line width, Opacity (slider) |
| **Bar Position** | Base, Offset, Width |
| **Text** | Text column, Text position (inside / outside / auto / none), Text template, Angle (slider), Font family, Size, Color |
| **Hover** | Info level (all / x / y / x+y / text / name / skip / none), Template, Label background, Label border, X/Y hover format |
| **Legend** | Show in legend (checkbox), Legend group |
| **Bar Layout** | Mode (group / stack / overlay / relative), Normalization (fraction / percent), Gap (slider), Group gap (slider) |

**Axes**
Toggle between **X Axis** and **Y Axis** to configure:
- Title text
- Gridlines

**Canvas, Title & Legend**
- **Title / Subtitle** — click directly on the chart to edit inline, or configure via the panel
- **Legend** — placement and styling

**Annotations**
Add text annotations to the chart.

**Modebar** (on the chart itself)
Download plot as PNG, Zoom, Pan, Zoom in, Zoom out, Reset axes.

**Bottom toolbar**
Clear All, Export, View Data.

#### Table

| Option | Description |
|---|---|
| **Show / Hide columns** | Toggle column visibility |
| **Filtering** | Enable per-column filters |
| **Sorting** | Enable per-column sorting and set default sort order |
| **Pagination** | Enable paginated rows |
| **Movable columns** | Let users reorder columns by dragging |
| **Hover highlighting** | Highlight rows on hover |

#### Map

| Option | Description |
|---|---|
| **Indicator** | Select the indicator displayed on the map |
| **Zoom level** | Initial zoom level |
| **Base map style** | Map tile style |
| **Legend** | Orientation (horizontal / vertical), Type, Position, Show/hide toggle, Steps |
| **Color palette** | 37 palette options |

#### Scorecard

| Option | Description |
|---|---|
| **Title** | Displayed title and its alignment |
| **Value alignment** | Alignment of the displayed value |
| **Background color** | Fill color |
| **Font color** | Text color |
| **Width / Height** | Card dimensions |

### Step 3 — Add metadata & save

Fill in the metadata for your visualization:

- **Title** (multi-language)
- **Description** (multi-language)
- **Filterable by geography** — toggle to let users filter by area
- **Reviewable** — toggle to allow ratings and reviews
- **Tags**

Topics are inherited automatically from the indicators selected in Step 1.

Click **Save** to store the visualization. It is saved as a draft; publishing is done separately from the visualization list.

## Editing a visualization

1. Click **Edit** next to a visualization
2. The editor reopens with your saved selections, allowing you to modify any step

## Publishing / unpublishing

Toggle the publish switch on a visualization row to control its visibility on the public Visualizations page. Requires the **Publish and unpublish** permission.

## Restricting / sharing

Toggle the restrict switch to limit a visualization to its owner only, or make it accessible to all users. Requires the **Edit** permission.

## Deleting a visualization

1. Click **Delete** next to a visualization
2. Confirm in the dialog. Requires the **Delete** permission.
