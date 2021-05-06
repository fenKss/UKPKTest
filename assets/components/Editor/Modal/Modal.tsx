import * as React from 'react';
import "./modal.scss"

interface ModalProps {
    onClose: () => void,
    title: string,
    wrapperClass: string
}

const Modal: React.FC<ModalProps> = (props) => {
    const {onClose, title, wrapperClass} = props;
    return (
        <div className='modal modal-open'>
            <div className={`modal-wrapper ${wrapperClass}`}>
                <div className="modal-content">
                    <div className="modal-head">
                        <div className="modal-title">
                            {title}
                        </div>
                        <div className="modal-close" onClick={onClose}>X</div>
                    </div>
                    <div className="modal-body">
                        {props.children}
                    </div>
                </div>
            </div>
        </div>
    )
}
export default Modal;