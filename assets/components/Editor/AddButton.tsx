import * as React from 'react';

export interface AddQuestionButtonProps {
    onClick: () => void,
    id?: string,
    class?: string
}

const AddButton: React.FC<AddQuestionButtonProps> = (props) => {
    const {onClick, id} = props;
    return (
        <button
            className={`btn addButton ${props.class}`}
            onClick={onClick}
            id={id}
        >
            <i className="fa fa-plus"/>
        </button>
    )
}

export default AddButton;