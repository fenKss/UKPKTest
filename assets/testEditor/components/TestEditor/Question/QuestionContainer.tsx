import * as React from 'react';
import Question from "./Question";
import {connect, ConnectedProps} from "react-redux";


const mapStateToProps = () => {};
const mapDispatchToProps = () => {};
const connector = connect(mapStateToProps, mapDispatchToProps);

const QuestionContainer = (props: QuestionContainerProps) =>{
    return <Question />
}

type QuestionContainerProps = ConnectedProps<typeof connector>;

export default connector(QuestionContainer);