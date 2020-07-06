require('./materialize.js');

document.addEventListener('DOMContentLoaded', function() {
  M.AutoInit();
  
  var elems = document.querySelectorAll('.tooltipped');
  M.Tooltip.init(elems);
});
