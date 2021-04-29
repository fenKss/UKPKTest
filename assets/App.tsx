import * as React from 'react';
import {BrowserRouter as Router, Route} from "react-router-dom";
import Editor from "./components/Editor/Editor";

const App = () => {
    return (
        <Router>
            <Route path="/admin/variant/:variantId">
                <Editor />
            </Route>
        </Router>
    )
};
export default App;