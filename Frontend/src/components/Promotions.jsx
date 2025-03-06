import React, { useState, useEffect } from 'react';
import socket from '../socket';
import PromotionAjoutPanier from './Boutons/PromotionAjoutPanier';

const ShowPromotions = () => {
    console.log("🏠 Composant Promotion monté !");
    const [promotionsData, setPromotionsData] = useState(null);
    const [error, setError] = useState(null);
    const [quantite, setQuantite] = useState(1);
    const userId = localStorage.getItem("id");

    useEffect(() => {
          socket.emit('promotions');
  
          socket.on("promotionsResponse", (data) =>
             { console.log("📩 Réponse reçue du serveur :", data);
            setPromotionsData(data);
          });

          console.log("promo reçues : ", promotionsData );
          
          return () => {
              socket.off("promotionsResponse");
          };
    }, [userId]);

    if (error) return <p>❌ {error}</p>;
    if (!promotionsData) return <p>Chargement...</p>;

    return (
        <div>
            <h1>Tous les promotions disponibles sur la plateforme</h1>
            <div style={{ display: "flex", flexWrap: "wrap", gap: "20px" }}>
                {promotionsData.map((promotion) => (
                    <div >
                        {promotion.image && (
                            <img
                                src={`http://localhost:8000${promotion.image}`}
                                alt={promotion.slug}
                                style={{
                                    width: "100%",
                                    height: "150px",
                                    objectFit: "cover",
                                    borderRadius: "8px",
                                }}
                            />
                        )}
                        <h3>{promotion.nom}</h3>
                        <p><strong>Début le :</strong> {new Date(promotion.dateDebut).toLocaleString()}</p>
                        <p><strong>termine le :</strong> {new Date(promotion.dateFin).toLocaleString()}</p>
                        <p><strong>Prix :</strong> {promotion.prix} euros</p>     
                        <p><strong>Quantité :</strong> {promotion.quantite}</p>
                        <input 
                            type="number" 
                            value={quantite} 
                            onChange={(e) => setQuantite(parseInt(e.target.value, 10) || 1)} 
                            min="1"
                        />
                        <PromotionAjoutPanier promotionId={promotion.id} quantite={quantite} boutonTexte="Ajouter au panier" />
                    </div>
                ))}
            </div>
        </div>
    )
} 

export default ShowPromotions;