import * as React from "react";
import {connect, ConnectedProps} from "react-redux";
import {ParamTypes} from "../../../types";
import {RootState} from "../../../store/store";
import {useParams} from 'react-router-dom';
import {useEffect, useLayoutEffect} from "react";
import {setTestFromServer} from "../../../store/testReducer/serverActions";
import {Reducer} from "../../../store/testReducer/actions";
import selectQuestion = Reducer.Test.ActionCreator.selectQuestion;
import QuestionList from "../../Editor/QuestionList/QuestionList";
import  "./questionList.scss";

const QuestionListContainer: React.FC<QuestionListContainerProps> = (props) => {

    const {questions, setTestFromServer, selectedQuestionId, selectQuestion} = props;
    const {testId} = useParams<ParamTypes>();

    useLayoutEffect(() => {
        setTestFromServer(+testId, true);
    }, []);

    return (
        <QuestionList
            questions={questions}
            selectedQuestionId={selectedQuestionId}
            onSelectQuestion={selectQuestion}
            numbersOnly={true}
        />
    )
}

const mapStateToProps = (state: RootState) => ({
    questions: state.test.questions,
    selectedQuestionId: state.test.selectedQuestionId
})

const mapDispatchToProps = {
    setTestFromServer,
    selectQuestion,
}

const connector = connect(mapStateToProps, mapDispatchToProps);
export type QuestionListContainerProps = ConnectedProps<typeof connector>
export default connector(QuestionListContainer);
