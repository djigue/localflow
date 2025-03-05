import { useState, useEffect } from "react";
import socket from '../socket';
import ImagesForm from './ImagesForm';
 
function ProduitForm() {
  const [type, setType] = useState("produit");
  const [images, setImages] = useState([]);
  const [message, setMessage] = useState('');
  const [nom, setNom] = useState('');
  const [slug, setSlug] = useState('');
  const [description, setDescription] = useState('');
  const [prix, setPrix] = useState('');
  const [quantite, setQuantite] = useState('');
  const [alerte, setAlerte] = useState('');
  const [taille, setTaille] = useState('');
  const [formatPrix, setFormatPrix] = useState('');
  const [duree, setDuree] = useState('15');
  const [reservation, setReservation] = useState('');
 
  const handleTypeChange = (e) => {
    const selectedType = e.target.value;
    setType(selectedType);
   
    setDonneesFormulaire({
      nom: "",
      slug: "",
      description: "",
      prix: 0,
      quantite: selectedType === "produit" ? 0 : undefined,
      alerte: selectedType === "produit" ? 0 : undefined,
      taille: selectedType === "produit" ? "M" : undefined,
      formatPrix: selectedType === "produit" ? "unité" : undefined,
      duree: selectedType === "service" ? 15 : undefined,
      reservation: selectedType === "service" ? "" : undefined,
    });
  };

  useEffect(() => {
    socket.on('produitCreationReponse', (data) => {
        setMessage(data.success ? 'Le produit a bien été créé !' : 'Erreur : ' + data.message);                           
    });

    return () => {
        socket.off('produitCreationResponse');
    };
}, []);
 
  const handleSubmit = async (e) => {
    e.preventDefault();
    console.log('Type : ', type)
    if(type === 'produit') {

    // if (!nom || !prix || !quantite || !alerte || !formatPrix) {
    //     setMessage('Remplissez tous les champs');
    //     return;
    // }

    const user_id = localStorage.getItem('id');
    const commerce_id = localStorage.getItem('commerce_id');
    
    try {
        const imageBlobs = images.length > 0
          ? await Promise.all(images.map((file) => file.arrayBuffer())): [];
        socket.emit('produitCreation', {
            nom, slug, description, quantite, alerte, prix, formatPrix, taille, commerce_id, user_id, imageBlobs
        });
    } catch (error) {
        console.error('Erreur lors de la conversion des images en ArrayBuffer:', error);
        setMessage('Erreur lors de la préparation des images');
    }
   }

  
   if(type === 'service') {

    if (!nom || !prix) {
        setMessage('Remplissez tous les champs');
        return;
    }

    const commerce_id = localStorage.getItem('commerce_id');
    
    try {
        const imageBlobs = await Promise.all(images.map((file) => file.arrayBuffer()));
        socket.emit('serviceCreation', {
            nom, slug, description, prix, duree, reservation, commerce_id, imageBlobs
        });
    } catch (error) {
        console.error('Erreur lors de la conversion des images en ArrayBuffer:', error);
        setMessage('Erreur lors de la préparation des images');
    }
   }
};
 
  return (
    <div className="container mt-4">
      <div className="card p-4 shadow">
      <h2> Formulaire création Produit/Service</h2>
        <form onSubmit={handleSubmit}>
          <div className="mb-3">
            <label className="form-label">Type :</label>
            <select className="form-select" value={type} onChange={(e) => setType(e.target.value)}>
              <option value="produit">Produit</option>
              <option value="service">Service</option>
            </select>
          </div>
 
          <div className="mb-3">
            <label className="form-label">Nom :</label>
            <input type="text" name="nom" className="form-control" value={nom} onChange={(e) => setNom(e.target.value)} required />
          </div>
 
          <div className="mb-3">
            <label className="form-label">Description :</label>
            <textarea name="description" className="form-control" value={description} onChange={(e) => setDescription(e.target.value)} required />
          </div>
 
          <div className="mb-3">
            <label className="form-label">Slug :</label>
            <input type="text" name="slug" className="form-control" value={slug} onChange={(e) => setSlug(e.target.value)} />
          </div>
 
          <div className="mb-3">
            <label className="form-label">Prix :</label>
            <input type="number" name="prix" className="form-control" value={prix} onChange={(e) => setPrix(e.target.value)} required />
          </div>
 
          {type === "produit" && (
            <>
              <div className="mb-3">
                <label className="form-label">Quantité :</label>
                <input type="number" name="quantite" className="form-control" value={quantite} onChange={(e) => setQuantite(e.target.value)} required />
              </div>
 
              <div className="mb-3">
                <label className="form-label">Alerte :</label>
                <input type="number" name="alerte" className="form-control" value={alerte} onChange={(e) => setAlerte(e.target.value)} />
              </div>
 
              <div className="mb-3">
                <label className="form-label">Taille :</label>
                <select name="taille" className="form-select" value={taille} onChange={(e) => setTaille(e.target.value)}>
                  <option value="0">Pas de taille</option>
                  <option value="xxs">XXS</option>
                  <option value="xs">XS</option>
                  <option value="s">S</option>
                  <option value="m">M</option>
                  <option value="l">L</option>
                  <option value="xl">XL</option>
                  <option value="xxl">XXL</option>
                  <option value="xxxl">XXXL</option>
                </select>
              </div>
 
              <div className="mb-3">
                <label className="form-label">Format Prix :</label>
                <select name="formatPrix" className="form-select" value={formatPrix} onChange={(e) => setFormatPrix(e.target.value)}>
                  <option value="euros">Unité</option>
                  <option value="euros/kilo">Kilo</option>
                </select>
              </div>
            </>
          )}
 
          {type === "service" && (
            <>
              <div className="mb-3">
                <label className="form-label">Durée :</label>
                <select name="duree" className="form-select" value={duree} onChange={(e) => setDuree(e.target.value)}>
                  {Array.from({ length: 8 }, (_, i) => (i + 1) * 15).map((value) => (
                    <option key={value} value={value}>{value} min</option>
                  ))}
                </select>
              </div>
 
              <div className="mb-3">
                <label className="form-label">Réservation :</label>
                <select name="reservation" className="form-select" value={reservation} onChange={(e) => setReservation(e.target.value)}>
                  <option value="1">Oui</option>
                  <option value="0">Non</option>
                </select>
              </div>
            </>
          )}

          <ImagesForm setImages={setImages} images={images} /> 
 
          <button type="submit" className="btn btn-primary w-100">
            Ajouter {type}
          </button>
          {message && <p>{message}</p>}
        </form>
      </div>
    </div>
  );
}
 
export default ProduitForm;