import * as React from "react";
import {useEffect, useState} from "react";

interface TimesProps {
    expiredAt: Date,
    resultsSavedAt: Date
}

const Times: React.FC<TimesProps> = (props) => {
    const {expiredAt, resultsSavedAt} = props;

    let [time, setTime] = useState('');

    const pad = (n) => {
        return (n < 10 ? '0' : '') + n;
    }


    const getCountdown = () => {
        console.log(expiredAt, (+expiredAt - +(new Date())))
        if ((+expiredAt - +(new Date())) < 0) {
            /**
             * TODO Заменить на location.reload();
             */
            console.log('Время истекло');
            clearInterval(interval);
            return;
        }
        const current_date = new Date().getTime();
        let seconds_left = (+expiredAt - current_date) / 1000;

        const days = pad(seconds_left / 86400);
        seconds_left = seconds_left % 86400;

        const hours = pad(seconds_left / 3600);
        seconds_left = seconds_left % 3600;

        const minutes = pad(seconds_left / 60);
        const seconds = pad(seconds_left % 60);

        setTime(days + ' : ' + hours + ' : ' + minutes + ' : ' + seconds);
    }
    useEffect(getCountdown, []);
    const interval = setInterval(getCountdown, 1000);

    return (
        <div className="time">
            <div className="expired">
                Осталось времени: <span>{time}</span>
            </div>
            <div className="saved">
                Результаты сохранены: <span>2021-05-06 15:37:13</span>
            </div>
        </div>
    )
}
export default Times;

