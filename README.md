# Características

Proyecto Laravel 10 + vue3

- ✅ Laravel 10
- ✅ Vue 3
- ✅ VueRouter + Vuex
- ✅ Iniciar sesión
- ✅ Restablecimiento de contraseña
- ✅ Login
- ✅ Panel de administración
- ✅ Gestión de perfiles
- ✅ Gestión de usuarios
- ✅ Gestión de roles
- ✅ Gestión de permisos
- ✅ Cambio de contraseña
- ✅ Gestión de Posts
- ✅ Blog de Frontend
- ✅ Boostrap 5


## Como usar
### Clonar Repositorio 

```bash
git clone https://github.com/isaacmskk/futsim/
```

### Instalar vía Composer

```bash
composer install
```

### Copiar el fichero .env.example  a .env edita las credenciales y la url
Cambios:
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=futsim
DB_USERNAME=root
DB_PASSWORD=

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
