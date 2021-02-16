import * as React from 'react';
import QuestionAsideContainer from "./QuestionAside/QuestionAsideContainer";
import QuestionContainer from "./Question/QuestionContainer";
import {useEffect} from "react";

const TestEditor = (props) => {

    return (
        <div id={"test-editor"}>
            <QuestionAsideContainer/>
            <QuestionContainer/>
        </div>
    )

}

export default TestEditor;