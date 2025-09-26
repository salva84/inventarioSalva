# Desarrollo Local - Inventario Salva

## Configuración del Entorno Local

### Prerrequisitos
- PHP 8.4+ (instalado via Homebrew)
- MySQL 9.4+ (instalado via Homebrew)

### Inicio Rápido

1. **Iniciar MySQL:**
   ```bash
   brew services start mysql
   ```

2. **Iniciar el servidor PHP:**
   ```bash
   ./start-local.sh
   ```
   
   O manualmente:
   ```bash
   php -S localhost:8000
   ```

3. **Acceder a la aplicación:**
   - URL: http://localhost:8000
   - Usuario: `admin`
   - Contraseña: `admin123`

### Ventajas del Desarrollo Local

✅ **Más rápido**: Sin contenedores Docker  
✅ **Cambios inmediatos**: Los archivos se reflejan al instante  
✅ **Debugging fácil**: Errores PHP visibles directamente  
✅ **Menos recursos**: No consume memoria de Docker  

### Comandos Útiles

```bash
# Verificar que MySQL esté ejecutándose
brew services list | grep mysql

# Reiniciar MySQL si es necesario
brew services restart mysql

# Ver logs de PHP (si hay errores)
tail -f /opt/homebrew/var/log/php-fpm.log
```

### Estructura de Base de Datos

La base de datos `inventory_new` se inicializa automáticamente con:
- Tabla `users` (usuario admin por defecto)
- Tabla `consoles` 
- Tabla `videogames`
- Tabla `genres`
- Datos de ejemplo

### Desarrollo

Para hacer cambios:
1. Edita los archivos PHP directamente
2. Recarga la página en el navegador
3. Los cambios se reflejan inmediatamente

### Troubleshooting

**Error de conexión a MySQL:**
```bash
brew services restart mysql
```

**Error de permisos:**
```bash
chmod -R 755 uploads/
```

**Limpiar caché PHP:**
```bash
php -r "opcache_reset();"
```
