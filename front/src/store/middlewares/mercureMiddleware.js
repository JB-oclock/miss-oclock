import {MERCURE_SUBSCRIBE_STEPS, setGameStep } from '../reducer';

const mercureMiddleware = (store) => (next) => (action) => {
  switch (action.type) {
    case MERCURE_SUBSCRIBE_STEPS:
      const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);

      const state = store.getState();
      url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}${process.env.MERCURE_STEPS}${state.app.gameId}.jsonld`);
      const eventSource = new EventSource(url, { withCredentials: true });

      eventSource.onmessage = (e) => {
        const { step } = JSON.parse(e.data);
        store.dispatch(setGameStep(step));
      };
      next(action);
      break;
    default:
      next(action);
  }
}

export default mercureMiddleware;