import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import socket from "../socket";
import BoutonBack from "./bouton/BoutonBack";

const Connexion = ({ setIsAuthenticated }) => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");
  const navigate = useNavigate();

  useEffect(() => {
    socket.on("connexionResponse", (data) => {
      console.log("Données de connexion:", data);  // Ajout du log pour inspecter les données

      setMessage(data.success ? "Connexion réussie !" : "Erreur : " + data.message);

      if (data.success) {
        // Sauvegarde des informations dans localStorage
        localStorage.setItem("token", data.token);
        localStorage.setItem("id", data.user_id);
        localStorage.setItem("email", data.user_email);
        localStorage.setItem("role", data.user_role);  // Rôle de l'utilisateur
        localStorage.setItem("commerce_id", data.commerce_id);

        
        // Met à jour l'état de l'authentification
        setIsAuthenticated(true);

        // Vérification du rôle de l'utilisateur avant redirection
        const role = data.user_role;
        console.log("Role de l'utilisateur:", role);

        if (!role) {
          console.error("Rôle utilisateur non défini !");
          navigate("/");  // Redirige vers la page d'accueil par défaut
        } else if (role === "admin") {
          console.log("Redirection vers panelAdmin");
          navigate("/panelAdmin");
        } else if (role === "commercant") {
          console.log("Redirection vers accueil commerçant");
          navigate("/accueil");
        } else {
          console.log("Redirection vers page d'accueil visiteur");
          navigate("/");
        }
      }
    });

    // Nettoyage lors du démontage du composant
    return () => {
      socket.off("connexionResponse");
    };
  }, [setIsAuthenticated, navigate]);

  const handleSubmit = (e) => {
    e.preventDefault();

    if (!email || !password) {
      setMessage("Remplissez tous les champs");
      return;
    }

    socket.emit("connexion", { email, password });

    setEmail("");
    setPassword("");
  };

  return (
    <>
      <BoutonBack />

      <div className="container d-flex justify-content-center align-items-center min-vh-100">
        <div className="card shadow-lg p-4" style={{ maxWidth: "400px", width: "100%" }}>
          <h2 className="text-center mb-3">Connexion</h2>

          {/* Message d'erreur ou succès */}
          {message && (
            <div
              className={`alert ${message.includes("Erreur") ? "alert-danger" : "alert-success"} text-center`}
              role="alert"
            >
              {message}
            </div>
          )}

          <form onSubmit={handleSubmit}>
            {/* Champ Email */}
            <div className="mb-3">
              <label htmlFor="email" className="form-label">Email</label>
              <div className="input-group">
                <span className="input-group-text">
                  <i className="bi bi-envelope"></i> {/* Icône email Bootstrap */}
                </span>
                <input
                  type="email"
                  className="form-control"
                  id="email"
                  placeholder="Entrez votre email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                />
              </div>
            </div>

            {/* Champ Mot de passe */}
            <div className="mb-3">
              <label htmlFor="password" className="form-label">Mot de passe</label>
              <div className="input-group">
                <span className="input-group-text">
                  <i className="bi bi-lock"></i> {/* Icône mot de passe Bootstrap */}
                </span>
                <input
                  type="password"
                  className="form-control"
                  id="password"
                  placeholder="Entrez votre mot de passe"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  required
                />
              </div>
            </div>

            {/* Bouton Connexion */}
            <button type="submit" className="btn btn-primary w-100">
              Se connecter
            </button>
          </form>
        </div>
      </div>
    </>
  );
};

export default Connexion;
