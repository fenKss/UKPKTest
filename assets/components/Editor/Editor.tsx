import * as React from "react";
import {Api} from "../../types/api";
import Question = Api.Question;
import AddQuestionButtonContainer from "./AddQuestionButton/AddQuestionButtonContainer";
import QuestionListContainer from "./QuestionList/QuestionListContainer";



const Editor: React.FC<{}> = (props): JSX.Element => {
    return (
        <>
            <AddQuestionButtonContainer/>
            <QuestionListContainer />
        </>
    )
}
export default Editor;