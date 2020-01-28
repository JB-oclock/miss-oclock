// == Import : npm
import '@babel/polyfill';
import React from 'react';
import { render } from 'react-dom';
import { BrowserRouter } from 'react-router-dom';
import { Provider } from 'react-redux';


// == Import : local
import 'src/styles/index.scss';
import App from 'src/containers/App';
import store from 'src/store';

const rootComponent = (
    <Provider store={store}>
        <BrowserRouter>
            <App />
        </BrowserRouter>
    </Provider>
);

const target = document.getElementById('root');

render(rootComponent, target);
