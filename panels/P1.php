<?php
/*
Valores instantáneos y totales de hoy

Debe verse el valor numérico de:
pload: Potencia consumo (W)
voltage: Voltaje de consumo: (V)

Una gráfica con los valores de pload, título: Consumo (W)

Valor de energía consumida (día actual), eDLoad (kWh)

Gráfica con los últimos valores de eDLoad (pueden ser los últimos 7, y que permita desplazarse para ver los anteriores,
 como en las gráficas del panel.
*/
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P1 Class
  class EWatcherP1 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 1 View
    public function view() {
      echo "TODO P1";
    }
  }
?>
