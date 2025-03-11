import React, { useState, useRef, useEffect } from 'react';
import CardArticle from '../components/CardArticle';
/* import Valider from '../components/bouton/Valider';
import Add from '../components/bouton/Add';
import VoirPlus from '../components/bouton/VoirPlus'; */

const PageAcceuilVisiteur = () => {
    const articles = [
        { id: 1, imageUrl: 'https://picsum.photos/200/200?random=1', title: 'Tomate', price: '10€', categories: ['evenements', 'dernier'] },
        { id: 2, imageUrl: 'https://picsum.photos/200/200?random=2', title: 'Pomme', price: '15€', categories: ['vedette'] },
        { id: 3, imageUrl: 'https://picsum.photos/200/200?random=3', title: 'Orange', price: '20€', categories: ['dernier', 'promotions'] },
        { id: 4, imageUrl: 'https://picsum.photos/200/200?random=4', title: 'Bananes', price: '25€', categories: ['promotions'] },
    ];

    const categories = [
        { key: 'vedette', label: 'Les articles en vedette' },
        { key: 'dernier', label: 'Les derniers articles' },
        { key: 'evenements', label: 'Evénements' },
        { key: 'promotions', label: 'Promotions' },
    ];

    const [searchTerm, setSearchTerm] = useState('');
    const [suggestions, setSuggestions] = useState({ articles: [], categories: [] });
    const [showSuggestions, setShowSuggestions] = useState(false); // Etat pour afficher/masquer les suggestions
    const suggestionsRef = useRef(null); // Référence à la boîte de suggestions

    // Fonction de filtrage des articles par titre et par catégorie
    const filterArticles = (term) => {
        if (!term) return articles; // Si pas de recherche, retourner tous les articles

        return articles.filter(article => 
            article.title.toLowerCase().includes(term.toLowerCase()) || // Recherche par titre
            article.categories.some(category => category.toLowerCase().includes(term.toLowerCase())) // Recherche par catégorie
        );
    };

    // Fonction de filtrage des catégories en fonction du terme de recherche
    const filterCategories = (term) => {
        if (!term) return categories; // Si pas de recherche, retourner toutes les catégories

        return categories.filter(category =>
            category.label.toLowerCase().includes(term.toLowerCase()) // Recherche par nom de catégorie
        );
    };

    // Fonction pour gérer le changement dans la recherche
    const handleSearchChange = (e) => {
        const term = e.target.value;
        setSearchTerm(term);

        const filteredArticles = filterArticles(term);
        const filteredCategories = filterCategories(term);

        setSuggestions({
            articles: filteredArticles,
            categories: filteredCategories
        });
        setShowSuggestions(true); // Afficher les suggestions quand l'utilisateur tape dans la barre de recherche
    };

    // Fonction pour sélectionner une suggestion et effectuer la recherche
    const handleSuggestionClick = (term) => {
        setSearchTerm(term); // Met à jour le terme de recherche avec le terme cliqué
        const filteredArticles = filterArticles(term); // Filtrer les articles selon le terme
        const filteredCategories = filterCategories(term); // Filtrer les catégories selon le terme
        setSuggestions({
            articles: filteredArticles,
            categories: filteredCategories
        });
        setShowSuggestions(false); // Masquer les suggestions après avoir sélectionné une suggestion
    };

    // Fonction pour fermer les suggestions lorsque l'on clique ailleurs
    const handleClickOutside = (e) => {
        if (suggestionsRef.current && !suggestionsRef.current.contains(e.target)) {
            // Fermer uniquement les suggestions, sans toucher au champ de recherche
            setShowSuggestions(false);
        }
    };

    // Utiliser useEffect pour écouter les clics à l'extérieur de la boîte de suggestions
    useEffect(() => {
        // Ajouter l'écouteur d'événements
        document.addEventListener('mousedown', handleClickOutside);

        // Nettoyage de l'écouteur d'événements lorsque le composant est démonté
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    // Articles et catégories filtrées selon le terme de recherche
    const { articles: filteredArticles, categories: filteredCategories } = suggestions;

    return (
        <div className="container my-5">
            <h2 className="text-center">Bienvenue sur la page d'accueil visiteur</h2>

            {/* Champ de recherche avec suggestions */}
            <div className="mt-4 p-4 w-25">
                <input 
                    type="text" 
                    className="form-control" 
                    placeholder="Rechercher par titre ou catégorie..." 
                    value={searchTerm} 
                    onChange={handleSearchChange} 
                    onFocus={() => setShowSuggestions(true)} // Afficher les suggestions quand on clique dans la barre de recherche
                />
                {showSuggestions && searchTerm && (
                    <div ref={suggestionsRef} className="suggestions-box mt-3">
                        <h5>Suggestions d'articles :</h5>
                        {filteredArticles.length > 0 ? (
                            filteredArticles.map(article => (
                                <div 
                                    key={article.id} 
                                    className="suggestion-item" 
                                    onClick={() => handleSuggestionClick(article.title)} // Met à jour la recherche avec l'article
                                >
                                    {article.title}
                                </div>
                            ))
                        ) : (
                            <div>Aucun article trouvé</div>
                        )}
                        <h5>Suggestions de catégories :</h5>
                        {filteredCategories.length > 0 ? (
                            filteredCategories.map(category => (
                                <div 
                                    key={category.key} 
                                    className="suggestion-item" 
                                    onClick={() => handleSuggestionClick(category.label)} // Met à jour la recherche avec la catégorie
                                >
                                    {category.label}
                                </div>
                            ))
                        ) : (
                            <div>Aucune catégorie trouvée</div>
                        )}
                    </div>
                )}
            </div>

            <section className="row my-5">
                {/* Si le terme de recherche est vide, on affiche tous les articles et catégories */}
                {(searchTerm ? filteredArticles.length > 0 : true) && filteredCategories.length > 0 ? (
                    filteredCategories.map(({ key, label }) => (
                        <article key={key} className="col-12 mb-4">
                            <h3>{label} :</h3>
                            <div className="d-flex flex-row gap-3">
                                {/* Affichage des articles filtrés par catégorie */}
                                <CardArticle articles={filteredArticles.filter(article => article.categories.includes(key))} />
                            </div>
                        </article>
                    ))
                ) : (
                    // Si aucun article trouvé, afficher la page d'accueil complète avec toutes les catégories
                    <>
                        <article className="col-12 mb-4">
                            <h3>Les articles en vedette :</h3>
                            <div className="d-flex flex-row gap-3">
                                <CardArticle articles={articles.filter(article => article.categories.includes('vedette'))} />
                            </div>
                        </article>

                        <article className="col-12 mb-4">
                            <h3>Les derniers articles :</h3>
                            <div className="d-flex flex-row gap-3">
                                <CardArticle articles={articles.filter(article => article.categories.includes('dernier'))} />
                            </div>
                        </article>

                        <article className="col-12 mb-4">
                            <h3>Événements :</h3>
                            <div className="d-flex flex-row gap-3">
                                <CardArticle articles={articles.filter(article => article.categories.includes('evenement'))} />
                            </div>
                        </article>

                        <article className="col-12 mb-4">
                            <h3>Promotions :</h3>
                            <div className="d-flex flex-row gap-3">
                                <CardArticle articles={articles.filter(article => article.categories.includes('promotions'))} />
                            </div>
                        </article>
                    </>
                )}
            </section>

            {/* Section des boutons (facultatif) */}
            {/* <section className="text-center my-5">
                <h2>Différents boutons :</h2>
                <div className="d-flex justify-content-center gap-3">
                    <Valider />
                    <Add />
                    <VoirPlus />
                </div>
            </section> */}
        </div>
    );
};

export default PageAcceuilVisiteur;
