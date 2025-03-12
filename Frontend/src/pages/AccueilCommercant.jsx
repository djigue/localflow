import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import socket from "../socket";
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts';

const AccueilCommercant = () => {
 
  const [commercantData, setCommercantData] = useState(null);
  const [error, setError] = useState(null);
  const userId = localStorage.getItem("id");
  const navigate = useNavigate();

  useEffect(() => {

    if (!userId) return;

    socket.emit('commercantInfo', userId);

    socket.on("commercantInfoResponse", (data) => {
    
      setCommercantData(data);
    });

    return () => {
      socket.off("commercantInfoResponse");
    };
  }, [userId]);

  if (!userId) return <p>Vous devez être connecté.</p>;
  if (error) return <p>❌ {error}</p>;
  if (!commercantData) return <p>Chargement...</p>;

  const stats = {
    ventes: 42,
    chiffreAffaires: 12500,
    commandesEnAttente: 5,
    avisMoyen: 4.3,
  };

  const ventesData = [
    { jour: 'Lun', ventes: 5 },
    { jour: 'Mar', ventes: 8 },
    { jour: 'Mer', ventes: 12 },
    { jour: 'Jeu', ventes: 15 },
    { jour: 'Ven', ventes: 7 },
    { jour: 'Sam', ventes: 10 },
    { jour: 'Dim', ventes: 3 },
  ];

  return (
    <div>
   {/*    <NavbarCommerce /> */}

      <div className="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
        <div className="card shadow-lg p-4 w-75">
          <div className="card-body">
            <div className="d-flex justify-content-between align-items-center mb-4">
              <h1 className="text-center">Bienvenue, {commercantData.email}</h1>
            </div>

            {/* 📊 Section Statistiques */}
            <div className="row text-center">
              {[ 
                { title: 'Ventes du mois', value: stats.ventes },
                { title: 'Chiffre d\'affaires', value: `${stats.chiffreAffaires}€` },
                { title: 'Commandes en attente', value: stats.commandesEnAttente },
                { title: 'Avis moyen', value: `${stats.avisMoyen} ⭐` },
              ].map((stat, index) => (
                <div key={index} className="col-md-3">
                  <div className="card shadow">
                    <div className="card-body">
                      <h5 className="card-title">{stat.title}</h5>
                      <p className="display-6">{stat.value}</p>
                    </div>
                  </div>
                </div>
              ))}
            </div>

            {/* 📈 Graphique des ventes */}
            <div className="mt-5">
              <h3 className="text-center">Évolution des ventes cette semaine</h3>
              <ResponsiveContainer width="100%" height={300}>
                <LineChart data={ventesData}>
                  <CartesianGrid strokeDasharray="3 3" stroke="#ccc" />
                  <XAxis dataKey="jour" stroke="black" />
                  <YAxis stroke="black" />
                  <Tooltip />
                  <Line type="monotone" dataKey="ventes" stroke="#007bff" strokeWidth={3} />
                </LineChart>
              </ResponsiveContainer>
            </div>

            {/* 🎯 Raccourcis rapides */}
            <div className="mt-4 text-center">
              <button className="btn btn-primary m-2" onClick={() => navigate('/formulaire/produit')}>Ajouter un produit</button>
              <button className="btn btn-warning m-2" onClick={() => navigate('/commandes')}>Voir les commandes</button>
              <button className="btn btn-info m-2" onClick={() => navigate('/avis-clients')}>Voir les avis clients</button>
            </div>

            {/* 🏪 Section des commerces */}
            {commercantData.commerces.map((commerce) => (
              <div key={commerce.id} className="commerce-card">
                <h2>{commerce.nom}</h2>
                <p>Téléphone: {commerce.telephone}</p>
                <p>Description: {commerce.description}</p>
                <section>
                  <h2>Horaires</h2>
                  {commerce.horaires.map((horaire) => (
                    <li key={horaire.id}>{horaire.jour} {horaire.ouverture} {horaire.fermeture}</li> 
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
        </div>
      </div>
    </div>
  );
};

export default AccueilCommercant;
