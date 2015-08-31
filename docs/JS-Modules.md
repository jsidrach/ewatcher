# JavaScript Modules
Documentation of the JavaScript modules developed for this project.

* [instant-feed.js](#instant-feed)
* [cumulative-feed.js](#cumulative-feed)
* [feed-chart.js](#feed-chart)
* [feed-daily-table.js](#feed-daily-table)
* [dependent-value.js](#dependent-value)
* [ewatcher-config-panel.js](#ewatcher-config-panel)
* [chart-view.js](#chart-view)
* [timeseries.js](#timeseries)

## <a name="instant-feed"> </a>instant-feed.js
Automatic update of a feed value in the page every X seconds.

How to use: add the class `instant-feed` to the element, and the tag `data-feedid` with the id of the feed.

Example code:
```html
<span class="instant-feed" data-feedid="31"></span>
```

To set the refresh interval, call `InstantFeed.setInterval(ms)`, where `ms` is the number of milliseconds between each update.

Limitations:

* The user must have its *emoncms* timezone region correctly selected, as it must be the same as the browser local time
* If the `daily` chart type is selected, the latest data for the visualization will be the last day

Dependencies:

* Variables: `window.apikey_read`, `window.emoncms_path`
* Libraries: jQuery

## <a name="cumulative-feed"> </a>cumulative-feed.js
Automatic update of a cumulative feed value between two dates.

How to use: add the tag `data-feedid` with the id of the feed. Create a new `CumulativeFeed` object with the following parameters:

* `divId`: id of the feed value container
* `startDateId`: id of the start date of the cumulative feed
* `endDateId`: id of the end date of the cumulative feed

Example code:
```html
<div id="startDate" class="input-append date control-group">
  <input data-format="dd/MM/yyyy" value="10/02/2015" type="text" />
  <span class="add-on">
    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
  </span>
</div>
<div id="endDate" class="input-append date control-group">
  <input data-format="dd/MM/yyyy" value="10/05/2015" type="text" />
  <span class="add-on">
    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
  </span>
</div>
<span id="tLoad" data-feedid="32"></span>
<script>
  $(window).ready(function() {
    // Dates (datetimepicker)
    $('#startDate').datetimepicker({ pickTime: false });
    $('#endDate').datetimepicker({ pickTime: false });
    // Cumulative feed between dates
    var tLoad = new CumulativeFeed("#tLoad", "#startDate", "#endDate");
  });
</script>
```

Limitations

* The user must have its *emoncms* timezone region correctly selected, as it must be the same as the browser local time
* It is necessary that the start and end date have the datetimepicker option `pickTime` set to `false`
* Cumulative feeds may not work properly if there is the feeds have missing data or gaps between the dates selected

Dependencies:

* Variables: `window.apikey_read`, `window.emoncms_path`
* Libraries: jQuery, bootstrap-datetimepicker

## <a name="feed-chart"> </a>feed-chart.js
Create charts based on feed values.

How to use: create a new `FeedChart` object via the `FeedChartFactory`, with the following parameters:

* `divId`: id of the graph container
* `feeds`: array of feed objects
  * `id`: id of the feed
  * `color` (optional): color of the feed
  * `legend` (optional): legend of the feed
  * `line` (optional): line width (from 0 to 1)
  * `fill` (optional): line fill (from 0 to 1)
* `options` (optional): object of configuration options
  * `chartType` (optional): chart type ("instant"/"daily") - default: `"instant"`
  * `defaultRange` (optional): default interval for the visualization (in days) - default: `7`
  * `pWidth` (optional): percentaje of screen width (from 0 to 1) - default: `1`
  * `pHeight` (optional): percentaje of screen height (from 0 to 1) - default: `0.55`
  * `updateinterval` (optional): time between updates in live mode (in ms) - default: `10000`
  * `selectable` (optional): chart can be selected and zoomed in (boolean) - default: `true`
  * `steps` (optional): draw rectangles (true) or lines (false) (boolean) - default: `true`
  * `controls` (optional): append controls to the chart (boolean) - default: `true`

Example code:
```html
<div id="ExampleGraphic"></div>
<script>
  var feeds = [
    {
      id: 34,
      color: "#0699FA",
      legend: "Generation (kWh)"
    },
    {
      id: 35,
      color: "#04123F",
      legend: "Daily energy consumption (kWh)"
    }
  ];
  FeedChartFactory.create("ExampleGraphic", feeds, {chartType: "daily", defaultRange: 1});
</script>
```

Limitations:

* The user must have its *emoncms* timezone region correctly selected, as it must be the same as the browser local time

Dependencies:

* Variables: `window.apikey_read`, `window.emoncms_path`
* Libraries: jQuery, flot, flot.time, flot.selection, date.format, chart-view, timeseries

## <a name="feed-daily-table"> </a>feed-daily-table.js
Creates a table displaying the daily value of feeds.

How to use: create a new `FeedDailyTable` object with the following parameters:

* `divId`: id of the table container
* `startDateId`: id of the start date input
* `endDateId`: id of the end date input
* `feeds`: array of feed objects
  * `id`: id of the feed
  * `name`: name of the feed
* `localization` (optional): localization object
  * `day`: string for the `"Day"` column
  * `nodata`: string for no data on the table - default `"No data available at the selected date range"`
  * `exportcsv`: string for the export to csv button (`""` to not show the button) - default: `"Export to CSV"`
  * `total`: string for last row (`""` to not show the total row) - default `"Total"`

Example code:
```html
<div id="startDate" class="input-append date control-group">
  <input data-format="dd/MM/yyyy" value="10/02/2015" type="text" />
  <span class="add-on">
    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
  </span>
</div>
<div id="endDate" class="input-append date control-group">
  <input data-format="dd/MM/yyyy" value="10/05/2015" type="text" />
  <span class="add-on">
    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
  </span>
</div>
<div id="table"></div>
<script>
  $(window).ready(function() {
    // Dates (datetimepicker)
    $('#startDate').datetimepicker({ pickTime: false });
    $('#endDate').datetimepicker({ pickTime: false });
    // Daily feed values between dates
    var dailyTable = new FeedDailyTable("#table", "#startDate", "#endDate", [
      {
        id: 29,
        name: "Consumption (kWh)"
      },
      {
        id: 27,
        name: "PV energy (kWh)"
      },
      {
        id: 25,
        name: "PV self-consumed energy (kWh)"
      }
    ],
    {
      total: ""
    });
  });
</script>
```

**Note**: the table has a final total row (may be hidden) with the sum of each column, and the id of each column total is `#<table_id>_total_f<feedid>`

Limitations:

* The user must have its *emoncms* timezone region correctly selected, as it must be the same as the browser local time
* It is necessary that the start and end date have the datetimepicker option `pickTime` set to `false`

Dependencies:

* Variables: `window.apikey_read`, `window.emoncms_path`
* Libraries: jQuery, bootstrap-datetimepicker

## <a name="dependent-value"> </a>dependent-value.js
Automatic update of value which depends on other values.

How to use: create a new `DependentValue` object with the following parameters:

* `divId`: id of the value container
* `dependenciesIds`: comma separated list of ids this value depends on
* `callback`: callback function to calculate the value, it will receive an associative array of `["dependency" => dependencyValue]`

Example code:
```html
<input id="dep1" value="3" type="number" />
<input id="dep2" value="10" type="number" />
<span id="calcValue"></span>
<script>
  $(window).ready(function() {
    var calcValue = new DependentValue("#calcValue", "#dep1,#dep2", function(values) {
      var dep1 = parseFloat(values["#dep1"]);
      var dep2 = parseFloat(values["#dep2"]);
      return Math.round(dep1 * dep2 * 100) / 100;
    });
  });
</script>
```

Dependencies:

* Libraries: jQuery

## <a name="ewatcher-config-panel"> </a>ewatcher-config-panel.js
Create a configuration panel for the *EWatcher* module.

How to use: create a new `EWatcherConfigPanel` with the following parameters:

* `divId`: id of the configuration container
* `cIn`: id of the import cost input
* `cOut`: id of the export cost input
* `units`: id of the units input

Example code:
```html
<div id="ewatcher-config">
  <div class="default-hidden-config" style="display:none">
    <input id="cIn" type="number" value="0.12" step="any">
    <input id="units" type="text" value="euros">
    <input id="cOut" type="number" value="0.5" step="any">
    <i class="icon-arrow-up icon-white click-close"></i>
  </div>
  <div class="default-shown-config">
    <i class="icon-wrench icon-white click-open"></i>
  </div>
</div>
<script>
  $(window).ready(function() {
    var config = new EWatcherConfigPanel("#ewatcher-config", "#cIn", "#cOut", "#units");
  });
</script>
```

Dependencies:

* Variables: `window.apikey_read`, `window.emoncms_path`
* Libraries: jQuery

## Auxiliary modules
### <a name="chart-view"> </a>chart-view.js
Helper class for the feed charts.

### <a name="timeseries"> </a>timeseries.js
Helper class for the feed charts (live update).
