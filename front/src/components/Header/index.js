import React from 'react'


const Header = ({step, view}) => {
    if(view != 'global' && step != 0) {
        return (
            <header>
                <h1>Miss O'clock</h1>
            </header>
        )
    } else {
        return ('');
    }
}


export default Header;