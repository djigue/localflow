import { useState } from "react";
import 'bootstrap/dist/css/bootstrap.min.css';

export default function AdminPanel() {
  // État pour gérer la section active (ex: "Dashboard", "Produits", etc.)
  const [active, setActive] = useState("Dashboard");

  return (
    <div className="container-fluid d-flex vh-100 p-0">
      {/* Barre latérale (Sidebar) contenant le menu d'administration */}
      <div className="col-md-2 bg-dark text-white p-4">
        <h2 className="text-center">Admin Panel</h2>
        
        {/* Liste des sections du panneau admin */}
        <ul className="list-group list-group-flush mt-4">
          <li 
            className={`list-group-item bg-dark text-white border-0 ${active === "Dashboard" ? "active" : ""}`}
            onClick={() => setActive("Dashboard")}
            style={{ cursor: "pointer" }}
          >
            🏠 Dashboard
          </li>
          <li 
            className={`list-group-item bg-dark text-white border-0 ${active === "Produits" ? "active" : ""}`}
            onClick={() => setActive("Produits")}
            style={{ cursor: "pointer" }}
          >
            📦 Produits
          </li>
          <li 
            className={`list-group-item bg-dark text-white border-0 ${active === "Événements" ? "active" : ""}`}
            onClick={() => setActive("Événements")}
            style={{ cursor: "pointer" }}
          >
            📅 Événements
          </li>
          <li 
            className={`list-group-item bg-dark text-white border-0 ${active === "Promotions" ? "active" : ""}`}
            onClick={() => setActive("Promotions")}
            style={{ cursor: "pointer" }}
          >
            🎉 Promotions
          </li>
          <li 
            className={`list-group-item bg-dark text-white border-0 ${active === "Messages" ? "active" : ""}`}
            onClick={() => setActive("Messages")}
            style={{ cursor: "pointer" }}
          >
            📩 Messages
          </li>
        </ul>
      </div>

      {/* Contenu principal qui affiche la section sélectionnée */}
      <div className="col-md-10 p-4">
        <h1>{active}</h1>
        <div className="mt-4 p-4 bg-light rounded shadow-sm">
          {active === "Dashboard" && <p>Bienvenue sur le panneau d'administration.</p>}
          {active === "Produits" && <p>Gestion des produits commerçant : Ajout, modification et suppression.</p>}
          {active === "Événements" && <p>Gestion des événements commerciaux.</p>}
          {active === "Promotions" && <p>Gestion des promotions et réductions des commerçants.</p>}
          {active === "Messages" && <p>Boîte de réception des messages des commerçants.</p>}
        </div>
      </div>
    </div>
  );
}
