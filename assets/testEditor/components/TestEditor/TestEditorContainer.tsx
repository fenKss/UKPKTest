import * as React from 'react';
import {connect, ConnectedProps} from "react-redux";
import TestEditor from "./TestEditor";
import {getQuestions} from "../../store/questionsReducer";
import {useParams} from "react-router-dom";
import {useEffect} from "react";

const mapStateToProps = (state) => {
    return {
        questions: state.questions.questions
    }
};
const mapDispatchToProps = {
    getQuestions
};

const connector = connect(mapStateToProps, mapDispatchToProps);
type Props = ConnectedProps<typeof connector>;

const TestEditorContainer = (props: Props) => {
    const {getQuestions, questions} = props;
    //@ts-ignore
    const {variantId} = useParams();
    useEffect(()=> {
        getQuestions(variantId);
    },[])
    return <TestEditor questions={questions}/>
};

export default connector(TestEditorContainer);