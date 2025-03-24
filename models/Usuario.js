const mongoose = require('mongoose');

const usuarioSchema = new mongoose.Schema({
  nome: String,
  email: String,
  whatsapp: String,
  senha: String,
  sol: String,
  lua: String,
  ascendente: String,
  venus: String,
  marte: String,
  mercurio: String,
  saturno: String,
  meioDoCeu: String
});

module.exports = mongoose.model('Usuario', usuarioSchema);