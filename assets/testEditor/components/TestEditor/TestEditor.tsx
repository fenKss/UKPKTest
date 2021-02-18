import * as React from 'react';
import QuestionAsideContainer from "./QuestionAside/QuestionAsideContainer";
import QuestionContainer from "./Question/QuestionContainer";

const TestEditor = (props) => {

    return (
        <div id={"test-editor"}>
            <QuestionAsideContainer/>
            <QuestionContainer/>
        </div>
    )

}

export default TestEditor;