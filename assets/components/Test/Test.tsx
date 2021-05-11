import * as React from "react";
import QuestionListContainer from "./QuestionList/QuestionListContainer";
import TestHeadContainer from "./TestHead/TestHeadContainer";

const Test: React.FC = () => {
    return (
        <>
            <TestHeadContainer/>
            <QuestionListContainer/>
        </>
    )
}

export default Test;