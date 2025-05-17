import React, { useState } from 'react';
import { FaUser, FaGoogle, FaFacebook, FaInstagram } from 'react-icons/fa';
import { validateConnexionClient } from '../utils/formValidationClient';  

const MyForm = () => {
  const [formData, setFormData] = useState({ email: '', password: '' });
  const [errors, setErrors] = useState({});

  const handleSubmit = (e) => {
    e.preventDefault();
    const validationErrors = validateConnexionClient(formData);

    if (Object.keys(validationErrors).length === 0) {
      console.log("Connexion réussie avec :", formData);
      // Appeler une API ici si besoin
    } else {
      setErrors(validationErrors);
    }
  };

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  return (
    <form onSubmit={handleSubmit} noValidate>
      <div className="text-center mb-4">
        <img src="/images/logo.jpg" alt="Logo LocalFlow" style={{ width: '150px', height: 'auto' }} />
      </div>

      <h2 className="text-center mb-4" style={{ fontFamily: 'Poppins, sans-serif' }}>
        Se connecter
      </h2>

      <div className="mb-3 text-center">
        <FaUser
          size={50}
          color="white"
          style={{
            background: 'linear-gradient(45deg, #ff7f50, #00bcd4)',
            borderRadius: '50%',
            padding: '10px',
            boxShadow: '0 10px 20px rgba(0, 0, 0, 0.1)',
          }}
        />
      </div>

      <div className="mb-3">
        <label htmlFor="email" className="form-label">Email</label>
        <input
          type="email"
          className={`form-control ${errors.email ? 'is-invalid' : ''}`}
          id="email"
          name="email"
          placeholder="Entrez votre email"
          value={formData.email}
          onChange={handleChange}
          required
          style={{ borderRadius: '8px' }}
        />
        {errors.email && <div className="invalid-feedback">{errors.email}</div>}
      </div>

      <div className="mb-3">
        <label htmlFor="password" className="form-label">Mot de passe</label>
        <input
          type="password"
          className={`form-control ${errors.password ? 'is-invalid' : ''}`}
          id="password"
          name="password"
          placeholder="Entrez votre mot de passe"
          value={formData.password}
          onChange={handleChange}
          required
          style={{ borderRadius: '8px' }}
        />
        {errors.password && <div className="invalid-feedback">{errors.password}</div>}
      </div>

      <div className="d-flex justify-content-center">
        <button
          type="submit"
          className="btn btn-primary"
          style={{
            background: 'linear-gradient(45deg, #FF7F50, #FFFFFF)',
            color: 'black',
            borderRadius: '8px',
            padding: '12px 24px',
            border: 'none',
            boxShadow: '0 10px 20px rgba(0, 0, 0, 0.1)',
            transition: 'all 0.3s ease',
          }}
        >
          Se connecter
        </button>
      </div>

      <div className="d-flex justify-content-center mt-4">
        <a href="https://accounts.google.com/signin" className="mx-2">
          <FaGoogle size={30} color="#db4437" />
        </a>
        <a href="https://www.facebook.com/login" className="mx-2">
          <FaFacebook size={30} color="#3b5998" />
        </a>
        <a href="https://www.instagram.com/accounts/login/" className="mx-2">
          <FaInstagram size={30} color="#e4405f" />
        </a>
      </div>

      <p className="mt-3 text-center">
        Pas encore de compte ? <a href="/inscription" style={{ color: '#2196F3' }}>S'inscrire</a>
      </p>
    </form>
  );
};

export default MyForm;
