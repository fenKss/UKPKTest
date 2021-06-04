import * as React from "react";

type ExpiredAtTimerProps = {
    expiredAt: Date
}
const padTime = time => {
    return String(time).length === 1 ? `0${time}` : `${time}`;
};

const format = time => {
    // Convert seconds into minutes and take the whole part
    const minutes = Math.floor(time / 60);

    // Get the seconds left after converting minutes
    const seconds = Math.floor(time % 60);

    //Return combined values as string in format mm:ss
    return `${minutes}:${padTime(seconds)}`;
};
const ExpiredAtTimer: React.FC<ExpiredAtTimerProps> = ({expiredAt}) => {
    let counter, setCounter;
    if (expiredAt) {
        const current_date = new Date().getTime();
        let seconds_left = (+expiredAt - current_date) / 1000;
        [counter, setCounter] = React.useState(seconds_left);
        React.useEffect(() => {
            let timer;
            if (counter > 0) {
                timer = setTimeout(() => setCounter(c => c - 1), 1000);
            }

            return () => {
                if (timer) {
                    clearTimeout(timer);
                }
            };
        }, [counter]);
    }
    if (typeof counter == 'undefined') {
        counter = 0;
    }
    return (
        <div className="expired">
            Осталось времени: <span> {counter === 0 ? "Time over" : format(counter)}</span>
        </div>
    )
}
export default ExpiredAtTimer;