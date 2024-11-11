import { Plugin } from '@ckeditor/ckeditor5-core';

import ChartEmbedEditing from "./ChartEmbedEditing.js";
import ChartEmbedUI from "./ChartEmbedUI.js";

export default class ChartEmbed extends Plugin {
    static get requires() {
        return [ ChartEmbedEditing, ChartEmbedUI ];
    }
}
