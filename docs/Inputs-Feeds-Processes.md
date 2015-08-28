# Inputs-Feeds-Processes

This document gives a brief explanation about how the data is collected and processed by the application. The raw data is drawn in the INPUTS, and every single Input has some PROCESSES that work with that data and save the results in the FEEDS.

  - The information gathered in the station comes in the INPUT
  - This Input has PROCESSES that transform it SEQUENTIALLY.
  - Every time you have transformed that Input in a desired FEED, you have to LOG IT to that Feed.

E.G.: The Inputs comes with a value "x", and you want to save as a Feed "x+3" and "2*(x+3)". Then, your Processes should be the following:  Add 3 >> Log To Feed >> Multiply (or scale) by 2 >> Log To Feed.

This application works with two diferent facilities: Photovoltaic (PV) and Energy Consumption. Next we are going to list their Inputs, Feeds and how are they calculated.

## PV facilities
### Inputs

They are as follows:

 * **ipv**: photovoltaic intensity
 * **ppv**: photovoltaic power
 * **iload**: intensity of consumption
 * **pload**: power of consumption
 * **voltage**: voltage


**Note**: every Input is send, by convention, to the Node 7


### Feeds

You can calculate instant (Realtime) values, daily values and total values for the whole period since the Feed is defined.

The Engine column represents the method (engine) for saving the data of the Feed in a file.

The processes **Power to kWh** and **Power to kWh/d** do an automatic log.

