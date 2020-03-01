import {createStore, combineReducers, applyMiddleware, compose } from 'redux';

import reducer, { initialState } from './reducer';
import questionsReducer, { initialState as questionsInitialState} from './questionsReducer';
import performancesReducer, { initialState as performancesInitialState} from './performancesReducer';
import votesReducer, { initialState as votesInitialState} from './votesReducer';
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
    performances: performancesReducer,
    votes: votesReducer,
    toastr: toastrReducer,
};

const initialStates = {
    app: initialState,
    questions: questionsInitialState,
    performances: performancesInitialState,
    votes: votesInitialState,
}; 

const combinedReducers = combineReducers(reducers);

const store = createStore(combinedReducers, initialStates, enhancers);


export default store;