import React from 'react'


const End = ({winner, view}) => {
    const viewClass = (view == undefined) ? 'user-view' : view;
    return(
        <>
            <div className={viewClass}>
                <p className="new-miss animated fadeIn">Et notre nouvelle miss est...</p>
                <div className="miss-result animated fadeIn delay-2">{winner} !</div>
                <div className="thankyu animated fadeIn delay-4">Merci d'avoir participé, patati patata</div>
            </div>
        </>
    );
}

export default End;