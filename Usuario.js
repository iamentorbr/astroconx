
const mongoose = require('mongoose');

const usuarioSchema = new mongoose.Schema({
  nome: String,
  email: String,
  whatsapp: String,
  senha: String
});

module.exports = mongoose.model('Usuario', usuarioSchema);
