import React from 'react';
import { useNavigate } from 'react-router-dom';

const BoutonBack = () => {
  const navigate = useNavigate(); // Hook de React Router pour la navigation

  const handleGoBack = () => {
    navigate(-1); // Retourne à la page précédente
  };

  return (
    <button onClick={handleGoBack} className="btn btn-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
      </svg>
      Retour
    </button>
  );
};

export default BoutonBack;
