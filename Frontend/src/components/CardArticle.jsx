import React, { useState } from 'react';
import Add from './bouton/Add';
import VoirPlus from './bouton/VoirPlus';

const CardArticle = ({ articles }) => {
    const [addedToCart, setAddedToCart] = useState({});

    if (!articles || articles.length === 0) {
        return <p className="text-center mt-4">Aucun article disponible.</p>;
    }

    const handleAddToCart = (articleId) => {
        setAddedToCart(prevState => ({
            ...prevState,
            [articleId]: !prevState[articleId],
        }));
    };

    const handleViewMore = (article) => {
        alert(`Voir plus de détails pour : ${article.title}`);
    };

    return (
        <div className="container mt-4">
            <div className="row g-4">
                {articles.map(article => (
                    <div key={article.id} className="col-md-4 col-lg-3">
                        <div className="card border-0 shadow-sm h-100 bg-light text-dark dark-mode">
                            <img 
                                src={article.imageUrl} 
                                className="card-img-top rounded-top" 
                                alt={`Image de ${article.title}`} 
                                style={{ height: "180px", objectFit: "cover" }}
                            />
                            <div className="card-body d-flex flex-column">
                                <h5 className="card-title">{article.title}</h5>
                                <p className="text-muted small">Slug: {article.slug}</p>
                                <p className="fw-bold text-primary">Prix : {article.price}</p>
                                <p className="text-secondary"><strong>Catégories :</strong> {article.categories.join(', ')}</p>
                                <div className="mt-auto d-flex justify-content-between">
                                    <VoirPlus onClick={() => handleViewMore(article)} />
                                    <Add onClick={() => handleAddToCart(article.id)} />
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default CardArticle;
