#!/bin/bash
# Démarrer le serveur Node.js en arrière-plan
node server.js &

# Démarrer React
npm run dev
