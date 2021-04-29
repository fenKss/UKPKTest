namespace Api {
    interface IImage {
        filename: string
        fullPath: string
    }

    enum ETypedFieldType {
        TEXT_TYPE = 0,
        IMAGE_TYPE = 1
    }

    enum EQuestionType {
        RADIO_TYPE = 0,
        SELECT_TYPE = 1
    }

    type TypedField = {
        id: number;
        type: ETypedFieldType;
        text: string | null;
        image: IImage | null;
    }

    type Option = {
        id: number
        questionId: number
        isCorrect: boolean
        body: TypedField
    }
    type Question = {
        id: number
        title: TypedField
        type: EQuestionType
        variantId: number
        options: Option[]
    }

    type Variant = {
        id: number
        testId: number
        userTests: []
        questions: Question[]
    }

    type Response<T> = {
        error: boolean,
        data: T,
        error_msg: string
    }
}