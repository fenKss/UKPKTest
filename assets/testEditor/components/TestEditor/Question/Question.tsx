import * as React from 'react';
import  {Question} from "../../../../types/testEditor";

type Props = {
    question:Question
}
const Question = (props: Props) => {
    const {question} = props;
    if (!question){
        return <></>
    }
    return (
        <div className="question">
            <div className="question-head">
                <div className="question-title">{question.title}</div>
            </div>
        </div>
    )
}

export default Question;