import React, { useState, useEffect } from 'react';
import socket from '../socket'; // Utilise l'import unique
import BoutonBack from './bouton/BoutonBack';

const Inscription = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
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

    if (!email || !password) {
      setMessage('Remplissez tous les champs');
      return;
    }

    socket.emit('signupForm', { email, password });

    setEmail('');
    setPassword('');
  };

  return (
    <>
    <BoutonBac/>
    <div className="p-6 max-w-md mx-auto bg-white rounded-xl shadow-md space-y-4">
      <h2 className="text-xl font-bold">Inscription</h2>
      <form onSubmit={handleSubmit} className="space-y-4">
        <input type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} className="w-full p-2 border border-gray-300 rounded" />
        <input type="password" placeholder="Mot de passe" value={password} onChange={(e) => setPassword(e.target.value)} className="w-full p-2 border border-gray-300 rounded" />
        <button type="submit" className="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600">S'inscrire</button>
      </form>
      {message && <p className="text-center">{message}</p>}
    </div>
    </>
  );
};

export default Inscription;
