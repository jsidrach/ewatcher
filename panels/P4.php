<?php
/*
Consultas

Se debería permitir seleccionar fecha de inicio y fecha de fin (ojo, hay un “reloj” en el formulario 
y si no se indica nada, toma la hora en la que se hace la consulta como inicio y fin, por lo que esos días inicial 
y final no serían correctos, habría que usar el día,mes,año que se seleccione pero la hora sería desde las 00:00).

Para ese periodo seleccionado mostrar una tabla con los valores de (es el valor total entre esas dos fechas):
tLoad: Consumo total,
tLoad: Energía FV generadaz
tPvToLoad: Energía FV autoconsumida
tPvToNet: Energía FV inyectada a red
tLoadFromNet: Energía importada de la red
tPvToLoad / tPv: Porcentaje de autoconsumo
tPvToLoad / tLoad: Porcentaje de consumo generado con FV

Pedir también:
Precio del kWh de la red: (es el que corresponde a 0.1244)
Precio del kWh inyectado a la red (es el que aparece como 0.054):

Con esto, calcular según las fórmulas anotadas en feeds y mostrar lo siguiente:
cNet: Coste de la energía importada
cPvToNet: Coste energía inyectada a la red
cLoadNoPv: Coste sin producción FV
cLoadPv: Coste con producción FV
savings: Ahorro

Por último, si fuera posible, un botón con la opción Descargar datos diarios, y se descargarían los datos diarios de:
eDLoad: Consumo
eDPv: Energía FV
eDLoadFromPv: Energía FV autoconsumida
eDPvToNet: Energía FV inyectada a red
eDNet: Energía importada de la red
*/
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P4 Class
  class EWatcherP4 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 4 View
    public function view() {
      echo "TODO P4";
    }
  }
?>
