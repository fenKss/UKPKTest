import {combineReducers, createStore} from 'redux';
import questionsReducer from "./questionsReducer";

let reducers = combineReducers(
    {
        questions: questionsReducer,
    });

let store = createStore(reducers);
export type AppDispatch = typeof store.dispatch;
export default store;