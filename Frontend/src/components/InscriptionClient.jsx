import React, { useState } from "react";
import MyForm from "../components/MyForm";
import { validateInscriptionClient } from "../utils/formValidationClient";

const InscriptionClient = () => {
  // Déclaration de l'état pour les données du formulaire
  const [formData, setFormData] = useState({
    prenom: "",
    nom: "",
    email: "",
    telephone: "",
    motDePasse: "",
    confirmPassword: "",
  });

  const [errors, setErrors] = useState({});

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const validationErrors = validateInscriptionClient(formData);
    setErrors(validationErrors);

    if (Object.keys(validationErrors).length === 0) {
      console.log("Inscription réussie avec :", formData);
    
    }
  };

  const handleCancel = () => {
    console.log("Annulation de l'inscription !");
  };

  // Champs du formulaire
  const fields = [
    { name: "prenom", label: "Prénom*", type: "text", placeholder: "| Prénom" },
    { name: "nom", label: "Nom*", type: "text", placeholder: "| Nom" },
    { name: "email", label: "Email*", type: "email", placeholder: "| Email" },
    { name: "telephone", label: "Téléphone*", type: "tel", placeholder: "| Téléphone" },
    { name: "motDePasse", label: "Mot de passe*", type: "password", placeholder: "| Mot de passe" },
    { name: "confirmPassword", label: "Confirmation du mot de passe*", type: "password", placeholder: "| Confirmer le mot de passe" },
  ];

  return (
    <MyForm
      fields={fields}
      formData={formData}
      onChange={handleChange}
      onSubmit={handleSubmit}
      onCancel={handleCancel}
      errors={errors}
    />
  );
};

export default InscriptionClient;

