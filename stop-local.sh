#!/bin/bash

# Script para detener el servidor PHP local
echo "🛑 Deteniendo servidor PHP local..."

# Buscar y matar el proceso de PHP
pkill -f "php -S localhost:8000"

echo "✅ Servidor PHP detenido"
echo "💡 Para reiniciar: ./start-local.sh"
