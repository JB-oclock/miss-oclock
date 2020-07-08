import { connect } from 'react-redux';

import Question from 'src/components/GlobalView/Question';
import {setQuestion,  endQuestions, setAnswered } from 'src/store/questionsReducer';


const mapStateToProps = (state) => ({
  question: state.questions,
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
  setQuestion: (q) => {
    dispatch(setQuestion(q));
  },
  setAnswered: () => {
    dispatch(setAnswered());
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