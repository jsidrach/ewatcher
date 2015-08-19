<?php
/*
Valores instantáneos y totales de hoy

Debe verse el valor numérico de:
ppload: Consumo: (W)
ppv: Potencia fv generada: (W)
iGridToLoad: Consumo de la red (W)

Una gráfica similar a la que hay en: http://195.248.230.142/emoncmsmonitor/autoconsumofv&id=12 
(aunque esa gráfica no es muy “bonita”, la de la app se veía mejor). Los tres valores que se van graficando son:
ppc: Producción fv
pload: Consumo
iGridToLoad: Red
Las unidades de la gráfica con W.

Además, como información adicional (es decir, que se vea después de la gráfica y lo de arriba) 
los valores para el día actual de: 
eDPv: Energía fotovoltaica generada 
eDLoadFromPv: Energía fotovoltaica autoconsumida 
eDPvToNet: Energía fotovoltaica inyectada a red 
eDNet: Energía importada de la red * eDLoad: Consumo

(Las unidades de estos valores diarios son kWh/día)

dPLoadFromPv: Porcentaje de consumo generado con fotovoltaica
dPSelf: Porcentaje de autoconsumo

Básicamente toda la información de este panel es la información que hay en http://195.248.230.142/emoncmsmonitor/autoconsumofv&id=6 y en el panel 12 indicado antes
*/
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P3 Class
  class EWatcherP3 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 3 View
    public function view() {
      echo "TODO P3";
    }
  }
?>
