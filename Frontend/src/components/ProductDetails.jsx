import React, { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import { Button, Card } from "react-bootstrap";
import axios from "axios";

const ProductDetails = () => {
  const { id } = useParams();
  const [product, setProduct] = useState(null);
  const [quantity, setQuantity] = useState(1);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!id) {
      setError("L'ID du produit est manquant.");
      return;
    }

    axios
      .get(`http://127.0.0.1:8000/api/products/${id}`, {
        headers: {
          "Content-Type": "application/json",
        },
        withCredentials: true,
      })
      .then((response) => {
        setProduct(response.data);
      })
      .catch((error) => {
        console.error("Erreur:", error);
        setError("Le produit n'a pas pu être récupéré.");
      })
      .finally(() => setLoading(false));
  }, [id]);

  const handleAddToCart = () => {
    if (!product) return;

    // Vérifier si la quantité demandée est disponible
    if (quantity > product.quantity) {
      alert("La quantité demandée est supérieure à la quantité disponible.");
      return;
    }

    // Affichage de popup l'alerte ( en cours attendant la table panier)
    alert(`Produit ajouté au panier: ${product.titre}, Quantité: ${quantity}`);

    // Réinitialisation de la quantité
    setQuantity(1);
  };

  // Message erreur 
  if (loading) return <p>Chargement...</p>;
  if (error) return <p className="text-danger">{error}</p>;
  if (!product) return <p className="text-warning">Aucun produit trouvé.</p>;

  return (
    <div
      style={{
        backgroundImage: `url("/images/background-product.webp"), url("/images/background-product.webp")`,
        backgroundSize: "cover",
        backgroundPosition: "center",
        backgroundAttachment: "fixed",
        height: "100vh",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        padding: "0 15px",
      }}
    >
      <Card
        className="d-flex flex-row shadow-lg rounded"
        style={{
          maxWidth: "920px",
          width: "100%",
          backgroundColor: "white",
          padding: "20px",
          boxSizing: "border-box",
        }}
      >
        {/* Conteneur pour l'image */}
        <div
          className="col-md-5 d-flex justify-content-center align-items-center"
          style={{
            padding: "0",
            borderRight: "1px solid black",
            height: "auto",
            marginRight: "20px", 
          }}
        >
          <img
            src={`/images/${product.imageUrl}`}
            alt={product.titre}
            className="img-fluid"
            style={{
              width: "100%", 
              height: "250px", 
              objectFit: "contain", 
            }}
          />
        </div>

        {/* Conteneur pour le texte */}
        <div className="col-md-7 d-flex flex-column">
          <Card.Body>
            <Card.Title>{product.titre}</Card.Title>
            <Card.Text>
              <strong>Prix:</strong> {product.prix} €
            </Card.Text>
            <Card.Text>
              <strong>Description :</strong>
            </Card.Text>
            <Card.Text>{product.description}</Card.Text>
            <Card.Text>
              <strong>Quantité disponible:</strong> {product.quantity}
            </Card.Text>

            <div className="mb-3">
              <label htmlFor="quantity" className="form-label">
                Quantité:
              </label>
              <input
                type="number"
                id="quantity"
                value={quantity}
                onChange={(e) => {
                  let value = Number(e.target.value);
                  if (value < 1) value = 1;
                  if (value > product.quantity) value = product.quantity;
                  setQuantity(value);
                }}
                min="1"
                max={product.quantity}
                className="form-control"
              />
            </div>
         {/* Fin */}

          {/* Button Ajouter au panier */}
            <div className="d-flex justify-content-between">
              <Button
                variant="secondary"
                onClick={handleAddToCart} 
                style={{
                  borderRadius: "15px",
                  padding: "10px 20px",
                  width: "100%",
                  marginTop: "20px",
                }}
                onMouseEnter={(e) => {
                  e.target.style.borderColor = "blue";
                }}
                onMouseLeave={(e) => {
                  e.target.style.borderColor = "gray";
                }}
              >
                Ajouter au panier
              </Button>
            </div>
             {/* fin button */}

       {/* fin de page */}
          </Card.Body>
        </div>
      </Card>
    </div>
  );
};

export default ProductDetails;
