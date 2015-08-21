// FeedLineChart class
// Variables needed: window.apikey_read, window.emoncms_path
// Libraries needed: jQuery, flot, flot.time, flot.selection, date.format, chart-view
//
// Parameters:
//   divId: id of the graph container
//   feeds: list of feed ids
//   defaultRange: default interval for the visualization
function FeedLineChart(divId, feeds, defaultRange) {
  // Parameter Properties
  // ID of the div where the graph is drawn
  this.divId = divId;
  // Array of feed id's to be represented
  this.feeds = feeds;
  // Default interval drawn
  this.defaultRange = defaultRange;

  // Object Properties
  // Live (setInterval)
  this.live = false;
  // Reload the chart
  this.reload = true;
  // Autoupdate the cart
  this.autoupdate = true;
  // Last update
  this.lastupdate = 0;
  // View
  this.view = new ChartView();
  // Data store
  this.datastore = {};

  // Functions
  this.show = function() {
    // TODO
  };
  this.resize = function() {
    // TODO
  };
  this.hide = function() {
    // TODO
  };
  this.livefn = function() {
    // TODO
  };
  this.draw = function() {
    // TODO
  };
  this.getData = function(id, start, end, interval, callback) {
    // TODO
  };
}
