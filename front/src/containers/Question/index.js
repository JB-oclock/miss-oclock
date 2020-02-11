import { connect } from 'react-redux';

import Question from 'src/components/Question';
import {setQuestion } from 'src/store/questionsReducer';

const mapStateToProps = (state) => ({
  questions: state.questions,
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
  setQuestion: (q) => {
    dispatch(setQuestion(q));
  },
});

const QuestionContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Question);

export default QuestionContainer;