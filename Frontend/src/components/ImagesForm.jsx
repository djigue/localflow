import { useState } from "react";

const ImageForm = ({setImages, images}) => {
  const [mainImage, setMainImage] = useState(null);
  const [message, setMessage] = useState("");

  const handleImageChange = (e) => {
    const newImages = Array.from(e.target.files);
    setImages((prevImages) => {
      const updatedImages = [...prevImages, ...newImages];
      return updatedImages;  
    });
  };

  const removeImage = (index) => {
    setImages(images.filter((_, i) => i !== index));
};

  const handleMainImageChange = (image) => {
    setMainImage(image);
  };

  return (
    <div>
     <fieldset>
      <legend>Images</legend>
      <input type="file" multiple onChange={handleImageChange} />
      <div>
        {images.map((image, index) => (
          <div key={index}>
            <span>{images.name}</span>
            <button type="button" onClick={() => removeImage(index)}> Supprimer</button>
            <button type="button" onClick={() => handleMainImageChange(image)}>
              Définir comme image principale
            </button>
          </div>
        ))}
        
      </div>
     </fieldset>
    </div>
  );
}

export default ImageForm;
