// == Import : npm
import React, { Component } from 'react';


class Player extends Component {

    render() {
        const { submitForm, code, handleChange, name } = this.props;
        return (
            <form onSubmit={submitForm}>
                <label htmlFor="code">Mon prénom, nom ou autre chaîne de caractères servant à m'identifier</label>
                <input type="hidden" name="code" value={code}></input>
                <input onChange={handleChange} autoFocus defaultValue={ name } name="name" id="name" type="text"/>
                <input disabled={!(name.length > 1)} type="submit" value="Envoyer" />
            </form>
        );
    }
}
// == Export 
export default Player;
 