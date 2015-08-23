// Helper class
// Chart View
function ChartView() {
  "use strict";

  // Start time of the graph
  this.start = 0;
  // End time of the graph
  this.end = 0;

  // Zoom out (double the interval)
  this.zoomout = function() {
    var time_window = this.end - this.start;
    this.start -= time_window / 2;
    this.end += time_window / 2;
  };

  // Zoom in (half the interval)
  this.zoomin = function() {
    var time_window = this.end - this.start;
    this.start += time_window / 4;
    this.end -= time_window / 4;
  };

  // Pan right (20% of the interval)
  this.panright = function() {
    var time_window = this.end - this.start;
    var shift = time_window * 0.2;
    this.start += shift;
    this.end += shift;
  };

  // Pan left (20% of the interval)
  this.panleft = function() {
    var time_window = this.end - this.start;
    var shift = time_window * 0.2;
    this.start -= shift;
    this.end -= shift;
  };

  // Sets the timewindow, aligned to the end (in days)
  this.timewindow = function(time) {
    var now = (new Date()).getTime();
    // Get start time
    this.start = now - (3600000 * 24 * time);
    // Get end time
    this.end = now;
  };
};
