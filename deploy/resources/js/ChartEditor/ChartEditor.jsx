import React, { useState, useEffect } from 'react';
import plotly from 'plotly.js-dist';
import PlotlyEditor from 'react-chart-editor';
import 'react-chart-editor/lib/react-chart-editor.css';
import DataViewer from "./DataViewer.jsx";
import TemplateSaver from "./TemplateSaver.jsx";
import Button from "./Button.jsx";
import {CancelIcon, ErrorIcon, ResetIcon, SaveIcon, SuccessIcon, TemplateIcon} from "./Icons.jsx";
import fr from 'plotly.js-locales/fr';
import ptPT from 'plotly.js-locales/pt-pt';
import {cloneDeep} from "lodash";

function ChartEditor({dataSources, initialData, initialLayout, config, vizId, indicatorTitle, defaultLayout}) {
    const [data, setData] = useState(initialData);
    const [layout, setLayout] = useState(initialLayout);
    const [frames, setFrames] = useState([]);
    /*const [notification, setNotification] = useState({});*/

    const updateState = (data, layout, frames) => {
        setData(data);
        setLayout(layout);
        setFrames(frames);

        writeToTransporterFormElements();
        //Livewire.dispatch('chartDesignerStateChanged', { data: stripData(data), layout })
    };

    const stripData = (original) => {
        const dataStrippedData = cloneDeep(original);
        dataStrippedData.forEach((trace, index) => {
            if (trace.meta?.columnNames) {
                const propertiesToRemove = Object.keys(trace.meta.columnNames);
                propertiesToRemove.forEach(property => {
                    delete dataStrippedData[index][property];
                });
            }
        })
        return dataStrippedData;
    }

    const writeToTransporterFormElements = () => {
        console.log(data, layout)
        const dataStrippedData = stripData(data)
        const chartData = document.getElementById('chart-data')
        chartData.value = JSON.stringify(dataStrippedData);
        const chartLayout = document.getElementById('chart-layout')
        chartLayout.value = JSON.stringify(layout);
    };

    if (config.locale === 'fr') {
        plotly.register(fr);
    } else if (config.locale === 'pt') {
        plotly.register(ptPT);
    }

    /*const traceTypesConfig = {
        traces: (_) => [
            {
                value: 'scatter',
                icon: 'scatter',
                label: _('Scatter'),
            },
            {
                value: 'line',
                label: _('Line'),
            },
            {
                value: 'area',
                label: _('Area'),
            },
            {
                value: 'bar',
                label: _('Bar'),
            },
            {
                value: 'histogram',
                label: _('Histogram'),
            },
            {
                value: 'table',
                label: _('Table'),
            },
            {
                value: 'pie',
                label: _('Pie'),
            },
            {
                value: 'box',
                label: _('Box'),
            },
            {
                value: 'histogram2d',
                label: _('Histogram 2D'),
            },
        ],
        complex: true,
    };*/

    return (
        <>
            {/*<div className="flex justify-between w-full bg-gray-50">
                <div className="text-gray-600 text-xl font-medium items-center p-3 w-1/4 xl:w-1/3 2xl:w-1/2 truncate">ahem</div>
            </div>*/}

            <PlotlyEditor
                data={data}
                layout={layout}
                config={config}
                frames={frames}
                dataSources={dataSources}
                dataSourceOptions={Object.keys(dataSources).map((name) => ({
                    value: name,
                    label: name,
                }))}
                plotly={plotly}
                onUpdate={updateState}
                locale={config.locale}
                dictionaries={{fr: {"Vertical": "Verticale", "Type": "Le genre"}}}
                useResizeHandler
                debug={true}
                advancedTraceTypeSelector={true}
                //traceTypesConfig={traceTypesConfig}
            />
        </>

    );
}

export default ChartEditor;
