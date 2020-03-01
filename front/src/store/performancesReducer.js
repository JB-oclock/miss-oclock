
export const initialState = {
    performanceId: 0,
    performerId:0,
    title: '',
    answers: [],
    answered: false, 
    last: false,
    ended: false,
  };
  

const SET_PERFORMANCE = 'SET_PERFORMANCE';
export const ANSWER_PERFORMANCE = 'ANSWER_PERFORMANCE';
export const END_PERFORMANCE = 'END_PERFORMANCE';
export const SET_ANSWERED = 'SET_ANSWERED';

/**
 * Action creators
 */


export const setPerformance = (performance) => ({
  type: SET_PERFORMANCE,
  performance,
});

export const answerPerformance = (answer) => ({
  type: ANSWER_PERFORMANCE,
  answer,
});
export const setAnswered = () => ({
  type: SET_ANSWERED,
});
export const endPerformance = () => ({
  type: END_PERFORMANCE,
});


/**
 * Reducer
 */

const reducer = (state = initialState, action = {}) => {
    switch (action.type) {
      case SET_PERFORMANCE :
          return {
            ...state,
            ...action.performance,
          };
        break;
      case SET_ANSWERED: 
          return {
            ...state,
            answered: true,
          }
        break;
      case END_PERFORMANCE: 
          return {
            ...state,
            ended: true,
          }
        break;
      default:
        return state;
    }
  };
  
export default reducer;
  