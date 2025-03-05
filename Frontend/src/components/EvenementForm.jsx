import React, { useState, useEffect } from 'react';
import socket from '../socket';
import ImagesForm from './ImagesForm';

const EvenementForm = () => {
    const [nom, setNom] = useState('');
    const [date_debut, setDateDebut] = useState('');
    const [date_fin, setDateFin] = useState('');
    const [slug, setSlug] = useState('');
    const [description, setDescription] = useState('');
    const [heure_debut, setHeureDebut] = useState('');
    const [heure_fin, setHeureFin] = useState('');
    const [inscription, setInscription] = useState('');
    const [nombre, setNombre] = useState('');
    const [numero, setNumero] = useState('');
    const [rue, setRue] = useState('');
    const [cp, setCp] = useState('');
    const [ville, setVille] = useState('');
    const [message, setMessage] = useState('');
    const [alerte, setAlerte] = useState('');
    const [images, setImages] = useState([]);

    useEffect(() => {
        socket.on('evenementCreationReponse', (data) => {
            setMessage(data.success ? 'L\'évenement a bien été créé !' : 'Erreur : ' + data.message);                           
        });

        return () => {
            socket.off('evenementCreationResponse');
        };
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (!nom || !date_debut || !date_fin|| !description || !heure_debut || !rue || !cp || !ville || !heure_fin
              || !inscription || !nombre || !alerte) {
            setMessage('Remplissez tous les champs');
            return;
        }

        const commerce_id = localStorage.getItem('commerce_id');
        
        try {
            const imageBlobs = await Promise.all(images.map((file) => file.arrayBuffer()));
            socket.emit('evenementCreation', {
                nom, date_debut, date_fin, heure_debut, heure_fin, description, inscription, nombre, alerte, 
                numero, rue, cp, ville, commerce_id, imageBlobs
            });
        } catch (error) {
            setMessage('Erreur lors de la préparation des images');
        }
    };
return (
    <div>
        <h2> Formulaire création Evenement</h2>
        <form onSubmit={handleSubmit}>
         
            <legend>Informations</legend>
            <label> Nom : </label>
            <input type="text" placeholder="Nom" value={nom} onChange={(e) => setNom(e.target.value)} />
            
            <label> Date Début : </label>
            <input type="date" placeholder="Date début" value={date_debut} onChange={(e) => setDateDebut(e.target.value)} />
            
            <label> Date fin : </label>
            <input type="date" placeholder="Date fin" value={date_fin} onChange={(e) => setDateFin(e.target.value)} />

            <label> Heure Début : </label>
            <input type="time" placeholder="Heure début" value={heure_debut} onChange={(e) => setHeureDebut(e.target.value)} />

            <label> Heure Fin : </label>
            <input type="time" placeholder="Heure fin" value={heure_fin} onChange={(e) => setHeureFin(e.target.value)} />
            
            <br />
            
            <label> L'evenement est il soumis à une inscription ? : </label>
            <select value={inscription} onChange={(e) => setInscription(e.target.value)}>
                <option value="">Sélectionnez une option</option>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>

            <label> Nombre maximum de participants : </label>
            <input type="number" placeholder="Nombre participant" value={nombre} onChange={(e) => setNombre(e.target.value)} />

            <label> Voulez vous recevoir un avertissement avant que l'événement soit complet? <br />
                    si oui renseignez a quel moment en donnant le nombre de place restante</label>
            <input type="number" placeholder="Alerte" value={alerte} onChange={(e) => setAlerte(e.target.value)} />

            <br />

            <label> Petite description de l'evenement : </label>
            <textarea
                placeholder="Petite description (50 caractères max)"
                value={slug}
                onChange={(e) => setSlug(e.target.value)}
                rows="3"
                maxLength="50"
            />

            <label> Description de l'evenement : </label>
            <textarea
                placeholder="Description (255 caractères max)"
                value={description}
                onChange={(e) => setDescription(e.target.value)}
                rows="10"
                maxLength="255"
            />

            <label> Numéro : </label>
            <input type="text" placeholder="Numéro" value={numero} onChange={(e) => setNumero(e.target.value)} />

            <label> Rue : </label>
            <input type="text" placeholder="Rue" value={rue} onChange={(e) => setRue(e.target.value)} />
            
            <label> Code postal : </label>
            <input type="text" placeholder="Code Postal" value={cp} onChange={(e) => setCp(e.target.value)} />

            <label> Ville : </label>
            <input type="text" placeholder="Ville" value={ville} onChange={(e) => setVille(e.target.value)} />

          

            <ImagesForm setImages={setImages} images={images} /> 
         <br />
            <button type="submit">Créer l'événement</button>

            {message && <p>{message}</p>}
        </form>
     </div>
    )
};

export default EvenementForm;
