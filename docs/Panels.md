# Panels

Panels display the information of the feeds, using values, graphs, forms and tables. There are 5 panels in *EWatcher*. The first 2 use the electric facilities defined feeds, and the last 3 the PV self-consumption facilities defined feeds. Below is a description of the information displayed in each panel.

## Panel 1 - Consumption
* Values: sPLoad, sVoltage, eDLoad (intant feeds)
* Graphic: sPLoad (last 7 values + interactivity), continuous graph
* Graphic: eDLoad (last 7 values + interactivity), daily graph

## Panel 2 - Consumption - Queries
* Form: two dates (default range is one week)
  * Table: eDLoad daily between the dates (daily table)

## Panel 3 - PV
* Values: sPLoad, sPPv, iGridToLoad, iPvToGrid (instant feeds)
* Graphic: sPLoad, sPPv, iGridToLoad (continuous graph)
* Values: eDPv, eDLoadFromPv, eDPvToGrid, eDGrid, eDLoad (instant feeds)
* Values: dPLoadFromPv, dPSelf (intant feeds)

## Panel 4 - PV - Queries
* (Optional Configuration) set: cIn, cOut, units
* Form: two dates (default to one week)
  * Values: tLoad, tPv, tPvToLoad, tPvToGrid, tLoadFromGrid (cumulative feeds), 100*tPvToLoad/tPv, 100*tPvToLoad/tLoad (dependent feeds)
  * Values: cGrid, cPvToGrid, cLoadNoPv, cLoadPv, savings (dependent feeds)
  * Table: eDLoad, eDPv, eDLoadFromPv, eDPvToGrid, eDGrid, dPSelf, dPLoadFromPv (daily table)

## Panel 5 - PV - Daily values
* Graphic: eDPvToGrid, eDLoadFromPv (last 7 days + interactivity), daily graph
* Graphic: eDPvToGrid, eDGrid (last 7 days + interactivity), daily graph
* Graphic: eDGrid, eDLoadFromPv (last 7 days + interactivity), daily graph
* Graphic: eDLoad, eDPv, eDGrid (last 7 days + interactivity), daily graph
