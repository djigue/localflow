import React, { useState, useEffect } from 'react';
import socket from '../socket';
import ProduitsAjoutPanier from './Boutons/ProduitAjoutPanier';

const ShowProduits = () => {
    console.log("🏠 Composant Produit monté !");
    const [produitsData, setProduitsData] = useState(null);
    const [error, setError] = useState(null);
    const [quantites, setQuantites] = useState({});
    const userId = localStorage.getItem("id");

    useEffect(() => {
          socket.emit('produits');
  
          socket.on("produitsResponse", (data) =>
             { console.log("📩 Réponse reçue du serveur :", data);
            setProduitsData(data);
          });
          
          return () => {
              socket.off("produitsResponse");
          };
    }, [userId]);

    if (error) return <p>❌ {error}</p>;
    if (!produitsData) return <p>Chargement...</p>;

    const handleQuantiteChange = (produitId, value) => {
        setQuantites(prevQuantites => ({
            ...prevQuantites,
            [produitId]: Math.max(value, 1)  
        }));
    };

    return (
        <div>
            <h1>Tous les produits disponibles sur la plateforme</h1>
            <div style={{ display: "flex", flexWrap: "wrap", gap: "20px" }}>
                {produitsData.map((produit) => (
                    <div key={produit.id}>
                        {produit.image && (
                            <img
                                src={`http://localhost:8000${produit.image}`}
                                alt={produit.slug}
                                style={{
                                    width: "100%",
                                    height: "150px",
                                    objectFit: "cover",
                                    borderRadius: "8px",
                                }}
                            />
                        )}
                        <h3>{produit.nom}</h3>
                        <p><strong>Prix :</strong> {produit.prix} {produit.formatPrix}</p>
                        <p><strong>Taille :</strong> {produit.taille}</p>
                        <p><strong>Quantité :</strong> {produit.quantite}</p>
                        <input 
                            type="number" 
                            value={quantites[produit.id] || 1}
                            onChange={(e) => handleQuantiteChange(produit.id, parseInt(e.target.value, 10))}
                            min="1"
                        />
                        <ProduitsAjoutPanier produitId={produit.id} quantite={quantites[produit.id]} boutonTexte="Ajouter au panier" />
                    </div>
                ))}
            </div>
        </div>
    )
} 

export default ShowProduits;