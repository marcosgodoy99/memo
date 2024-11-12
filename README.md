# Proyecto Memo

Este proyecto utiliza Laravel y requiere un entorno de desarrollo adecuado con PHP, MySQL/MariaDB, Composer y Node.js. Sigue estos pasos para configurar y ejecutar la aplicación localmente.

## Requisitos

Asegúrate de tener los siguientes componentes instalados en tu máquina:

- **PHP** versión 8.1 o superior
- **MySQL** o **MariaDB**
- **Composer** (para manejar las dependencias de PHP)
- **Node.js** (para manejar las dependencias de JavaScript)

## Pasos de Instalación

1. *Descargar e Instalar Laragon*:
   - Descarga [Laragon](https://laragon.org/download/) e instálalo en tu máquina.

2. *Abrir Laragon*:
   - Abre Laragon y asegúrate de que PHP, MySQL/MariaDB y Composer están configurados correctamente.

3. *Abrir la Terminal de Laragon*:
   - Ve al apartado de **Terminal** dentro de Laragon.

4. *Clonar el Repositorio*:
   - Ejecuta el siguiente comando para clonar el repositorio:

     git clone https://github.com/marcosgodoy99/memo.git

5. *Acceder al Proyecto*:
   - Entra al directorio del proyecto con el siguiente comando:
     
     cd memo

6. *Instalar Dependencias*:
   - Ejecuta los siguientes comandos para instalar las dependencias de PHP y JavaScript:

     composer install // npm install // npm run build // 

7. *Configurar el Archivo `.env`*:
   - Copia el archivo `.env.example` y renómbralo a `.env`.

     cp .env.example .env

   - Abre el archivo `.env` y configura las credenciales de tu base de datos. Asegúrate de que el valor de `DB_DATABASE` esté configurado como `memo`.
   - 
     DB_DATABASE=memo

8. *Generar la Clave de la Aplicación*:
   - Establece la clave de la aplicación ejecutando el siguiente comando:

     php artisan key:generate --ansi

9. *Realizar la Migración de la Base de Datos*:
   - Ejecuta los siguientes comandos para realizar la migración de la base de datos y poblarla con datos de ejemplo:

     php artisan migrate // php artisan db:seed

10. *Iniciar el Servidor Local*:
    - Inicia el servidor local de Laravel con el siguiente comando:

      php artisan serve

11. *Probar la Aplicación*:
    - Abre tu navegador y visita la siguiente URL para probar la aplicación:

      http://127.0.0.1:8000

## Credenciales de Administrador

Para iniciar sesión como administrador en la aplicación, utiliza las siguientes credenciales predeterminadas:

- **Correo electrónico**: `admin@admin.com`
- **Contraseña**: `12345678`

Estas credenciales te permitirán acceder al panel de administración y gestionar la aplicación.

## Notas

- Si encuentras algún problema durante la instalación, asegúrate de que tu entorno de desarrollo esté correctamente configurado (PHP, MySQL/MariaDB, Composer y Node.js).
- Si necesitas más información sobre Laravel, visita la [documentación oficial](https://laravel.com/docs).
