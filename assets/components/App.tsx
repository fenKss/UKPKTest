import * as React from 'react';
import {BrowserRouter as Router, Route} from "react-router-dom";
import Editor from "./Editor/Editor";
import Test from "./Test/Test";

const App = () => {
    return (
        <Router>
            <Route path="/admin/variant/:variantId">
                <Editor />
            </Route>
            <Route path="/test/:testId/react">
                <Test />
            </Route>
        </Router>
    )
};
export default App;