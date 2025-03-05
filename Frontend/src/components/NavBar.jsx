import React from 'react';
import { Link } from "react-router-dom";
import LogoutButton from './LogoutButton';

const NavBar = ({ isAuthenticated, setIsAuthenticated }) => {
  return (
    <nav className="bg-blue-500 p-4 text-white">
      <ul className="flex space-x-4">
        {isAuthenticated ? (
          <>
            <li><Link to="/accueil">Accueil</Link></li>
            <li><Link to="/formulaire/commerce">Formulaire Commerce</Link></li>
            <li><Link to="/formulaire/evenement">Formulaire Evenement</Link></li>
            <li><Link to="/formulaire/produit">Formulaire Produit</Link></li>
            <li><Link to="/formulaire/promotion">Formulaire Promotion</Link></li>
            <li><LogoutButton setIsAuthenticated={setIsAuthenticated} /></li>
          </>
        ) : (
          <>
            <li><Link to="/register">Inscription</Link></li>
          </>
        )}
      </ul>
    </nav>
  );
};

export default NavBar;
