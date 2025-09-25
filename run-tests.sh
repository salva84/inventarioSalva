#!/bin/bash

echo "🧪 Ejecutando tests unitarios para la aplicación de inventario..."

# Verificar que Docker esté funcionando
if ! docker-compose ps | grep -q "Up"; then
    echo "❌ Los contenedores Docker no están funcionando. Ejecuta 'docker-compose up -d' primero."
    exit 1
fi

# Instalar dependencias si no existen
echo "📦 Instalando dependencias de PHP..."
docker-compose exec web composer install

# Ejecutar tests unitarios
echo "🔬 Ejecutando tests unitarios..."
docker-compose exec web ./vendor/bin/phpunit tests/Unit/

# Ejecutar tests de integración
echo "🔗 Ejecutando tests de integración..."
docker-compose exec web ./vendor/bin/phpunit tests/Integration/

# Ejecutar todos los tests
echo "🎯 Ejecutando todos los tests..."
docker-compose exec web ./vendor/bin/phpunit

echo "✅ Tests completados!"
