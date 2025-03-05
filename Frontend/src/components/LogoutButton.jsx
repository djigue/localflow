import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import socket from '../socket'; // Assurez-vous d'importer le socket ici, comme dans Connexion

const LogoutButton = ({ setIsAuthenticated }) => {
  const [message, setMessage] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    // Écouter la réponse du serveur après l'événement de déconnexion
    socket.on('deconnexionReponse', (data) => {
      setMessage(data.message);
      if (data.success) {
        localStorage.removeItem('token');
        localStorage.removeItem('id');
        localStorage.removeItem('email');
        localStorage.removeItem('role');
        localStorage.removeItem('commerce_id')
        setIsAuthenticated(false);
      }
      navigate('/');
    });

    return () => {
      socket.off('deconnexionReponse'); // Définir l'écouteur sur un retour propre
    };
  }, [setIsAuthenticated, navigate]);

  const handleLogout = () => {
    const token = localStorage.getItem('token');
    const userId = Number(localStorage.getItem('id'));
    console.log('user-id : ',userId);

    try {
      // Envoyer l'événement de déconnexion au serveur via WebSocket
      socket.emit('deconnexion', {token, user_id: userId})
      console.log('Déconnexion réussie');
      navigate('/login');
    } catch (error) {
      console.error('Erreur lors de la déconnexion:', error);
    }
  };
  

  return (
    <div>
      <button onClick={handleLogout} className="bg-red-500 text-white p-2 rounded hover:bg-red-600">
        Se déconnecter
      </button>
      {message && <p className="text-center">{message}</p>} {/* Afficher un message de déconnexion */}
    </div>
  );
};

export default LogoutButton;
