import * as React from 'react';
import {BrowserRouter as Router, Route} from "react-router-dom";

const App = () => {
    return (
        <Router>
            <Route path="/admin/variant/:variantId">
                123
            </Route>
        </Router>
    )
};
export default App;