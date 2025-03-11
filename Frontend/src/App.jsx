import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import React, { useState, useEffect } from 'react';

import Connexion from './components/Connexion';
import InscUtil from './components/InscUtil';
import NavbarTest from './components/NavbarTest';
import CommerceForm from './components/CommerceForm';
import EvenementForm from './components/EvenementForm';
import ProduitForm from './components/ProduitForm';
import PromotionForm from './components/PromotionForm';
import { AuthProvider } from "./components/AuthContext";
import ContactForm from "./components/ContactForm";

import 'bootstrap/dist/css/bootstrap.min.css';  // CSS de Bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // JS de Bootstrap

import Accueil from "./pages/AccueilCommercant";
import PageAcceuilVisiteur from "./pages/PageAcceuilVisiteur";
import FAQ from "./pages/FAQ";
import Commandes from "./pages/Commandes";
import AvisClientsPanel from "./pages/AvisClients";


function App() {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [loading, setLoading] = useState(true);

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
    <AuthProvider>
    <div className="App">
      <Router>
        <NavbarTest isAuthenticated={isAuthenticated} setIsAuthenticated={setIsAuthenticated}/>

        <Routes>
          <Route path="/" element={<PageAcceuilVisiteur />} />

          {/* Route protégée pour la page d'accueil */}
          <Route
            path="/accueil"
            element={
              isAuthenticated ? (
                localStorage.getItem("role") === "commercant" ? (
                  <Accueil /> // Page d'accueil commerçant
                ) : (
                  <PageAcceuilVisiteur /> // Page d'accueil visiteur
                )
              ) : (
                <Navigate to="/login" />
              )
            }
          />

          {/* Route pour la connexion */}
          <Route
            path="/login"
            element={isAuthenticated ? <Navigate to="/accueil" /> : <Connexion setIsAuthenticated={setIsAuthenticated} />}
          />

          <Route path="/register" element={<InscUtil />} />

          {/* Formulaires protégés, accessibles uniquement si authentifié */}
          <Route path="/formulaire/commerce" element={isAuthenticated ? <CommerceForm /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/formulaire/evenement" element={isAuthenticated ? <EvenementForm /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/formulaire/produit" element={isAuthenticated ? <ProduitForm /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/formulaire/promotion" element={isAuthenticated ? <PromotionForm /> : <Connexion setIsAuthenticated={setIsAuthenticated} />} />
          <Route path="/FAQ" element={<FAQ />} />
          <Route path="/commandes" element={<Commandes />} />
          <Route path="/avis-clients" element={<AvisClientsPanel/>}/>
          <Route path="/contact" element={<ContactForm/>}/>
        </Routes>
      </Router>
    </div>
    </AuthProvider>
  );
}

export default App;
