import { connect } from 'react-redux';

import Question from 'src/components/Question';

const mapStateToProps = (state) => ({
  questions: state.questions,
});

const mapDispatchToProps = (dispatch) => ({

});

const QuestionContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Question);

export default QuestionContainer;