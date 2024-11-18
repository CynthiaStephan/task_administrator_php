const express = require('express');
const path = require('path');

const app = express();

// Servir les fichiers statiques (HTML, CSS, JS, etc.)
app.use(express.static(path.join(__dirname, 'public')));

// Route pour la page d'accueil
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

app.listen(3000);
