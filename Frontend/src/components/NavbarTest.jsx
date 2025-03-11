import React, { useState } from 'react';
import { Link } from "react-router-dom";
import LogoutButton from './bouton/LogoutButton';

const NavbarTest = ({ isAuthenticated, setIsAuthenticated }) => {
  const role = localStorage.getItem('role');
  const [isOpen, setIsOpen] = useState(false);

  // Fonction pour basculer l'état du menu burger
  const toggleMenu = () => {
    setIsOpen(!isOpen);
  };

  return (
    <nav className="navbar navbar-expand-lg navbar-dark bg-primary">
      <div className="container">
        {/* Logo/Titre */}
        <Link className="navbar-brand" to="/">LocalFlow</Link>

        {/* Bouton mobile */}
        <button
          className="navbar-toggler"
          type="button"
          onClick={toggleMenu}
          aria-controls="navbarNav"
          aria-expanded={isOpen ? 'true' : 'false'}
          aria-label="Toggle navigation"
        >
          <span className="navbar-toggler-icon"></span>
        </button>

        {/* Menu de navigation */}
        <div className={`collapse navbar-collapse ${isOpen ? 'show' : ''}`} id="navbarNav">
          <ul className="navbar-nav ms-auto">
            {isAuthenticated ? (
              <>
                {/* Lien Accueil commun */}
                <li className="nav-item">
                  <Link className="nav-link" to="/accueil">Accueil</Link>
                </li>

                {role === "commercant" ? (
                  <>

                    {/* Menu déroulant pour les formulaires */}
                    <li className="nav-item dropdown">
                      <a
                        className="nav-link dropdown-toggle"
                        href="#"
                        id="dropdownMenuButton"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        Menu
                      </a>

                      <ul className="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <Link className="dropdown-item" to="/commandes">Commandes</Link>
                        </li>
                        <li>
                          <Link className="dropdown-item" to="/avis-clients">Avis Clients</Link>
                        </li>
                        <li>
                          <Link className="dropdown-item" to="/formulaire/commerce">
                            Formulaire Commerce
                          </Link>
                        </li>
                        <li>
                          <Link className="dropdown-item" to="/formulaire/evenement">
                            Formulaire Événement
                          </Link>
                        </li>
                        <li>
                          <Link className="dropdown-item" to="/formulaire/produit">
                            Formulaire Produit
                          </Link>
                        </li>
                        <li>
                          <Link className="dropdown-item" to="/formulaire/promotion">
                            Formulaire Promotion
                          </Link>
                        </li>
                      </ul>
                      
                    </li>
                    <li className="nav-item">
                      <Link className="nav-link" to="../FAQ">FAQ</Link>
                    </li>
                    <li className="nav-item">
                      <Link className="nav-link" to="/contact">Contact</Link>
                    </li>
                  </>
                ) : role === "client" ? (
                  <>
                    <li className="nav-item">
                      <Link className="nav-link" to="/produits">Voir Produits</Link>
                    </li>
                    <li className="nav-item">
                      <Link className="nav-link" to="/mon-panier">Mon Panier</Link>
                    </li>
                  </>
                ) : null}

                {/* Bouton de déconnexion */}
                <li className="nav-item">
                  <LogoutButton setIsAuthenticated={setIsAuthenticated} />
                </li>
              </>
            ) : (
              <>
                <li className="nav-item">
                  <Link className="nav-link" to="/register">Inscription</Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" to="/login">Connexion</Link>
                </li>
              </>
            )}
          </ul>
        </div>
      </div>
    </nav>
  );
};

export default NavbarTest;
