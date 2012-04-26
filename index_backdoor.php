<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Upload Something</title>
        <link href="jquery-ui.css" rel="stylesheet" />
        <script src="jquery.min.js"></script>
        <script src="jquery-ui.min.js"></script>
        <style>
            #progress-bar, #upload-frame {
                display: none;
            }
            #banner {
            width:auto;
            height:20em;
            background-image:url('./images/banner_clyde.png');
            background-repeat:no-repeat;
            background-position:left top;
            position:relative;
		left:-120px;
            }
            h4 {
            font-family:"arial",Serif;
            }
            h5 {
            font-family:"arial",Serif;
            font-style:oblique;
            color:red;
            }
            h6 {
            font-family:"arial",Serif;
            font-size:medium;
            font-style:oblique;
            color:red;
            }
        </style>
        <script src="main.js"></script>
        
        <div id="banner"></div>
        	<h2>Put your files inside me</h2>
    </head>
    <body>
     	<h4>1- Set the date/time. Use format YYMMDD-HH:mm. (If not set, it takes the current date/time)</h4><p>
		<?php echo 'Example: 110413-13:00 mean 13 April 2011 at 13:00'; ?>
		<form id="date-form"
		    method="post" 
		    action="index.php">
		    <input type="text" name="date">
		    <input type="submit" id="date" value="Set Date/Time">
		</form>
		<?php 
		$date=$_POST['date'];
		if($date!=NULL){echo'<h6>You have set the date/time in: ';
			  echo $date.'</h6>';} ?> 
		<p>
		
	<h4>2- Choose Course ---> Year ---> Lesson</h4>
	<h5>Pay attention, You've to choose 1_anno_aule_virtuali for evening first year FAD lessons</h5>
	<form id="upload-form"
	      method="post" 
	      action="upload.php"
	      enctype="multipart/form-data"
	      target="upload-frame" >
	      <?php include("function.php");
	       corso($array,$date);?>
	       <p>
	       
	<h4>3- Upload the file</h4>
		<input type="hidden"
		   id="uid"
		   name="UPLOAD_IDENTIFIER" 
		   value="<?php echo md5(uniqid(mt_rand())); ?>" >
		<input type="file" name="file">
		<input type="submit" name="submit" value="Upload!">
	</form>
        <div id="progress-bar"></div>
        <iframe id="upload-frame" name="upload-frame"></iframe>
    </body>
</html>



