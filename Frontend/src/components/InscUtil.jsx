import React, { useState, useEffect } from 'react';
import socket from '../socket'; // Utilise l'import unique

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

  useEffect(() => {
    socket.on('signupResponse', (data) => {
      setMessage(data.success ? 'Inscription réussie !' : 'Erreur : ' + data.message);
    });

    return () => {
      socket.off('signupResponse');
    };
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();

    if (!nom || !prenom || !date_naissance || !password || !email|| !rue || !cp || !ville || !role || !password) {
      setMessage('Remplissez tous les champs');
      return;
    }

    socket.emit('inscription', { civilite, nom, prenom, pseudo, date_naissance, password, email, telephone, numero, rue, cp, ville, role });

    // setEmail('');
    // setPassword('');
  };

  return (
    <div>
      <h2>Inscription Utilisateur</h2>
      <form onSubmit={handleSubmit} className="space-y-4">
        <label> Civilité : </label>
        <select value={civilite} onChange={(e) => setCivilite(e.target.value)}>
                <option value="">Sélectionnez une civilité</option>
                <option value="Mademoiselle">Mademoiselle</option>
                <option value="Madame">Madame</option>
                <option value="Monsieur">Monsieur</option>
        </select>
        <label> Nom : </label>
        <input type="text" placeholder="Nom" value={nom} onChange={(e) => setNom(e.target.value)} /> 
        <label> Prénom : </label>
        <input type="text" placeholder="Prenom" value={prenom} onChange={(e) => setPrenom(e.target.value)} />
        <label> Pseudo : </label>
        <input type="text" placeholder="Pseudo" value={pseudo} onChange={(e) => setPseudo(e.target.value)} /> 
        <label> Date de naissance : </label>
        <input type="date" value={date_naissance} onChange={(e) => setDateNaissance(e.target.value)} />
        <br></br><label> Mot de passe : </label>
        <input type="password" placeholder="Mot de passe" value={password} onChange={(e) => setPassword(e.target.value)} />
        <label> Email :</label>
        <input type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} />
        <label> Téléphone : </label>
        <input type="text" placeholder="Téléphone" value={telephone} onChange={(e) => setTelephone(e.target.value)} />
        <br />
        <label> Numero : </label>
        <input type="text" placeholder="Numéro" value={numero} onChange={(e) => setNumero(e.target.value)} />
        <label> Rue : </label>
        <input type="text" placeholder="Rue" value={rue} onChange={(e) => setRue(e.target.value)} />
        <label> Code postal : </label>
        <input type="text" placeholder="Code Postal" value={cp} onChange={(e) => setCp(e.target.value)} />
        <label> Ville : </label>
        <input type="text" placeholder="Ville" value={ville} onChange={(e) => setVille(e.target.value)} />
        <br />
        <label> Rôle : </label>
        <select value={role} onChange={(e) => setRole(e.target.value)} >
                <option value="">Sélectionnez un rôle</option>
                <option value="client">Client</option>
                <option value="commercant">Commerçant</option>
        </select>
        <br />
        <br />
        <button type="submit">S'inscrire</button>
      </form>
      {message && <p className="text-center">{message}</p>}
    </div>
  );
};

export default InscUtil;