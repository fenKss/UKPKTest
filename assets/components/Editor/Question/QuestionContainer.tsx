import * as React from "react";
import {connect, ConnectedProps} from "react-redux";
import {RootState} from "../../../store/store";
import Question from "./Question";
import {Api} from "../../../types/api";
import {editQuestionOnServer} from "../../../store/editorReducer/editorReducer";

const QuestionContainer: React.FC<QuestionContainerProps> = (props) => {
    const {question, editQuestionOnServer} = props;
    const onEditQuestion = (question: Api.Question) => {
        editQuestionOnServer(question);
    }
    return (
        question ? <Question question={question} onEditQuestion={onEditQuestion}/> : <></>
    )
}
const mapStateToProps = (state: RootState) => {
    const question = state.editor.questions.find(element => {
        if (element.id == state.editor.selectedQuestionId) {
            return element
        }
        return false;
    })
    return {
        question
    }
}
const mapDispatchToProps = ({
    editQuestionOnServer
});
const connector = connect(mapStateToProps, mapDispatchToProps);
export type QuestionContainerProps = ConnectedProps<typeof connector>
export default connector(QuestionContainer);
