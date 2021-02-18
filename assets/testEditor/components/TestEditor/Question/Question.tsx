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
        <div>{question.title}</div>
    )
}

export default Question;