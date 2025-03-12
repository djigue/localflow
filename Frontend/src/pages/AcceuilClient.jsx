import React, { useState, useRef, useEffect } from 'react';
import socket from '../socket';
import BarreRecherche from '../components/BarreRecherche';
import CardArticle from '../components/CardArticles';

const PageAcceuilVisiteur = () => {
    const userId = localStorage.getItem('id');
    const [acceuil, setAcceuil] = useState({
        prenom: "",
        commerces: [],
        produits: [],
        promotions: [],
        services: [],
        evenements: []
    });

    useEffect(() => {
        socket.emit('acceuilClient', userId);
        socket.on("acceuilClientResponse", (data) => {
            setAcceuil(data);
        });

        return () => {
            socket.off("acceuilClientResponse");
        };
    }, []);

    if (!acceuil) return <p>Chargement...</p>;

    return (
        <div style={{ padding: '20px', fontFamily: 'Arial, sans-serif' }}>
            <BarreRecherche />
            <h2 style={{ textAlign: 'center' }}>Bienvenue {acceuil.prenom}</h2>

            <section style={{ marginTop: '40px' }}>
                {/* Section Commerces */}
                <article>
                    <h3>Les Commerces les plus visités :</h3>
                    <div style={{ display: 'flex', flexWrap: 'wrap', gap: '15px', justifyContent: 'center' }}>
                        {acceuil.commerces.map((commerce, index) => (
                            <div key={index} style={{
                                flex: '1 1 calc(20% - 15px)',
                                maxWidth: '200px',
                                textAlign: 'center',
                                padding: '10px',
                                borderRadius: '10px',
                                boxShadow: '0px 4px 6px rgba(0, 0, 0, 0.1)',
                                backgroundColor: '#fff',
                                transition: 'transform 0.3s ease-in-out'
                            }}>
                                <img src={`http://localhost:8000${commerce.image}`} alt={commerce.nom}
                                    style={{ width: '100%', height: '150px', objectFit: 'cover', borderRadius: '10px' }} />
                                <p>{commerce.nom}</p>
                            </div>
                        ))}
                    </div>
                </article>

                {/* Section Produits */}
                <article>
                    <h3>Les Produits les plus vendus :</h3>
                    <div style={{ display: 'flex', flexWrap: 'wrap', gap: '15px', justifyContent: 'center' }}>
                        {acceuil.produits.map((produit, index) => (
                            <div key={index} style={{
                                flex: '1 1 calc(20% - 15px)',
                                maxWidth: '200px',
                                textAlign: 'center',
                                padding: '10px',
                                borderRadius: '10px',
                                boxShadow: '0px 4px 6px rgba(0, 0, 0, 0.1)',
                                backgroundColor: '#fff',
                                transition: 'transform 0.3s ease-in-out'
                            }}>
                                <img src={`http://localhost:8000${produit.image}`} alt={produit.nom}
                                    style={{ width: '100%', height: '150px', objectFit: 'cover', borderRadius: '10px' }} />
                                <p>{produit.nom}</p>
                            </div>
                        ))}
                    </div>
                </article>

                {/* Section Services */}
                <article>
                    <h3>Les Services les plus vendus :</h3>
                    <div style={{ display: 'flex', flexWrap: 'wrap', gap: '15px', justifyContent: 'center' }}>
                        {acceuil.services.map((service, index) => (
                            <div key={index} style={{
                                flex: '1 1 calc(20% - 15px)',
                                maxWidth: '200px',
                                textAlign: 'center',
                                padding: '10px',
                                borderRadius: '10px',
                                boxShadow: '0px 4px 6px rgba(0, 0, 0, 0.1)',
                                backgroundColor: '#fff',
                                transition: 'transform 0.3s ease-in-out'
                            }}>
                                <img src={`http://localhost:8000${service.image}`} alt={service.nom}
                                    style={{ width: '100%', height: '150px', objectFit: 'cover', borderRadius: '10px' }} />
                                <p>{service.nom}</p>
                            </div>
                        ))}
                    </div>
                </article>

                {/* Section Promotions */}
                <article>
                    <h3>Les Promotions les plus vendues :</h3>
                    <div style={{ display: 'flex', flexWrap: 'wrap', gap: '15px', justifyContent: 'center' }}>
                        {acceuil.promotions.map((promotion, index) => (
                            <div key={index} style={{
                                flex: '1 1 calc(20% - 15px)',
                                maxWidth: '200px',
                                textAlign: 'center',
                                padding: '10px',
                                borderRadius: '10px',
                                boxShadow: '0px 4px 6px rgba(0, 0, 0, 0.1)',
                                backgroundColor: '#fff',
                                transition: 'transform 0.3s ease-in-out'
                            }}>
                                <img src={`http://localhost:8000${promotion.image}`} alt={promotion.nom}
                                    style={{ width: '100%', height: '150px', objectFit: 'cover', borderRadius: '10px' }} />
                                <p>{promotion.nom}</p>
                            </div>
                        ))}
                    </div>
                </article>

                {/* Section Evénements */}
                <article>
                    <h3>Les Evénements les plus attendus :</h3>
                    <div style={{ display: 'flex', flexWrap: 'wrap', gap: '15px', justifyContent: 'center' }}>
                        {acceuil.evenements.map((evenement, index) => (
                            <div key={index} style={{
                                flex: '1 1 calc(20% - 15px)',
                                maxWidth: '200px',
                                textAlign: 'center',
                                padding: '10px',
                                borderRadius: '10px',
                                boxShadow: '0px 4px 6px rgba(0, 0, 0, 0.1)',
                                backgroundColor: '#fff',
                                transition: 'transform 0.3s ease-in-out'
                            }}>
                                <img src={`http://localhost:8000${evenement.image}`} alt={evenement.nom}
                                    style={{ width: '100%', height: '150px', objectFit: 'cover', borderRadius: '10px' }} />
                                <p>{evenement.nom}</p>
                            </div>
                        ))}
                    </div>
                </article>
            </section>
        </div>
    );
};

export default PageAcceuilVisiteur;
