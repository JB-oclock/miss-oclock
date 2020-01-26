// == Import : npm
import React, { Component } from 'react';


class Code extends Component {
    state = {
        code: ''
    }

 
    changeCode = (event) => {
        this.setState({
            code: event.target.value
        });
    }

    submitCode = (event) => {
        event.preventDefault();
        // Send to API
    }

    render() {
    return (
        <form onSubmit={this.submitCode}>
            <label htmlFor="code">Code de jeu</label>
            <input onChange={this.changeCode} autoFocus defaultValue={ this.state.code } name="code" id="code" type="text"/>
            <input type="submit" value="Envoyer" />
        </form>
    );
}
}
// == Export 
export default Code;
 