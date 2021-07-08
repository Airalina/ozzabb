# Librería LaRecipe

La recipe nos permite tener una secciòn en nuestra aplicación con la documentación
basada en archivos markdown y html.

Esta herramienta se utiliza mayormente para componer el manual de la aplicaciòn o para detallar el uso y funcionamiento de APIs. En el proyecto lo vamos a utilizar para mantener la documentaciòn funcional durante el desarrollo.

## Cómo instalar la librería

   1. Iniciar una terminal en Linux.
   2. Ir al directorio de nuestra aplicación.
   3. Ejecutar el siguiente comando para registrar la dependencia en nuestra app.
   
   ~~~ 
     composer require binarytorch/larecipe
   ~~~

  - Debería utilizarse compser v2 para la instalación.

   4. Luego ejecutar el siguiente comando para completar la instalación.

   ~~~
   php artisan larecipe:install
   ~~~

   Después de la instalaciòn el directorio de nuestra aplicación debería incluir los siguientes archivos y directorios.

   ~~~
   app dir 
   |
   |---- Configs
   |          |
   |          |---- larecipe.php
   |
   |---- public/vendor/binarytorch/larecipe/assets/
   |                         |
   |                         | ---- css
   |                         | ---- fonts
   |                         | ---- js
   |---- Resources
             |---- vendor/views/larecipe/partials
             |
             |---- docs/1.0
                       |
                       |---- index.md
                       |---- overview.md
                       * (Aquí habrá otros archivos con la documentación)
   ~~~
                     
   y yendo a 

   ~~~ 
   http://localhost/docs
   ~~~

   Deberíamos poder ver la documentación de la app.


   

