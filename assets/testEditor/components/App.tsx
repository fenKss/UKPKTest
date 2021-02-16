import * as React from 'react';
import QuestionAsideContainer from "./TestEditor/QuestionAside/QuestionAsideContainer";
import QuestionContainer from "./TestEditor/Question/QuestionContainer";
import TestEditorContainer from "./TestEditor/TestEditorContainer";
import { BrowserRouter as Router,Route, useParams } from "react-router-dom";

const App = () => {
    return(
        <Router>
            <Route path="/admin/variant/:variantId/react">
                <TestEditorContainer />
            </Route>
        </Router>
    )

};
export default App;