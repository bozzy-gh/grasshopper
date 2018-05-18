
<script type="text/javascript">
function ajaxRequest(){

 var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
 if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
  for (var i=0; i<activexmodes.length; i++){
   try{
    return new ActiveXObject(activexmodes[i])
   }catch(e){}
  }
 }
 else if (window.XMLHttpRequest) // if Mozilla, Safari etc
  return new XMLHttpRequest()
 else
  return false
} 

function openpage(url){
 var myrequest=new ajaxRequest();
 myrequest.open("GET", url, true) ;
 myrequest.send(null);
}
</script>  

