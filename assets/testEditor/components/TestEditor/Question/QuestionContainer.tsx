import * as React from 'react';
import Question from "./Question";
import {connect, ConnectedProps} from "react-redux";

const mapStateToProps = (state) => {
    return {
        questions: state.questions.questions,
        selectedQuestion: state.questions.selectedQuestion
    }
};
const mapDispatchToProps = (dispatch) => {
    return {}
};
const connector = connect(mapStateToProps, mapDispatchToProps);

const QuestionContainer = (props: QuestionContainerProps) => {
    const {questions, selectedQuestion} = props;

    const question = questions.find((q) => q.id == selectedQuestion);

    return (
        <>
            <Question question={question}/>
        </>
    )
}

type QuestionContainerProps = ConnectedProps<typeof connector>;

export default connector(QuestionContainer);