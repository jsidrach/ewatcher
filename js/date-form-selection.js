// Sets the events
$(document).ready(function () {
  DateFormSelection.init();
});

//
// DateFormSelection module
//   Reloads values and calculated values on a selected date
//
// Needs: window.apikey_read, window.emoncms_path
(function (DateFormSelection, $, undefined) {
  // Dependant feeds
  var dependantFeeds;
  // Dependant variables
  var dependantValues;
  // Dependant tables
  var dependantTables;

  // Initializes the module
  DateFormSelection.init = function () {
    dependantFeeds = [];
    dependantValues = [];
    dependantTables = [];
    // TODO
  }

}(window.DateFormSelection = window.DateFormSelection || {}, jQuery));
