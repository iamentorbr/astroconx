const express = require('express');
const router = express.Router();
const Usuario = require('../models/Usuario');

router.post('/', async (req, res) => {
  try {
    const novoUsuario = new Usuario(req.body);
    const salvo = await novoUsuario.save();
    res.status(201).json(salvo);
  } catch (err) {
    res.status(400).json({ erro: err.message });
  }
});

module.exports = router;