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
    var last_pos = datastore[feedid].data.length - 1;

    // If the datapoint is newer than the last:
    if (pos > last_pos) {
      var npadding = (pos - last_pos) - 1;

      // Padding
      if ((npadding > 0) && (npadding < 12)) {
        for (var padd = 0; padd < npadding; padd++) {
          var padd_time = start + ((last_pos + padd + 1) * interval);
          datastore[feedid].data.push([padd_time * 1000, null]);
        }
      }

      // Insert datapoint
      datastore[feedid].data.push([time * 1000, value]);
    }
  };

  // Trim the start of the graphic
  this.trimstart = function(feedid, newstart) {
    // Find datastore
    if (datastore[feedid] == undefined) {
      return false;
    }

    var interval = datastore[feedid].interval;
    var start = datastore[feedid].start;

    newstart = Math.floor(newstart / interval) * interval;
    var pos = (newstart - start) / interval;
    var tmpdata = [];

    if (pos >= 0) {
      for (var p = pos; p < datastore[feedid].data.length; p++) {
        if (datastore[feedid].data[p] == undefined) {
            console.log("undefined: "+p);
            console.log(interval)
            console.log(start)
        } else {
          var t = datastore[feedid].data[p][0];
          var v = datastore[feedid].data[p][1];
          tmpdata.push([t,v]);
        }
      }
      datastore[feedid].data = tmpdata;
      datastore[feedid].start = datastore[feedid].data[0][0] * 0.001;
      datastore[feedid].interval = (datastore[feedid].data[1][0] - datastore[feedid].data[0][0]) * 0.001;
    }
  };
};
