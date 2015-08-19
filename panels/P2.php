<?php
/*
Consultas

Se debería permitir seleccionar fecha de inicio y fecha de fin (ojo, hay un “reloj” en el formulario 
y si no se indica nada, toma la hora en la que se hace la consulta como inicio y fin, 
por lo que esos días inicial y final no serían correctos, habría que usar el día,mes,año 
que se seleccione pero la hora sería desde las 00:00). Para ese periodo seleccionado mostrar 
una tabla con los valores de (es el valor total entre esas dos fechas)

tLoad: Consumo total

Si fuera posible, un botón con la opción Descargar datos diarios, y se descargarían los datos diarios de:

eDLoad: Consumo

*/
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P2 Class
  class EWatcherP2 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 2 View
    public function view() {
      echo "TODO P2";
    }
  }
?>
