import { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css'; // Assurez-vous d'avoir Bootstrap installé


import BoutonBack from '../components/bouton/BoutonBack'; 

function FAQ() {
  const [openIndex, setOpenIndex] = useState(null);

  const faqs = [
    { question: 'Qu\'est-ce que LocalFlow ?', answer: 'LocalFlow est une plateforme permettant de connecter les utilisateurs avec les commerçants locaux.' },
    { question: 'Comment créer un compte ?', answer: 'Pour créer un compte, cliquez sur le bouton "S\'inscrire" en haut à droite de la page et remplissez le formulaire.' },
    { question: 'Est-ce que l\'inscription est gratuite ?', answer: 'Oui, l\'inscription est entièrement gratuite pour tous les utilisateurs.' },
    { question: 'Puis-je modifier mes informations personnelles ?', answer: 'Oui, vous pouvez modifier vos informations personnelles en vous rendant sur la page "Mon compte".' },
    { question: 'Comment contacter un commerçant ?', answer: 'Chaque commerçant a un formulaire de contact sur sa page de profil. Vous pouvez également envoyer un message direct.' },
  ];

  const toggleAnswer = (index) => {
    if (openIndex === index) {
      setOpenIndex(null); // Fermer la réponse si elle est déjà ouverte
    } else {
      setOpenIndex(index); // Ouvrir la réponse
    }
  };

  return (
    <div> 

    <div className="container my-5">
    {<BoutonBack />}
      <h2 className="mb-4">Foire Aux Questions (FAQ)</h2>

      <div className="accordion" id="faqAccordion">
        {faqs.map((faq, index) => (
          <div key={index} className="accordion-item">
            <h2 className="accordion-header" id={`faqHeading${index}`}>
              <button
                className="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target={`#faqCollapse${index}`}
                aria-expanded={openIndex === index ? 'true' : 'false'}
                aria-controls={`faqCollapse${index}`}
                onClick={() => toggleAnswer(index)}
              >
                {faq.question}
              </button>
            </h2>
            <div
              id={`faqCollapse${index}`}
              className={`accordion-collapse collapse ${openIndex === index ? 'show' : ''}`}
              aria-labelledby={`faqHeading${index}`}
              data-bs-parent="#faqAccordion"
            >
              <div className="accordion-body">
                {faq.answer}
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
    </div>
  );
}

export default FAQ;
