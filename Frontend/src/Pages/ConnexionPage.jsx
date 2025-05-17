import React from 'react';
import MyForm from '../components/MyForm';

const ConnexionPage = () => {
  return (
    <div className="container-fluid p-0">
      <div className="row w-100 no-gutters">
        {/* Colonne gauche avec l'image et le texte */}
        <div className="col-md-6 p-0" style={{ position: 'relative' }}>
          <img 
            src="/images/imgconnexion.webp" 
            alt="ImagedeConnexion"
            style={{
              width: '100%',
              height: '100vh',
              objectFit: 'cover',
            }}
          />
          <div style={{
            position: 'absolute', 
            top: '30%', 
            left: '10%', 
            color: 'white', 
            zIndex: 2, 
            textAlign: 'left',
            padding: '20px',
            backgroundColor: 'rgba(0, 0, 0, 0.3)',
            borderRadius: '10px',
            fontFamily: 'Poppins, sans-serif',
          }}>
            <h1 style={{ textAlign:'center', fontWeight: 'bold', fontSize: '2.5rem' }}>Se connecter à LocalFlow</h1>
            <p style={{ fontSize: '1.2rem' }}>
               Rejoignez votre communauté locale et profitez des meilleurs produits, services et promotions près de chez vous !
            </p>
          </div>
        </div>

        {/* Colonne droite avec le formulaire */}
        <div className="col-md-6 d-flex justify-content-center align-items-center p-0">
          <div className="card shadow-lg" style={{ width: '100%', maxWidth: '400px' }}>
            <div className="card-body">
              <MyForm type="login" />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ConnexionPage;
