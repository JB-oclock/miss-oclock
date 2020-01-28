import { connect } from 'react-redux';

import App from 'src/components/App';

const mapStateToProps = (state) => ({
  player: state.app.player,
});

const mapDispatchToProps = {};

const AppContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(App);

export default AppContainer;