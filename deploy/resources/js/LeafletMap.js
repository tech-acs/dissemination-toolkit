import L from 'leaflet';
import leafletImage from 'leaflet-image';
import {DoublyLinkedList} from './DataStructures';
import {colorbrewer} from "./ColorBrewer.js";
import {format as d3format} from "d3-format";
import {max, min, get} from "lodash-es";

const baseMapOptions =      [
    {
        name: "Blank Background",
        url: "",
        options: {
            "center": [0, 0],
            "minZoom": 5,
            "maxZoom": 20
        },
    },

    {
        name:"Google Hybrid",
        url:"http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}",
        options:{
            minZoom: 5,
            maxZoom: 20,
            subdomains: ["mt0","mt1","mt2","mt3"]
        },
    },
    {
        name:"Open Topo Map",
        url:"https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",
        options:{
            minZoom: 5,
            maxZoom: 17
        },
    },
    {
        name: "CartoDB",
        url: "https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}@2x.png",
        options:
            {
                minZoom: 4,
                maxZoom: 19,
            }
    },{
        name: "Open Street Map",
        url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        options:
            {
                minZoom: 4,
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }
    }
]
const defaultStyle = {
    fillColor: '#ffffff',
    weight: 1,
    opacity: 1,
    color: 'black',
    fillOpacity: 0.7
};
export default class LeafletMap {
    id;
    rootElement;
    vizId;
    map;
    mapOptions ={
        attributionControl: false,
        renderer: L.canvas(),
    };
    styles;
    options;
    indicators = {};
    locale;
    levels = [];
    nav;
    layout ={}
    config = [];
    filterable = false;
    geoJsons = [];
    basemapLayers = {};

