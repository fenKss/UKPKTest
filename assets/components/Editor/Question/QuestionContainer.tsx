import * as React from "react";
import {connect, ConnectedProps} from "react-redux";
import {RootState} from "../../../store/store";
import Question from "./Question";
import {Api} from "../../../types/api";
import {
    createOption, deleteOptionOnServer, deleteQuestionOnServer, editOptionOnServer, editOptionTitleOnServer,
    editQuestionOnServer,
    editQuestionTitleOnServer,
} from "../../../store/editorReducer/serverActions";
import {getQuestionFromEditorState} from "../../../store/editorReducer/editorReducer";

const QuestionContainer: React.FC<QuestionContainerProps> = (props) => {

    const {
        question,
        editQuestionOnServer,
        editQuestionTitleOnServer,
        createOption,
        editOptionOnServer,
        editOptionTitleOnServer,
        deleteOptionOnServer,
        deleteQuestionOnServer,
        isPublished
    } = props;

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
    const onDeleteOption = (option: Api.Option) => {
        deleteOptionOnServer(option);
    }
    const onDeleteQuestion = (question: Api.Question) => {
        deleteQuestionOnServer(question);
    }
    return (
        question ?
            <Question question={question}
                      onEditQuestion={onEditQuestion}
                      onEditQuestionTitle={onEditQuestionTitle}
                      onAddOption={onAddOption}
                      onEditOption={onEditOption}
                      onEditOptionTitle={onEditOptionTitle}
                      onDeleteOption={onDeleteOption}
                      onDeleteQuestion={onDeleteQuestion}
                      isPublished={isPublished}
            />

            : <></>
    )
}
const mapStateToProps = (state: RootState) => {
    return {
        question: getQuestionFromEditorState(state.editor),
        isPublished: state.editor.isPublished
    }
}
const mapDispatchToProps = ({
    editQuestionOnServer,
    editQuestionTitleOnServer,
    createOption,
    editOptionOnServer,
    editOptionTitleOnServer,
    deleteOptionOnServer,
    deleteQuestionOnServer,
});
const connector = connect(mapStateToProps, mapDispatchToProps);
export type QuestionContainerProps = ConnectedProps<typeof connector>
export default connector(QuestionContainer);
