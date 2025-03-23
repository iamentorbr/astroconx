require('dotenv').config();
const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

// Conectar ao MongoDB Atlas
mongoose.connect(process.env.MONGO_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
})
.then(() => console.log('🛸 Conectado ao MongoDB!'))
.catch((err) => console.error('Erro ao conectar ao MongoDB:', err));

// Modelo do cadastro
const Cadastro = mongoose.model('Cadastro', new mongoose.Schema({
  nome: String,
  email: String,
  whatsapp: String,
  sol: String,
  lua: String,
  ascendente: String,
  venus: String,
  marte: String,
  mercurio: String,
  saturno: String,
  mc: String
}, { timestamps: true }));

// Rota de recebimento
app.post('/api/cadastro', async (req, res) => {
  try {
    const novoCadastro = new Cadastro(req.body);
    const salvo = await novoCadastro.save();
    res.status(201).json({ mensagem: 'Cadastro salvo com sucesso!', dados: salvo });
  } catch (error) {
    console.error(error);
    res.status(500).json({ erro: 'Erro ao salvar cadastro.' });
  }
});

// Iniciar servidor
const PORT = process.env.PORT || 3001;
app.listen(PORT, () => console.log(`🚀 Servidor rodando na porta ${PORT}`));