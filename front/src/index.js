// == Import : npm
import React from 'react';
import { render } from 'react-dom';
import { BrowserRouter } from 'react-router-dom';


// == Import : local
// Styles de base
import 'src/styles/index.scss';
// Composant racine
import App from 'src/components/App';

const rootComponent = (
    <BrowserRouter>
        <App />
    </BrowserRouter>
);

const target = document.getElementById('root');

render(rootComponent, target);
