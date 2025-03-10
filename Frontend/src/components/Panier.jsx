import { useState, useEffect } from "react";
import socket from '../socket';
import ProduitsAjoutPanier from "./Boutons/ProduitAjoutPanier"; 
import PromotionsAjoutPanier from "./Boutons/PromotionAjoutPanier";
import ServicesAjoutPanier from "./Boutons/ServiceAjoutPanier";
const Panier = () => {
    const [panier, setPanier] = useState({
        produits: [],
        promotions: [],
        services: []
    });
    const userId = localStorage.getItem("id");

    useEffect(() => {
        socket.emit("panier", userId);

        socket.on("panierResponse", (data) => {
            console.log("📩 Réponse reçue du serveur :", data);
            setPanier(data);
        });

        return () => {
            socket.off("panierResponse");
        };
    }, [userId]);

    const handleQuantityChange = (type, index, newQuantity) => {
        if (newQuantity < 1) return; 

        setPanier((prevPanier) => {
            const newItems = [...prevPanier[type]];
            newItems[index].quantite = newQuantity;
            return { ...prevPanier, [type]: newItems };
        });
    };

    const getTotalPanier = () => {
        const totalProduits = panier.produits.reduce((total, p) => {
            if (p.prix && p.quantite) {
                return total + p.prix * p.quantite;
            }
            return total;
        }, 0);
    
        const totalPromos = panier.promotions.reduce((total, p) => {
            if (p.nouveau_prix && p.quantite) {
                return total + p.nouveau_prix * p.quantite;
            }
            return total;
        }, 0);
    
        const totalServices = panier.services.reduce((total, s) => {
            if (s.prix && s.quantite) {
                return total + s.prix * s.quantite;
            }
            return total;
        }, 0);
    
        const total = totalProduits + totalPromos + totalServices;
        return total ? total.toFixed(2) : "0.00";  
    };
    

    if (!panier) return <p>Chargement...</p>;

    return (
        <div>
            <h2>Mon Panier</h2>

            {/* Produits */}
            <section>
                <h3>Produits</h3>
                {panier.produits.length === 0 ? (
                    <p>Aucun produit dans le panier.</p>
                ) : (
                    <ul>
                        {panier.produits.map((produit, index) => (
                            <li key={index}>
                                <img src={`http://localhost:8000${produit.image}`} alt={produit.nom} width="50" />
                                {produit.nom} - {produit.prix}{produit.format_prix} 
                                (x
                                <input
                                    type="number"
                                    value={produit.quantite}
                                    onChange={(e) => handleQuantityChange("produits", index, parseInt(e.target.value))}
                                    min="1"
                                    style={{ width: "50px", margin: "0 5px" }}
                                />
                                ) = <strong>{(produit.prix * produit.quantite).toFixed(2)}€</strong>
                                <ProduitsAjoutPanier produitId={produit.id} quantite={produit.quantite} boutonTexte="Modifier le panier" />
                            </li>
                        ))}
                    </ul>
                )}
            </section>

            {/* Promotions */}
            <section>
                <h3>Promotions</h3>
                {panier.promotions.length === 0 ? (
                    <p>Aucune promotion appliquée.</p>
                ) : (
                    <ul>
                        {panier.promotions.map((promo, index) => (
                            <li key={index}>
                                 <img src={`http://localhost:8000${promo.image}`} alt={promo.nom} width="50" />
                                {promo.nom} - {promo.nouveau_prix}€ 
                                (x
                                <input
                                    type="number"
                                    value={promo.quantite}
                                    onChange={(e) => handleQuantityChange("promotions", index, parseInt(e.target.value))}
                                    min="1"
                                    style={{ width: "50px", margin: "0 5px" }}
                                />
                                ) = <strong>{(promo.nouveau_prix * promo.quantite).toFixed(2)}€</strong>
                                <PromotionsAjoutPanier promotionId={promo.id} quantite={promo.quantite} boutonTexte="Modifier le panier" />
                            </li>
                        ))}
                    </ul>
                )}
            </section>

            {/* Services */}
            <section>
                <h3>Services</h3>
                {panier.services.length === 0 ? (
                    <p>Aucun service ajouté.</p>
                ) : (
                    <ul>
                        {panier.services.map((service, index) => (
                            <li key={index}>
                                 <img src={`http://localhost:8000${service.image}`} alt={service.nom} width="50" />
                                {service.nom} - {service.prix}€
                                (x
                                <input
                                    type="number"
                                    value={service.quantite}
                                    onChange={(e) => handleQuantityChange("services", index, parseInt(e.target.value))}
                                    min="1"
                                    style={{ width: "50px", margin: "0 5px" }}
                                />
                                ) = <strong>{(service.prix * service.quantite).toFixed(2)}€</strong>
                                <ServicesAjoutPanier serviceId={service.id} quantite={service.quantite} boutonTexte="Modifier le panier" />
                            </li>
                        ))}
                    </ul>
                )}
            </section>
            <h3>Total du panier : {getTotalPanier()}€</h3>
            <button>Valider le panier</button>
        </div>
    );
};

export default Panier;
