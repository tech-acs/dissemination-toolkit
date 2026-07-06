# Tidy Data Maker

The Tidy Data Maker reshapes non-tidy data into a long, import-ready format. It is useful when your source data has values spread across multiple columns (for example, one column per year or per sex). Accessible from the datasets index page by clicking the **Tidy Data Maker** link.

## Using the Tidy Data Maker

### 1. Paste wide format data (CSV/TSV)

Paste your data into the text area. The tool accepts comma-, tab-, or semicolon-delimited data.

What you **name** your columns determines what gets codified; what you **check** (in step 2) determines what gets melted.

<div class="tidy-cols-visual">

<div class="tidy-cols-legend">
<span class="tidy-cols-chip tidy-cols-area">Area hierarchy level name → codified to area code</span>
<span class="tidy-cols-chip tidy-cols-dim">Dimension name → codified to value code</span>
<span class="tidy-cols-chip tidy-cols-melt">Dimension value, checked → melted &amp; codified</span>
<span class="tidy-cols-chip tidy-cols-carry">Dimension value, unchecked → carried over, not codified</span>
</div>

<div class="tidy-cols-case">
<div class="tidy-cols-case-title">Case 1 — Area pivot <span class="tidy-cols-badge">the usual case</span></div>
<div class="tidy-cols-pair">
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Wide (pasted)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-area">Province</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Male</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Female</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Total</th>
</tr></thead>
<tbody>
<tr><td>North</td><td>100</td><td>120</td><td>220</td></tr>
<tr><td>South</td><td>80</td><td>90</td><td>170</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot"><span class="tidy-cols-area">area code</span><span class="tidy-cols-melt">melt → Sex</span><span class="tidy-cols-melt">melt → Sex</span><span class="tidy-cols-melt">melt → Sex</span></div>
</div>
<div class="tidy-cols-arrow">→</div>
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Tidy (long)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-area">Province</th>
<th class="tidy-cols-dim">Sex</th>
<th>Population</th>
</tr></thead>
<tbody>
<tr><td>North</td><td>Male</td><td>100</td></tr>
<tr><td>North</td><td>Female</td><td>120</td></tr>
<tr><td>North</td><td>Total</td><td>220</td></tr>
<tr><td>South</td><td>Male</td><td>80</td></tr>
<tr class="tidy-cols-ellipsis"><td>…</td><td>…</td><td>…</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot" style="--cols:3"><span class="tidy-cols-area">area code</span><span class="tidy-cols-dim">value code</span><span>value</span></div>
</div>
</div>
</div>

<div class="tidy-cols-case">
<div class="tidy-cols-case-title">Case 2 — Dimension pivot</div>
<div class="tidy-cols-pair">
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Wide (pasted)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-dim">Age group</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Male</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Female</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Total</th>
</tr></thead>
<tbody>
<tr><td>0-4</td><td>40</td><td>38</td><td>78</td></tr>
<tr><td>5-9</td><td>45</td><td>42</td><td>87</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot"><span class="tidy-cols-dim">value code</span><span class="tidy-cols-melt">melt → Sex</span><span class="tidy-cols-melt">melt → Sex</span><span class="tidy-cols-melt">melt → Sex</span></div>
</div>
<div class="tidy-cols-arrow">→</div>
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Tidy (long)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-dim">Age group</th>
<th class="tidy-cols-dim">Sex</th>
<th>Population</th>
</tr></thead>
<tbody>
<tr><td>0-4</td><td>Male</td><td>40</td></tr>
<tr><td>0-4</td><td>Female</td><td>38</td></tr>
<tr><td>0-4</td><td>Total</td><td>78</td></tr>
<tr><td>5-9</td><td>Male</td><td>45</td></tr>
<tr class="tidy-cols-ellipsis"><td>…</td><td>…</td><td>…</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot" style="--cols:3"><span class="tidy-cols-dim">value code</span><span class="tidy-cols-dim">value code</span><span>value</span></div>
</div>
</div>
</div>

<div class="tidy-cols-case">
<div class="tidy-cols-case-title">Case 3 — Extra dimensions carried over <span class="tidy-cols-badge">selection drives the split</span></div>
<div class="tidy-cols-pair">
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Wide (pasted)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-area">Province</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Male</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Female</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Total</th>
<th class="tidy-cols-carry"><span class="tidy-cols-check tidy-cols-unchecked">○</span> Urban</th>
<th class="tidy-cols-carry"><span class="tidy-cols-check tidy-cols-unchecked">○</span> Rural</th>
</tr></thead>
<tbody>
<tr><td>North</td><td>100</td><td>120</td><td>220</td><td>60</td><td>160</td></tr>
<tr><td>South</td><td>80</td><td>90</td><td>170</td><td>50</td><td>120</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot" style="--cols:6"><span class="tidy-cols-area">area code</span><span class="tidy-cols-melt">melt → Sex</span><span class="tidy-cols-melt">melt → Sex</span><span class="tidy-cols-melt">melt → Sex</span><span class="tidy-cols-carry">carried over</span><span class="tidy-cols-carry">carried over</span></div>
</div>
<div class="tidy-cols-arrow">→</div>
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Tidy (long)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-area">Province</th>
<th class="tidy-cols-carry">Urban</th>
<th class="tidy-cols-carry">Rural</th>
<th class="tidy-cols-dim">Sex</th>
<th>Population</th>
</tr></thead>
<tbody>
<tr><td>North</td><td>60</td><td>160</td><td>Male</td><td>100</td></tr>
<tr><td>North</td><td>60</td><td>160</td><td>Female</td><td>120</td></tr>
<tr><td>North</td><td>60</td><td>160</td><td>Total</td><td>220</td></tr>
<tr><td>South</td><td>50</td><td>120</td><td>Male</td><td>80</td></tr>
<tr class="tidy-cols-ellipsis"><td>…</td><td>…</td><td>…</td><td>…</td><td>…</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot" style="--cols:5"><span class="tidy-cols-area">area code</span><span class="tidy-cols-carry">unchanged</span><span class="tidy-cols-carry">unchanged</span><span class="tidy-cols-dim">value code</span><span>value</span></div>
</div>
</div>
<div class="tidy-cols-callout">Only one dimension can be melted at a time. Check Male/Female/Total to melt into Sex; leave Urban/Rural unchecked and they ride along on every row, un-codified.</div>
</div>

