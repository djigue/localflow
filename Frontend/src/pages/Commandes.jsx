import { useState } from "react";
import BoutonBack from "../components/bouton/BoutonBack";

function Commandes() {
  const [commandes, setCommandes] = useState([
    { id: 1, client: "Jean Dupont", total: 45.99, statut: "En attente" },
    { id: 2, client: "Marie Curie", total: 89.50, statut: "Expédiée" },
    { id: 3, client: "Albert Einstein", total: 120.75, statut: "En attente" },
  ]);

  // États pour gérer la modification
  const [commandeEnCours, setCommandeEnCours] = useState(null);
  const [modalOuvert, setModalOuvert] = useState(false);

  // Fonction pour ouvrir le modal avec uniquement la modification du statut
  const ouvrirModalModification = (commande) => {
    setCommandeEnCours(commande);
    setModalOuvert(true);
  };

  // Fonction pour mettre à jour uniquement le statut de la commande
  const modifierCommande = () => {
    setCommandes(
      commandes.map((cmd) =>
        cmd.id === commandeEnCours.id
          ? { ...cmd, statut: commandeEnCours.statut }
          : cmd
      )
    );
    setModalOuvert(false);
  };

  return (
    <>
     
      <div className="container-fluid min-vh-100">
        <div className="container py-5">
          <BoutonBack/>
          <h1 className="text-center text-info mb-4">📦 Gestion des Commandes</h1>

          <div className="card bg-secondary shadow-lg p-4">
            <div className="card-body">
              <table className="table table-dark table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Total (€)</th>
                    <th>Statut</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {commandes.map((commande) => (
                    <tr key={commande.id}>
                      <td>{commande.id}</td>
                      <td>{commande.client}</td>
                      <td>{commande.total.toFixed(2)}€</td>
                      <td>
                        <span
                          className={`badge ${
                            commande.statut === "Expédiée" ? "bg-success" : "bg-warning"
                          }`}
                        >
                          {commande.statut}
                        </span>
                      </td>
                      <td>
                        <button
                          className="btn btn-primary btn-sm me-2"
                          onClick={() => ouvrirModalModification(commande)}
                        >
                          📝 Modifier
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      {/* MODAL MODIFICATION */}
      {modalOuvert && (
        <div className="modal fade show d-block" tabIndex="-1">
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Modifier le statut de la commande</h5>
                <button className="btn-close" onClick={() => setModalOuvert(false)}></button>
              </div>
              <div className="modal-body">
                <p><strong>Client :</strong> {commandeEnCours.client}</p>
                <p><strong>Total :</strong> {commandeEnCours.total.toFixed(2)}€</p>

                <label className="form-label mt-2">Statut</label>
                <select
                  className="form-select"
                  value={commandeEnCours.statut}
                  onChange={(e) =>
                    setCommandeEnCours({ ...commandeEnCours, statut: e.target.value })
                  }
                >
                  <option value="En attente">En attente</option>
                  <option value="Expédiée">Expédiée</option>
                </select>
              </div>
              <div className="modal-footer">
                <button className="btn btn-secondary" onClick={() => setModalOuvert(false)}>
                  Annuler
                </button>
                <button className="btn btn-success" onClick={modifierCommande}>
                  ✅ Sauvegarder
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </>
  );
}

export default Commandes;
