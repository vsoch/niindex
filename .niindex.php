<html>
<head>
  <title>Drop-in Nifti Viewer</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" media="screen" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
  <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script>
  <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
  <script src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://rawgithub.com/vsoch/font-brain/master/font-brain/font-brain.css">
<script>
var filenames = []
</script>

<style>

table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child,
table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child {
  position: relative;
  padding-left: 30px;
  cursor: pointer;
}
table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before,
table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child:before {
  top: 8px;
  left: 4px;
  height: 16px;
  width: 16px;
  display: block;
  position: absolute;
  color: white;
  border: 2px solid white;
  border-radius: 16px;
  text-align: center;
  line-height: 14px;
  box-shadow: 0 0 3px #444;
  box-sizing: content-box;
  content: '+';
  background-color: #31b131;
}
table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child.dataTables_empty:before,
table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child.dataTables_empty:before {
  display: none;
}
table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td:first-child:before,
table.dataTable.dtr-inline.collapsed > tbody > tr.parent > th:first-child:before {
  content: '-';
  background-color: #d33333;
}
table.dataTable.dtr-inline.collapsed > tbody > tr.child td:before {
  display: none;
}
table.dataTable.dtr-inline.collapsed.compact > tbody > tr > td:first-child,
table.dataTable.dtr-inline.collapsed.compact > tbody > tr > th:first-child {
  padding-left: 27px;
}
table.dataTable.dtr-inline.collapsed.compact > tbody > tr > td:first-child:before,
table.dataTable.dtr-inline.collapsed.compact > tbody > tr > th:first-child:before {
  top: 5px;
  left: 4px;
  height: 14px;
  width: 14px;
  border-radius: 14px;
  line-height: 12px;
}
table.dataTable.dtr-column > tbody > tr > td.control,
table.dataTable.dtr-column > tbody > tr > th.control {
  position: relative;
  cursor: pointer;
}
table.dataTable.dtr-column > tbody > tr > td.control:before,
table.dataTable.dtr-column > tbody > tr > th.control:before {
  top: 50%;
  left: 50%;
  height: 16px;
  width: 16px;
  margin-top: -10px;
  margin-left: -10px;
  display: block;
  position: absolute;
  color: white;
  border: 2px solid white;
  border-radius: 16px;
  text-align: center;
  line-height: 14px;
  box-shadow: 0 0 3px #444;
  box-sizing: content-box;
  content: '+';
  background-color: #31b131;
}
table.dataTable.dtr-column > tbody > tr.parent td.control:before,
table.dataTable.dtr-column > tbody > tr.parent th.control:before {
  content: '-';
  background-color: #d33333;
}
table.dataTable > tbody > tr.child {
  padding: 0.5em 1em;
}
table.dataTable > tbody > tr.child:hover {
  background: transparent !important;
}
table.dataTable > tbody > tr.child ul {
  display: inline-block;
  list-style-type: none;
  margin: 0;
  padding: 0;
}
table.dataTable > tbody > tr.child ul li {
  border-bottom: 1px solid #efefef;
  padding: 0.5em 0;
}
table.dataTable > tbody > tr.child ul li:first-child {
  padding-top: 0;
}
table.dataTable > tbody > tr.child ul li:last-child {
  border-bottom: none;
}
table.dataTable > tbody > tr.child span.dtr-title {
  display: inline-block;
  min-width: 75px;
  font-weight: bold;
}
</style>
</head>  

<body>

