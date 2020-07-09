import React from 'react'


const Header = ({step, view}) => {
    if(step != 0 && step != 2) {
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