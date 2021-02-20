import {applyMiddleware, combineReducers, createStore} from 'redux';
import questionsReducer from "./questionsReducer";
import popupReducer from "./popupReducer";
import thunkMiddleware from "redux-thunk";

let reducers = combineReducers(
    {
        questions: questionsReducer,
        popup:popupReducer
    });

let store = createStore(reducers, applyMiddleware(thunkMiddleware));

export type AppDispatch = typeof store.dispatch;
export default store;