import React, { useState, useEffect } from 'react';
import MyBouton from './MyBouton';

const PromotionAjoutPanier = ({ promotionId, quantite }) => {
    const [message, setMessage] = useState('');

    useEffect(() => {
        socket.on('ajoutPromotionPanierResponse', (data) => {
          setMessage(data.success ? 'Promotion ajoutée au panier !' : 'Erreur : ' + data.message);
        });
    
        return () => {
          socket.off('ajoutPromotionPanierResponse');
        };
      }, []);

    const handleSubmit = (e) => {
        e.preventDefault();
        const userId =localStorage.getItem('id');

        socket.emit('ajoutPromotionPanier', {userId, quantite});
      };

    return (
      <div>
        <MyBouton nom="Ajouter au panier" action={handleSubmit} />;
        {message && <p className="text-center">{message}</p>}
      </div> 
    ) 
};

export default PromotionAjoutPanier;
