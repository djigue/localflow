// Validation de l'inscription client
export const validateInscriptionClient = (formData) => {
  const errors = {};

  // Vérifie si l'email est vide
  if (!formData.email) {
    errors.email = "L'email est requis";
  } else {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(formData.email)) {
      errors.email = "Veuillez entrer un email valide";
    }
  }

  // Vérifie si le mot de passe est vide
  if (!formData.password) {
    errors.password = "Le mot de passe est requis";
  } else if (formData.password.length < 6) {
    errors.password = "Le mot de passe doit contenir au moins 6 caractères";
  }

  // Vérifie si la confirmation du mot de passe est vide et correspond au mot de passe
  if (!formData.confirmPassword) {
    errors.confirmPassword = "La confirmation du mot de passe est requise";
  } else if (formData.password !== formData.confirmPassword) {
    errors.confirmPassword = "Les mots de passe ne correspondent pas";
  }

  // Vérifie si le prénom est vide
  if (!formData.firstName) {
    errors.firstName = "Le prénom est requis";
  }

  // Vérifie si le nom est vide
  if (!formData.lastName) {
    errors.lastName = "Le nom est requis";
  }

  return errors;
};

