
export const initialState = {
    questionId: 0,
    question: '',
    answers: [],
    answered: false, 
    last: false,
  };
  

const SET_QUESTION = 'SET_QUESTION';
export const ANSWER_QUESTION = 'ANSWER_QUESTION';
export const SET_ANSWERED = 'SET_ANSWERED';

/**
 * Action creators
 */


export const setQuestion = (question) => ({
  type: SET_QUESTION,
  question,
});

export const answerQuestion = (answer) => ({
  type: ANSWER_QUESTION,
  answer,
});
export const setAnswered = () => ({
  type: SET_ANSWERED,
});


/**
 * Reducer
 */

const reducer = (state = initialState, action = {}) => {
    switch (action.type) {
      case SET_QUESTION :
          return {
            ...state,
            ...action.question,
          };
        break;
      case SET_ANSWERED: 
          return {
            ...state,
            answered: true,
          }
          break;
      default:
        return state;
    }
  };
  
export default reducer;
  