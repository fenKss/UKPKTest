import * as React from "react";
import {Api} from "../../../../../types/api";
import Title from "../../Title";
import EQuestionType = Api.EQuestionType;
import {useState} from "react";
import EditOptionTitleModal from "./EditOptionTitleModal/EditOptionTitleModal";

interface OptionProps {
    option: Api.Option,
    type: EQuestionType,
    onEditOption: (option: Api.Option) => void
    onEditOptionTitle: (option: Api.Option) => void
    onDeleteOption: (option: Api.Option) => void
    isPublished: boolean
}

const Option: React.FC<OptionProps> = (props) => {
    const {option, onEditOption, type, onEditOptionTitle, onDeleteOption, isPublished} = props;
    const onChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (isPublished) return;
        option.isCorrect = !option.isCorrect;
        onEditOption({...option});
    }
    const onChangeTitle = (option: Api.Option) => {
        onEditOptionTitle({...option});
    }
    const onModalClose = () => {
        setIsModalVisible(false);
    }
    const onDelete = () => {
        onDeleteOption(option);
    }
    const [isModalVisible, setIsModalVisible] = useState(false);
    return (
        <li className="option">
            <label>
                <input
                    type={type == EQuestionType.RADIO_TYPE ? "radio" : "checkbox"}
                    onChange={onChange}
                    checked={option.isCorrect}
                />
                <Title field={option.body}/>
                {!isPublished &&
                <button
                  onClick={() => {
                      setIsModalVisible(true)
                  }}
                  className={"btn btn-xs"}>
                  <i className="fa fa-edit"/>
                </button>
                }
                {!isPublished &&
                <button
                  onClick={onDelete}
                  className={"btn btn-xs btn-danger"}
                >
                  <i className="fa fa-trash"/>
                </button>}
            </label>
            {isModalVisible && !isPublished &&
            <EditOptionTitleModal
              onClose={onModalClose}
              option={option}
              onSubmit={onChangeTitle}
            />}
        </li>
    )
}

export default Option;