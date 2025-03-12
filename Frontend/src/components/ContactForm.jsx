import React, { useState, useEffect } from 'react';

const MessageForm = () => {
  const [destinataires, setDestinataires] = useState([]);
/*   const [destinataireId, setDestinataireId] = useState(''); */
  const [message, setMessage] = useState('');
  const [user, setUser] = useState(null);  // L'utilisateur connecté (expéditeur)

  useEffect(() => {
    // Charger les destinataires depuis l'API
    fetch('/api/destinataires')
      .then(response => response.json())
      .then(data => {
        setDestinataires(data.destinataires);
      })
    

    // Simuler l'utilisateur connecté (à remplacer par un appel réel à l'API si nécessaire)
    setUser({ id: 1, name: 'Jean Dupont' });
  }, []);

  const handleSubmit = (event) => {
    event.preventDefault();

    if (!message) {
      alert('Veuillez sélectionner un destinataire et entrer un message.');
      return;
    }

    // Envoi du message au backend
    const messageData = {
      expediteur: user.id, // L'ID de l'utilisateur connecté
      destinataire: user.id,
      message: message,
    };

    fetch('/api/messages', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(messageData),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Message envoyé avec succès!');
          setMessage(''); // Réinitialiser le message
        } else {
          alert('Erreur lors de l\'envoi du message.');
        }
      })
      .catch(error => {
     
      });
  };

  return (
    <div>
      <h2>Envoyer un message</h2>
      {user && (
        <form onSubmit={handleSubmit}>
          

          <div>
            <label htmlFor="message">Message:</label>
            <textarea
              id="message"
              value={message}
              onChange={(e) => setMessage(e.target.value)}
              rows="4"
              placeholder="Écrivez votre message ici..."
            />
          </div>

          <button type="submit">Envoyer</button>
        </form>
      )}
    </div>
  );
};

export default MessageForm;
