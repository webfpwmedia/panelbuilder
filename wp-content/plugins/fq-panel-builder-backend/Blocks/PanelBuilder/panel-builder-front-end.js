const dom_container = document.querySelector('#panel-builder');

import PanelBuilder from './PanelBuilder';
import React from 'react';
import ReactDOM from 'react-dom';

ReactDOM.render( React.createElement(PanelBuilder) , dom_container);