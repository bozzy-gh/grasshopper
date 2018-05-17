<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>

      <meta charset="UTF-8">
    <title>Grasshopper Setup</title>
<link rel="stylesheet" type="text/css" href="jquery-ui.structure.min.css"/>
<link rel="stylesheet" type="text/css" href="jquery-ui.theme.min.css"/>
<link rel="stylesheet" type="text/css" href="jquery-ui.theme.alternate.min.css"/>
<link rel="stylesheet" type="text/css" href="jquery.appendGrid-1.5.2.css"/>

<link href="css/grasshoppersetup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.1.min.js"></script>
<script type="text/javascript" src="jquery.appendGrid-1.5.2.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT']."/setup/includes/ajax_php_submit.php"); ?>



    <title>Grasshopper Configuration</title>

    <style type="text/css">
      body { font-size: 80%; font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif; }
      ul#tabs { list-style-type: none; margin: 30px 0 0 0; padding: 0 0 0.3em 0; }
      ul#tabs li { display: inline; }
      ul#tabs li a { color: #42454a; background-color: #dedbde; border: 1px solid #c9c3ba; border-bottom: none; padding: 0.3em; text-decoration: none; }
      ul#tabs li a:hover { background-color: #f1f0ee; }
      ul#tabs li a.selected { color: #000; background-color: #f1f0ee; font-weight: bold; padding: 0.7em 0.3em 0.38em 0.3em; }
      div.tabContent { border: 2px solid #c9c3ba; padding: 0.5em; margin-bottom: 200px; padding-bottom: 180px;}
      div.tabContent.hide { display: none; }


      #wrap {
      width:100%;
      margin:0 auto;
        }
      #left_col {
      float:left;
      width:50%;
      }
      #right_col {
      float:right;
      width:50%;
      }
    </style>

    <script type="text/javascript">

    var tabLinks = new Array();
    var contentDivs = new Array();

    function init() {

      // Grab the tab links and content divs from the page
      var tabListItems = document.getElementById('tabs').childNodes;
      for ( var i = 0; i < tabListItems.length; i++ ) {
        if ( tabListItems[i].nodeName == "LI" ) {
          var tabLink = getFirstChildWithTagName( tabListItems[i], 'A' );
          var id = getHash( tabLink.getAttribute('href') );
          tabLinks[id] = tabLink;
          contentDivs[id] = document.getElementById( id );
        }
      }

      // Assign onclick events to the tab links, and
      // highlight the first tab
      var i = 0;

      for ( var id in tabLinks ) {
        tabLinks[id].onclick = showTab;
        tabLinks[id].onfocus = function() { this.blur() };
        if ( i == 0 ) tabLinks[id].className = 'selected';
        i++;
      }

      // Hide all content divs except the first
      var i = 0;

      for ( var id in contentDivs ) {
        if ( i != 0 ) contentDivs[id].className = 'tabContent hide';
        i++;
      }
    }

    function showTab() {
      var selectedId = getHash( this.getAttribute('href') );

      // Highlight the selected tab, and dim all others.
      // Also show the selected content div, and hide all others.
      for ( var id in contentDivs ) {
        if ( id == selectedId ) {
          tabLinks[id].className = 'selected';
          contentDivs[id].className = 'tabContent';
        } else {
          tabLinks[id].className = '';
          contentDivs[id].className = 'tabContent hide';
        }
      }

      // Stop the browser following the link
      return false;
    }

    function getFirstChildWithTagName( element, tagName ) {
      for ( var i = 0; i < element.childNodes.length; i++ ) {
        if ( element.childNodes[i].nodeName == tagName ) return element.childNodes[i];
      }
    }

    function getHash( url ) {
      var hashPos = url.lastIndexOf ( '#' );
      return url.substring( hashPos + 1 );
    }

    </script>
  </head>

  <body onload="init()">
    <h1>Grasshopper Configuration</h1>

    <ul id="tabs">
      <li><a href="#rooms_controlpoints">Rooms & Control Points</a></li>
      <li><a href="#myhome_gateway">MyHome Gateway</a></li>
      <li><a href="#system_tools">System Tools</a></li>
    </ul>

    <div class="tabContent" id="rooms_controlpoints">
      <script id="jsSource" type="text/javascript">
$(function () {
    // Initialize appendGrid
    $('#tblAppendGrid').appendGrid({
        caption: 'My Rooms & Control points',
        initRows: 1,
        columns: [
            { name: 'roomname', display: 'Room', type: 'text', ctrlAttr: { maxlength: 1000 }, ctrlCss: { width: '500px'} }
        ],
        initData: [
            {}
        ],
        useSubPanel: true,
        subPanelBuilder: function (cell, uniqueIndex) {
            // Create a table object and add to sub panel
            var subgrid = $('<table></table>').attr('id', 'tblSubGrid_' + uniqueIndex).appendTo(cell);
            // Optional. Add a class which is the CSS scope specified when you download jQuery UI
            subgrid.addClass('alternate');
            // Initial the sub grid
            subgrid.appendGrid({
                initRows: 1,
                hideRowNumColumn: true,
                columns: [
                    { name: 'bticinonumber', display: 'Bticino Number', ctrlCss: { 'width': '100px', 'text-align': 'right' } },
                    { name: 'controlpointname', display: 'Controlpoint Name', ctrlCss: { 'width': '200px'} },
                    { name: 'controlpointtype', display: 'Type', ctrlCss: { 'width': '150px'}, type: 'select', ctrlOptions: { 0: 'Light on-off', 1: 'Light dimmable', 2: 'Motorised Screens', 3: 'Push-button'} }
                ],
                initData: [
                    {
                          controlpointtype: 0
                    }
                ]
            });
        },
        subPanelGetter: function (uniqueIndex) {
            // Return the sub grid value inside sub panel for `getAllValue` and `getRowValue` methods
            return $('#tblSubGrid_' + uniqueIndex).appendGrid('getAllValue', true);
        },
        rowDataLoaded: function (caller, record, rowIndex, uniqueIndex) {
            // Check SubGridData exist in the record data
            if (record.SubGridData) {
                // Fill the sub grid
                $('#tblSubGrid_' + uniqueIndex, caller).appendGrid('load', record.SubGridData);
            }
        }
    });

    // Handle `Save` button click
    $('#btnSaveConfig').button().click(function () {
        // Get grid values in array mode
        var allData = $('#tblAppendGrid').appendGrid('getAllValue');

        $.ajax({
            type: 'POST',
            url: 'processparameters.php',
            data: {arr: JSON.stringify(allData)},
            success: function(data) {
                console.log("success:",data);},
            failure: function(errMsg) {
                console.error("error:",errMsg);
           }
        });
    });

    // Handle `Load` button click
    $('#btnLoadConfig').button().click(function () {
        $.getJSON("loadparameters.php", function(allData) {
            $('#tblAppendGrid').appendGrid('load', allData);
        });
    });

    // Handle `Clear` button click
    $('#btnClearConfig').button().click(function () {
        $('#tblAppendGrid').appendGrid('load', [{}]);
    });
     $.getJSON('loadparameters.php', function(allData) {
            $('#tblAppendGrid').appendGrid('load', allData);
        });
});
</script>

