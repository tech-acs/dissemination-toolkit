import { Plugin } from '@ckeditor/ckeditor5-core';

import PlaceholderEditing from "./PlaceholderEditing.js";
import PlaceholderUI from "./PlaceholderUI.js";

export default class Placeholder extends Plugin {
    static get requires() {
        return [ PlaceholderEditing, PlaceholderUI ];
    }
}
