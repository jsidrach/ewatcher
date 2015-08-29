# Inputs & Feeds

This document gives a brief explanation about how the data is collected and processed by the application, and which *inputs* and *feeds* it requires. They must exist in *emoncms* (for each user), otherwise *EWatcher* may not work properly. Although not every *input* and *feed* defined here is currently being used, but it may be in future versions, so it is advised to have all defined. Luckily enough, there has also been created another module to aid with the definition of the *inputs* and *feeds* in a fully automatic way ([see here](http://github.com/jsidrach/ewatcher-users)).

This application works with two different types of facilities: electric ones and PV self-consumption ones.

## Electric facilities
### Inputs

Input | Description | Units
--- | --- | ---
**iload** | Consumption intensity | A
**pload** | Consumption power | W
**voltage** | Voltage | V

**Note**: every input is sent, by convention, to the node 7

### Feeds

Feed | Description | Units| Type | Engine | Formula
--- | --- | --- | --- | --- | ---
**sILoad** | Consumption intensity | A | REALTIME | PHPFIWA | Log **iload**
**sPLoad** | Consumption power | W | REALTIME | PHPFIWA | Log **pload**
**sVoltage** | Voltage | V | REALTIME | PHPFIWA | Log **voltage**
**eDLoad** | Daily consumption | kWh | DAILY | PHPTIMESERIES | From **sPLoad** using **Power to kWh/d**
**tLoad** | Total consumption | kWh | REALTIME | PHPFINA | From **sPLoad** using **Power to kWh**

## PV self-consumption facilities
### Inputs

Input | Description | Units
--- | --- | ---
**ipv** | Photovoltaic intensity | A
**ppv** | Photovoltaic power | W
**iload** | Consumption intensity | A
**pload** | Consumption power | W
**voltage** | Voltage | V

**Note**: every input is sent, by convention, to the node 7

### Feeds

Feed | Description | Units | Type | Engine | Formula
--- | --- | --- | --- | --- | ---
**sIPv** | PV intensity | A | REALTIME | PHPFIWA | Log **ipv**
**sPPv** | PV power | W | REALTIME | PHPFIWA | Log **ppv**
**sILoad** | Consumption intensity | A | REALTIME | PHPFIWA | Log **iload**
**sPLoad** | Consumption power | W | REALTIME | PHPFIWA | Log **pload**
**sVoltage** | Voltage | V | REALTIME | PHPFIWA | Log **voltage**
**iPvToLoad** | PV power consumption | W | REALTIME | PHPFIWA | **ppv**  if **ppv** < **pload**  otherwise **pload**
**iGridToLoad** | Grid power consumption | W | REALTIME | PHPFIWA | **pload** - **iPvToLoad**
**iPLoadFromPv** | Percentage of consumption with PV power | % | REALTIME | PHPFIWA | 100 \* **iPvToLoad** / **pload**
**iPLoadFromGrid** | Percentage of consumption with grid power | % | REALTIME | PHPFIWA |  100 \* **iGridToLoad** / **pload**  (must match 100 - **iPLoadFromPv**)
**iPvToGrid** | PV power exported to the grid | W | REALTIME | PHPFIWA | **ppv** - **iPvToLoad**
**eDPv** | Daily PV energy produced |  kWh | DAILY | PHPTIMESERIES | From **sPPv** using **Power to kWh/d**
**eDGrid** | Daily energy imported from the grid | kWh | DAILY | PHPTIMESERIES |  From **iGridToLoad** using **Power to kWh/d**
**eDLoad** | Daily consumption | kWh | DAILY | PHPTIMESERIES | From **sPLoad** using **Power to kWh/d**
**eDPvToGrid** | Daily PV energy exported to the grid | kWh | DAILY | PHPTIMESERIES | From **iPvToGrid** using **Power to kWh/d**
**dPSelf** | Percentage of daily self-consumption | % | DAILY | PHPFIWA | 100 \* (**eDPv** - **eDPvToGrid**)/**eDPv**
**dPLoadFromPv** | Percentage of daily consumption with PV origin | % | DAILY | PHPFIWA |    100 \* (**eDPv** - **eDPvToGrid**) / **eDLoad**
**eDLoadFromPv** | Daily energy consumption from PV energy | kWh | DAILY | PHPTIMESERIES |  **eDPv** - **eDPvToGrid**
**tLoad** | Total consumption | kWh | REALTIME | PHPFINA | From **sPLoad** using **Power to kWh**
**tPv** | Total PV energy produced | kWh | REALTIME | PHPFINA | From **sPPv** using **Power to kWh**
**tLoadFromGrid** | Total energy imported from the grid | kWh | REALTIME | PHPFINA | From **iGridToLoad** using **Power to kWh**
**tPvToLoad** | Total PV energy consumed | kWh | REALTIME | PHPFINA | From **iPvToLoad** using **Power to kWh**
**tPvToGrid** | Total PV energy exported to the grid | kWh | REALTIME | PHPFINA | **tPv** - **tPvToLoad**

**Note**: the processes **Power to kWh** and **Power to kWh/d** do an automatic log of the result

The following values are calculated with *JavaScript* in the client, so there is no need to create feeds for them:

Var | Description | Units  | Type | Formula
--- | --- | --- | --- | ---
**cGrid** | Cost of the imported energy | *units* | REALTIME | *cIn* \* **tLoadFromGrid**
**cPvToGrid** | Cost of the energy exported to the grid | *units* | REALTIME | *cOut* \* **tPvToGrid**
**cLoadNoPv** | Consumption cost without PV | *units* | REALTIME |  *cIn* \* **tLoad**
**cLoadPv** | Consumption cost with PV | *units* | REALTIME | **cGrid** - **cPvToGrid**
**savings** | Estimated savings | *units* | REALTIME | **cLoadNoPv** - **cLoadPv**

The default values for the configuration settings (you can change them in some of the *EWatcher* panels) are:

* *cIn* = 0.1244
* cOut = 0.054
* *units* = euros
