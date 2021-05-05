import * as React from "react";
import {Api} from "../../../../../types/api";
import Title from "../../Title";
import EQuestionType = Api.EQuestionType;
import {useState} from "react";
import EditOptionTitleModal from "./EditOptionTitleModal/EditOptionTitleModal";
import AddButton from "../../../AddButton";

interface OptionProps {
    option: Api.Option,
    type: EQuestionType,
    onEditOption: (option: Api.Option) => void
    onEditOptionTitle: (option: Api.Option) => void
}

const Option: React.FC<OptionProps> = (props) => {
    const {option, onEditOption, type,onEditOptionTitle } = props;
    const onChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        option.isCorrect = !option.isCorrect;
        console.log(option.isCorrect);
        onEditOption({...option});
    }
    const onChangeTitle = (option: Api.Option) => {
        onEditOptionTitle({...option});
    }
    const onModalClose = () => {
        setIsModalVisible(false);
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
                <button onClick={()=> {setIsModalVisible(true)}} className={"btn btn-xs"} ><i className="fa fa-edit"/></button>
            </label>
            {isModalVisible && <EditOptionTitleModal onClose={onModalClose} option={option} onSubmit={onChangeTitle} /> }
        </li>
    )
}

export default Option;