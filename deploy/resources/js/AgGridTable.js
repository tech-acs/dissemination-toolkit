import { createGrid } from 'ag-grid-community';
import html2canvas from "html2canvas-pro";

export default class AgGridTable {
    id;
    rootElement;
    table;
    options;

    async fetchData(vizId) {
        const response = await axios.get(`${ajaxBaseURL}/api/visualization/${vizId}`);
        console.log('Fetched table via axios:', response.data);
        this.options = response.data.options;
    }

    constructor(htmlId,canvas = null) {
        this.id = htmlId
        if(canvas)
        {
            this.rootElement = canvas.getElementById(htmlId)
        }
        else{
            this.rootElement = document.getElementById(htmlId)
        }
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
        const shouldCaptureThumbnail = document.getElementById('should-capture-thumbnail')?.value
        if (shouldCaptureThumbnail) {
            console.log('Capturing and sending thumbnail...', this.vizId);
            this.captureThumbnail().then((imageData) => {
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
            html2canvas(this.rootElement, {
                useCORS: true, // Enable cross-origin handling for images
                allowTaint: false, // Disallow tainted canvas
                scale: 2, // Increase resolution for a high-quality image
                backgroundColor: null, // Preserve transparency
                onclone: (clonedDocument) => {
                    const clonedElement = clonedDocument.getElementById(this.id);

                    // Adjust cloned element to match visible styles
                    clonedElement.style.width = `${this.rootElement.width}px`;
                    clonedElement.style.height = `${this.rootElement.height}px`;

                    // Ensure custom properties or unsupported colors are handled
                    clonedDocument.querySelectorAll('*').forEach((element) => {
                        const computedStyle = getComputedStyle(element);
                        if (computedStyle.backgroundColor.includes('color(')) {
                            element.style.backgroundColor = 'transparent'; // Fallback for unsupported colors
                        }
                    });

                    // Optionally remove or adjust any elements that should not appear in the thumbnail
                    const unnecessaryElements = clonedElement.querySelectorAll('.exclude-from-thumbnail');
                    unnecessaryElements.forEach(el => el.remove());
                },
            })
                .then((canvas) => {
                    // Convert the canvas to a data URL
                    resolve(canvas.toDataURL('image/png'));
                })
                .catch((error) => {
                    console.error('Error capturing thumbnail:', error);
                    reject(error);
                });
        });
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
