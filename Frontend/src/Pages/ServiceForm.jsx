import React, { useState } from "react";
import MyForm from "../components/MyForm";
import { validateServiceForm } from "../utils/formValidationService";

const ServiceForm = () => {

  // Déclaration de l'état pour les données du formulaire
  const [formData, setFormData] = useState({
    name: '',
    email: '',              
    price: '',            
    shortDescription: '',   
    detailedDescription: '',
    reservation: false,     
  });

  const [errors, setErrors] = useState({});

  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData({
      ...formData,
      [name]: type === "checkbox" ? checked : value,
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const validationErrors = validateServiceForm(formData);
    setErrors(validationErrors);

    if (Object.keys(validationErrors).length === 0) {
      console.log(formData);
      console.log("Formulaire soumis !");
    } else {
      console.log("Formulaire invalide", validationErrors);
    }
  };

  // Configuration des champs du formulaire sous forme de tableau
  const fields = [
    { name: "name", label: "Nom du service*", type: "text", placeholder: "| Nom du service" },
    { name: "email", label: "Email*", type: "email", placeholder: "| Email" },
    { name: "price", label: "Prix du service*", type: "number", placeholder: "| Prix" },
    { name: "shortDescription", label: "Courte description*", type: "text", placeholder: "| Description courte" },
    { name: "detailedDescription", label: "Description détaillée*", type: "textaera", placeholder: "| Description détaillée" },

    // Case pour la réservation
    { name: "reservation", label: "Permettre la réservation dans le système ?", type: "checkbox" },
  ];

  return (
    <MyForm
      fields={fields}
      formData={formData}
      onChange={handleChange}
      onSubmit={handleSubmit}
      errors={errors}
    />
  );
};

export default ServiceForm;

