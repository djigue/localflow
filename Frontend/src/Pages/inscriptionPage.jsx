import React from 'react';
import MyForm from '../components/MyForm';

const InscriptionPage = () => {
  return (
    <div className="container-fluid p-0">
      <div className="row w-100 no-gutters">
        
        {/* Colonne gauche avec l'image et le texte */}
        <div className="col-md-6 p-0" style={{ position: 'relative' }}>
          <img 
            src="/images/ImgInscription.webp" 
            alt="ImageInscription"
            style={{
              width: '100%',
              height: '100%',
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
            <h1 style={{ textAlign:'center', fontWeight: 'bold', fontSize: '2.5rem' }}>
              Rejoignez LocalFlow
            </h1>
            <p style={{ fontSize: '1.2rem' }}>
               Inscrivez-vous pour découvrir les meilleurs commerces locaux et bénéficier d'offres exclusives !
            </p>
          </div>
        </div>

        {/* Colonne droite avec le formulaire */}
        <div className="col-md-6 d-flex justify-content-center align-items-center p-0">
          <div className="card shadow-lg" style={{ width: '100%', maxWidth: '400px' }}>
            <div className="card-body">
              <MyForm type="register" />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default InscriptionPage;
