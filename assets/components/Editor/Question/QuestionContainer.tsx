import * as React from "react";
import {connect, ConnectedProps} from "react-redux";
import {RootState} from "../../../store/store";
import Question from "./Question";
import {Api} from "../../../types/api";
import {
    createOption, editOptionOnServer, editOptionTitleOnServer,
    editQuestionOnServer,
    editQuestionTitleOnServer,
} from "../../../store/editorReducer/serverActions";
import {getQuestionFromEditorState} from "../../../store/editorReducer/editorReducer";

const QuestionContainer: React.FC<QuestionContainerProps> = (props) => {

    const {question, editQuestionOnServer, editQuestionTitleOnServer, createOption,editOptionOnServer,editOptionTitleOnServer} = props;

    const onEditQuestion = (question: Api.Question) => {
        editQuestionOnServer(question);
    }
    const onEditQuestionTitle = (question: Api.Question) => {
        editQuestionTitleOnServer(question);
    }
    const onEditOption = (option: Api.Option) => {
        editOptionOnServer(option, question);
    }
    const onAddOption = () => {
        createOption(question);
    }
    const onEditOptionTitle = (option: Api.Option) => {
        editOptionTitleOnServer(option);
    }
    return (
        question ?
            <Question question={question}
                      onEditQuestion={onEditQuestion}
                      onEditQuestionTitle={onEditQuestionTitle}
                      onAddOption={onAddOption}
                      onEditOption={onEditOption}
                      onEditOptionTitle={onEditOptionTitle}
            />

            : <></>
    )
}
const mapStateToProps = (state: RootState) => {
    return {
        question: getQuestionFromEditorState(state.editor)
    }
}
const mapDispatchToProps = ({
    editQuestionOnServer,
    editQuestionTitleOnServer,
    createOption,
    editOptionOnServer,
    editOptionTitleOnServer
});
const connector = connect(mapStateToProps, mapDispatchToProps);
export type QuestionContainerProps = ConnectedProps<typeof connector>
export default connector(QuestionContainer);
