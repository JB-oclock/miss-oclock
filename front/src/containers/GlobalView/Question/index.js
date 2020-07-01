import { connect } from 'react-redux';

import Question from 'src/components/GlobalView/Question';
import {setQuestion, answerQuestion, endQuestions } from 'src/store/questionsReducer';
import {setStep1Winner } from 'src/store/reducer';


const mapStateToProps = (state) => ({
  question: state.questions,
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
  setQuestion: (q) => {
    dispatch(setQuestion(q));
  },
  endQuestions: () => {
    dispatch(endQuestions());
  },
});

const QuestionContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Question);

export default QuestionContainer;