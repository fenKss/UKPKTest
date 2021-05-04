import * as React from 'react'
import {Api} from "../../../../types/api";
import {useState} from "react";
import EditQuestionTitleModal from "./EditQuestionTitleModal/EditQuestionTitleModal";

interface QuestionTitleProps {
    question: Api.Question,
    onEditQuestionTitle: (question: Api.Question) => void
}

const QuestionTitle: React.FC<QuestionTitleProps> = (props) => {
    const {question,onEditQuestionTitle} = props;
    const body = question.title.body;

    const [isModalVisible, changeModalVisibility] = useState(false);

    const onButtonClick = () => {
        changeModalVisibility(true);
    }
    const onClose = () => {
        changeModalVisibility(false);
    }

    const Title = () => {
        if (question.title.type == Api.ETypedFieldType.IMAGE_TYPE) {
            //@ts-ignore
            return <img src={body?.fullPath} alt={body?.filename}/>
        }
        return <span>{body}</span>;
    }
    const onChangeTitle = (changedQuestion: Api.Question) => {
        onEditQuestionTitle(changedQuestion);
        changeModalVisibility(false);
    }
    return (
        <div className={'question-title'}>
            <Title/>
            <button className={"btn btn-xs"} onClick={onButtonClick}><i className="fa fa-edit"/></button>
            {isModalVisible && <EditQuestionTitleModal onClose={onClose} question={question} onSubmit={onChangeTitle}/>}
        </div>
    )
};

export default QuestionTitle;