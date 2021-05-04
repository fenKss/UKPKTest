import * as React from 'react';
import Modal from "../../../Modal/Modal";

interface EditQuestionTitleModal {
    onClose: () => void,
    title: string
}


const EditQuestionTitleModal: React.FC<EditQuestionTitleModal> = (props) => {
    const {onClose, title} = props;
    return (
        <Modal onClose={onClose} title={title}>123</Modal>
    )
}

export default EditQuestionTitleModal;