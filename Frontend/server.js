process.env.NODE_TLS_REJECT_UNAUTHORIZED = "0";


import http from 'http';
import { Server as SocketIO } from 'socket.io';
import axios from 'axios'; 
import express from 'express';

const app = express();
const server = http.createServer(app);
const io = new SocketIO(server, {
  cors: {
    origin: '*', 
    methods: ['GET', 'POST'],
  },
  maxHttpBufferSize: 10 * 1024 * 1024,
});

const PORT = 4000;

// Démarrer le serveur WebSocket
server.listen(PORT, () => {
  console.log(`🚀 Serveur WebSocket en écoute sur le port ${PORT}`);
});

// Gérer les connexions WebSocket
io.on('connection', (socket) => {
  console.log('✅ Un client est connecté');

  socket.on('inscription', async (data) => {
    console.log('📩 Formulaire d\'inscription reçu:', data);

    try {
      const response = await axios.post('http://localhost:8000/api/utilisateur/inscription', {
        civilite: data.civilite,
        nom: data.nom,
        prenom: data.prenom,
        pseudo: data.pseudo,
        date_naissance: data.date_naissance,
        password: data.password,
        email: data.email,
        telephone: data.telephone,
        numero: data.numero,
        rue: data.rue,
        cp: data.cp,
        ville: data.ville,
        roles: data.role,
      });

      console.log('✅ Utilisateur enregistré dans Symfony');
      socket.emit('signupResponse', { success: true, message: 'Utilisateur créé avec succès' });
    } catch (error) {
      console.error('❌ Erreur lors de l\'inscription:', error.response?.data || error.message);
      socket.emit('signupResponse', { success: false, message: 'Erreur d\'inscription' });
    }
  });

  socket.on('connexion', async (data) => {
    console.log('📩 Formulaire de connexion reçu:', data);

    try {
      const response = await axios.post('http://localhost:8000/api/utilisateur/connexion', {
        email: data.email,
        password: data.password,
      });

      console.log('✅ Utilisateur validé par Symfony token : ', response.data);
      socket.emit('connexionResponse', { success: true, message: 'Connexion réussie', token: response.data.token,
                  user_id: response.data.user_id, user_email: response.data.user_email, user_role: response.data.user_role, commerce_id: response.data.user_commerce });
    } catch (error) {
      console.error('❌ Erreur lors de la connexion:', error.response?.data || error.message);
      socket.emit('loginResponse', { success: false, message: 'Erreur de connexion' });
    }
  });

  socket.on('deconnexion', async (data) => {
    console.log('📩 Formulaire de deconnexion:', data);

    try {
      const response = await axios.post('http://localhost:8000/api/utilisateur/deconnexion', {
        token: data.token,       
        user_id: data.user_id
      });

      console.log('✅ Utilisateur deco par Symfony');
      socket.emit('deconnexionReponse', { success: true, message: 'Déconnexion réussie'});
    } catch (error) {
      console.error('❌ Erreur lors de la connexion:', error.response?.data || error.message);
      socket.emit('deconnexionReponse', { success: false, message: 'Erreur de déconnexion' });
    }
  });

  socket.on('commerceCreation', async (data) => {

    console.log('📩 Formulaire de création :', data);

    if (data.imageBlobs && Array.isArray(data.imageBlobs)) {
      console.log("Images reçues (ArrayBuffer) :", data.imageBlobs);
  } else {
      console.log('Aucune image reçue ou format incorrect');
  }

    try {

      const formData = new FormData();
       formData.append("nom", data.nom);
       formData.append("siret", data.siret);
       formData.append("secteur_activite", data.secteur_activite);
       formData.append("fixe", data.fixe);
       formData.append("slug", data.slug);
       formData.append("description", data.description);
       formData.append("livraison", data.livraison);
       formData.append("lien", data.lien);
       formData.append("horaire", JSON.stringify(data.horaire));
       formData.append("telephone", data.telephone);
       formData.append("numero", data.numero);
       formData.append("rue", data.rue);
       formData.append("cp", data.cp);
       formData.append("ville", data.ville);
       formData.append("user_id", data.user_id);

       // Ajouter les images
       data.imageBlobs.forEach((buffer, index) => {
           const file = new Blob([buffer], { type: "image/jpeg" });
           formData.append(`images[]`, file, `image_${index}.jpg`);
       });

      const response = await axios.post('http://localhost:8000/api/commerce/creation', formData, {
        headers: {
          "Content-Type": "multipart/form-data",
      },
      });

      console.log('✅ Commerce créé par Symfony');
      socket.emit('commerceCreationReponse', {
         success: true,
         message: 'Commerce créé avec succès',
         user_id: response.data.user_id,
         commerce_id: response.data.commerce_id
      });
    } catch (error) {
      console.error('❌ Erreur lors de la connexion:', error.response?.data || error.message);
      socket.emit('commerceCreationReponse', { success: false, message: 'Le commerce n\'a pu être créé' });
    }
  });

  socket.on('evenementCreation', async (data) => {

    console.log('📩 Formulaire evenement :', data);

    if (data.imageBlobs && Array.isArray(data.imageBlobs)) {
      console.log("Images reçues (ArrayBuffer) :", data.imageBlobs);
  } else {
      console.log('Aucune image reçue ou format incorrect');
  }

    try {

      const formData = new FormData();
        formData.append("nom", data.nom);
        formData.append("date_debut", data.date_debut);
        formData.append("date_fin", data.date_fin);
        formData.append("heure_debut", data.heure_debut);
        formData.append("heure_fin", data.heure_fin);
        formData.append("description", data.description);
        formData.append("slug", data.slug);
        formData.append("inscription", data.inscription);
        formData.append("nombre", data.nombre);
        formData.append("alerte", data.alerte);
        formData.append("numero", data.numero);
        formData.append("rue", data.rue);
        formData.append("cp", data.cp);
        formData.append("ville", data.ville);
        formData.append("commerce_id", data.commerce_id);

        // Ajouter les images
        data.imageBlobs.forEach((buffer, index) => {
            const file = new Blob([buffer], { type: "image/jpeg" });
            formData.append(`images[]`, file, `image_${index}.jpg`);
        });

      const response = await axios.post('http://localhost:8000/api/commerce/evenement', formData, {
        headers: {
          "Content-Type": "multipart/form-data",
      },
      });

      console.log('✅ evenement créé par Symfony');
      socket.emit('evenementCreationReponse', {
         success: true,
         message: 'evenementcréé avec succès',
      });
    } catch (error) {
      console.error('❌ Erreur lors de la connexion:', error.response?.data || error.message);
      socket.emit('evenementCreationReponse', { success: false, message: 'Le commerce n\'a pu être créé' });
    }
  });

  socket.on('produitCreation', async (data) => {

    console.log('📩 Formulaire produit :', data);

  //   if (data.imageBlobs && Array.isArray(data.imageBlobs)) {
  //     console.log("Images reçues (ArrayBuffer) :", data.imageBlobs);
  // } else {
  //     console.log('Aucune image reçue ou format incorrect');
  // }

    try {

      const formData = new FormData();
        formData.append("nom", data.nom);
        formData.append("prix", data.prix);
        formData.append("formatPrix", data.formatPrix);
        formData.append("slug", data.slug);
        formData.append("description", data.description);
        formData.append("taille", data.taille);
        formData.append("quantite", data.quantite);
        formData.append("alerte", data.alerte);
        formData.append("user_id", data.user_id);
        formData.append("commerce_id", data.commerce_id);
       
        // Ajouter les images
        data.imageBlobs.forEach((buffer, index) => {
            const file = new Blob([buffer], { type: "image/jpeg" });
            formData.append(`images[]`, file, `image_${index}.jpg`);
        });
        
      const response = await axios.post('http://localhost:8000/api/produit/creation', formData, {
        headers: {
          "Content-Type": "multipart/form-data",
      },
      });

      console.log('✅ produit créé par Symfony');
      socket.emit('produitCreationReponse', {
         success: true,
         message: 'produit créé avec succès',
      });
    } catch (error) {
      console.error('❌ Erreur lors de la connexion:', error.response?.data || error.message);
      socket.emit('produitCreationReponse', { success: false, message: 'Le produit n\'a pu être créé' });
    }
  });

  socket.on('serviceCreation', async (data) => {

    console.log('📩 Formulaire service :', data);

  //   if (data.imageBlobs && Array.isArray(data.imageBlobs)) {
  //     console.log("Images reçues (ArrayBuffer) :", data.imageBlobs);
  // } else {
  //     console.log('Aucune image reçue ou format incorrect');
  // }

    try {

      const formData = new FormData();
        formData.append("nom", data.nom);
        formData.append("prix", data.prix);
        formData.append("slug", data.slug);
        formData.append("description", data.description);
        formData.append("duree", data.duree);
        formData.append("reservation", data.reservation);
        formData.append("commerce_id", data.commerce_id);
       
        // Ajouter les images
        data.imageBlobs.forEach((buffer, index) => {
            const file = new Blob([buffer], { type: "image/jpeg" });
            formData.append(`images[]`, file, `image_${index}.jpg`);
        });
        
      const response = await axios.post('http://localhost:8000/api/service/creation', formData, {
        headers: {
          "Content-Type": "multipart/form-data",
      },
      });

      console.log('✅ service créé par Symfony');
      socket.emit('serviceCreationReponse', {
         success: true,
         message: 'service créé avec succès',
      });
    } catch (error) {
      console.error('❌ Erreur lors de la connexion:', error.response?.data || error.message);
      socket.emit('serviceCreationReponse', { success: false, message: 'Le service n\'a pu être créé' });
    }
  });

  socket.on('promotionCreation', async (data) => {

    console.log('📩 Formulaire promotion :', data);

  //   if (data.imageBlobs && Array.isArray(data.imageBlobs)) {
  //     console.log("Images reçues (ArrayBuffer) :", data.imageBlobs);
  // } else {
  //     console.log('Aucune image reçue ou format incorrect');
  // }

    try {

      const formData = new FormData();
        formData.append("nom", data.nom);
        formData.append("slug", data.slug);
        formData.append("description", data.description);
        formData.append("dateDebut", data.dateDebut);
        formData.append("dateFin", data.dateFin);
        formData.append("reduction", data.reduction);
        formData.append("formatReduction", data.formatReduction);
        formData.append("commerce_id", data.commerce_id);
       
        // Ajouter les images
        data.imageBlobs.forEach((buffer, index) => {
            const file = new Blob([buffer], { type: "image/jpeg" });
            formData.append(`images[]`, file, `image_${index}.jpg`);
        });
        
      const response = await axios.post('http://localhost:8000/api/promotion/creation', formData, {
        headers: {
          "Content-Type": "multipart/form-data",
      },
      });

      console.log('✅ promotion créé par Symfony');
      socket.emit('promotionCreationReponse', {
         success: true,
         message: 'promotion créé avec succès',
      });
    } catch (error) {
      console.error('❌ Erreur lors de la connexion:', error.response?.data || error.message);
      socket.emit('promotionCreationReponse', { success: false, message: 'La promotion n\'a pu être créé' });
    }
  });

  socket.on('commercantInfo', async (userId) => {
    console.log(`📩 Demande d'informations pour le commerçant ${userId}`);
  
    try {
      const response = await axios.get(`http://localhost:8000/api/commercant/${userId}`);
      socket.emit('commercantInfoResponse', response.data);
      console.log("données recues : ", response.data )
    } catch (error) {
      console.error("❌ Erreur lors de la récupération des informations :", error.response?.data || error.message);
      socket.emit('commercantInfoResponse', { error: "Erreur serveur" });
    }
  });

  socket.on('sendContactMessage', async (data) => {
    console.log(`📩 Données message : `, data);
  
    try {
      const response = await axios.get(`http://localhost:8000/api/message`, {
        nom: data.nom,
        email: data.email,
        message: data.message,
        user_id: data.user_id,
      });
      socket.emit('contactResponse', response.data);
      console.log("données recues : ", response.data );
    } catch (error) {
      console.error("❌ Erreur lors de la récupération des informations :", error.response?.data || error.message);
      socket.emit('contactResponse', { error: "Erreur serveur" });
    }
  });


  socket.on('disconnect', () => {
    console.log('❌ Un client s\'est déconnecté');
  });
});

