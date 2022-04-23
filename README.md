# places-api
A PHP api created by Slim framework for managing places.

### A typical top-level directory layout

   .
   ├── config/             Configuration files
   ├── public/             Web server files (DocumentRoot)
   │   └── .htaccess       Apache redirect rules for the front controller
   │   └── index.php       The front controller
   ├── templates/          Twig templates
   ├── src/                PHP source code (The App namespace)
   ├── tmp/                Temporary files (cache and logfiles)
   ├── vendor/             Reserved for composer
   ├── .htaccess           Internal redirect to the public/ directory
   ├── .gitignore          Git ignore rules
   └── composer.json       Project dependencies and autoloader
