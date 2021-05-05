import * as React from "react";
import {Api} from "../../../../../types/api";
import Title from "../../Title";
import EQuestionType = Api.EQuestionType;

interface OptionProps {
    option: Api.Option,
    type: EQuestionType,
    onEditOption: (option: Api.Option) => void
    onEditOptionTitle: (option: Api.Option) => void
}

const Option: React.FC<OptionProps> = (props) => {
    const {option, onEditOption, type} = props;
    const onChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        option.isCorrect = !option.isCorrect;
        onEditOption({...option});
    }
    const onChangeTitle = (e: React.ChangeEvent<HTMLInputElement>) => {
        option.isCorrect = !option.isCorrect;
        onEditOption({...option});
    }

    return (
        <li className="option">
            <label>
                    <input
                        type={type == EQuestionType.RADIO_TYPE ? "radio" : "checkbox"}
                        onChange={onChange}
                        checked={option.isCorrect}
                    />
                    <Title field={option.body}/>
            </label>
        </li>
    )
}

export default Option;