Feed | Description | Units | Type | Engine | Formula
--- | --- | --- | --- | --- | ---
**sIPv** | PV intensity | A | Realtime | PHPFIWA | Log **ipv**
**sPPv** | PV power | W | Realtime | PHPFIWA | Log **ppv**
**sILoad** | Intensity of Consumption | A | Realtime | PHPFIWA | Log **iload**
**sPLoad** | Power of Consumption | W | Realtime | PHPFIWA | Log **pload**
**sVoltage** | Voltage | V | Realtime | PHPFIWA | Log **voltage**
**iPvToLoad** | From PV power to Power of Consumption | W | Realtime | PHPFIWA | **ppv**  if **ppv**<**pload**  otherwise **pload**     |
**iGridToLoad** | Power from the Net to Consumption | W | Realtime | PHPFIWA | **pload** - **iPvToLoad**
**iPLoadFromPv** | Percentage of Consumption with actual PV | % | Realtime | PHPFIWA | 100\***iPvToLoad**/**pload**
**iPLoadFromNet** | Actual percentage of Net Conumption | % | Realtime | PHPFIWA |  100\***iGridToLoad**/**pload**  (must match 100 - **iPLoadFromPv**)
**iPvToNet** | PV power to Net | W | Realtime | PHPFIWA | **ppv** - **iPvToLoad**
**eDPv** | Daily PV energy |  kWh | Daily | PHPTIMESERIES | From **sPPv** using **Power to kWh/d**
**eDNet** | Daily energy from the Net | kWh | Daily | PHPTIMESERIES |  From **iGridToLoad** using **Power to kWh/d**
**eDLoad** | Daily Consumption | kWh | Daily | PHPTIMESERIES | From **sPLoad** using **Power to kWh/d**
**eDPvToNet** | Daily PV energy to the Net | kWh | Daily | PHPTIMESERIES | From **iPvToNet** using **Power to kWh/d**
**dPSelf** | Percentage of daily self-consumption | % | Daily | PHPFIWA | 100\*(**eDPv** - **eDPvToNet**)/**eDPv**
**dPLoadFromPv** |Percentage of daily Consumption with PV origin | % | Daily | PHPFIWA |    100\*(**eDPv** - **eDPvToNet**)/**eDLoad**
**eDLoadFromPv** | Daily energy Consumption from PV | kWh | Daily | PHPTIMESERIES |  **eDPv** - **eDPvToNet**
**tLoad** | Total Consumption | kWh | Realtime | PHPFINA | From **sPLoad** using **Power to kWh**
**tPv** | Total PV energy | kWh | Realtime | PHPFINA | From **sPPv** using **Power to kWh**
**tLoadFromNet** | Total energy imported from the Net |kWh | Realtime | PHPFINA | From **iGridToLoad** using **Power to kWh**
**tPvToLoad** | PV energy to total Consumption | kWh | Realtime | PHPFINA | From **iPvToLoad** using **Power to kWh**
**tPvToNet** | Total PV energy injected into the Net | kWh | Realtime | PHPFINA | **tPv** - **tPvToLoad**

The following values are calculated with javascript, there is no need to create feeds for them.

Feed | Description | Units  | Type | Formula
--- | --- | --- | --- | --- 
**cNet** | Cost of the imported energy | €   | Realtime | cIn\***tLoadFromNet**
**cPvToNet** | Cost of the energy injected into the Net | €  | Realtime | cOut\***tPvToNet**
**cLoadNoPv** | Consumption cost without PV| € | Realtime |  cIn\***tLoad**
**cLoadPv** | Consumption cost with PV | €  | Realtime | **cNet** - **cPvToNet**
**savings** | Savings | € | Realtime | **cLoadNoPv** - **cLoadPv**

**Nota**: the values cIn = 0.1244 and cOut = 0.054 are defined in the app, just as the units (€).

## Energetic Consumption Measurement Facilities

### Inputs

They are as follows:

 * **iload**: intensity of consumption
 * **pload**: power of consumption
 * **voltage**: voltage
 

**Note**: every Input is send, by convention, to the Node 7

### Feeds

Feed | Description | Units| Type | Engine | Formula
--- | --- | --- | --- | --- | ---
**sILoad** | Intensity of Consumption | A | Realtime | PHPFIWA | Log **iload**
**sPLoad** | Power of Consumption | W |  Realtime | PHPFIWA | Log **pload**
**sVoltage** | Voltage | V | Realtime | PHPFIWA | Log **voltage**
**eDLoad** | Daily Consumption | kWh | Daily | PHPTIMESERIES | From **sPLoad** using **Power to kWh/d**
**tLoad** | total Consumption | kWh | Realtime | PHPFINA | From**sPLoad** using **Power to kWh**

## Processes

So far we have seen the Feeds and the Inputs in the aplication. Now we will take a look at the Processes, which relates both, Feeds and Inputs.

The syntax is the following: [process_id:argument].

Id | Process | Description | Argument
--- | --- | --- | --- 
1 | log_to_feed | Saves the input in a feed | The ID of the FEED
2 | scale | Multiply the input by the arg | Value
3 | offset | Adds the arg to the input | Value
4 | power_to_kwh | Saves the input as kWh in a feed | The ID of the FEED
5 | power_to_kwhd | Saves the input as kWh/day in a feed | The ID of the FEED
6 | times_input | Multiply the input by another one | The ID of the INPUT
7 | input_ontime | Input on-time counter | The ID of the FEED
8 | kwhinc_to_kwhd | Wh increments to kWh/day | The ID of the FEED
9 | kwh_to_kwhd_old | Currently no used | The ID of the FEED
10 | update_feed_data | Updates the data in a feed | The ID of the FEED
11 | add_input | Adds an Input to the input | The ID of the INPUT
12 | divide_input | Divides the input by another one | The ID of the INPUT
13 | phaseshift | Currently no used | Value
14 | accumulator | Adds the input to the last entry of a feed | The ID of the FEED
15 | ratechange | Display the rate of change for the current and last entry of a feed | The ID of the FEED
16 | histogram | This method converts power to energy vs power (Histogram) | The ID of the FEED
17 | average | Currently no used | The ID of the FEED
18 | heat_flux | Removed. To be implemented in a posterior version | The ID of the FEED
19 | power_acc_to_kwhd | Currently no used | The ID of the FEED
20 | pulse_diff | Total pulse count to pulse increment | The ID of the FEED
21 | kwh_to_power | Converts kWh to Power | The ID of the FEED
22 | subtract_input | Substracts an Input to the input | The ID of the INPUT
23 | kwh_to_kwhd | Converts kWh to kWh per day | The ID of the FEED
24 | allowpositive | If the input is negative, turns it to 0 | Any
25 | allownegative | If the input is positive, turns it to 0 | Any 
26 | signed2unsigned | If the input is negative, turns it to positive | Any
27 | max_value | Max daily value of a feed | The ID of the FEED
28 | min_value | Min daily value of a feed | The ID of the FEED
29 | add_feed | Adds a feed to the input | The ID of the FEED
30 | sub_feed | Substracts a feed to the input | The ID of the FEED
31 | multiply_by_feed | Multiply the input by a feed | The ID of the FEED
32 | divide_by_feed | Divide the input by a feed | The ID of the FEED
33 | reset2zero | Resets the input to 0 | Any
34 | wh_accumulator | Adds the input to the last entry of a feed (REDIS) | The ID of the FEED
35 | publish_to_mqtt | Publish value to MQTT topic | TEXT
36 | reset_to_NULL | Resets the input to NULL | Any
37 | reset_to_original | Resets the input to the original value | Any 
38 | if_!schedule,_zero | If it is not a schedule, turns the input to 0 | The ID of the SCHEDULE
39 | if_!schedule,_NULL | If it is not a schedule, turns the input to NULL | 
40 | if_schedule,_zero | If it is a schedule, turns the input to 0 | 
41 | if_schedule,_NULL | If it is a schedule, turns the input to NULL | 
42 | if_zero,_skip_next | If the input is 0, skips next process | Any
43 | if_!zero,_skip_next | If the input is not 0, skips next process | Any
44 | if_NULL,_skip_next | If the input is NULL, skips next process | Any
45 | if_!NULL,_skip_next | If the input is not NULL, skips next process | Any
46 | if_>,_skip_next | If the input is greater than the arg, skips next process | Value
47 | if_>=,_skip_next | If the input is greater or equal to the arg, skips next process | Value
48 | if_<,_skip_next | If the input is lesser than the arg, skips next process | Value
49 | if_<=,_skip_next | If the input is lesser or equal to the arg, skips next process | Value
50 | if_=,_skip_next | If the input is equal to the arg, skips next process | Value
51 | if_!=,_skip_next | If the input is not equal to the arg, skips next process | Value
52 | GOTO | Goes to the process where the arg says (Warning: Loops) | Value
53 | source_feed | Used as Virtual feed source of data (read from other feeds) | The ID of the FEED

