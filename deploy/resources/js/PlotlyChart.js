import Plotly from 'plotly.js-dist';
import fr from 'plotly.js-locales/fr';
import ptPT from 'plotly.js-locales/pt-pt';

export default class PlotlyChart {
    id;
    rootElement;
    vizId;
    data = [];
    layout = {};
    config = [];
    baseurl;
    filterable = false;

    emptyLayout = {
        xaxis: {visible: false},
        yaxis: {visible: false},
        plot_bgcolor: '#f1f5f9',
        annotations: [{
            text: 'There is no data for selected area',
            xref: 'paper',
            yref: 'paper',
            showarrow: false,
            font: {size: 28}
        }]
    }

    async fetchData(vizId, filterPath = '') {
        //console.log({URL:`${this.baseurl}/api/visualization/${vizId}?path=${filterPath}`});
        const response = await axios.get(`/api/visualization/${vizId}?path=${filterPath}`);
        console.log('Fetched chart via axios:', response.data);
        this.data = response.data.data;
        this.layout = response.data.layout;
        this.config = response.data.config;
        this.filterable = response.data.filterable;
    }

    constructor(htmlId) {
        this.id = htmlId
        this.rootElement = document.getElementById(htmlId)
        this.baseurl = this.rootElement.dataset['baseurl']

        if (this.config.locale === 'fr') {
            Plotly.register(fr);
        } else if (this.config.locale === 'pt') {
            Plotly.register(ptPT);
        }

        this.vizId = this.rootElement.getAttribute('viz-id')
        this.rootElement.innerHTML = ''
        if (this.vizId) {
            this.fetchData(this.vizId)
                .then(() => {
                    console.log({data: this.data});
                    Plotly.newPlot(this.rootElement, this.data, this.layout, this.config);
                    this.registerLivewireEventListeners(this.filterable);
                })
        } else {
            this.data = JSON.parse(this.rootElement.dataset['data'])
            this.layout = JSON.parse(this.rootElement.dataset['layout'])
            this.config = JSON.parse(this.rootElement.dataset['config'])
            console.log({data: this.data, layout: this.layout, config: this.config});
            Plotly.newPlot(this.rootElement, this.data, this.layout, this.config);
            this.registerLivewireEventListeners(this.filterable);
        }

        const shouldCaptureThumbnail = document.getElementById('should-capture-thumbnail')?.value
        if (shouldCaptureThumbnail) {
            console.log('Capturing and sending thumbnail...', this.vizId);
            Plotly.toImage(this.id, { format: 'png', width: 600, height: 400 })
                .then((imageData) => {
                    console.log({imageData});
                    Livewire.dispatch('thumbnailCaptured', {imageData})
                })
                .catch((error) => console.error('Error converting plot to image:', error));
        }
    }

    registerLivewireEventListeners(filterable) {
        Livewire.on(`updateResponse.${this.id}`, (dataAndLayout) => {
            console.log('Received updateResponse: ' + this.id, dataAndLayout);
            Plotly.react(this.id, ...dataAndLayout, this.config)
        });

        if (filterable) {
            Livewire.on(`filterChanged`, ({filter}) => {
                console.log({filter})
                const [areaName, filterPath] = Object.entries(filter)[0] ?? '';
                this.fetchData(this.vizId, filterPath)
                    .then(() => {
                        //console.log({Path: filterPath, Filtered: this.data});
                        if (! this.data.length) {
                            Plotly.react(this.rootElement, this.data, this.emptyLayout);
                        } else {
                            Plotly.react(this.rootElement, this.data, this.layout);
                        }
                    })
            });
        }
    }
}
