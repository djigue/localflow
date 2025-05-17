import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import MarchantPage from './Pages/MarchantPage'; 
import ProductDetails from './components/ProductDetails'; 
import ConnexionPage from './Pages/ConnexionPage';  
import InscriptionPage from './Pages/inscriptionPage';  
import 'bootstrap/dist/css/bootstrap.min.css';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<MarchantPage />} /> 
        <Route path="/produit-detail/:id" element={<ProductDetails />} /> 
        <Route path="/login" element={<ConnexionPage />} />  
        <Route path="/register" element={<InscriptionPage />} />  
      </Routes>
    </Router>
  );
}

export default App;
