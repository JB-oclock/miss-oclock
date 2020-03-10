import React from 'react'


const End = ({winner}) => {
    
    return(
        <>
            <p className="new-miss animated fadeIn">Et notre nouvelle miss est...</p>
            <div className="miss-result animated fadeIn">{winner} !</div>
            <div className="thankyu animated fadeIn">Merci d'avoir participé, patati patata</div>
        </>
    );
}

export default End;