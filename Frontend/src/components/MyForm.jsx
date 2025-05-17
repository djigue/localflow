import React, { useState } from 'react';
import axios from 'axios';
import { FaUser, FaUserPlus, FaGoogle, FaFacebook, FaInstagram } from 'react-icons/fa';
import { validateConnexionClient, validateInscriptionClient } from '../utils/formValidationClient';

const MyForm = ({ type }) => {
  const [loginData, setLoginData] = useState({ email: '', password: '' });
  const [loginErrors, setLoginErrors] = useState({});
  const [loginMessage, setLoginMessage] = useState('');
  const [loginSuccess, setLoginSuccess] = useState(false);

  const [registerData, setRegisterData] = useState({
    prenom: '', nom: '', email: '', telephone: '', mot_de_passe: '', confirmPassword: ''
  });
  const [registerErrors, setRegisterErrors] = useState({});

  const handleChange = (e, formType) => {
    const { name, value } = e.target;
    if (formType === "login") {
      setLoginData(prev => ({ ...prev, [name]: value }));
    } else {
      setRegisterData(prev => ({ ...prev, [name]: value }));
    }
  };

  const handleLoginSubmit = async (e) => {
    e.preventDefault();
    console.log("✅ Formulaire de connexion soumis");

    const validationErrors = validateConnexionClient(loginData);
    if (Object.keys(validationErrors).length === 0) {
      try {
        const response = await axios.post(
          'http://127.0.0.1:8000/api/login',
          {
            email: loginData.email,
            password: loginData.password,
          },
          {
            headers: { 'Content-Type': 'application/json' },
            withCredentials: true
          }
        );

        console.log("✅ Réponse du backend :", response.data);
        localStorage.setItem('token', response.data.token);
        setLoginMessage("Connexion réussie !");
        setLoginSuccess(true);
      } catch (error) {
        console.error("❌ Erreur lors de la connexion :", error);
        setLoginMessage("Email ou mot de passe incorrect.");
        setLoginSuccess(false);
      }
    } else {
      setLoginErrors(validationErrors);
    }
  };

  const handleRegisterSubmit = async (e) => {
    e.preventDefault();

    const validationErrors = validateInscriptionClient(registerData);
    if (Object.keys(validationErrors).length === 0) {
      try {
        const response = await axios.post(
          'http://127.0.0.1:8000/api/register',
          {
            prenom: registerData.prenom,
            nom: registerData.nom,
            email: registerData.email,
            telephone: registerData.telephone,
            motDePasse: registerData.mot_de_passe,
            confirmPassword: registerData.confirmPassword,
          },
          {
            headers: { 'Content-Type': 'application/json' },
            withCredentials: true
          }
        );

        console.log("✅ Réponse du backend :", response.data);
      } catch (error) {
        console.error("❌ Erreur lors de l'inscription :", error);
      }
    } else {
      setRegisterErrors(validationErrors);
    }
  };

  return (
    <div className="d-flex justify-content-center">
      <div style={{ width: '100%', maxWidth: '400px' }}>
        {type === "login" && (
          <form onSubmit={handleLoginSubmit} noValidate>
            <div className="text-center mb-4">
              <img src="/images/logo.jpg" alt="Logo LocalFlow" style={{ width: '200px' }} />
            </div>

            <h2 className="text-center mb-4">Se connecter</h2>

            <div className="mb-3 text-center">
              <FaUser size={50} color="white" style={{
                background: 'linear-gradient(45deg, #ff7f50, #00bcd4)',
                borderRadius: '50%', padding: '10px',
                boxShadow: '0 10px 20px rgba(0, 0, 0, 0.1)'
              }} />
            </div>

            <div className="mb-3">
              <label htmlFor="email" className="form-label">Email</label>
              <input type="email" name="email" id="email"
                className={`form-control ${loginErrors.email ? 'is-invalid' : ''}`}
                value={loginData.email} onChange={(e) => handleChange(e, "login")} required />
              {loginErrors.email && <div className="invalid-feedback">{loginErrors.email}</div>}
            </div>

            <div className="mb-3">
              <label htmlFor="password" className="form-label">Mot de passe</label>
              <input type="password" name="password" id="password"
                className={`form-control ${loginErrors.password ? 'is-invalid' : ''}`}
                value={loginData.password} onChange={(e) => handleChange(e, "login")} required />
              {loginErrors.password && <div className="invalid-feedback">{loginErrors.password}</div>}
            </div>

            <div className="d-flex justify-content-center">
              <button type="submit" className="btn"
                style={{
                  background: 'linear-gradient(45deg, #FF7F50, #FFFFFF)',
                  color: 'black',
                  borderRadius: '8px',
                  padding: '12px 24px',
                  border: 'none',
                  boxShadow: '0 10px 20px rgba(0, 0, 0, 0.1)'
                }}>
                Se connecter
              </button>
            </div>

            {loginMessage && (
              <div className={`text-center mt-3 fw-bold ${loginSuccess ? 'text-success' : 'text-danger'}`}>
                {loginMessage}
              </div>
            )}

            <div className="d-flex justify-content-center mt-4">
              <a href="https://accounts.google.com/signin" className="mx-2"><FaGoogle size={30} color="#db4437" /></a>
              <a href="https://www.facebook.com/login" className="mx-2"><FaFacebook size={30} color="#3b5998" /></a>
              <a href="https://www.instagram.com/accounts/login/" className="mx-2"><FaInstagram size={30} color="#e4405f" /></a>
            </div>
          </form>
        )}

        {type === "register" && (
          <form onSubmit={handleRegisterSubmit} noValidate>
            <div className="text-center mb-4">
              <img src="/images/logo.jpg" alt="Logo LocalFlow" style={{ width: '200px' }} />
            </div>

            <h2 className="text-center mb-4">Créer un compte</h2>

            <div className="mb-3 text-center">
              <FaUserPlus size={50} color="white" style={{
                background: 'linear-gradient(45deg, #ff7f50, #00bcd4)',
                borderRadius: '50%', padding: '10px',
                boxShadow: '0 10px 20px rgba(0, 0, 0, 0.1)'
              }} />
            </div>

            {[{ name: 'prenom', label: 'Prénom', type: 'text' },
              { name: 'nom', label: 'Nom', type: 'text' },
              { name: 'email', label: 'Email', type: 'email' },
              { name: 'telephone', label: 'Téléphone', type: 'text' },
              { name: 'mot_de_passe', label: 'Mot de passe', type: 'password' },
              { name: 'confirmPassword', label: 'Confirmer le mot de passe', type: 'password' }
            ].map(field => (
              <div key={field.name} className="mb-3">
                <label htmlFor={field.name} className="form-label">{field.label}</label>
                <input type={field.type} name={field.name} id={field.name}
                  className={`form-control ${registerErrors[field.name] ? 'is-invalid' : ''}`}
                  value={registerData[field.name]} onChange={(e) => handleChange(e, "register")} required />
                {registerErrors[field.name] && <div className="invalid-feedback">{registerErrors[field.name]}</div>}
              </div>
            ))}

            <div className="d-flex justify-content-center">
              <button type="submit" className="btn"
                style={{
                  background: 'linear-gradient(45deg, #FF7F50, #FFFFFF)',
                  color: 'black',
                  borderRadius: '8px',
                  padding: '12px 24px',
                  border: 'none',
                  boxShadow: '0 10px 20px rgba(0, 0, 0, 0.1)'
                }}>
                S'inscrire
              </button>
            </div>
          </form>
        )}
      </div>
    </div>
  );
};

export default MyForm;
