// == Import : npm
import React, { Component } from 'react';


class Code extends Component {

    render() {
        const { handleChange } = this.props;
        return (
            <form>
                <label htmlFor="code">Code de jeu</label>
                <input onChange={handleChange} autoFocus defaultValue={ this.props.code } name="code" id="code" type="text"/>
                <input type="submit" value="Envoyer" />
            </form>
        );
    }
}
// == Export 
export default Code;
 