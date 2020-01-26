// == Import : npm
import React, { Component } from 'react';
import Axios from 'axios';
import Code from './code'

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
        console.log(name);
        
        this.setState({
            [name]: value
        });
    }


    submitCode = (event) => {
        event.preventDefault();
        
        // Send to API
        Axios.post(process.env.API_DOMAIN + "login", {
            code: this.state.code
        })
        .then(function(response){
            console.log(response.data);
        });
    }

    render() {
        const { code } = this.state;
        switch (this.state.step) {
            case 1:
                return <Code code={code} handleChange={this.handleChange} />
            case 2:
                // return <Player />
        }
    }
}
// == Export 
export default FirstTimeForm;
 