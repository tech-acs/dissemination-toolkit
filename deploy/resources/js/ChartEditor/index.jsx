import ReactDOM from 'react-dom';
import ChartEditor from "./ChartEditor.jsx";
import './index.css';
import { has } from "lodash";

const rootElement = document.getElementById('chart-editor')

if (rootElement) {
    const response = await axios.get(`${ajaxBaseURL}/manage/viz-builder/chart/api/get`);
    console.log('Fetched initial:', response.data);

    let data = response.data.initialData ?? [];
    data.forEach((trace, index) => {
        if (has(trace, 'meta.columnNames')) {
            console.log({trace})
            Object.keys(trace.meta.columnNames).forEach((key) => {
                const columnName = trace.meta.columnNames[key];
                if (columnName.includes(' - ')) {
                    const columns = columnName.split(' - ')
                    data[index][key] = columns.map(column => response.data.dataSources[column])
                } else {
                    data[index][key] = response.data.dataSources[data[index][`${key}src`]]
                }
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
