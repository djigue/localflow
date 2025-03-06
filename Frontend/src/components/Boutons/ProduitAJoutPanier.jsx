import React, { useState, useEffect } from 'react';
import MyBouton from './MyBouton';
import socket from '../../socket';

const ProduitAjoutPanier = ({ produitId, quantite, boutonTexte = "Ajouter au panier"  }) => {
    const [message, setMessage] = useState('');

    useEffect(() => {
        socket.on('ajoutProduitPanierResponse', (data) => {
          setMessage(data.success ? 'Produit ajouté au panier !' : 'Erreur : ' + data.message);
        });
    
        return () => {
          socket.off('ajoutProduitPanierResponse');
        };
      }, []);

    const handleSubmit = (e) => {
        e.preventDefault();
        const userId =localStorage.getItem('id');

        socket.emit('ajoutProduitPanier', {userId, produitId, quantite});
      };

    return (
      <div>
        <MyBouton nom={boutonTexte} action={handleSubmit} />;
        {message && <p className="text-center">{message}</p>}
      </div> 
    ) 
};

export default ProduitAjoutPanier;
