# Area Hierarchy

Area hierarchies define the geographic levels used throughout the platform, such as Region, District, County, or Ward. Accessible at `manage/area-hierarchy` (Super Admin only).

## Creating a hierarchy level

1. Navigate to `manage/area-hierarchy`
2. Click **Create**
3. Fill in the fields:
   - **Name** (multi-language) — e.g. "Region", "District"
   - **Zero pad length** — number of digits for zero-padding area codes
   - **Shape simplification tolerance** — tolerance value for simplifying shapefile geometries
4. Click **Save**

The order of hierarchy levels determines their display order in geographic filters throughout the platform.

## Editing a hierarchy level

1. Click **Edit** next to a hierarchy level
2. Update the fields as needed
3. Click **Update**

## Deleting a hierarchy level

1. Click **Delete** next to a hierarchy level
2. Confirm in the dialog

The list displays badges (First, Last) to indicate the ordering of levels in the hierarchy.
