// == Import : npm
import React, { Component } from 'react';
import Axios from 'axios';
import { toastr } from 'react-redux-toastr';
import store from 'src/store';
import { stopWaitingAjax, waitingAjax } from '../../store/reducer';
import Ajaxbutton from '../../containers/AjaxButton';

class Code extends Component {
    constructor(props) {
        super(props);
        this.checkCode = this.checkCode.bind(this);
     }    
   
    checkCode = (event) => {
        store.dispatch(waitingAjax());
        event.preventDefault();
        const {nextStep} = this.props;
        Axios.post(process.env.API_DOMAIN + "check-code", {
            code: this.props.code
        })
        .then(function(response){
            if(response.data) {
                nextStep();
            } else {
               toastr.error('Erreur', "Ce code n'existe pas !");
            } 
        }).finally(() => {
          store.dispatch(stopWaitingAjax());
        });
    }
    render() {
        const { handleChange, code } = this.props;
        return ( 
            <form autoComplete='off' onSubmit={this.checkCode}>
                <label htmlFor="code">Code de jeu</label>
                <input autoComplete="off" onChange={handleChange} autoFocus defaultValue={ code } name="code" id="code" type="text"/>
                <Ajaxbutton disabled={!(code.length == 5)} textContent="Envoyer"></Ajaxbutton>
            </form>
        );
    }
}
// == Export 
export default Code;
 