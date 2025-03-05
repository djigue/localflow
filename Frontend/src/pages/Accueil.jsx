import { useState, useEffect } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import socket from "../socket";

const Accueil = () => {
  console.log("🏠 Composant Accueil monté !");
    const [commercantData, setCommercantData] = useState(null);
    const [error, setError] = useState(null);
    const userId = localStorage.getItem("id");

    useEffect(() => {
      console.log("🔍 userId récupéré:", userId);
        if (!userId) return;

        socket.emit('commercantInfo', userId);

        socket.on("commercantInfoResponse", (data) =>
           { console.log("📩 Réponse reçue du serveur :", data);
          setCommercantData(data);
        });
        
        return () => {
            socket.off("commercantInfoResponse");
        };
    }, [userId]);

    if (!userId) return <p>Vous devez être connecté.</p>;
    if (error) return <p>❌ {error}</p>;
    if (!commercantData) return <p>Chargement...</p>;

    return (
        <div>
            <h1>Bienvenue, {commercantData.email}</h1>

            {commercantData.commerces.map((commerce) => (
                <div key={commerce.id} className="commerce-card">
                    <h2>{commerce.nom}</h2>
                    <p>Téléphone: {commerce.telephone}</p>
                    <p>Description: {commerce.description}</p>
                    <section>
                        <h2>Horaires</h2>
                        {commerce.horaires.map((horaire) => (
                           <li>{horaire.jour} {horaire.ouverture} {horaire.fermeture}</li> 
                        ))}
                    </section>

                    <h3>Images du commerce</h3>
                    <div className="images">
                        {commerce.images.map((img, index) => (
                            <img key={index} src={`http://localhost:8000${img}`} alt={`Commerce ${index}`} width="100" />
                        ))}
                    </div>

                    <h3>Produits</h3>
                    <ul>
                        {commerce.produits.map((produit) => (
                            <li key={produit.id}>
                                <strong>{produit.nom}</strong> - {produit.slug} {produit.prix} {produit.formatPrix}
                                <div className="images">
                                    {produit.images.map((img, index) => (
                                        <img key={index} src={`http://localhost:8000${img}`} alt={`Produit ${index}`} width="50" />
                                    ))}
                                </div>
                            </li>
                        ))}
                    </ul>

                    <h3>Services</h3>
                    <ul>
                        {commerce.services.map((service) => (
                            <li key={service.id}>
                                <strong>{service.nom}</strong> - {service.prix} {service.formatPrix}
                                <div className="images">
                                    {service.images.map((img, index) => (
                                        <img key={index} src={`http://localhost:8000${img}`} alt={`Service ${index}`} width="50" />
                                    ))}
                                </div>
                            </li>
                        ))}
                    </ul>
                </div>
            ))}
        </div>
    );
};

export default Accueil;
