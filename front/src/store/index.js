import {createStore, combineReducers, applyMiddleware, compose } from 'redux';

import reducer, { initialState } from './reducer';
import questionsReducer, { initialState as questionsInitialState} from './questionsReducer';
import {reducer as toastrReducer} from 'react-redux-toastr';
import mercureMiddleware from './middlewares/mercureMiddleware';
import ajaxMiddleware from './middlewares/ajaxMiddleware';

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const enhancers = composeEnhancers(
  applyMiddleware(
    ajaxMiddleware,
    mercureMiddleware,
  ),
);

const reducers = {
    app: reducer,
    questions: questionsReducer,
    toastr: toastrReducer,
};

const initialStates = {
    app: initialState,
    questions: questionsInitialState,
};

const combinedReducers = combineReducers(reducers);

const store = createStore(combinedReducers, initialStates, enhancers);


export default store;