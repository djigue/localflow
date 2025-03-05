// src/hooks/useSocket.js
import { useEffect } from 'react';
import socket from '../socket';  // Assurez-vous d'utiliser le bon chemin d'import

const useSocket = () => {
  useEffect(() => {
    // Vérifie si le socket est déjà connecté, sinon se connecter
    if (!socket.connected) {
      socket.connect();
      console.log("Connexion WebSocket établie");
    }

    // Déconnecte le socket à la destruction du composant
    return () => {
      socket.disconnect();
      console.log("Déconnexion WebSocket");
    };
  }, []);  // Le tableau vide garantit que ce code n'est exécuté qu'une seule fois
};

export default useSocket;
