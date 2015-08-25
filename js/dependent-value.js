// DependentValue class
// Libraries needed: jQuery
//
// Parameters:
//   divId: id of the value container
//   dependenciesIds: comma separated list of ids this value depends on
//   callback: callback function to calculate the value, it will receive an associative array of ["dependencyId" =>  dependencyValue]
function DependentValue(divId, dependenciesIds, callback) {
  "use strict";

  // Parameter properties
  // Container id
  this.divId = divId;
  // Comma separated list of ids this value depends on
  this.dependenciesIds = dependenciesIds;
  // Callback function
  this.callback = callback;

  // Object properties
  // Container object
  this.div = $(divId);
  // Dependencies array
  this.dependenciesArray = this.dependenciesIds.split(",");

  // Save context
  var self = this;
  // Sets the events
  $(document).ready(function () {
    // On dependency change
    $(self.dependenciesIds).on("change", function() {
      self.div.text(self.callback(self.getDependenciesData())).trigger("change");
    });
    // Initial data
    self.div.text(self.callback(self.getDependenciesData())).trigger("change");
  });

  // Get dependencies data
  this.getDependenciesData = function() {
    var dependenciesData = [];
    for(var index in this.dependenciesArray) {
      var deptId = this.dependenciesArray[index];
      var deptObject = $(deptId);
      var value = deptObject.is("input") ? deptObject.val() : deptObject.text();
      dependenciesData[deptId] = parseFloat(value);
    }
    return dependenciesData;
  };
};
