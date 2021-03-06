import * as React   from 'react';
import ReactDOM     from 'react-dom';
import App          from './components/App.tsx';
import './css/index.scss';
import store        from '../assets/store/store';
import { Provider } from 'react-redux';

ReactDOM.render(
  <Provider store={store}>
    <App/>
  </Provider>,
  document.getElementById('root'));

