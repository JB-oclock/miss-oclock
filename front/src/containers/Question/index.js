import { connect } from 'react-redux';

import Question from 'src/components/Question';
import {setQuestion, answerQuestion, endQuestions, setAnswered } from 'src/store/questionsReducer';
import {setStep1Winner } from 'src/store/reducer';


const mapStateToProps = (state) => ({
  question: state.questions,
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
  setQuestion: (q) => {
    dispatch(setQuestion(q));
  },
  setWinner: (winners) => {
    dispatch(setStep1Winner(winners));
  },
  setAnswered: () => {
    dispatch(setAnswered());
  },
  endQuestions: () => {
    dispatch(endQuestions());
  },
  answerQuestion: (answer) => {
    dispatch(answerQuestion(answer))
  }
});

const QuestionContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Question);

export default QuestionContainer;