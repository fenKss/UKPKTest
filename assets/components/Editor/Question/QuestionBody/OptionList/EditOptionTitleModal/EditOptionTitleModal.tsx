import * as React from 'react';
import Modal from "../../../../Modal/Modal";
import {Api} from "../../../../../../types/api";
import "./editOptionTitleModal.scss";
import ETypedFieldType = Api.ETypedFieldType;

interface EditOptionTitleModal {
    onClose: () => void,
    option: Api.Option,
    onSubmit: (question: Api.Option) => void
}

const EditOptionTitleModal: React.FC<EditOptionTitleModal> = (props) => {
    const {onClose, option, onSubmit} = props;

    const init = {...option, body: {...option.body}};

    const [localOption, setLocalQuestion] = React.useState(init);

    const onTypeChange = () => {
        localOption.body.type = localOption.body.type === ETypedFieldType.TEXT_TYPE ? ETypedFieldType.IMAGE_TYPE : ETypedFieldType.TEXT_TYPE;
        setLocalQuestion({...localOption, body: {...localOption.body}});
    }
    const onChangeTextTitle = (e: React.ChangeEvent<HTMLInputElement>) => {
        localOption.body.text = e.target.value;
        setLocalQuestion({...localOption});
    }
    const Body = () => {
        const title = localOption.body;

        if (title.type === ETypedFieldType.TEXT_TYPE) {
            return (
                <input type="text" value={title.text} onChange={onChangeTextTitle} autoFocus={true}/>
            )
        } else {
            const onFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
                localOption.body.file = e.target.files[0];
                setLocalQuestion({...localOption});
            }
            return (
                <div>
                    <input type="file" accept="image/*" onChange={onFileChange}/>
                    <span>Выбранный файл: {localOption.body?.file?.name}</span>
                </div>
            )
        }

    };

    const submit = () => {
        onSubmit(localOption);
        onClose();
    }

    return (
        <Modal onClose={onClose} title={"Изменение вопроса"} wrapperClass={'editQuestionTitleModal'}>
            <div className="question-title-type">
                <span>Text</span>
                <div className="material-switch">
                    <input className="edit-question-type"
                           id={`questionTitle_${localOption.id}`}
                           name={`questionTitle_${localOption.id}`}
                           type="checkbox"
                           checked={localOption.body.type === ETypedFieldType.IMAGE_TYPE}
                           onChange={onTypeChange}
                    />
                    <label htmlFor={`questionTitle_${localOption.id}`} className="label-default"/>
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

export default EditOptionTitleModal;