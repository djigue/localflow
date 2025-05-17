import React from 'react';

const ButtonsInscriptionClient = ({ onSubmit, onCancel }) => {
  return (
    <>
      <button type="submit" onClick={onSubmit}>
        Inscription
      </button>
      <button type="button" onClick={onCancel}>
        X Annuler
      </button>
    </>
  );
};

export default ButtonsInscriptionClient;
