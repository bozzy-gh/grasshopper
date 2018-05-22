function ajaxRequest() {
  if (window.XMLHttpRequest) // modern browser
    return new XMLHttpRequest()
  else
    return false
}

function openpage(url) {
  var myrequest=new ajaxRequest();
  myrequest.open("GET", url, true);
  myrequest.send(null);
}
