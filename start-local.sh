#!/bin/bash

# Script para iniciar el servidor PHP local
echo "🚀 Iniciando servidor PHP local..."
echo "📱 Aplicación disponible en: http://localhost:8000"
echo "🔧 Para detener el servidor: Ctrl+C"
echo ""

# Verificar que MySQL esté ejecutándose
if ! pgrep -x "mysqld" > /dev/null; then
    echo "⚠️  MySQL no está ejecutándose. Iniciando MySQL..."
    brew services start mysql
    sleep 2
fi

# Iniciar servidor PHP
php -S localhost:8000
