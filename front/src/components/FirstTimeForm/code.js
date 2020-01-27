// == Import : npm
import React, { Component } from 'react';
import Axios from 'axios';
import { toastr } from 'react-redux-toastr';


class Code extends Component {

    checkCode = (event) => {
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
        });
    }
    render() {
        const { handleChange, code } = this.props;
        return (
            <form onSubmit={this.checkCode}>
                <label htmlFor="code">Code de jeu</label>
                <input onChange={handleChange} autoFocus defaultValue={ code } name="code" id="code" type="text"/>
                <input disabled={!(code.length == 5)} type="submit" value="Envoyer" />
            </form>
        );
    }
}
// == Export 
export default Code;
 