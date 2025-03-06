import React, { useState, useEffect } from 'react';

const myBouton = ({nom, action, type ="button"}) => {

    return(
        <button type={type} onClick={action}>{nom}</button>
)}

export default myBouton;