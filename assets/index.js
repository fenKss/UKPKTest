import * as React   from 'react';
import ReactDOM     from 'react-dom';
import App          from './testEditor/components/App';
import './testEditor/css/index.scss';
import store        from './testEditor/store/store';
import { Provider } from 'react-redux';

ReactDOM.render(
    <Provider store={store}>
      <App/>
    </Provider>,
    document.getElementById('root'));

