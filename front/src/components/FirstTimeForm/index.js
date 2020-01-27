// == Import : npm
import React, { Component } from 'react';
import Axios from 'axios';
import Code from './code'
import Player from './player'
import { toastr } from 'react-redux-toastr';

class FirstTimeForm extends Component {
    state = {
        step: 1,
        code: '',
        name: ''
    }

    constructor(props) {
        super(props);
    }
 
    handleChange = (event) => {
        const { name, value} = event.target;
        
        this.setState({
            [name]: value
        });
    }

    
    nextStep = () => {
        this.setState({
            step: this.state.step +1
        })
    }

    submitForm = (event) => {
        event.preventDefault();
        
        Axios.post(process.env.API_DOMAIN + "login", {
            code: this.state.code,
            name: this.state.name
        })
        .then(function(response){
            localStorage.setItem('token', response.data);
            // Dispatch to store
        })
        .catch(function(error) {
            if(error.response.data.errors) 
            {
                const errors = error.response.data.errors;
                for (const error in errors){
                    toastr.error(errors[error]);
                }
            }
           
        });
    }

    render() {
        const { code, name } = this.state;
        switch (this.state.step) {
            case 1:
                return <Code 
                    code={code}
                    handleChange={this.handleChange}
                    nextStep={this.nextStep} 
                    />
            case 2:
                return <Player 
                        code={code}
                        name={name}
                        handleChange={this.handleChange}
                        submitForm={this.submitForm}
                         />
        }
    }
}
// == Export 
export default FirstTimeForm;
 