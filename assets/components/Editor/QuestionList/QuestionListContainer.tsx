import * as React from "react";
import {connect, ConnectedProps} from "react-redux";
import {Reducer} from "../../../store/editorReducer/actions";
import {ParamTypes} from "../../../types";
import {RootState} from "../../../store/store";
import {useParams} from 'react-router-dom';
import {useEffect} from "react";
import QuestionList from "./QuestionList";
import {setQuestionsFromServer} from "../../../store/editorReducer/serverActions";
import selectQuestion = Reducer.Editor.ActionCreator.selectQuestion;
import  "./questionList.scss";

const QuestionListContainer = (props: EditorContainerProps) => {

    const {questions, setQuestionsFromServer, selectedQuestionId, selectQuestion} = props;
    const {variantId} = useParams<ParamTypes>();

    useEffect(() => {
        setQuestionsFromServer(+variantId, true);
    }, []);

    return (
        <QuestionList
            questions={questions}
            selectedQuestionId={selectedQuestionId}
            onSelectQuestion={selectQuestion}
        />
    )
}

const mapStateToProps = (state: RootState) => ({
    questions: state.editor.questions,
    selectedQuestionId: state.editor.selectedQuestionId
})

const mapDispatchToProps = {
    setQuestionsFromServer,
    selectQuestion,
}

const connector = connect(mapStateToProps, mapDispatchToProps);
export type EditorContainerProps = ConnectedProps<typeof connector>
export default connector(QuestionListContainer);
