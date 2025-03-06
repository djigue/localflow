import React from 'react';
import { Link } from "react-router-dom";
import LogoutButton from './LogoutButton';

const NavBar = ({ isAuthenticated, setIsAuthenticated }) => {
  const role = localStorage.getItem('role'); 

  return (
    <nav className="bg-blue-500 p-4 text-white">
      <ul className="flex space-x-4">
        {isAuthenticated ? (
          <>
            <li><Link to="/accueil">Accueil</Link></li>

            {role === "commercant" ? (
              <>
                <li><Link to="/formulaire/commerce">Formulaire Commerce</Link></li>
                <li><Link to="/formulaire/evenement">Formulaire Événement</Link></li>
                <li><Link to="/formulaire/produit">Formulaire Produit</Link></li>
                <li><Link to="/formulaire/promotion">Formulaire Promotion</Link></li>
              </>
            ) : role === "client" ? (
              <>
                <li><Link to="/produits">Voir Produits</Link></li>
                <li><Link to="/services">Voir Services</Link></li>
                <li><Link to="/promotions">Voir Promotions</Link></li>
                <li><Link to="/mon-panier">Mon Panier</Link></li>
              </>
            ) : null}

            <li><LogoutButton setIsAuthenticated={setIsAuthenticated} /></li>
          </>
        ) : (
          <>
            <li><Link to="/register">Inscription</Link></li>
            <li><Link to="/login">Connexion</Link></li>
          </>
        )}
      </ul>
    </nav>
  );
};

export default NavBar;
