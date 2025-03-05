import React, { useState, useEffect } from 'react';

const myBouton = ({nom, action, type}) => {

    return(
        <button action={action}>{nom}</button>
    )}