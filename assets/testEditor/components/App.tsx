import * as React from 'react';
import TestEditorContainer from "./TestEditor/TestEditorContainer";
import { BrowserRouter as Router,Route, useParams } from "react-router-dom";

const App = () => {
    return(
        <Router>
            <Route path="/admin/variant/:variantId">
                <TestEditorContainer />
            </Route>
        </Router>
    )

};
export default App;