# EWatcher
Paneles de Autoconsumo FV y Consumo Eléctrico

### Instalación y Configuración
* **NOTA**: es necesario haber instalado *emoncms* previamente
* Situarse en la carpeta de *emoncms* (`/var/www/html/emoncms/`)
* Clonar el repositorio mediante `git clone https://USUARIO@bitbucket.org/ismsolar/ewatcher.git`, sustituyendo `USUARIO` por tu nombre de usuario
* Visitar `http://IP/emoncms/admin/db` y actualizar la base de datos en caso de ser necesario

### Utilización
Crear usuarios y asignarles paneles mediante el [sistema automático de creación de usuarios](https://bitbucket.org/ismsolar/creacion-usuarios/). Una vez un usuario tenga al menos un panel asignado, al entrar en la plataforma *emoncms* verá un menú de *EWatcher* con todos los paneles disponibles.

### Actualización
* Situarse en la carpeta `/var/www/html/emoncms/ewatcher/` y ejecutar `git pull`
* Descartar los cambios locales en caso de haber discrepancias
* Visitar `http://IP/emoncms/admin/db` y actualizar la base de datos en caso de ser necesario

### Multiidioma
Este proyecto tiene soporte para multiidioma mediante *gettext*. Para traducir a más idiomas (o actualizar los ya existentes):

* Crear una carpeta en `./locale/`, con nombre el código de la región ([ver lista aquí](https://gist.github.com/jacobbubu/1836273)), y dentro una carpeta llamada `LC_MESSAGES`
* Copiar el archivo `messages.po` de una traducción ya existente (por ejemplo `./locale/es_ES/LC_MESSAGES/messages.po`) a la nueva carpeta `LC_MESSAGES`
* Editar el archivo con [POEdit](http://poedit.net)), escogiendo el nuevo idioma para el catálogo
* Traducir las cadenas de texto y guardar el catálogo

### Librerías externas
Se utilizan las siguientes librerías de terceros:

* [TODO]

### Tareas pendientes
* Investigar cómo se recuperan datos de *feeds* mediante llamadas *AJAX*
* Crear paneles
