// Helper class
// TimeSeries
function TimeSeries(datastore) {
  "use strict";

  // Datastore
  this.datastore = datastore;

  // Load data
  this.load = function(feedid, data) {
    this.datastore[feedid] = {};
    this.datastore[feedid].data = data;
    this.datastore[feedid].start = this.datastore[feedid].data[0][0] * 0.001;
    this.datastore[feedid].interval = (this.datastore[feedid].data[1][0] - this.datastore[feedid].data[0][0]) * 0.001;
  };

  // Append a new value to the graphic
  this.append = function(feedid, time, value) {
    // Find datastore
    if (this.datastore[feedid] == undefined) {
      return false;
    }

    var interval = this.datastore[feedid].interval;
    var start = this.datastore[feedid].start;

    // Align to timeseries interval
    time = Math.floor(time / interval) * interval;
    // Calculate new data point position
    var pos = (time - start) / interval;
    // Get last position from data length
    var last_pos = this.datastore[feedid].data.length - 1;

    // If the datapoint is newer than the last:
    if (pos > last_pos) {
      var npadding = (pos - last_pos) - 1;
      // Padding
      if ((npadding > 0) && (npadding < 12)) {
        for (var padd = 0; padd < npadding; padd++) {
          var padd_time = start + ((last_pos + padd + 1) * interval);
          this.datastore[feedid].data.push([padd_time, null]);
        }
      }

      // Insert datapoint
      this.datastore[feedid].data.push([time, value]);
    }
  };

  // Trim the start of the graphic
  this.trimstart = function(feedid, newstart) {
    // Find this.datastore
    if (this.datastore[feedid] == undefined) {
      return false;
    }

    var interval = this.datastore[feedid].interval;
    var start = this.datastore[feedid].start;

    newstart = Math.floor(newstart / interval) * interval;
    var pos = (newstart - start) / interval;
    var tmpdata = [];

    if (pos >= 0) {
      for (var p = pos; p < this.datastore[feedid].data.length; p++) {
        if (this.datastore[feedid].data[p] == undefined) {
            this.datastore[feedid].data[p] = [];
        }
        var t = this.datastore[feedid].data[p][0];
        var v = this.datastore[feedid].data[p][1];
        tmpdata.push([t,v]);
      }
      this.datastore[feedid].data = tmpdata;
      this.datastore[feedid].start = this.datastore[feedid].data[0][0] * 0.001;
      this.datastore[feedid].interval = (this.datastore[feedid].data[1][0] - this.datastore[feedid].data[0][0]) * 0.001;
    }
  };
};
