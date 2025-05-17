// src/utils/formValidationClient.js

// Validation de l'inscription client
export const validateInscriptionClient = (formData) => {
  const errors = {};

  // Vérifie si le prénom est vide
  if (!formData.prenom.trim()) {
    errors.prenom = "Le prénom est requis";
  }

  // Vérifie si le nom est vide
  if (!formData.nom.trim()) {
    errors.nom = "Le nom est requis";
  }

  // Vérifie si l'email est vide
  if (!formData.email.trim()) {
    errors.email = "L'email est requis";
  } else {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(formData.email)) {
      errors.email = "Veuillez entrer un email valide";
    }
  }

  // Vérifie si le téléphone est vide
  if (!formData.telephone.trim()) {
    errors.telephone = "Le téléphone est requis";
  } else {
    const phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(formData.telephone)) {
      errors.telephone = "Le numéro de téléphone doit contenir 10 chiffres";
    }
  }

  // Vérifie si le mot de passe est vide
  if (!formData.mot_de_passe.trim()) {
    errors.mot_de_passe = "Le mot de passe est requis";
  }

  // Vérifie la confirmation du mot de passe
  if (!formData.confirmPassword.trim()) {
    errors.confirmPassword = "La confirmation du mot de passe est requise";
  } else if (formData.mot_de_passe !== formData.confirmPassword) {
    errors.confirmPassword = "Les mots de passe ne correspondent pas";
  }

  return errors;
};

// Validation de la connexion client
export const validateConnexionClient = (formData) => {
  const errors = {};

  if (!formData.email.trim()) {
    errors.email = "L'email est requis";
  }

  if (!formData.password.trim()) {
    errors.password = "Le mot de passe est requis";
  }

  return errors;
};
