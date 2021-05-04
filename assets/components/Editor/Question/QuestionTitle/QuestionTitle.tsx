import * as React from 'react'
import {Api} from "../../../../types/api";
import {useState} from "react";
import EditQuestionTitleModal from "./EditQuestionTitleModal/EditQuestionTitleModal";

interface QuestionTitleProps {
    question: Api.Question
}

const QuestionTitle: React.FC<QuestionTitleProps> = (props) => {
    const {question} = props;
    const body = question.title.body;

    const [isModalVisible, changeModalVisibility] = useState(false);

    const onButtonClick = () => {
        changeModalVisibility(true);
    }
    const onClose = () => {
        changeModalVisibility(false);
    }
    const Title = () => {
        if (typeof body !== "string" && question.title.type == Api.ETypedFieldType.IMAGE_TYPE) {
            return <img src={body.fullPath} alt={body.filename}/>
        }
        return <span>{body}</span>;
    }

    return (
        <div className={'question-title'}>
            <Title/>
            <button className={"btn btn-xs"} onClick={onButtonClick}><i className="fa fa-edit"/></button>
            {isModalVisible && <EditQuestionTitleModal onClose={onClose} title={"Изменение вопроса"} />}
        </div>
    )
};

export default QuestionTitle;