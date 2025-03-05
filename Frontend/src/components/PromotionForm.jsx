import { useState, useEffect } from "react";
import socket from '../socket';
import ImagesForm from './ImagesForm';
 
function PromotionForm() {
  const [images, setImages] = useState([]);
  const [message, setMessage] = useState('');
  const [nom, setNom] = useState('');
  const [slug, setSlug] = useState('');
  const [description, setDescription] = useState('');
  const [dateDebut, setDateDebut] = useState('');
  const [dateFin, setDateFin] = useState('');
  const [reduction, setReduction] = useState('');
  const [formatReduction, setFormatReduction] = useState('%');

  useEffect(() => {
    socket.on('promotionCreationReponse', (data) => {
        setMessage(data.success ? 'La promotion a bien été créé !' : 'Erreur : ' + data.message);                           
    });

    return () => {
        socket.off('promotionCreationResponse');
    };
  }, []);
 
  const handleSubmit = async (e) => {
    e.preventDefault();

    // if (!nom || !prix || !quantite || !alerte || !formatPrix) {
    //     setMessage('Remplissez tous les champs');
    //     return;
    // }

    const commerce_id = localStorage.getItem('commerce_id');
    
    try {
        const imageBlobs = images.length > 0
          ? await Promise.all(images.map((file) => file.arrayBuffer())): [];
        socket.emit('promotionCreation', {
            nom, slug, description, dateDebut, dateFin, reduction, formatReduction, commerce_id, imageBlobs
        });
    } catch (error) {
        console.error('Erreur lors de la conversion des images en ArrayBuffer:', error);
        setMessage('Erreur lors de la préparation des images');   
    }
  };
 
  return (
    <div className="container mt-4">
      <div className="card p-4 shadow">
        <h2>Formulaire création Promotion</h2>
        <form onSubmit={handleSubmit}>
 
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
            <label className="form-label">Date de début :</label>
            <input type="date" name="dateDebut" className="form-control" value={dateDebut} onChange={(e) => setDateDebut(e.target.value)} required />
          </div>
 
              <div className="mb-3">
                <label className="form-label">Date de fin :</label>
                <input type="date" name="dateFin" className="form-control" value={dateFin} onChange={(e) => setDateFin(e.target.value)} required />
              </div>
 
              <div className="mb-3">
                <label className="form-label">Reduction :</label>
                <input type="number" name="reduction" className="form-control" value={reduction} onChange={(e) => setReduction(e.target.value)} />
              </div>
 
              <div className="mb-3">
                <label className="form-label">Format Reduction :</label>
                <select name="formatReduction" className="form-select" value={formatReduction} onChange={(e) => setFormatReduction(e.target.value)}>
                  <option value="%">%</option>
                  <option value="euro">Euros</option>
                </select>
              </div>

          <ImagesForm setImages={setImages} images={images} /> 
 
          <button type="submit" className="btn btn-primary w-100">
            Ajouter la promotion
          </button>
          {message && <p>{message}</p>}
        </form>
      </div>
    </div>
  );
}
 
export default PromotionForm;