import { useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import BoutonBack from "../components/bouton/BoutonBack"; // Vérifie le bon chemin

const AvisClientsPanel = () => {
  const [avis, setAvis] = useState([
    { id: 1, nom: "Jean Dupont", commentaire: "Super service !", note: 5 },
    { id: 2, nom: "Sophie Martin", commentaire: "Très satisfait de mon achat.", note: 4 },
    { id: 3, nom: "Paul Durant", commentaire: "Correct mais peut mieux faire.", note: 3 },
    { id: 4, nom: "Alice Morel", commentaire: "Pas satisfait du tout !", note: 1 },
  ]);

  const [filtreNote, setFiltreNote] = useState("Tous");
  const avisFiltres =
    filtreNote === "Tous" ? avis : avis.filter((a) => a.note === parseInt(filtreNote));

  return (
    <>
     {/*  <NavbarCommerce /> */}
      <div className="container-fluid min-vh-100">
        <div className="container py-5">
          <BoutonBack/>
          <h1 className="text-center text-info mb-4">📢 Avis des Clients</h1>

          {/* Filtre par note */}
          <div className="mb-4 d-flex justify-content-center">
            <label className="me-2">Filtrer par note :</label>
            <select
              className="form-select w-auto bg-secondary text-white border-info"
              value={filtreNote}
              onChange={(e) => setFiltreNote(e.target.value)}
            >
              <option value="Tous">Tous</option>
              <option value="5">5 ⭐</option>
              <option value="4">4 ⭐</option>
              <option value="3">3 ⭐</option>
              <option value="2">2 ⭐</option>
              <option value="1">1 ⭐</option>
            </select>
          </div>

          {/* Liste des avis */}
          <div className="row">
            {avisFiltres.length > 0 ? (
              avisFiltres.map((a) => (
                <div key={a.id} className="col-md-6 mb-3">
                  <div className="card bg-secondary text-white shadow-lg p-3 border-info">
                    <h5 className="fw-bold text-info">{a.nom}</h5>
                    <p>{a.commentaire}</p>
                    <p className="text-warning">⭐ {a.note}/5</p>
                  </div>
                </div>
              ))
            ) : (
              <p className="text-center">Aucun avis pour cette note.</p>
            )}
          </div>
        </div>
      </div>
    </>
    
  );
  
};

export default AvisClientsPanel;