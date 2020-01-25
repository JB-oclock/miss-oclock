/** 
 * Initial State
 */

 export const initialState = {
    
 };

/**
 * Types
 */

//   export const TYPE_NAME = 'TYPE_NAME';


/**
 * Action creators
 */

// export const actionExample = (storeElement) => ({
//     type: TYPE_NAME,
//     storeElement
// });


/**
 * Reducer
 */

 const reducer = (state = initialState, action = {}) => {
     switch (action.type) {
        // case TYPE_NAME:
        //     return {
        //         ...state,
        //         element: action.storeElement
        //     };
        default:
            return state;
     }
 }

 export  default reducer;