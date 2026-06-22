# Outil de mise en forme de données

L'outil de mise en forme de données remodelera les données non tidy en un format long, prêt à l'importation. Il est utile lorsque vos données sources ont des valeurs réparties sur plusieurs colonnes (par exemple, une colonne par année ou par sexe). Accessible depuis la page d'index des jeux de données en cliquant sur le lien **Outil de mise en forme de données**.

## Utilisation de l'outil de mise en forme de données

### 1. Coller les données au format large (CSV/TSV)

Collez vos données dans la zone de texte. L'outil accepte les données délimitées par des virgules, des tabulations ou des points-virgules.

Ce que vous **nommez** vos colonnes détermine ce qui sera codifié ; ce que vous **cochez** (à l'étape 2) détermine ce qui sera fusionné.

<div class="tidy-cols-visual">

<div class="tidy-cols-legend">
<span class="tidy-cols-chip tidy-cols-area">Nom de niveau de hiérarchie de zones → codifié en code de zone</span>
<span class="tidy-cols-chip tidy-cols-dim">Nom de dimension → codifié en code de valeur</span>
<span class="tidy-cols-chip tidy-cols-melt">Valeur de dimension, cochée → fusionnée &amp; codifiée</span>
<span class="tidy-cols-chip tidy-cols-carry">Valeur de dimension, décochée → reprise telle quelle, non codifiée</span>
</div>

<div class="tidy-cols-case">
<div class="tidy-cols-case-title">Cas 1 — Pivot de zone <span class="tidy-cols-badge">cas habituel</span></div>
<div class="tidy-cols-pair">
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Large (collé)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-area">Province</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Homme</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Femme</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Total</th>
</tr></thead>
<tbody>
<tr><td>Nord</td><td>100</td><td>120</td><td>220</td></tr>
<tr><td>Sud</td><td>80</td><td>90</td><td>170</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot"><span class="tidy-cols-area">code de zone</span><span class="tidy-cols-melt">fusionner → Sexe</span><span class="tidy-cols-melt">fusionner → Sexe</span><span class="tidy-cols-melt">fusionner → Sexe</span></div>
</div>
<div class="tidy-cols-arrow">→</div>
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Tidy (format long)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-area">Province</th>
<th class="tidy-cols-dim">Sexe</th>
<th>Population</th>
</tr></thead>
<tbody>
<tr><td>Nord</td><td>Homme</td><td>100</td></tr>
<tr><td>Nord</td><td>Femme</td><td>120</td></tr>
<tr><td>Nord</td><td>Total</td><td>220</td></tr>
<tr><td>Sud</td><td>Homme</td><td>80</td></tr>
<tr class="tidy-cols-ellipsis"><td>…</td><td>…</td><td>…</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot" style="--cols:3"><span class="tidy-cols-area">code de zone</span><span class="tidy-cols-dim">code de valeur</span><span>valeur</span></div>
</div>
</div>
</div>

<div class="tidy-cols-case">
<div class="tidy-cols-case-title">Cas 2 — Pivot de dimension</div>
<div class="tidy-cols-pair">
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Large (collé)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-dim">Groupe d'âge</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Homme</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Femme</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Total</th>
</tr></thead>
<tbody>
<tr><td>0-4</td><td>40</td><td>38</td><td>78</td></tr>
<tr><td>5-9</td><td>45</td><td>42</td><td>87</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot"><span class="tidy-cols-dim">code de valeur</span><span class="tidy-cols-melt">fusionner → Sexe</span><span class="tidy-cols-melt">fusionner → Sexe</span><span class="tidy-cols-melt">fusionner → Sexe</span></div>
</div>
<div class="tidy-cols-arrow">→</div>
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Tidy (format long)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-dim">Groupe d'âge</th>
<th class="tidy-cols-dim">Sexe</th>
<th>Population</th>
</tr></thead>
<tbody>
<tr><td>0-4</td><td>Homme</td><td>40</td></tr>
<tr><td>0-4</td><td>Femme</td><td>38</td></tr>
<tr><td>0-4</td><td>Total</td><td>78</td></tr>
<tr><td>5-9</td><td>Homme</td><td>45</td></tr>
<tr class="tidy-cols-ellipsis"><td>…</td><td>…</td><td>…</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot" style="--cols:3"><span class="tidy-cols-dim">code de valeur</span><span class="tidy-cols-dim">code de valeur</span><span>valeur</span></div>
</div>
</div>
</div>

<div class="tidy-cols-case">
<div class="tidy-cols-case-title">Cas 3 — Dimensions supplémentaires reprises telles quelles <span class="tidy-cols-badge">la sélection détermine la répartition</span></div>
<div class="tidy-cols-pair">
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Large (collé)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-area">Province</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Homme</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Femme</th>
<th class="tidy-cols-melt"><span class="tidy-cols-check">✓</span> Total</th>
<th class="tidy-cols-carry"><span class="tidy-cols-check tidy-cols-unchecked">○</span> Urbain</th>
<th class="tidy-cols-carry"><span class="tidy-cols-check tidy-cols-unchecked">○</span> Rural</th>
</tr></thead>
<tbody>
<tr><td>Nord</td><td>100</td><td>120</td><td>220</td><td>60</td><td>160</td></tr>
<tr><td>Sud</td><td>80</td><td>90</td><td>170</td><td>50</td><td>120</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot" style="--cols:6"><span class="tidy-cols-area">code de zone</span><span class="tidy-cols-melt">fusionner → Sexe</span><span class="tidy-cols-melt">fusionner → Sexe</span><span class="tidy-cols-melt">fusionner → Sexe</span><span class="tidy-cols-carry">repris tel quel</span><span class="tidy-cols-carry">repris tel quel</span></div>
</div>
<div class="tidy-cols-arrow">→</div>
<div class="tidy-cols-table-wrap">
<div class="tidy-cols-label">Tidy (format long)</div>
<table class="tidy-cols-table">
<thead><tr>
<th class="tidy-cols-area">Province</th>
<th class="tidy-cols-carry">Urbain</th>
<th class="tidy-cols-carry">Rural</th>
<th class="tidy-cols-dim">Sexe</th>
<th>Population</th>
</tr></thead>
<tbody>
<tr><td>Nord</td><td>60</td><td>160</td><td>Homme</td><td>100</td></tr>
<tr><td>Nord</td><td>60</td><td>160</td><td>Femme</td><td>120</td></tr>
<tr><td>Nord</td><td>60</td><td>160</td><td>Total</td><td>220</td></tr>
<tr><td>Sud</td><td>50</td><td>120</td><td>Homme</td><td>80</td></tr>
<tr class="tidy-cols-ellipsis"><td>…</td><td>…</td><td>…</td><td>…</td><td>…</td></tr>
</tbody>
</table>
<div class="tidy-cols-annot" style="--cols:5"><span class="tidy-cols-area">code de zone</span><span class="tidy-cols-carry">inchangé</span><span class="tidy-cols-carry">inchangé</span><span class="tidy-cols-dim">code de valeur</span><span>valeur</span></div>
</div>
</div>
<div class="tidy-cols-callout">Une seule dimension peut être fusionnée à la fois. Cochez Homme/Femme/Total pour fusionner dans Sexe ; laissez Urbain/Rural décochées et elles seront reprises sur chaque ligne, non codifiées.</div>
</div>

<div class="tidy-cols-caption">Une colonne est codifiée si son nom correspond à un niveau de hiérarchie de zones ou à une dimension. Parmi les colonnes nommées d'après des valeurs de dimension, celles que vous <b>cochez</b> sont fusionnées et codifiées par rapport à la dimension choisie ; celles que vous laissez <b>décochées</b> sont reprises telles quelles.</div>

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

### 2. Sélectionner les colonnes à fusionner/pivoter

Des cases à cocher apparaissent pour chaque colonne de vos données collées. Les **colonnes cochées** sont fusionnées en lignes variable/valeur. Les **colonnes décochées** restent comme colonnes dans le résultat.

Sélectionnez la dimension et l'indicateur à utiliser pour les colonnes fusionnées :

- **Nom de la nouvelle colonne « Dimension »** — choisissez la dimension que les en-têtes de colonnes fusionnées représentent (ex. Année, Sexe)
- **Nom de la nouvelle colonne « Valeur »** — choisissez l'indicateur que les valeurs représentent (ex. Population)

Si des colonnes cochées sont nommées d'après une dimension existante ou un niveau de hiérarchie de zones, les valeurs seront automatiquement **codifiées** (les libellés remplacés par les codes de la base de données) dans le résultat CSV codifié.

Cliquez sur **Appliquer** pour générer les données remodelées.

### 3. Données tidy (format long)

Les données remodelées sont affichées dans un tableau de prévisualisation et une zone de texte. De là, vous pouvez :

- **Télécharger CSV** — enregistre le fichier tidy avec des libellés lisibles
- **Télécharger CSV codifié** — enregistre le fichier tidy avec les libellés de dimension et de zone remplacés par leurs codes de base de données, prêt pour l'importation

## Valeurs non correspondantes

Si certaines valeurs dans les colonnes cochées ne peuvent pas être mises en correspondance avec des codes de dimension ou de zone existants, un avertissement s'affiche listant les valeurs non mappées. Vous pouvez facultativement cocher **Exclure les lignes sans correspondance de tous les CSV** pour sauter ces lignes dans le résultat. Après ajustement, cliquez à nouveau sur **Appliquer** et téléchargez le fichier.

## Prochaine étape

Importez le fichier résultant via la page **Jeux de données** (voir [Importation de données](/fr/manager/data/datasets)).
