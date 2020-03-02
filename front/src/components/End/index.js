import React from 'react'


const End = ({winner}) => {
    
    return(
        <>
            <p>Et notre nouvelle miss est...</p>
            <div className="miss-result">{winner}</div>
            <div className="thankyu">Merci d'avoir participé, patati patata</div>
        </>
    );
}

export default End;