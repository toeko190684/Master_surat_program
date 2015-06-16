<?php
@session_start();
if(($_SESSION[username]=='')and ($_SESSION[password]==''))
{
  echo "<script>alert(\"Untuk mengakses halaman ini anda harus login terlebih dahulu!!\");
  window.location = \"http://smi/\"
  </script>";
  //echo "<center><h2>Untuk Mengakses halaman ini harus login terlebih dahulu</h2>
  //<br><a href=index.php>Login Here..!</a></center>";
}else {
include "ksi_connect.php";
$tanggal=strtoupper(date("d F Y H:i:s a"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FILE MASTER SURAT PROGRAM</title>
<link href="../program/style.css" rel="stylesheet" type="text/css" />
<link href="../program/jquery/themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<script src="../program/jquery/jquery-1.6.2.js"></script>
<SCRIPT src="../program/jquery/external/jquery.bgiframe-2.1.2.js"></SCRIPT>
<SCRIPT src="../program/jquery/ui/jquery.ui.core.js"></SCRIPT>
<script src="../program/jquery/ui/jquery.ui.widget.js"></script>
<SCRIPT src="../program/jquery/ui/jquery.ui.dialog.js"></SCRIPT>
<SCRIPT src="../program/jquery/ui/jquery.ui.draggable.js"></SCRIPT>
<SCRIPT src="../program/jquery/ui/jquery.ui.mouse.js"></SCRIPT>
<SCRIPT src="../program/jquery/ui/jquery.ui.position.js"></SCRIPT>
<SCRIPT src="../program/jquery/ui/jquery.ui.resizable.js"></SCRIPT>
<script src="../program/jquery/ui/jquery.effects.core.js"></script>
<SCRIPT src="../program/jquery/ui/jquery.effects.bounce.js"></SCRIPT>
<SCRIPT src="../program/jquery/ui/jquery.effects.explode.js"></SCRIPT>
<SCRIPT>
$.fx.speeds._default = 500;
	$(function() {
		$( "#dialog" ).dialog({
			autoOpen: false,
			show: "bounce",
			hide: "explode",
			height: 120,
			width: 450,
			modal: true
		});
		
		
		$( "#opener" ).click(function() {
			$( "#dialog" ).dialog( "open" );
			return false;
		});
		
	});
</SCRIPT>
</head>

<body>
<div id="wrapper">
  <div id="header">FILE MANAGER</div>
	<div id="menu"><a href="../program/index.php" id="opener">Upload</a>
    <?php $today = gmdate("j F Y g:i a",time()+60*60*7);
        echo "<p align=right>Welcome <b>".$_SESSION[username]."</b>, $today, <a href='logout.php' title='Logout Here'>Logout<a></p>";
	?>
	</div>
	<div id="body">
    <?php
	//proses upload file
	if($_POST[submit]=='Upload'){
	if ($_FILES["file"]["error"] > 0)
  	{
  		echo "Error: " . $_FILES["file"]["error"] . "<br />";
  	}
	else
  	{
  		//echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  		//echo "Type: " . $_FILES["file"]["type"] . "<br />";
  		//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  		//echo "Stored in: " . $_FILES["file"]["tmp_name"];
		$namafile = $_FILES["file"]["name"];
		$typefile = $_FILES["file"]["type"];
		$size = ($_FILES["file"]["size"] / 1024) . " Kb";
  		if (file_exists("upload/" . $_FILES["file"]["name"]))
  		{
      		echo $_FILES["file"]["name"] . " already exists. ";
  		}
  		else
  		{
      		move_uploaded_file($_FILES["file"]["tmp_name"],"surat/" . $_FILES["file"]["name"]);
      		//echo "Stored in: " . "surat/" . $_FILES["file"]["name"];
			$insert = mysql_query("insert into surat_program values('$namafile','$_SESSION[username]','$tanggal')");
			//echo "<div id='dialog' title='Info'><p>$namafile  $typefile $size telah tersimpan..!!</p></div>";
			
  		}
  	}
  }
$surat = mysql_query("select * from surat_program");
			echo "<Br><Br><table><tr><th>NO</th><th>NAMA FILE</th><th>PENGUNGGAH</th><th>WAKTU UNGGGAH</th><th>DOWNLOAD</th></tr>";
			$i=1;
			while($rsurat = mysql_fetch_array($surat))
			{
				echo "<tr><td align=center>$i</td><td>$rsurat[nama_file]</td><td>$rsurat[uploader]</td><td>$rsurat[data]</td><td align=center><a href='surat/$rsurat[nama_file]' title='Download Link'>>>Download<<</a></td></tr>";
				$i++;
			}
			echo "</table>";	
	
	?>
    <div id="dialog" title="FILE UPLOAD">
	  <form action="../program/index.php" method="post" enctype="multipart/form-data">
		<label for="file">Filename:</label><input type="file" name="file" id="file" /><BR /><input type="submit" name="submit" value="Upload" />
	  </form>
	</div>
    </div>
</div>
</body>
</html>
<?php } ?>