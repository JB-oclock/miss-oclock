import {MERCURE_SUBSCRIBE_STEPS, setGameStep, stopWaiting } from '../reducer';
import { mercureSubscribe } from 'src/helpers';


const mercureMiddleware = (store) => (next) => (action) => {
  switch (action.type) {
    case MERCURE_SUBSCRIBE_STEPS:
      
      const state = store.getState();
      const eventSource = mercureSubscribe(`${process.env.MERCURE_STEPS}${state.app.gameId}`);

      eventSource.onmessage = (e) => {
        const { step } = JSON.parse(e.data);
        store.dispatch(setGameStep(step));
        store.dispatch(stopWaiting());
      };
      next(action);
      break;
    default:
      next(action);
  }
}

export default mercureMiddleware;