import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom'; // Importez le hook useNavigate
import socket from '../socket'; // Utilisation de l'import unique

const InscUtil = () => {
  const [civilite, setCivilite] = useState('');
  const [nom, setNom] = useState('');
  const [prenom, setPrenom] = useState('');
  const [pseudo, setPseudo] = useState('');
  const [date_naissance, setDateNaissance] = useState('');
  const [password, setPassword] = useState('');
  const [email, setEmail] = useState('');
  const [telephone, setTelephone] = useState('');
  const [numero, setNumero] = useState('');
  const [rue, setRue] = useState('');
  const [cp, setCp] = useState('');
  const [ville, setVille] = useState('');
  const [role, setRole] = useState('');
  const [message, setMessage] = useState('');

  const navigate = useNavigate(); // Créez une instance de useNavigate pour la redirection

  useEffect(() => {
    socket.on('signupResponse', (data) => {
      setMessage(data.success ? 'Inscription réussie !' : 'Erreur : ' + data.message);
      
      // Si l'inscription est réussie, redirigez vers la page de connexion
      if (data.success) {
        setTimeout(() => {
          navigate('/login'); // Redirige vers la page de connexion après 2 secondes
        }, 2000);
      }
    });

    return () => {
      socket.off('signupResponse');
    };
  }, [navigate]); // Ajoutez navigate comme dépendance

  const handleSubmit = (e) => {
    e.preventDefault();

    if (!nom || !prenom || !date_naissance || !password || !email || !rue || !cp || !ville || !role) {
      setMessage('Remplissez tous les champs');
      return;
    }

    socket.emit('inscription', { civilite, nom, prenom, pseudo, date_naissance, password, email, telephone, numero, rue, cp, ville, role });
  };

  return (
    <div className="container d-flex justify-content-center align-items-center min-vh-100">
      <div className="card shadow-lg p-4" style={{ maxWidth: "900px", width: "100%" }}>
        <h2 className="text-center mb-4">Inscription Utilisateur</h2>
        <form onSubmit={handleSubmit}>
          <div className="row">
            <div className="col-md-6 mb-3">
              <label className="form-label">Civilité :</label>
              <select value={civilite} onChange={(e) => setCivilite(e.target.value)} className="form-select">
                <option value="">Sélectionnez une civilité</option>
                <option value="Mademoiselle">Mademoiselle</option>
                <option value="Madame">Madame</option>
                <option value="Monsieur">Monsieur</option>
              </select>
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Nom :</label>
              <input type="text" placeholder="Nom" value={nom} onChange={(e) => setNom(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Prénom :</label>
              <input type="text" placeholder="Prénom" value={prenom} onChange={(e) => setPrenom(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Pseudo :</label>
              <input type="text" placeholder="Pseudo" value={pseudo} onChange={(e) => setPseudo(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Date de naissance :</label>
              <input type="date" value={date_naissance} onChange={(e) => setDateNaissance(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Mot de passe :</label>
              <input type="password" placeholder="Mot de passe" value={password} onChange={(e) => setPassword(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Email :</label>
              <input type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Téléphone :</label>
              <input type="text" placeholder="Téléphone" value={telephone} onChange={(e) => setTelephone(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Numéro :</label>
              <input type="text" placeholder="Numéro" value={numero} onChange={(e) => setNumero(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Rue :</label>
              <input type="text" placeholder="Rue" value={rue} onChange={(e) => setRue(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Code Postal :</label>
              <input type="text" placeholder="Code Postal" value={cp} onChange={(e) => setCp(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Ville :</label>
              <input type="text" placeholder="Ville" value={ville} onChange={(e) => setVille(e.target.value)} className="form-control" />
            </div>

            <div className="col-md-6 mb-3">
              <label className="form-label">Rôle :</label>
              <select value={role} onChange={(e) => setRole(e.target.value)} className="form-select">
                <option value="">Sélectionnez un rôle</option>
                <option value="client">Client</option>
                <option value="commercant">Commerçant</option>
              </select>
            </div>
          </div>

          <button type="submit" className="btn btn-success w-100">S'inscrire</button>
        </form>

        {message && <p className="mt-3 text-center text-danger">{message}</p>}
      </div>
    </div>
  );
};

export default InscUtil;
