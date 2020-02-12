import { connect } from 'react-redux';

import Question from 'src/components/Question';
import {setQuestion, answerQuestion } from 'src/store/questionsReducer';

const mapStateToProps = (state) => ({
  question: state.questions,
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
  setQuestion: (q) => {
    dispatch(setQuestion(q));
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