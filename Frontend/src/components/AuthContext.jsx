import React, { createContext, useState } from "react";

// Création du contexte d'authentification
export const AuthContext = createContext();

// Fournisseur du contexte d'authentification
export const AuthProvider = ({ children }) => {
  // Initialisation du rôle à partir du localStorage (s'il existe)
  const [role, setRole] = useState(localStorage.getItem("role"));

  // Fonction de connexion (à appeler depuis votre composant Connexion par exemple)
  const login = (roleValue, token) => {
    localStorage.setItem("role", roleValue);
    localStorage.setItem("token", token);
    setRole(roleValue);
  };

  // Fonction de déconnexion
  const logout = () => {
    localStorage.removeItem("role");
    localStorage.removeItem("token");
    setRole(null);
  };

  return (
    <AuthContext.Provider value={{ role, setRole, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};
