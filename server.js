const path = require('path');

// servir arquivos estáticos da pasta www (que é a raiz do seu projeto)
app.use(express.static(path.join(__dirname)));

// rota base (opcional, para acessar o index.html diretamente)
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});

const express = require('express');
const mongoose = require('mongoose');
const dotenv = require('dotenv');
const cors = require('cors');
const cadastroRoutes = require('./routes/cadastro');

dotenv.config();

const app = express();
app.use(cors());
app.use(express.json());

mongoose.connect(process.env.MONGODB_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
}).then(() => console.log('💜 MongoDB conectado!'))
  .catch(err => console.error('Erro ao conectar ao MongoDB:', err));

app.use('/cadastro', cadastroRoutes);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`🚀 Servidor rodando na porta ${PORT}`);
});

