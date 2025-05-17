import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import { Card, Button } from 'react-bootstrap';

const MarchantPage = () => {
  const [products, setProducts] = useState([]);

  useEffect(() => {

    axios.get('http://127.0.0.1:8000/api/products')
      .then((response) => {
        setProducts(response.data);
      })
      .catch((error) => {
        console.error("Erreur de récupération des produits:", error);
      });
  }, []);

  return (
    <div className="container py-5">
      <h1 className="text-center">Produits du Commerçant</h1>
      <div className="row">
        {products.map((product) => (
          <div key={product.id} className="col-md-4 mb-4">
            <Card>
              <Card.Img variant="top" src={`/images/${product.imageUrl}`} />
              <Card.Body>
                <Card.Title>{product.titre}</Card.Title>
                <Card.Text>{product.description}</Card.Text>
                <Card.Text><strong>Prix:</strong> {product.prix} €</Card.Text>
                
                {/* Le lien ici pointe directement vers /produit-detail/:id */}
                <Link to={`/produit-detail/${product.id}`}>
                  <Button variant="primary">Savoir plus</Button>
                </Link>
              </Card.Body>
            </Card>
          </div>
        ))}
      </div>
    </div>
  );
};

export default MarchantPage;
