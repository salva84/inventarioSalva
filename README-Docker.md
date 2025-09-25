# Inventario App - Docker Setup

## Requisitos
- Docker
- Docker Compose

## Instrucciones de instalación

### 1. Construir y ejecutar los contenedores
```bash
docker-compose up --build
```

### 2. Acceder a la aplicación
- **Aplicación**: http://localhost:8080
- **Base de datos**: localhost:3306

### 3. Usuario por defecto
- **Usuario**: admin
- **Contraseña**: admin123

## Comandos útiles

### Ver logs
```bash
docker-compose logs -f
```

### Parar los contenedores
```bash
docker-compose down
```

### Parar y eliminar volúmenes (elimina datos de BD)
```bash
docker-compose down -v
```

### Acceder al contenedor de la aplicación
```bash
docker-compose exec web bash
```

### Acceder a MySQL
```bash
docker-compose exec db mysql -u root -p
```

## Estructura de la base de datos
- **users**: Usuarios del sistema
- **genres**: Géneros de videojuegos
- **consoles**: Consolas de videojuegos
- **videogames**: Videojuegos

## Características
- ✅ Sistema de autenticación
- ✅ Gestión de consolas
- ✅ Gestión de videojuegos
- ✅ Gestión de géneros
- ✅ Subida de imágenes
- ✅ Búsqueda y paginación
- ✅ Interfaz responsive con Tailwind CSS
