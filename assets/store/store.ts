import {combineReducers, createStore} from 'redux';

let reducers =() => {};/* combineReducers(
    {
        // addEvent: addEventReducer,
    });
*/
let store = createStore(reducers);
export type AppDispatch = typeof store.dispatch;
export default store;