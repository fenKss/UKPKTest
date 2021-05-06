import * as React from 'react'
import {Api} from "../../../../../types/api";
import {useState} from "react";
import EditQuestionTitleModal from "./EditQuestionTitleModal/EditQuestionTitleModal";
import Title from "../../Title";

interface QuestionTitleProps {
    question: Api.Question,
    onEditQuestionTitle: (question: Api.Question) => void
    isPublished: boolean
}

const QuestionTitle: React.FC<QuestionTitleProps> = (props) => {
    const {question, onEditQuestionTitle, isPublished} = props;

    const [isModalVisible, changeModalVisibility] = useState(false);

    const onButtonClick = () => {
        changeModalVisibility(true);
    }
    const onClose = () => {
        changeModalVisibility(false);
    }

    const onChangeTitle = (changedQuestion: Api.Question) => {
        onEditQuestionTitle(changedQuestion);
        changeModalVisibility(false);
    }
    return (
        <div className={'question-title'}>
            <Title field={question.title}/>
            {!isPublished &&
                <button className={"btn btn-xs"} onClick={onButtonClick}><i className="fa fa-edit"/></button>
            }
            {isModalVisible && !isPublished &&
                <EditQuestionTitleModal onClose={onClose} question={question} onSubmit={onChangeTitle}/>
            }
        </div>
    )
};

export default QuestionTitle;