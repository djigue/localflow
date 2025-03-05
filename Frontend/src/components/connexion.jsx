import React, { useState, useEffect } from 'react';
import socket from '../socket'; // Import unique

const Connexion = ({ setIsAuthenticated }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');

  useEffect(() => {
    socket.on('connexionResponse', (data) => {
      setMessage(data.success ? 'Connexion réussie !' : 'Erreur : ' + data.message);
      if (data.success) {
        localStorage.setItem('token', data.token);
        setIsAuthenticated(true);
        localStorage.setItem('id', data.user_id); 
        localStorage.setItem('email', data.user_email);
        localStorage.setItem('role', data.user_role);
        localStorage.setItem('commerce_id', data.commerce_id);
      }
    });

    return () => {
      socket.off('connexionResponse');
    };
  }, [setIsAuthenticated]);

  const handleSubmit = (e) => {
    e.preventDefault();

    if (!email || !password) {
      setMessage('Remplissez tous les champs');
      return;
    }

    socket.emit('connexion', { email, password });

    setEmail('');
    setPassword('');
  };

  return (
    <div className="p-6 max-w-md mx-auto bg-white rounded-xl shadow-md space-y-4">
      <h2 className="text-xl font-bold">Connexion</h2>
      <form onSubmit={handleSubmit} className="space-y-4">
        <input type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} className="w-full p-2 border border-gray-300 rounded" />
        <input type="password" placeholder="Mot de passe" value={password} onChange={(e) => setPassword(e.target.value)} className="w-full p-2 border border-gray-300 rounded" />
        <button type="submit" className="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Se connecter</button>
      </form>
      {message && <p className="text-center">{message}</p>}
    </div>
  );
};

export default Connexion;
