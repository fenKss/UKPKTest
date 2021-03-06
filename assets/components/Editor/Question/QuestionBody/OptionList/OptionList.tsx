import * as React from "react";
import {Api} from "../../../../../types/api";
import EQuestionType = Api.EQuestionType;
import Option from "./Option";
import AddButton from "../../../AddButton";
import "./optionList.scss";

interface OptionListProps {
    options: Api.Option[]
    type: EQuestionType
    onEditOption: (option: Api.Option) => void
    onDeleteOption: (option: Api.Option) => void
    onEditOptionTitle: (option: Api.Option) => void
    onAddOption: () => void
    isPublished: boolean

}

const OptionList: React.FC<OptionListProps> = (props) => {
    const {options, onEditOption, type, onAddOption, onEditOptionTitle, onDeleteOption, isPublished} = props;

    const Options = options.map((option, i) =>
        <Option
            option={option}
            type={type}
            onEditOption={onEditOption}
            onEditOptionTitle={onEditOptionTitle}
            onDeleteOption={onDeleteOption}
            isPublished={isPublished}
            key={i}
        />
    );
    return (
        <div>
            <span>Варианты ответа
                {!isPublished && <AddButton onClick={onAddOption} class="btn-xs btn-default"/>}
            </span>
            <ul className="option-list">
                {Options}
            </ul>
        </div>
    )
}
export default OptionList;