    constructor(htmlId,canvas = null) {
        this.id = htmlId
        if(canvas)
        {
            this.rootElement = canvas.getElementById(htmlId)
        }
        else{
            this.rootElement = document.getElementById(htmlId)
        }
        // Set locale
        // this.locale = this.mapOptions?.locale || 'en';

        // Initialize the map
        //basemaps is in data-layout attribute inside map.style

        this.vizId = this.rootElement.getAttribute('viz-id')
        this.rootElement.innerHTML = ''
        if(this.vizId){
            this.fetchData(this.vizId)
                .then(() => {
                    this.initializeMap(this.rootElement,this.layout.basemaps);
                    this.addControls();
                    this.initializeGeojsonLayer();
                    this.updateMapDataAndLayout(this.data,this.layout);
                    this.registerLivewireEventListeners(this.filterable);
                })
        } else {
            this.data = JSON.parse(this.rootElement.dataset['data'])
            this.geojson = L.geoJSON(this.data[0].geojson);
            this.layout = JSON.parse(this.rootElement.dataset['layout'])
            this.config = JSON.parse(this.rootElement.dataset['config'])
            this.initializeMap(this.rootElement,this.layout.basemaps);
            this.initializeGeojsonLayer();
            this.addControls();
            this.updateMapDataAndLayout(this.data,this.layout);
            this.registerLivewireEventListeners(this.filterable);
        }
        const shouldCaptureThumbnail = document.getElementById('should-capture-thumbnail')?.value
        if (shouldCaptureThumbnail) {
            console.log('Capturing and sending thumbnail...', this.vizId);
            this.captureThumbnail().then((imageData) => {
                console.log('Captured map image:', imageData);
                const loadingIndicator = document.getElementById('loading-indicator');
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'block';
                }
                Livewire.dispatch('thumbnailCaptured', {imageData})
            });
        }

    }

    captureThumbnail() {
        return new Promise((resolve, reject) => {
            if (!this.map) {
                reject(new Error('Map is not initialized'));
                return;
            }

            this.map.whenReady(() => {
                leafletImage(this.map, (err, canvas) => {

                    if (err) {
                        reject(err);
                    } else {
                        resolve(canvas.toDataURL());
                    }
                });
            });
        });
    }async fetchData(vizId, filterPath = '') {
        const response = await axios.get(`${ajaxBaseURL}/api/visualization/${vizId}?path=${filterPath}`);
        console.log('Fetched chart via axios:', response.data);
        this.data = response.data.data;
        this.geojson = L.geoJSON(this.data[0].geojson);
        this.layout = response.data.layout;
        this.config = response.data.config;
        this.filterable = response.data.filterable;
    }

    initializeMap(mapContainer, baseMap) {
        if (this.map) {
            this.map.off();     // remove all event listeners
            this.map.remove();  // remove the map from the DOM
        }
        this.map = L.map(mapContainer, this.mapOptions);

        this.map.setView(
            this.geojson.getBounds().getCenter(), 6    );
        this.addBaseMapsToMap();
    }
    addBaseMapsToMap(){
        let basemapsCount = baseMapOptions.length;
        baseMapOptions.forEach((basemap, index) => {
            let basemapLayer = new L.TileLayer(basemap.url, basemap.options);
            if (basemapsCount === index + 1) {
                this.map.addLayer(basemapLayer);
            }
            this.basemapLayers[basemap.name] = basemapLayer;
        });
        L.control.layers(this.basemapLayers).addTo(this.map);
        this.nav = new DoublyLinkedList(this.levels);
    }
    initializeGeojsonLayer(){
        this.geojsonLayerGroup = L.layerGroup().addTo(this.map);
        // this.geojsonLayerGroup.addLayer(this.geojson);
    }
    updateMapDataAndLayout(data, layout){
        data.forEach((trace) => {
            let options = this.getOptions(trace,layout);
            this.setTooltipConfig(options);
            this.addTraceToMap(trace,options);
            this.addLegendToMap(options);
            this.addInfoToMap(options);
            if (layout.map.style) {
                // Remove the current base map layer
                Object.values(this.basemapLayers).forEach(layer => {
                    if (this.map.hasLayer(layer)) {
                        this.map.removeLayer(layer);
                    }
                });

                // Add the new base map layer
                if (this.basemapLayers[layout.map.style]) {
                    this.basemapLayers[layout.map.style].addTo(this.map);
                }
            }
        });
        this.map.flyToBounds(this.geoJson.getBounds());
    }
    setTooltipConfig(options){
        this.tooltip =
            {
                style: {
                    className: 'leaflet-tooltip'
                },  getContent: (feature,values) => {
                    let info = options.info;
                    if(info.infos) {
                        return options.infos[options.locations.indexOf(get(feature, options.layout.featureidkey??'name'))];
                    }else {
                        return '<h4><b>' + feature.properties.name + '</b></h4>' + (feature?.properties ?
                            values[info.locations.indexOf(get(feature, options.layout.featureidkey??'name'))]??''
                            : 'Hover over an area');
                    }
                }
            };
    }
    addTraceToMap(trace,options){
        this.geoJson = L.geoJSON(trace.geojson, {
            style: options.style,
            onEachFeature: options.onEachFeature
        }).addTo(this.map);
        this.geoJsons.push(this.geoJson);
    }
    addLegendToMap(options) {
        if(options.layout.showlegend === 'No')
        {
            return;
        }
        this.legend = L.control({position: options.legend.position});
        this.legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'info legend');
            if (options.legend?.type === 'categorical') {
                const div = L.DomUtil.create('div', 'info legend');
                for (let i = 0; i < options.legend.colors.length; i++) {
                    const legendItem = L.DomUtil.create('div', 'legend-item', div);
                    legendItem.innerHTML +=
                        '<i style="background:' + options.legend.colors[i] + '" ></i> ' +
                        options.legend.labels[i] + '<br>';
                    legendItem.onmouseover = function (e) {
                        map.eachLayer(function (layer) {
                            layer.fireEvent('highlightFeature', {colorIndex: i});
                        });
                        legendItem.onmouseout = function (e) {
                            map.eachLayer(function (layer) {
                                layer.fireEvent('mouseout');
                            });
                        }

                    }
                }
                L.DomEvent.disableClickPropagation(div);


                return div;
            } else {

                if(options.legend.orientation === 'Vertical')
                {
                    console.log('Vertical');
                    const div_scale = L.DomUtil.create('div', 'legend-scale ');
                    const linearGradient = 'linear-gradient(to bottom, ' + options.legend.colors.join(',') + ')';

                    div_scale.innerHTML += '<div class="legend-color-gradient" style="background:' + linearGradient + '"></div>';
                    div_scale.innerHTML += '<div class="legend-labels-gradient"><span>'+options.legend.labels[0]+
                        '</span><span>' +options.legend.labels[options.legend.labels.length-1]+'</span></div>';
                    div.appendChild(div_scale);
                }
                else{
                    const div_scale = L.DomUtil.create('div', 'legend-scale h');
                    const linearGradient = 'linear-gradient(to right, ' + options.legend.colors.join(',') + ')';
                    div_scale.innerHTML += '<div class="legend-color-gradient" style="background:' + linearGradient + '"></div>';
                    div_scale.innerHTML += '<div class="legend-labels-gradient"><span>'+options.legend.labels[0]+
                        '</span><span>' +options.legend.labels[options.legend.labels.length-1]+'</span></div>';
                    div.appendChild(div_scale);
                }

                return div;
            }
        };

        this.legend.addTo(this.map);
    }

    addInfoToMap(options){
        this.info = L.control({position: options.info.position});
        this.info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };
        this.info.update = function (feature,values) {
            let info = options.info;
            if(info.infos) {
                this._div.innerHTML = info.infos[info.locations.indexOf(get(feature, options.layout.featureidkey??'name'))];
            }
            else {
                this._div.innerHTML = '<h4>Area</h4>' + (feature?.properties ?
                    '<b>' + feature.properties.name + '</b><br />' + values[info.locations.indexOf(get(feature,options.layout.featureidkey??'name'))]??''
                    : 'Hover over an area');
            }
        };
        this.info.addTo(this.map);
    }
    getOptions(customData,customLayout){
        const z = customData.z.map((value) => Number(value));

        const layout = {
            steps: 6,
            colorpallette: 'Blues',
            ...customLayout,
        }
        const trace = {
            zmin: min(z),
            zmax: max(z),
            style: defaultStyle,
            colorbar:{
                tickformat: '.2f',
            },
            legend: {
                position: 'bottomright',
                format: '.2f',
                type: 'continuous',
                colors: [],
                labels: [],
                range: [],
            },
            ...layout,
            ...customData,
            geojson: undefined,
        };
        const colorPallette = colorbrewer[trace.colorpallette][layout.steps];
        return {
            style: (feature) => {
                const index = trace.locations.indexOf(get(feature, trace.featureidkey??'name'));
                if (index < 0) {
                    return {
                        fillOpacity: 0,
                        weight: 0,
                        opacity: 1,
                    }
                }
                const normalizedValue = (Number(trace.z[index]) - trace.zmin) / (trace.zmax - trace.zmin);
                const colorIndex = Math.ceil((normalizedValue * layout.steps)-1);
                return {
                    ...trace.style,
                    fillColor: colorPallette[colorIndex>0?colorIndex:0],
                    colorIndex: colorIndex,
                }
            },
            onEachFeature: (feature, layer) => {

                layer.on({
                    mouseover: (e) => {
                        const layer = e.target;
                        layer.setStyle({
                            weight: 1,
                            color: 'white',
                            dashArray: '',
                            fillOpacity: 0.7
                        });

                        layer.bringToFront();
                        layer.bindTooltip(this.tooltip.getContent(feature, trace.z));
                        layer.openTooltip();
                        this.info.update(layer.feature,trace.z);
                    },
                    mouseout: (e) => {
                        this.geoJson.resetStyle();
                        layer.closeTooltip();


                    },
                    click: (e) => {
                        const feature = e.target.feature;
                        // console.log('Clicked on feature:', feature.properties);
                        // Livewire.dispatch('filterChanged',{filter: feature.properties.path});

                    },
                    highlightFeature: (e) => {
                        const layer = e.target;
                        if(layer.options.colorIndex === e.colorIndex) {

                            layer.setStyle({
                                weight: 2,
                                color: 'white',
                                dashArray: '-',
                                fillOpacity: 1
                            });
                            layer.bringToFront();
                            layer.bindTooltip(this.tooltip.getContent(feature, trace.z));
                            layer.openTooltip();
                            this.info.update(layer.feature,trace.z);
                        }
                        else {
                            layer.setStyle({
                                fillOpacity: 0.4,
                                dashArray: '.',
                            });
                        }
                    }
                });
            },
            legend: {
                position: 'bottomright',
                type: trace.legend?.type??'continuous',
                colors: colorPallette,
                labels: colorPallette.map((color, index) => {
                        const formatter = d3format(trace.legend?.format??'.2f');
                        if(trace.legend?.type === 'categorical'){

                            const min = formatter(Number(trace.zmin) + index * ((Number(trace.zmax) - Number(trace.zmin)) / (layout.steps)),trace.legend?.format);
                            const max = formatter(Number(trace.zmin) + (index + 1) * ((Number(trace.zmax) - Number(trace.zmin)) / (layout.steps)),trace.legend?.format??'.2f');

                            return `${min} - ${max}`;
                        }
                        else{
                            if(index === 0){
                                return formatter(Number(trace.zmin) + index * ((Number(trace.zmax) - Number(trace.zmin)) / (layout.steps)),trace.legend?.format);
                            }else
                            {
                                return formatter(Number(trace.zmin) + index * ((Number(trace.zmax) - Number(trace.zmin)) / (layout.steps)),trace.legend?.format);
                            }
                        }
                    }
                ),
                ...trace.legend
            },
            info: {
                position: 'bottomleft',
                infos: trace.infos,
                locations: trace.locations,

            },
            layout: {
                ...trace,
            }
        };

    }
    addControls(){
        // L.control.scale().addTo(this.map);
        // L.control.fullscreen().addTo(this.map);
        // L.control.locate().addTo(this.map);
        // L.control.layers().addTo(this.map);
    }
    refocusMap(){
        this.map.invalidateSize(true);
        if(this.geojson){
            console.log(this.geojson.getBounds());
            // this.map.flyToBounds(this.geojson.getBounds());
        }
    }
    registerLivewireEventListeners(filterable){
        Livewire.on(`updateResponse.${this.id}`, (dataAndLayout) => {
            console.log('Received updateResponse: ' + this.id, dataAndLayout);
            this.clearMap();
            const [data, layout] = dataAndLayout;
            this.updateMapDataAndLayout(data, layout);
        });
        if(filterable){
            Livewire.on(`filterChanged`, ({filter}) => {
                console.log('*** map filter: ',{filter})
                const [areaName, filterPath] = Object.entries(filter)[0] ?? '';
                this.fetchData(this.vizId, filterPath)
                    .then(() => {
                        this.clearMap();
                        this.updateMapDataAndLayout(this.data, this.layout);
                    })
            });
        }

    }
    clearMap(){
        this.geoJsons.forEach((geoJson)=>{
            this.map.removeLayer(geoJson);
        });
        this.geoJsons = [];
        if(this.legend){
            this.map.removeControl(this.legend);
        }
        if(this.info){
            this.map.removeControl(this.info);
        }
        this.map.closePopup();
    }

}
