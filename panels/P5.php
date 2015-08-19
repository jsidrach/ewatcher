<?php
/*
Valores diarios

Una tabla con los valores de los últimos siete días para las variables diarias.

Si fuera posible, gráficas con la información que hay en http://195.248.230.142/emoncmsmonitor/autoconsumofv&id=7

Gráfica 1 - Generación FV:
eDPvToNet: Energía FV inyectada a red
eDLoadFromPv: Energía FV autoconsumida

Gráfica 2 - Intercambio con la red:
eDPvToNet: Energía FV inyectada a red
eDNet: Energía importada de la red

Gráfica 3 - Origen de la energía consumida
eDNet: Energía importada de la red
eDLoadFromPv: Autoconsumo FV

Gráfica 4 - Totales (esta gráfica es distinta a la que hay en el panel antiguo 7):
eDLoad: Consumo
eDPv: Energía FV
eDNet: Energía importada de la red
*/
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P5 Class
  class EWatcherP5 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 5 View
    public function view() {
      echo "TODO P5";
    }
  }
?>
