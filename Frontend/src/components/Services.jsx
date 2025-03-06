import React, { useState, useEffect } from 'react';
import socket from '../socket';
import ServiceAjoutPanier from './Boutons/ServiceAjoutPanier';

const ShowServices = () => {
    console.log("🏠 Composant Service monté !");
    const [servicesData, setServicesData] = useState(null);
    const [error, setError] = useState(null);
    const [quantite, setQuantite] = useState(1);
    const userId = localStorage.getItem("id");

    useEffect(() => {
          socket.emit('services');
  
          socket.on("servicesResponse", (data) =>
             { console.log("📩 Réponse reçue du serveur :", data);
            setServicesData(data);
          });
          
          return () => {
              socket.off("servicesResponse");
          };
    }, [userId]);

    if (error) return <p>❌ {error}</p>;
    if (!servicesData) return <p>Chargement...</p>;

    return (
        <div>
            <h1>Tous les services disponibles sur la plateforme</h1>
            <div style={{ display: "flex", flexWrap: "wrap", gap: "20px" }}>
                {servicesData.map((service) => (
                    <div >
                        <h3>{service.nom}</h3>
                        {service.image && (
                            <img
                                src={`http://localhost:8000${service.image}`}
                                alt={service.slug}
                                style={{
                                    width: "100%",
                                    height: "150px",
                                    objectFit: "cover",
                                    borderRadius: "8px",
                                }}
                            />
                        )}
                        {service.reservation === 'true' ?? (
                            <p>Réservation Obligatoire</p>
                        )}
                        <p> {service.slug} </p>
                        <p><strong>Prix :</strong> {service.prix}</p>
                        <p><strong>Durée :</strong> {service.duree} minutes</p>
                        <input 
                            type="number" 
                            value={quantite} 
                            onChange={(e) => setQuantite(parseInt(e.target.value, 10) || 1)} 
                            min="1"
                        />
                        <ServiceAjoutPanier serviceId={service.id} quantite={quantite} boutonTexte="Ajouter au panier" />
                    </div>
                ))}
            </div>
        </div>
    )
} 

export default ShowServices;