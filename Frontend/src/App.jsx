import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import React, { useState, useEffect } from 'react';

import Connexion from './components/Connexion';
import InscUtil from './components/InscUtil';
import Accueil from "./pages/Accueil";
import AcceuilClient from "./pages/AcceuilClient";
import NavBar from './components/NavBar';
import CommerceForm from './components/CommerceForm';
import EvenementForm from './components/EvenementForm';
import ProduitForm from './components/ProduitForm';
import PromotionForm from './components/PromotionForm';
import Produits from './components/Produits';
import Services from './components/Services';
import Promotions from './components/Promotions';
import Panier from './components/Panier';

function App() {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [loading, setLoading] = useState(true);
  const role = localStorage.getItem('role');

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (token) {
      setIsAuthenticated(true);
    } else {
      setIsAuthenticated(false);
    }
    setLoading(false);
  }, []);

  // Si le contenu est en cours de chargement, on affiche un spinner ou un message de chargement
  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <div className="App">
      <Router>

        <NavBar isAuthenticated={isAuthenticated} setIsAuthenticated={setIsAuthenticated}/>
        
        <Routes>
          {/* Page d'accueil (protégée) */}
          <Route
            path="/"
            element={
              isAuthenticated ? (
                role === "client" ? (
                  <AcceuilClient />
                ) : role === "commercant" ? (
                  <Accueil />
                ) : (
                  <Navigate to="/login" />
                )
              ) : (
                <Navigate to="/login" />
              )
            }
          />
          {/* Route pour la connexion */}
          <Route
            path="/login"
            element={isAuthenticated ? <Navigate to="/" /> : <Connexion setIsAuthenticated={setIsAuthenticated} />}
          />
          <Route path="/register" element={<InscUtil />} />
          
          {/* Formulaires protégés, accessibles uniquement si authentifié */}
          <Route path="/acceuil" element={isAuthenticated ? <Accueil /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/acceuilClient" element={isAuthenticated ? <AcceuilClient /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/formulaire/commerce" element={isAuthenticated ? <CommerceForm /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/formulaire/evenement" element={isAuthenticated ? <EvenementForm /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/formulaire/produit" element={isAuthenticated ? <ProduitForm /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/formulaire/promotion" element={isAuthenticated ? <PromotionForm /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/produits" element={isAuthenticated ? <Produits /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/services" element={isAuthenticated ? <Services/> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/promotions" element={isAuthenticated ? <Promotions/> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/panier" element={isAuthenticated ? <Panier/> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
        </Routes>
      </Router>
    </div>
  );
}

export default App;
