import { createGrid } from 'ag-grid-community';

export default class AgGridTable {
    id;
    rootElement;
    table;
    options;
    baseurl;

    async fetchData(vizId) {
        const response = await axios.get(`/api/visualization/${vizId}`);
        console.log('Fetched table via axios:', response.data);
        this.options = response.data.options;
    }

    constructor(htmlId) {
        this.id = htmlId
        this.rootElement = document.getElementById(htmlId)
        this.baseurl = this.rootElement.dataset['baseurl']

        this.rootElement.classList.add(...['ag-theme-quartz', 'w-full', 'h-[calc(60vh)]']);
        const vizId = this.rootElement.getAttribute('viz-id')

        if (vizId) {
            this.fetchData(vizId)
                .then(() => {
                    this.rootElement.innerHTML = ''
                    this.table = createGrid(this.rootElement, this.options);
                })
        } else {
            this.options = JSON.parse(this.rootElement.dataset['options'])
            if (this.options?.rowData?.length > 0) {
                this.rootElement.innerHTML = ''
                this.table = createGrid(this.rootElement, this.options)
            }
        }

        console.log({htmlId, options: this.options})
        this.registerLivewireEventListeners();
    }

    registerLivewireEventListeners() {
        Livewire.on(`updateTable.${this.id}`, (event) => {
            let options
            [options] = event
            console.log('Table received data: ' + this.id, options);
            this.rootElement.innerHTML = ''

            options.columnDefs = options.columnDefs.map(colDef => {
                if (colDef?.type === 'numericColumn') {
                    colDef.valueFormatter = params => new Intl.NumberFormat().format(params.value)
                }
                if (colDef?.type === 'rangeColumn') {
                    colDef.comparator = (valueA, valueB, nodeA, nodeB, isDescending) => parseInt(valueA) - parseInt(valueB)
                }
                return colDef
            })

            this.table = createGrid(this.rootElement, options);
        });
    }

    resize() {
        const table = Alpine.raw(this.table)
        if (table) {
            table.sizeColumnsToFit()
        }
    }
}
