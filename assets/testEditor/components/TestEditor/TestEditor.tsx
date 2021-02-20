import * as React from 'react';
import QuestionAsideContainer from "./QuestionAside/QuestionAsideContainer";
import QuestionContainer from "./Question/QuestionContainer";
import TestEditorPopupContainer from "./TestEditorPopup/TestEditorPopupContainer";

const TestEditor = (props) => {

    return (
        <div id={"test-editor"}>
            <QuestionAsideContainer/>
            <QuestionContainer/>
            <TestEditorPopupContainer />
        </div>
    )

}

export default TestEditor;