import {createStore, combineReducers } from 'redux';

import reducer, { initialState } from './reducer';

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const enhancers = composeEnhancers(
//   applyMiddleware(
//     mercureMiddleware,
//   ),
);

const reducers = {
    app: reducer
};

const initialStates = {
    app: initialState
};

const combinedReducers = combineReducers(reducers);

const store = createStore(combinedReducers, initialStates, enhancers);


export default store;