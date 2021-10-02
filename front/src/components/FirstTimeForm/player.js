// == Import : npm
import React, { Component } from 'react';
import AjaxButton from '../../containers/AjaxButton';


class Player extends Component {

    render() {
        const { submitForm, code, handleChange, name } = this.props;
        return (
            <form autoComplete="off" onSubmit={submitForm}>
                <label htmlFor="code">Mon prénom, nom ou autre chaîne de caractères servant à m'identifier</label>
                <input type="hidden" name="code" value={code}></input>
                <input autoComplete="off" onChange={handleChange} autoFocus defaultValue={ name } name="name" id="name" type="text"/>
                <AjaxButton disabled={!(name.length > 1)} textContent="Envoyer"></AjaxButton>
            </form>
        );
    }
}
// == Export 
export default Player;
 