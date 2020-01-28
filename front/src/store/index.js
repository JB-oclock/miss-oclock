import {createStore, combineReducers, compose } from 'redux';

import reducer, { initialState } from './reducer';
import {reducer as toastrReducer} from 'react-redux-toastr';
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const enhancers = composeEnhancers(
//   applyMiddleware(
//     mercureMiddleware,
//   ),
);

const reducers = {
    app: reducer,
    toastr: toastrReducer
};

const initialStates = {
    app: initialState
};

const combinedReducers = combineReducers(reducers);

const store = createStore(combinedReducers, initialStates, enhancers);


export default store;