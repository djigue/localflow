import { useState, useEffect } from "react";
import socket from '../socket';

const BarreRecherche = () => {   
  const [query, setQuery] = useState("");   
  const [results, setResults] = useState([]);   

  useEffect(() => { 
    if (!socket) return;
    
    socket.on("rechercheReponse", (data) => { 
        setResults(data);     
    });     
    
    return () => socket.off("rechercheReponse");
  }, [socket]);
  
  const handleSearch = (e) => {     
    setQuery(e.target.value);     
    if (e.target.value.length > 2) {       
      socket.emit("recherche", e.target.value);
    } else {       
      setResults([]);
    }   
};   

  return (     
    <div>       
      <input         
        type="text"         
        value={query}         
        onChange={handleSearch}         
        placeholder="Rechercher..."       
      />       
      {results.length > 0 && (         
        <ul>           
          {results.map((item, index) => (             
            <li key={index}>               
              {item.nom} ({item.type})             
            </li>           
          ))}         
        </ul>       
        )}     
    </div>   
  ); 
}; 

export default BarreRecherche;