<div class="tidy-cols-caption">A column is codified if its name matches an area hierarchy level or a dimension. Among dimension-value-named columns, the ones you <b>check</b> get melted and codified against the chosen dimension; the ones you leave <b>unchecked</b> are carried over unchanged.</div>

</div>

<style>
.tidy-cols-visual { margin: 24px 0; padding: 20px; border: 1px solid var(--vp-c-border); border-radius: 8px; background: var(--vp-c-bg-soft); font-size: 13px; }
.tidy-cols-legend { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
.tidy-cols-chip { padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 500; border: 1px solid; }
.tidy-cols-area { background: rgba(16,131,118,.12); border-color: rgba(16,131,118,.4); color: #0f766e; }
.tidy-cols-dim { background: rgba(59,130,246,.12); border-color: rgba(59,130,246,.4); color: #1d4ed8; }
.tidy-cols-melt { background: rgba(217,119,6,.14); border-color: rgba(217,119,6,.45); color: #b45309; }
.tidy-cols-carry { background: rgba(100,116,139,.14); border-color: rgba(100,116,139,.4); color: #475569; }
.tidy-cols-case { margin-bottom: 24px; padding: 14px; border: 1px solid var(--vp-c-divider); border-radius: 6px; background: var(--vp-c-bg); }
.tidy-cols-case:last-of-type { margin-bottom: 16px; }
.tidy-cols-case-title { font-weight: 600; margin-bottom: 10px; font-size: 14px; }
.tidy-cols-badge { display: inline-block; margin-left: 8px; padding: 1px 8px; border-radius: 999px; font-size: 11px; font-weight: 500; background: var(--vp-c-default-soft); color: var(--vp-c-text-2); border: 1px solid var(--vp-c-divider); }
.tidy-cols-pair { display: flex; align-items: flex-start; gap: 16px; flex-wrap: wrap; }
.tidy-cols-table-wrap { flex: 1 1 240px; min-width: 0; }
.tidy-cols-label { font-size: 11px; text-transform: uppercase; letter-spacing: .04em; color: var(--vp-c-text-2); margin-bottom: 4px; }
.tidy-cols-table { border-collapse: collapse; width: 100%; font-variant-numeric: tabular-nums; }
.tidy-cols-table th, .tidy-cols-table td { border: 1px solid var(--vp-c-divider); padding: 4px 8px; text-align: left; white-space: nowrap; }
.tidy-cols-table thead th { color: var(--vp-c-text-1); }
.tidy-cols-table th.tidy-cols-area { background: rgba(16,131,118,.18); }
.tidy-cols-table th.tidy-cols-dim { background: rgba(59,130,246,.18); }
.tidy-cols-table th.tidy-cols-melt { background: rgba(217,119,6,.18); }
.tidy-cols-table th.tidy-cols-carry { background: rgba(100,116,139,.16); }
.tidy-cols-check { font-size: 10px; font-weight: 700; }
.tidy-cols-check.tidy-cols-unchecked { color: var(--vp-c-text-3); }
.tidy-cols-arrow { align-self: center; font-size: 22px; font-weight: 700; color: var(--vp-c-brand); padding: 0 4px; }
.tidy-cols-annot { display: grid; grid-template-columns: repeat(var(--cols, 4), 1fr); gap: 2px; margin-top: 4px; font-size: 10px; }
.tidy-cols-annot span { text-align: center; padding: 1px 2px; border-radius: 3px; }
.tidy-cols-annot .tidy-cols-area { color: #0f766e; }
.tidy-cols-annot .tidy-cols-dim { color: #1d4ed8; }
.tidy-cols-annot .tidy-cols-melt { color: #b45309; }
.tidy-cols-annot .tidy-cols-carry { color: #475569; }
.tidy-cols-callout { margin-top: 10px; padding: 8px 10px; border-left: 3px solid var(--vp-c-brand); background: var(--vp-c-default-soft); font-size: 12px; color: var(--vp-c-text-2); border-radius: 0 4px 4px 0; }
.tidy-cols-caption { font-size: 12px; color: var(--vp-c-text-2); line-height: 1.5; }
.tidy-cols-ellipsis td { color: var(--vp-c-text-3); font-style: italic; text-align: left; }
@media (max-width: 640px) {
  .tidy-cols-arrow { transform: rotate(90deg); padding: 4px 0; }
  .tidy-cols-pair { flex-direction: column; align-items: stretch; }
  .tidy-cols-annot { font-size: 9px; }
}
</style>

### 2. Select columns to melt/pivot

Checkboxes appear for each column in your pasted data. **Checked columns** are melted into variable/value rows. **Unchecked columns** remain as columns in the output.

Select the dimension and indicator to use for the melted columns:

- **New "Dimension" column name** — pick the dimension the melted column headers represent (e.g. Year, Sex)
- **New "Value" column name** — pick the indicator the values represent (e.g. Population)

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
