import ReactDOM from 'react-dom';
import ChartEditor from "./ChartEditor.jsx";
import './index.css';
import { has } from "lodash";

const rootElement = document.getElementById('chart-editor')

if (rootElement) {
    const response = await axios.get('/manage/viz-builder/chart/api/get');
    console.log('Fetched initial:', response.data);

    let data = response.data.initialData ?? [];
    /*if (data && has(data[0], 'meta.columnNames')) {
        if (data[0].type === 'pie') {
            data[0].value = response.data.dataSources[data[0].valuessrc];
            data[0].values = response.data.dataSources[data[0].valuessrc];
            data[0].label = response.data.dataSources[data[0].labelssrc];
            data[0].labels = response.data.dataSources[data[0].labelssrc];
        } else {
            // ToDo: Do this for all traces and even for z... axis. Also, it breaks when there are multi-columns on same axis
            data[0].x = response.data.dataSources[data[0].xsrc];
            data[0].y = response.data.dataSources[data[0].ysrc];
        }
    }*/
    data.forEach((trace, index) => {
        if (has(trace, 'meta.columnNames')) {
            console.log({trace})
            Object.keys(trace.meta.columnNames).forEach((key) => {
                data[index][key] = response.data.dataSources[data[index][`${key}src`]];
            })
        }
    })
    console.log({data})

    ReactDOM.render(<ChartEditor
        dataSources={response.data.dataSources}
        initialData={data}
        initialLayout={response.data.initialLayout}
        config={response.data.config}
        defaultLayout={response.data.defaultLayout}
    />, rootElement);
}
