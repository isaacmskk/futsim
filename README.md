# Introducción

Este fichero documenta todos los resultados de las diferentes categorías del proyecto en parejas encargado para este curso. Implementamos VUE y LARAVEL para crear una web de fútbol interactiva con los usuarios que acceden a la misma, aparte de realizar diferentes acciones programadas.

## Manual de Instalación

### Clonar Repositorio 

```bash
git clone https://github.com/isaacmskk/futsim/
```

### Instalar vía Composer

```bash
composer install
```

### Configuración del archivo .env
Copiar el fichero .env.example  a .env edita las credenciales y la url
```bash
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=futsim
DB_USERNAME=root
DB_PASSWORD=
```

### Generar Application Key

```bash
php artisan key:generate
```

### Migrar base de datos

```bash
php artisan migrate
```

### Lanzar Seeders

```bash
php artisan db:seed
```
### Creacion de un link para la media

```bash
 php artisan storage:link
```
### Instalar las dependencias de Node

```bash
npm install

npm run dev
```
### Encender los servicios de web

```bash
php artisan serve

npm run dev
```

### Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Node.js 14 o superior

### Instrucciones Adicionales de Configuración
- Configurar el servidor web para que apunte al directorio de la aplicación.
- Configurar la base de datos según las credenciales proporcionadas en el archivo .env.

### Ejecutar Pruebas
Para ejecutar las pruebas automatizadas, ejecute el siguiente comando:
```bash
php artisan test

```
### Información de Contacto
Para preguntas o comentarios sobre el proyecto, puede contactar a los autores:
- Unai Tejeda: puldgamer@gmail.com
- Isaac Montes: isaacmskk@gmail.com

### Documentación

- [Manual de usuario](https://github.com/isaacmskk/futsim/blob/main/documentos/ManualUsuario_FUTSIM_IsaacMontes-UnaiTejeda.pdf)
- Memoria final:
