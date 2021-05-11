import * as React from "react";

interface AboutProps {
    olympicName: string,
    variantIndex: number,
    tourIndex: number
}

const About: React.FC<AboutProps> = (props) => {
    const {olympicName, variantIndex, tourIndex} = props;

    return (
        <div className="about">
            <div className="olympic-name title">
                Олимпиада: <span>{olympicName}</span>
            </div>
            <div className="tour-name title">
                Тур: <span>{tourIndex}</span>
            </div>
            <div className="variant-index title">
                Вариант: <span>{variantIndex}</span>
            </div>
        </div>
    )
};

export default About;