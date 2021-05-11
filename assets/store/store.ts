import {applyMiddleware, combineReducers, createStore} from 'redux';
import thunkMiddleware from "redux-thunk";
import editorReducer from "./editorReducer/editorReducer";
import testReducer from "./testReducer/testReducer";
let reducers = combineReducers(
    {
        editor: editorReducer,
        test: testReducer
    });

let store = createStore(reducers, applyMiddleware(thunkMiddleware));

export type RootState = ReturnType<typeof store.getState>
export type AppDispatch = typeof store.dispatch
export default store;