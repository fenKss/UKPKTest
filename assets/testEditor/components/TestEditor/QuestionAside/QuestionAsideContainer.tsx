import * as React from 'react';
import {connect, ConnectedProps} from "react-redux";
import {QuestionsState} from "../../../../types/testEditor";
import {addQuestion, selectQuestion} from "../../../store/questionsReducer";
import QuestionAside from "./QuestionAside";

const mapStateToProps = (state: any): QuestionsState => {
    return {
        questions: state.questions.questions,
        selectedQuestion: state.questions.selectedQuestion
    }
}
const mapDispatchToProps = {
    addQuestion,
    selectQuestion
}


const QuestionAsideContainer = (props: QuestionAsideContainerProps) => {
    const {questions, selectedQuestion,addQuestion, selectQuestion} = props;
    return (
        <QuestionAside
            questions={questions}
            selectedQuestion={selectedQuestion}
            onSelectQuestion={selectQuestion}
            onAddQuestion={addQuestion}
    />
    )
};

const connector = connect(mapStateToProps, mapDispatchToProps);
export type QuestionAsideContainerProps = ConnectedProps<typeof connector>
export default connector(QuestionAsideContainer);