<form action="" method="post">
    <table id="tblAppendGrid"></table>
    <br>
    <button id="btnSaveConfig" type="button">Save configuration</button>
<p>
Use the table above to define your rooms and control points (eg. lights). <br>
Use the blue [+] to add rooms and the yellow [+] to add control points. use [&uarr;] or [&darr;] to move rooms and lightpoints around.<br>
Once finished, press the [Save Configuration] button to store the updates.<br>
These will be immediately visible on your Grasshopper webpage.
</p>
</form>
<hr>
<br>
<div id="wrap">
    <div id="left_col">

<a href="../includes/myhome.conf" download="myhome.conf"><button>Export Configuration</button></a>
<p>
Press [Export Configuration] to save a copy of the rooms & control points<br>
configuration file on your hard-drive for safekeeping.<br>
If ever Grasshopper fails, you can restore this file to have all your<br>
settings loaded again.
</p>
 </div>
    <div id="right_col">

<form enctype="multipart/form-data" action="uploader.php" method="POST" onsubmit="setTimeout(function () { window.location.reload(); }, 10)">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<b>Restore myhome.conf:</b>  <br><br><input name="uploadedfile" type="file" /> <p style="text-indent: 5em;">  ==>

<input type="submit" value="Upload File" /> </p>
</form>
<p>
Restore a previously exported configuration file by:<br>
- using the [Browse] button to locate the backed up myhome.conf file on your hard drive.<br>
- pressing [Upload File] to restore this file onto Grasshopper.<br>
</p>
 </div>
</div>
    </div>

    <div class="tabContent" id="myhome_gateway">
   <script id="jsSource" type="text/javascript">
$(function () {
    // Initialize appendGrid
    $('#tblGatewayConfiguration').appendGrid({
        caption: 'Myhome Gateway Configuration',
        initRows: 1,
        columns: [
                { name: 'HOST', display: 'MyHome Gateway IP address', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '160px'} },
                { name: 'PORT', display: 'Port Number', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '160px'} },
                { name: 'PASSWORD', display: 'Password', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '160px'} },

            ],
            hideButtons: {
                remove: true,
                removeLast: true,
                append: true,
                insert: true,
                moveUp: true,
                moveDown: true
            },
            hideRowNumColumn: true
    });


 // Handle `Load` button click
    $('#btnLoadgwConfig').button().click(function () {
        $.getJSON("loadgwparameters.php", function(allData) {
            $('#tblGatewayConfiguration').appendGrid('load', allData);
        });
    });

    // Handle `Save` button click
    $('#btnSavegwConfig').button().click(function () {
        // Get grid values in array mode
        var allData = $('#tblGatewayConfiguration').appendGrid('getAllValue');

        $.ajax({
            type: 'POST',
            url: 'processgwparameters.php',
            data: {arr: JSON.stringify(allData)},
            success: function(data) {
                console.log("success:",data);},
            failure: function(errMsg) {
                console.error("error:",errMsg);
           }
        });
    });
    $.getJSON('loadgwparameters.php', function(allData) {
            $('#tblGatewayConfiguration').appendGrid('load', allData);
        });
});
</script>

<form action="" method="post">
   <table id="tblGatewayConfiguration">
</table>
<br>
    <button id="btnSavegwConfig" type="button">Save Gateway configuration</button>
    <p>
Enter your Bticino Gateway IP address / Port number / Password.<br><br>
<b>Bticino Gateway IP address:</b> this is the IP address of eg. MH20x / Bticino Touchscreen 3,5'' or 10'' / Other network-connected Bticino device.<br>
<b>Bticino Port number:</b> this is the port on which the Bticino Gateway listens for openwebnet commands. Usually this is 20000.<br>
<b>Password:</b> This is the Open password for the Bticino Gateway.**<br><br>
**MIND: if the Grasshopper IP address is in the range of authorised IP addresses defined in your gateway, leave the password field empty.<br>
</p>
</form>
    </div>


<div class="tabContent" id="system_tools">

    <p>
<u><b>Manage the controlpoint table:</b></u><br><br>
To get a view on the status of the control points in the database table, access <A href="/phpliteadmin/phpliteadmin.php">phpLiteAdmin</A>.<br><br>
Log in using password <b>admin</b><br><br>

</div>

    </script>

  </body>
</html>
