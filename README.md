<div align="center">

# 🔐 Laboratorio #2 – Implementación del Login en Laravel

### Unidad I: Modelo Vista Controlador (MVC)

**Universidad Tecnológica de Panamá**
Facultad de Ingeniería en Sistemas Computacionales · Campus Víctor Levis Sasso
Desarrollo Web

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?logo=vite&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-2.10-885630?logo=composer&logoColor=white)
![Node.js](https://img.shields.io/badge/Node.js-24-339933?logo=nodedotjs&logoColor=white)

</div>

---

## 📑 Contenido

1. [Introducción y objetivo](#1--introducción-y-objetivo)
2. [Requisitos previos](#2--requisitos-previos)
3. [Instalación y flujo de comandos](#3--instalación-y-flujo-de-comandos)
4. [Base de datos](#4--base-de-datos)
5. [Resultado del laboratorio](#5--resultado-del-laboratorio)
6. [Arquitectura MVC en el proyecto](#6--arquitectura-mvc-en-el-proyecto)
7. [Dificultades y soluciones](#7--dificultades-y-soluciones)
8. [Fechas](#8--fechas)
9. [Referencias](#9--referencias)

---

## 1. 📘 Introducción y objetivo

Este laboratorio es la primera práctica con el framework **Laravel** dentro del curso de Desarrollo Web. Laravel organiza sus aplicaciones bajo el patrón **Modelo–Vista–Controlador (MVC)**, lo que separa la lógica de negocio, la presentación y el acceso a datos en capas distintas; esto facilita que un proyecto crezca de forma ordenada y que varias personas lo mantengan al mismo tiempo sin pisarse el código.

**Objetivo:** reconocer la estructura de un proyecto Laravel recién creado, entender cómo se expresa el patrón MVC en sus carpetas y archivos, e implementar un módulo funcional de **registro, inicio de sesión y cierre de sesión** apoyándome en el paquete `laravel/ui` con Bootstrap 5.

### Función de las principales carpetas (MVC)

| Parte del MVC | Carpeta / archivo | ¿Qué hace? |
|---|---|---|
| 🗂️ **Modelo** | `app/Models/` | Representa las tablas de la base de datos y expone métodos para leerlas o escribirlas (ej. `User.php`). |
| 🖼️ **Vista** | `resources/views/` | Plantillas Blade con el HTML que ve el usuario (ej. `auth/login.blade.php`). |
| 🧠 **Controlador** | `app/Http/Controllers/` | Recibe la petición, aplica la lógica y entrega una vista como respuesta (ej. `LoginController`). |
| 🧭 **Rutas** | `routes/web.php` | Conecta cada URL con el método de controlador que la maneja. |
| 🧱 **Migraciones** | `database/migrations/` | Describen en PHP la estructura de las tablas de la base de datos. |
| ⚙️ **Configuración** | `.env` y `config/` | Credenciales de la base de datos y parámetros globales de la aplicación. |

**Flujo de una petición de login:** el usuario abre `/login` → la **ruta** `GET /login` apunta a `Auth\LoginController@showLoginForm` → el **controlador** devuelve la **vista** `login.blade.php` → el usuario envía el formulario como `POST /login` → el controlador consulta al **modelo** `User` para validar el correo y la contraseña hasheada → si coinciden, inicia sesión y redirige al **home**.

---

## 2. 🧰 Requisitos previos

### Ecosistema de desarrollo

| Tecnología | Detalle | Versión utilizada |
|---|---|---|
| ![Windows](https://img.shields.io/badge/Windows-0078D6?logo=windows&logoColor=white) | **Sistema operativo** | Windows (64 bits) |
| ![WAMP](https://img.shields.io/badge/WampServer-Apache%20%7C%20MySQL%20%7C%20PHP-F7931E) | **Entorno de desarrollo local** (servidor web Apache + MySQL) | WampServer 3.4.0 (64 bits) |
| ![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white) | Lenguaje del backend (con variables de entorno configuradas) | 8.4.15 |
| ![Composer](https://img.shields.io/badge/Composer-885630?logo=composer&logoColor=white) | Gestor de dependencias de PHP | 2.10.3 |
| ![Laravel](https://img.shields.io/badge/Laravel%20Installer-FF2D20?logo=laravel&logoColor=white) | Instalador de Laravel (`laravel new`) | 5.32.0 |
| ![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white) | Base de datos (motor InnoDB) | 8.4.7 |
| ![Node.js](https://img.shields.io/badge/Node.js-339933?logo=nodedotjs&logoColor=white) | Necesario para compilar los assets con Vite | 24.21.0 |
| ![npm](https://img.shields.io/badge/npm-CB3837?logo=npm&logoColor=white) | Gestor de paquetes de Node | 11.19.0 |
| ![VS Code](https://img.shields.io/badge/VS%20Code-007ACC?logo=visualstudiocode&logoColor=white) | Editor de código | Visual Studio Code |
| ![phpMyAdmin](https://img.shields.io/badge/phpMyAdmin-6C78AF?logo=phpmyadmin&logoColor=white) | Administración de la base de datos | 5.2.3 (incluido en WAMP) |

> **Nota:** WampServer debe mostrar su ícono en **verde** (Apache y MySQL en ejecución) antes de comenzar; con naranja o rojo algún servicio no arrancó y el proyecto no responderá.

### Verificación de versiones

```bash
php -v
composer -V
node -v
npm -v
```

![Versiones instaladas](capturas/01-versiones.png)

### Motor de almacenamiento InnoDB

El motor por defecto de MySQL en mi instalación venía como **MyISAM**, por lo que lo cambié a InnoDB editando el `my.ini` de WAMP (ver sección [Dificultades y soluciones](#7--dificultades-y-soluciones)). Para verificarlo basta con ejecutar en phpMyAdmin:

```sql
SHOW VARIABLES LIKE 'default_storage_engine';
```

![Motor InnoDB](capturas/02-innodb.png)

### Instalador de Laravel

```bash
composer global require laravel/installer
laravel --version
```

![Laravel Installer](capturas/03-instalador-laravel.png)

---

## 3. 💻 Instalación y flujo de comandos

### 3.1 Crear el proyecto (dentro de `C:\wamp64\www`)

```bash
cd C:\wamp64\www
laravel new LoginLaravel
cd LoginLaravel
```

En el asistente del instalador respondí: **starter kit = no**, **frontend stack = Blade**.

> **Alternativa sin el instalador:** `composer create-project laravel/laravel LoginLaravel`

Al abrir la carpeta del proyecto en VS Code se observa la estructura típica de un Laravel recién creado, con sus carpetas `app/`, `resources/`, `routes/`, `database/`, `config/`, entre otras:

![Estructura del proyecto](capturas/05-estructura-proyecto.png)

### 3.2 Dependencias y archivo `.env`

Si se clona este repositorio en otra máquina, los pasos para dejarlo funcional son:

```bash
composer install
copy .env.example .env
php artisan key:generate
npm install
```

### 3.3 Paquete de autenticación: `laravel/ui`

```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install
composer run dev
```

| Comando | Función |
|---|---|
| `composer require laravel/ui` | Agrega el paquete oficial de scaffolding de autenticación. |
| `php artisan ui bootstrap --auth` | Genera Bootstrap más las vistas, controladores y rutas de login, registro y recuperación de contraseña. |
| `npm install` | Instala las dependencias de Node (Bootstrap, Vite, Sass, Axios). |
| `composer run dev` | Levanta a la vez el servidor de Laravel, el worker de la cola y el dev server de Vite (asset bundling). |

> **Alternativa documentada en la guía (no utilizada):** Laravel Breeze
> ```bash
> composer require laravel/breeze --dev
> php artisan breeze:install
> ```

---

## 4. 🗄️ Base de datos

### 4.1 Entorno

- **Motor:** MySQL 8.4.7 (InnoDB) administrado con phpMyAdmin 5.2.3.
- **Base de datos:** `loginlaravel` (cotejamiento `utf8mb4_unicode_ci`).
- **Usuario:** `root` sin contraseña (configuración por defecto de WAMP).

La vista desde phpMyAdmin con todas las tablas del esquema y su motor confirmado como **InnoDB**:

![Base de datos en phpMyAdmin](capturas/06-base-datos-phpmyadmin.png)

### 4.2 Configuración del `.env`

Laravel lee las credenciales de la base de datos desde el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loginlaravel
DB_USERNAME=root
DB_PASSWORD=
```

![Archivo .env](capturas/07-env.png)

Después de editar el `.env` conviene limpiar la caché de configuración para que Laravel reciba los cambios:

```bash
php artisan config:clear
```

### 4.3 Migraciones

Las **migraciones** son archivos PHP dentro de `database/migrations/` que describen cómo crear, modificar o eliminar tablas de manera controlada. El método `up()` describe la creación y `down()` la reversión. Laravel registra en su propia tabla `migrations` cuáles ya corrieron, para no repetirlas.

```bash
php artisan migrate
```

Las 9 tablas quedan listas con motor **InnoDB** y cotejamiento `utf8mb4_unicode_ci`:

![Tablas creadas](capturas/09-tablas-innodb.png)

Otros comandos útiles de migraciones:

```bash
php artisan migrate:status     # ver qué migraciones corrieron
php artisan migrate:rollback   # revertir la última tanda
```

### 4.4 Respaldo (backup) de la base de datos

Para generar un respaldo desde phpMyAdmin: seleccionar la base `loginlaravel` → pestaña **Exportar** → método *Rápido*, formato *SQL* → **Exportar**.

Desde terminal:

```bash
C:\wamp64\bin\mysql\mysql8.4.7\bin\mysqldump.exe -u root --result-file=database/backup/loginlaravel.sql loginlaravel
```

Para restaurar: crear la base `loginlaravel` en phpMyAdmin → pestaña **Importar** → seleccionar el archivo `.sql`.

---

## 5. ✅ Resultado del laboratorio

Con el servidor corriendo (`composer run dev`) el proyecto responde en `http://localhost:8000`.

**Página de bienvenida de Laravel 13:**

![Bienvenida de Laravel](capturas/10-bienvenida-laravel.png)

**Formulario de registro** (`/register`):

![Registro](capturas/14-registro.png)

**Formulario de login** (`/login`):

![Login](capturas/15-login.png)

**Dashboard con sesión iniciada** (`/home`) — tras registrarse el usuario entra automáticamente a esta vista:

![Home con sesión iniciada](capturas/16-home.png)

**Usuarios guardados en la base de datos** — las contraseñas se almacenan hasheadas con **bcrypt** (visible el prefijo `$2y$12$...` que genera el `Hash::make()` de Laravel). La contraseña NO viaja ni se almacena nunca en texto plano:

![Tabla users](capturas/17-tabla-users.png)

**Validación de credenciales incorrectas:** al intentar iniciar sesión con un correo válido pero contraseña errónea, Laravel responde con el mensaje estándar *"These credentials do not match our records."* sin revelar si el usuario existe o no (comportamiento correcto desde el punto de vista de seguridad):

![Error de credenciales](capturas/19-error-credenciales.png)

---

## 6. 🧩 Arquitectura MVC en el proyecto

Los archivos del proyecto que corresponden a cada parte del patrón MVC, abiertos en VS Code:

![Archivos MVC](capturas/20-archivos-mvc.png)

| Componente | Archivos |
|---|---|
| **Modelo** | `app/Models/User.php` |
| **Vistas** | `resources/views/auth/login.blade.php`, `register.blade.php`, `layouts/app.blade.php`, `home.blade.php` |
| **Controladores** | `app/Http/Controllers/Auth/LoginController.php`, `RegisterController.php`, `app/Http/Controllers/HomeController.php` |
| **Rutas** | `routes/web.php` |

Con `php artisan route:list` se verifica cómo cada URL se conecta con su controlador correspondiente. Se observan las rutas `GET /login` y `POST /login` apuntando a `Auth\LoginController`, `GET /register` y `POST /register` apuntando a `Auth\RegisterController`, `POST /logout` también en `LoginController`, y `GET /home` en `HomeController`:

![route:list](capturas/18-route-list.png)

---

## 7. 🛠️ Dificultades y soluciones

Durante la ejecución del laboratorio se presentaron las siguientes complicaciones:

- **Dificultad 1: MySQL mostraba MyISAM como motor por defecto en lugar de InnoDB.**
  - **Solución:** se editó `C:\wamp64\bin\mysql\mysql8.4.7\my.ini`, se comentó la línea `default_storage_engine=MYISAM` y se descomentó `default_storage_engine=InnoDB`. Después de reiniciar WAMP y volver a correr `SHOW VARIABLES LIKE 'default_storage_engine';` el motor por defecto ya salía como InnoDB, y las migraciones subsiguientes crearon todas las tablas con ese motor.

- **Dificultad 2: Las páginas de login y registro cargaban sin estilo (HTML plano, sin Bootstrap).**
  - **Solución:** `php artisan serve` por sí solo levanta únicamente el backend; para que las hojas de estilo y los JS de Bootstrap/Vite se sirvieran hubo que correr `composer run dev`, que arranca al mismo tiempo el servidor de Laravel, el worker de la cola y el dev server de Vite. Tras recargar la página con `Ctrl+Shift+R`, los formularios aparecen con la caja blanca, los campos redondeados y el botón azul característicos de Bootstrap 5.

- **Dificultad 3: PowerShell bloqueaba `npm` con el mensaje "la ejecución de scripts está deshabilitada en este sistema".**
  - **Solución:** se habilitó la ejecución de scripts solo para el usuario actual con `Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy RemoteSigned`. También es posible evitar el problema usando CMD en lugar de PowerShell.

- **Dificultad 4: El error `Command "ui" is not defined` al ejecutar `php artisan ui bootstrap --auth`.**
  - **Solución:** el paquete no estaba instalado todavía en ese punto. Después de correr `composer require laravel/ui` el comando `ui` ya quedó registrado como comando artisan y funcionó correctamente.

- **Dificultad 5: El menú desplegable del navbar (botón hamburguesa y el nombre del usuario) no respondía al click, por lo que no se podía cerrar sesión desde la interfaz.**
  - **Solución:** era un problema de JS que se producía cuando el dev server de Vite no estaba activo. Para la captura de "credenciales inválidas" se abrió una ventana de incógnito en Chrome (sin sesión activa) y se visitó directamente `http://localhost:8000/login`. Con Vite corriendo (`composer run dev`) el desplegable de logout opera correctamente.

- **Dificultad 6: El Composer Setup oficial fallaba al agregar la ruta de Composer al PATH del usuario (Error: *Add to User path*).**
  - **Solución:** se instaló Composer manualmente descargando `composer-setup.php` a `%USERPROFILE%\composer\`, ejecutándolo con `php composer-setup.php`, creando un `composer.bat` que invoca `php composer.phar %*`, y agregando esa carpeta al PATH de usuario mediante **Variables de entorno** del panel de control (más confiable que el instalador cuando hay antivirus bloqueando cambios al registro).

---

## 8. 📅 Fechas

- **Fecha de ejecución del laboratorio:** 30 de octubre de 2026
- **Fecha de entrega:** noviembre de 2026

---

## 9. 📚 Referencias

1. Laravel. *Documentación oficial de Laravel 13*. https://laravel.com/docs/13.x
2. Laravel. *laravel/ui – Legacy scaffolding for Laravel* (repositorio oficial). https://github.com/laravel/ui
3. Composer. *Documentación de Composer*. https://getcomposer.org/doc/
4. Oracle. *MySQL Reference Manual – InnoDB Storage Engine*. https://dev.mysql.com/doc/refman/8.4/en/innodb-storage-engine.html
5. Bootstrap. *Documentación de Bootstrap 5.3*. https://getbootstrap.com/docs/5.3/
6. Vite. *Documentación oficial de Vite*. https://vitejs.dev/guide/
7. Fong, I. *Guía de Laboratorio: Cómo crear un Login y Registro en Laravel*. Universidad Tecnológica de Panamá.

---

<div align="center">

### 🎓 Información del estudiante

Este laboratorio ha sido desarrollado por el estudiante de la Universidad Tecnológica de Panamá:

**Nombre:** Alcibiades Chanis Viadés
**Cédula:** 8-1021-1306
**Correo:** alcibiades.chanis@utp.ac.pa
**Curso:** 1S3122
**Instructor del Laboratorio:** Ing. Irina Fong

</div>
