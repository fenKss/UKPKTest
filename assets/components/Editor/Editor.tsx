import * as React from "react";
import AddQuestionButtonContainer from "./AddQuestionButton/AddQuestionButtonContainer";
import QuestionListContainer from "./QuestionList/QuestionListContainer";
import QuestionContainer from "./Question/QuestionContainer";


const Editor: React.FC = (): JSX.Element => {
    return (
        <>
            <AddQuestionButtonContainer/>
            <div id="editor">
                <QuestionListContainer/>
                <QuestionContainer/>
            </div>
        </>
    )
}
export default Editor;