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
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="jquery/themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<script src="jquery/jquery-1.6.2.js"></script>
<SCRIPT src="jquery/external/jquery.bgiframe-2.1.2.js"></SCRIPT>
<SCRIPT src="jquery/ui/jquery.ui.core.js"></SCRIPT>
<script src="jquery/ui/jquery.ui.widget.js"></script>
<SCRIPT src="jquery/ui/jquery.ui.dialog.js"></SCRIPT>
<SCRIPT src="jquery/ui/jquery.ui.draggable.js"></SCRIPT>
<SCRIPT src="jquery/ui/jquery.ui.mouse.js"></SCRIPT>
<SCRIPT src="jquery/ui/jquery.ui.position.js"></SCRIPT>
<SCRIPT src="jquery/ui/jquery.ui.resizable.js"></SCRIPT>
<script src="jquery/ui/jquery.effects.core.js"></script>
<SCRIPT src="jquery/ui/jquery.effects.bounce.js"></SCRIPT>
<SCRIPT src="jquery/ui/jquery.effects.explode.js"></SCRIPT>
<SCRIPT>
$.fx.speeds._default = 500;
	$(function() {
		$( "#dialog" ).dialog({
			autoOpen: false,
			show: "bounce",
			hide: "explode",
			width : "500",
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
<DIV id="info">
<?php $today = gmdate("j F Y g:i a",time()+60*60*7);
        echo "<p align=right>Welcome <b>".$_SESSION[username]."</b>, $today, <a href='logout.php' title='Logout Here'>Logout<a></p>";
?>
</DIV>
<div id="cetak">
	<form method="post" action="index.php" >
    <fieldset><legend>VIEW BY</legend>
    <table><tr><th>BAGIAN</th></tr>
      <tr>
        <td><label>
          <input type="radio" name="rgbagian" value="CY" id="rgbagian_0" />
CANDY</label>
          <br />
          <label>
          <input type="radio" name="rgbagian" value="SN" id="rgbagian_1" />
SNACK</label>
          <br />
          <label>
          <input type="radio" name="rgbagian" value="BV" id="rgbagian_2" />
BEVERAGE</label>
          <br />
          <label>
          <input type="radio" name="rgbagian" value="MT" id="rgbagian_3" />
MT</label></td>
      </tr>
      <tr>
        <th>BULAN</th>
      </tr>
      <tr>
        <td align="center"><select name="bulan">
          <option value="01">JANUARI</option>
          <option value="02">FEBRUARI</option>
          <option value="03">MARET</option>
          <option value="04">APRIL</option>
          <option value="05">MEI</option>
          <option value="06">JUNI</option>
          <option value="07">JULI</option>
          <option value="08">AGUSTUS</option>
          <option value="09">SEPTEMBER</option>
          <option value="10">OKTOBER</option>
          <option value="11">NOVEMBER</option>
          <option value="12">DESEMBER</option>
        </select></td>
      </tr>
      <tr>
        <th>TAHUN</th>
      </tr>
      <tr>
        <td align="center"><select name="tahun">
          <option value="2011">2011</option>
          <option value="2012">2012</option>
          <option value="2013">2013</option>
        </select></td>
      </tr>
      <tr>
        <th>UPLOADER</th>
      </tr>
      <tr>
        <td align="center"><select name="uploader">
        <?php
			$uploader = mysql_query("select distinct uploader from surat_program");
			while ($ruploader = mysql_fetch_array($uploader))
			{
				echo "<option value='$ruploader[uploader]'>$ruploader[uploader]</option>";
			}
		?>
        </select></td>
      </tr>
      <tr>
        <th></th>
      </tr>
      <tr>
        <td align="center"><input name="" type="submit" value="SEARCH" /></td>
      </tr>
    </table>
    </fieldset>
    </form>
</div>
<div id="wrapper">
  <div id="header">FILE MASTER SURAT PROGRAM</div>
	<div id="menu"><a href="index.php" id="opener">Upload</a></div>
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
  		if (file_exists("surat/" . $_FILES["file"]["name"]))
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

//TAMPILKAN FILE UPLOAD
	if(($_POST[rgbagian]=='')or($_POST[bulan]=='')or($_POST[tahun]=='')or($_POST[uploader]==''))
	{
		$surat = mysql_query("select * from surat_program"); 
	}else{			
		$namafile = $_POST[rgbagian].$_POST[bulan].substr($_POST[tahun],2,2);
		$surat = mysql_query("select * from surat_program where substring(nama_file,1,6)='$namafile' and uploader='$_POST[uploader]'");
	}	
	echo "<Br><Br><table><tr><th>NO</th><th>NAMA FILE</th><th>PENGUNGGAH</th><th>WAKTU UNGGGAH</th><th>DOWNLOAD</th></tr>";
	$i=1;
	while($rsurat = mysql_fetch_array($surat))
	{
		echo "<tr><td align=center>$i</td><td>$rsurat[nama_file]</td><td>$rsurat[uploader]</td><td>$rsurat[data]</td><td align=center><a href='surat/$rsurat[nama_file]' title='Download Link'>>>Download<<</a></td></tr>";
		$i++;
	}
	echo "</table>";
//AKHIR MENAMPILKAN 	
	?>
    <div id="dialog" title="FILE UPLOAD">
	  	<img src="images/pemberitahuan.jpg" width="480" />
        <form action="index.php" method="post" enctype="multipart/form-data">
		<label for="file">Filename:</label><input type="file" name="file" id="file" /><br /><input type="submit" name="submit" value="Upload" />
	  </form>
	</div>
    </div>
</div>
</body>
</html>
<?php } ?>