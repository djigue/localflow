import React, { useState, useEffect } from 'react';
import MyBouton from './MyBouton';

const ServiceAjoutPanier = ({ serviceId, quantite }) => {
    const [message, setMessage] = useState('');

    useEffect(() => {
        socket.on('ajoutServicePanierResponse', (data) => {
          setMessage(data.success ? 'Service ajouté au panier !' : 'Erreur : ' + data.message);
        });
    
        return () => {
          socket.off('ajoutServicePanierResponse');
        };
      }, []);

    const handleSubmit = (e) => {
        e.preventDefault();
        const userId =localStorage.getItem('id');

        socket.emit('ajoutServicePanier', {userId, quantite});
      };

    return (
      <div>
        <MyBouton nom="Ajouter au panier" action={handleSubmit} />;
        {message && <p className="text-center">{message}</p>}
      </div> 
    ) 
};

export default ServiceAjoutPanier;
