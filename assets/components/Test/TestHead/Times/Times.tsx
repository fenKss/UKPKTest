import * as React from "react";
import ExpiredAtTimer from "./ExpiredAtTimer";

interface TimesProps {
    expiredAt: Date,
    resultsSavedAt: Date
}


const Times: React.FC<TimesProps> = (props) => {
    const {expiredAt, resultsSavedAt} = props;

    return (
        <div className="time">
            <ExpiredAtTimer expiredAt={expiredAt}/>
            <div className="saved">
                Результаты сохранены: <span>2021-05-06 15:37:13</span>
            </div>
        </div>
    )
}
export default Times;

