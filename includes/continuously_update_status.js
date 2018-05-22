$(document).ready(function() {
  $.ajaxSetup({cache: false});
  run_update_every_x_milliseconds = setInterval(refresh_lightstatus, 1000);
});
