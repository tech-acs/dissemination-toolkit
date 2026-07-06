import './bootstrap.js';
import PlotlyChart from "./PlotlyChart.js";
window.PlotlyChart = PlotlyChart;

import AgGridTable from "./AgGridTable";
window.AgGridTable = AgGridTable;

import LeafletMap from "./LeafletMap.js";
window.LeafletMap = LeafletMap;

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

Alpine.start();

Livewire.start();