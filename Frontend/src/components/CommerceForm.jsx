import React, { useState, useEffect } from 'react';
import socket from '../socket';
import ImagesForm from './ImagesForm';

const CommerceForm = () => {
    const [nom, setNom] = useState('');
    const [siret, setSiret] = useState('');
    const [secteur_activite, setSecteurActivite] = useState('');
    const [fixe, setFixe] = useState('');
    const [slug, setSlug] = useState('');
    const [description, setDescription] = useState('');
    const [livraison, setLivraison] = useState('');
    const [telephone, setTelephone] = useState('');
    const [lien, setLien] = useState('');
    const [horaire, setHoraire] = useState([
        { jour: "Lundi", ouverture: "08:00", fermeture: "18:00" },
        { jour: "Mardi", ouverture: "08:00", fermeture: "18:00" },
        { jour: "Mercredi", ouverture: "08:00", fermeture: "18:00" },
        { jour: "Jeudi", ouverture: "08:00", fermeture: "18:00" },
        { jour: "Vendredi", ouverture: "08:00", fermeture: "18:00" },
        { jour: "Samedi", ouverture: "08:00", fermeture: "18:00" },
        { jour: "Dimanche", ouverture: "08:00", fermeture: "18:00" },
    ]);
    const [numero, setNumero] = useState('');
    const [rue, setRue] = useState('');
    const [cp, setCp] = useState('');
    const [ville, setVille] = useState('');
    const [images, setImages] = useState([]);
    const [message, setMessage] = useState('');

    useEffect(() => {
        socket.on('commerceCreationReponse', (data) => {
            setMessage(data.success ? 'Le commerce a bien été créé !' : 'Erreur : ' + data.message);           
            localStorage.setItem('commerce_id', data.commerce_id);                
        });

        return () => {
            socket.off('commerceCreationResponse');
        };
    }, []);

    const handleHoraireChange = (index, field, value) => {
        const updatedHoraires = [...horaire];
        updatedHoraires[index][field] = value;
        setHoraire(updatedHoraires);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (!nom || !siret || !secteur_activite || !fixe || !numero || !rue || !cp || !ville || !livraison || !horaire) {
            setMessage('Remplissez tous les champs');
            return;
        }

        const user_id = localStorage.getItem('id');
        
        try {
            const imageBlobs = await Promise.all(images.map((file) => file.arrayBuffer()));
            socket.emit('commerceCreation', {
                nom, siret, secteur_activite, fixe, slug, description, livraison, lien, horaire, 
                numero, rue, cp, ville, telephone, user_id, imageBlobs
            });
        } catch (error) {
            console.error('Erreur lors de la conversion des images en ArrayBuffer:', error);
            setMessage('Erreur lors de la préparation des images');
        }
    };

    return (
     <div>
        <h2> Formulaire création commerce</h2>
        <form onSubmit={handleSubmit}>
         <fieldset>
            <legend>Informations</legend>
            <label> Nom : </label>
            <input type="text" placeholder="Nom" value={nom} onChange={(e) => setNom(e.target.value)} />
            
            <label> Numéro SIRET : </label>
            <input type="text" placeholder="Numéro SIRET" value={siret} onChange={(e) => setSiret(e.target.value)} />
            
            <label> Numéro de Téléphone : </label>
            <input type="text" placeholder="Numéro de Téléphone" value={telephone} onChange={(e) => setTelephone(e.target.value)} />
            
            <br />

            <label> Choisissez votre secteur d'activité : </label>
            <select value={secteur_activite} onChange={(e) => setSecteurActivite(e.target.value)}>
                <option value="">Sélectionnez un secteur d'activité</option>
                <option value="alimentaire">Alimentaire</option>
                <option value="informatique">Informatique</option>
                <option value="service">Service</option>
                <option value="mode">Mode</option>
            </select>
            
            <label> Le Commerce est-il nomade ? : </label>
            <select value={fixe} onChange={(e) => setFixe(e.target.value)}>
                <option value="">Sélectionnez une option</option>
                <option value="0">Oui</option>
                <option value="1">Non</option>
            </select>

            <br />

            <label> Petite description du commerce : </label>
            <textarea
                placeholder="Petite description (50 caractères max)"
                value={slug}
                onChange={(e) => setSlug(e.target.value)}
                rows="3"
                maxLength="50"
            />
            
            <br />

            <label> Décrivez en détail les activités de votre commerce : </label>
            <textarea
                placeholder="Description "
                value={description}
                onChange={(e) => setDescription(e.target.value)}
                rows="20"
                maxLength="500"
            />

            <br />

            <label> Numéro : </label>
            <input type="text" placeholder="Numéro" value={numero} onChange={(e) => setNumero(e.target.value)} />

            <label> Rue : </label>
            <input type="text" placeholder="Rue" value={rue} onChange={(e) => setRue(e.target.value)} />
            
            <label> Code postal : </label>
            <input type="text" placeholder="Code Postal" value={cp} onChange={(e) => setCp(e.target.value)} />

            <label> Ville : </label>
            <input type="text" placeholder="Ville" value={ville} onChange={(e) => setVille(e.target.value)} />

            <br />

            <label> Assurez-vous la livraison des produits ou services à domicile ? : </label>
            <select value={livraison} onChange={(e) => setLivraison(e.target.value)}>
                <option value="">Sélectionnez une option</option>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>

            <br />

            <label> Lien vers votre site internet : </label>
            <input type="text" placeholder="Lien" value={lien} onChange={(e) => setLien(e.target.value)} />
         </fieldset>

         <br />

         <fieldset>
            <legend>Horaires</legend>
            {horaire.map((horaire, index) => (
                <div key={index}>
                    <input
                        type="text"
                        value={horaire.jour}
                        placeholder="Jour"
                        readOnly
                    />
                    <input
                        type="time"
                        value={horaire.ouverture}
                        onChange={(e) => handleHoraireChange(index, "ouverture", e.target.value)}
                    />
                    <input
                        type="time"
                        value={horaire.fermeture}
                        onChange={(e) => handleHoraireChange(index, "fermeture", e.target.value)}
                    />
                </div>
            ))}
         </fieldset>

         <br />

            <ImagesForm setImages={setImages} images={images} /> 
         <br />
            <button type="submit">Créer le commerce</button>

            {message && <p>{message}</p>}
        </form>
     </div>
    );
};

export default CommerceForm;
