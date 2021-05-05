import * as React from 'react';
import Modal from "../../../../Modal/Modal";
import {Api} from "../../../../../../types/api";
import "./editQuestionTitleModal.scss";
import ETypedFieldType = Api.ETypedFieldType;

interface EditQuestionTitleModal {
    onClose: () => void,
    question: Api.Question,
    onSubmit: (question: Api.Question) => void
}

const EditQuestionTitleModal: React.FC<EditQuestionTitleModal> = (props) => {
    const {onClose, question, onSubmit} = props;

    const init = {...question, title: {...question.title}};

    const [localQuestion, setLocalQuestion] = React.useState(init);

    const onTypeChange = () => {
        localQuestion.title.type = localQuestion.title.type === ETypedFieldType.TEXT_TYPE ? ETypedFieldType.IMAGE_TYPE : ETypedFieldType.TEXT_TYPE;
        setLocalQuestion({...localQuestion, title: {...localQuestion.title}});
    }
    const onChangeTextTitle = (e: React.ChangeEvent<HTMLInputElement>) => {
        localQuestion.title.body = e.target.value;
        setLocalQuestion({...localQuestion});
    }
    const Body = () => {
        const title = localQuestion.title;

        if (title.type === ETypedFieldType.TEXT_TYPE) {
            if (typeof title.body != "string") {
                title.body = '';
            }
            return (
                <input type="text" value={title.body} onChange={onChangeTextTitle} autoFocus={true}/>
            )
        } else {
            const onFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
                localQuestion.title.file = e.target.files[0];
                setLocalQuestion({...localQuestion});
            }
            return (
                <div>
                    <input type="file" accept="image/*" onChange={onFileChange}/>
                    <span>Выбранный файл: {localQuestion.title?.file?.name}</span>
                </div>
            )
        }

    };

    const submit = () => {
        onSubmit(localQuestion);
    }

    return (
        <Modal onClose={onClose} title={"Изменение вопроса"} wrapperClass={'editQuestionTitleModal'}>
            <div className="question-title-type">
                <span>Text</span>
                <div className="material-switch">
                    <input className="edit-question-type"
                           id={`questionTitle_${localQuestion.id}`}
                           name={`questionTitle_${localQuestion.id}`}
                           type="checkbox"
                           checked={localQuestion.title.type === ETypedFieldType.IMAGE_TYPE}
                           onChange={onTypeChange}

                    />
                    <label htmlFor={`questionTitle_${localQuestion.id}`} className="label-default"/>
                </div>
                <span>Image</span>
            </div>
            <Body/>
            <div>
                <button className={"btn btn-success btn-sm"} onClick={submit}>Изменить</button>
            </div>
        </Modal>
    )
}

export default EditQuestionTitleModal;