import Axios from 'axios';
import { GET_PLAYER_INFOS, setPlayer, stopLoading, waiting, mercureSubscribeSteps, setGameId, getGameData, GET_GAME_DATA, setGameStep, setStep1Winner } from '../reducer';
import { setQuestion, setAnswered, ANSWER_QUESTION } from '../questionsReducer';
import { toastr } from 'react-redux-toastr';
import { setPerformance, ANSWER_PERFORMANCE, setAnswered as setAnsweredPerformance } from '../performancesReducer';


const ajaxMiddleware = (store) => (next) => (action) => {
  const token = `Bearer ${localStorage.getItem('token')}`;
  const state = store.getState();
  let data;
  switch (action.type) {
    case GET_PLAYER_INFOS:
      Axios.get(`${process.env.API_DOMAIN}get-infos`, {
        headers: {
          Authorization: token,
        },
      }).then((response) => {
        const player = {
          token: localStorage.getItem('token'),
          ...response.data,
        };
        store.dispatch(setPlayer(player));
        store.dispatch(getGameData());
      }).catch(() => {
        store.dispatch(stopLoading());
      });
      break;

    case GET_GAME_DATA: 
      Axios.get(`${process.env.API_DOMAIN}game-data`, {
        headers: {
          Authorization: token,
        },
      }).then((response) => {
          const {gameId, gameStep, question, step_1_winner, performance} = response.data;
          
        store.dispatch(setGameId(gameId));
        store.dispatch(setGameStep(gameStep));
        store.dispatch(setStep1Winner(step_1_winner));
        store.dispatch(mercureSubscribeSteps());

        store.dispatch(stopLoading());
        if(gameStep == 0 ){
          store.dispatch(waiting());
        }
        if(gameStep == 1 && question) {
          store.dispatch(setQuestion(question));
        }  
        if(gameStep == 2 && performance) {
          store.dispatch(setPerformance(performance));
        }   
      });
      break;  

    case ANSWER_QUESTION:
      data = {
        answer: action.answer,
        question: state.questions.questionId
      };
      
      Axios.post(`${process.env.API_DOMAIN}answer-question`,data, {
        headers: {
          Authorization: token,
        },
      }).then(() => {
        store.dispatch(setAnswered());
        
      }).catch((error) => {
        if (error.response?.data.errors) {
          const { errors } = error.response.data;
          for (const error in errors) {
            toastr.error(errors[error]);
          }
        }

      });
      break;
    case ANSWER_PERFORMANCE:
      data = {
        answer: action.answer,
        performance: state.performances.performanceId
      };
      
      Axios.post(`${process.env.API_DOMAIN}answer-performance`,data, {
        headers: {
          Authorization: token,
        },
      }).then(() => {
        store.dispatch(setAnsweredPerformance());
        
      }).catch((error) => {
        if (error.response?.data.errors) {
          const { errors } = error.response.data;
          for (const error in errors) {
            toastr.error(errors[error]);
          }
        }

      });
      break;
    default:
      next(action);
  }
};

export default ajaxMiddleware;