<div class="container" style="">
    <div class="row">
       <div class="col-md-6">
            <div class='papaya' data-params='params'></div>
       </div>
       <div class="col-md-6">
       
           <table id="tabley" class="table table-condensed table-striped table-hover">
               <thead>
                   <tr>
                       <th></th>
                       <th>Name</th>
                       <th>Modified</th>
                       <th></th>
                       <th></th>
                   </tr>
                </thead>
                <tbody>

      <?php

    
        // Get directory calling function 
        $base=$_SERVER["SERVER_ADDR"];
        $niindex=strtok($_SERVER["REQUEST_URI"],'?');
     
    
        // Opens directory
        $myDirectory=opendir(".$niindex");
        
        // Gets each entry
        while($entryName=readdir($myDirectory)) {
          $dirArray[]=$entryName;
        }
        
        // Finds extensions of files
        function findexts ($filename) {
          $filename=strtolower($filename);
          $exts=split("[/\\.]", $filename);
          $n=count($exts)-1;
          $exts=$exts[$n];
          return $exts;
        }
        
        // Closes directory
        closedir($myDirectory);
        
        // Counts elements in array
        $indexCount=count($dirArray);
        
        // Sorts files
        sort($dirArray);
        
       // Loops through the array of files

       $count=0;
 
   for($index=0; $index < $indexCount; $index++) {

      // Gets File Names
      $name=$dirArray[$index];
      $namehref=$dirArray[$index];

      // Gets Extensions
      $extn=findexts($dirArray[$index]);

      // Gets file size
      $size=number_format(filesize($dirArray[$index]));

      // Gets Date Modified Data
      $modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
      $timekey=date("YmdHis", filemtime($dirArray[$index]));

      // Print
      if (is_dir(".$niindex/$namehref") && $namehref != ".") {
          print ("<tr>
                  <td><i class='fa fa-folder'></i></td>
                  <td><a href='./$namehref'>$namehref</a></td>
                  <td></td>
                  <td></td>
                  <td></td>
          </tr>");
      }

      if ($extn == "nii" || $extn == "gz") {
          print("
              <script>filenames.push('$namehref')</script>
              <tr>
                  <td><i class='icon-sagittal'></i></td>
                  <td><a href='./$namehref'>$name</a></td>
                  <td><a href='./$namehref'>$modtime</a></td>
                  <td><button class='btn btn-default' onclick='changeImage(\"$count\")'>View</button></td>
                  <td><a href='http://neurosynth.org/decode/?url=$base$niindex$namehref' target='_blank'><button class='btn btn-default'>Decode</button></a></td>
              </tr>");
      $count=$count+1;
      }
    }
  ?>
  </tbody>
</table>

  <script type="text/javascript">
        // Here is a funcion to get variables from the URL - the image index
        function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
        return vars;
         }

         // Discover index from url
         var idx = getUrlVars()
         if (typeof idx["id"] == 'undefined'){ idx = "0";}
         else { idx = idx["id"].replace("/",""); }

         // Configure papaya viewer
         var filename = filenames[parseInt(idx)]
         var params = [];
         params["worldSpace"] = true;
         params["expandable"] = true;
         params["combineParametric"] = true;
         params["images"] = [filename];
         params[filename] = {"parametric":true, "alpha":"0.75","symmetric":true,"min":0.0,"lut":"Spectrum"};
   
    function changeImage(imageid) {
        return window.location='?id=' + imageid;
    }


   </script>
</div><!--col-->
</div><!--row-->
<div class="row" style="margin:20px">
    <div class="col-md-1" style="margin-right:20px">
    <a href="https://twitter.com/share" class="twitter-share-button" data-text="View my brainmaps" data-size="large" data-hashtags="niindex">Tweet</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
    <div class="col-md-2" style="margin-top:5px">
       <p>powered by <a href="http://www.github.com/vsoch/niindex">niindex</a></p>
    </div>
</div>

</div><!--container-->

<link rel="stylesheet" type="text/css" href="http://ric.uthscsa.edu/mango/papaya/papaya.css?version=0.8&build=895" />
<script type="text/javascript" src="http://ric.uthscsa.edu/mango/papaya/papaya.js?version=0.8&build=895"/>

<script>
$(document).ready(function() {
    $('#tabley').dataTable();
    // Get selected image from the browser url
});
</script>
</body>
</html>
