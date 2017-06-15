<html>
	<head>
		<title>Auto Text Summarization</title>
		<!-- Bootstrap -->
    	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
    	<link href="./css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    	<link href="./css/bootswatch.css" rel="stylesheet" media="screen">
    	<script type="text/javascript">
    		function printValue(sliderID, textbox) {
            var x = document.getElementById(textbox);
            var y = document.getElementById(sliderID);
            x.value = y.value;
        }
    	</script>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</head>
	<body>
		<?php
		error_reporting(E_ERROR | E_PARSE);
		include "./summarize.php";

		// scan nama file korpus
		$dir_corpus = "./corpus";
		$files 		= scandir($dir_corpus);
		$files		= array_slice($files, 2);
		//print_r($files);
		
		// hasil
		if(isset($_GET["filename"]) && isset($_GET["compression"])) {
			$filename	 = $_GET["filename"];
			$compression = $_GET["compression"];
			$output 	 = summarize($filename, $compression);
			$title 		 = substr($filename, 0, -4);
		}
		
		$_POST['tfIdf'] = $_SESSION['tfIdf'];
  		$_POST['token'] = $_SESSION['token'];
		
		?>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="index.php">Auto Text Summarization</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li><a class="brand" style="margin-left:85px;"><?php echo $title;?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

	    <div class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
						<form action="index.php" method="GET">
							<li class="nav-header style1">Pilih Dokumen Korpus </li>
							<li>
								<select class="span3" name="filename" style="width:100%;">
									<option value="0"> Pilih File </option>
									<?php
									foreach ($files as $key => $value) {
										$title = str_replace("_", " ", substr($value, 0, -4));
										if($filename == $value) {
											echo "<option value='$value' SELECTED>$title</option>";
										}
										else {
											echo "<option value='$value'>$title</option>";
										}
									}
									?>
								</select>
							</li>
							<li class="nav-header style1">Tingkat Kompresi (%)</li>
							<li>
								<table border="0">
									<tr>
										<td><input type="range" id="slider" min="1" max="100" value="<?php echo !empty($compression)? $compression : '';?>" step="1" style="width:100%;" onChange="printValue('slider','rangeValue')"></td>
										<td><input type="text" id="rangeValue" name="compression" value="<?php echo !empty($compression)? $compression : '50';?>" style="width:35px;" /></td>
									</tr>
								</table>
							</li>
							<li class="nav-header style1">Summarize</li>
							<li><input class="btn btn-primary" type="submit" value="Proses" style="float: right;"></li>
							<li>&nbsp;</li>
						</form>
						</ul>
					</div><!--/.well -->
				</div><!--/span-->
				<div class="span9">
					<div class="row-fluid" style="margin-top:0px;">
						<div class="span6">
							<h2> Teks Asli </h2>
							<p><?php echo !empty($output['original'])? $output['original'] : "";?></p>
						</div><!--/span-->
						<div class="span6">
							<h2>Hasil Ringkasan </h2>
							<p><?php echo !empty($output['summary'])? $output['summary'] : "";?></p>
						</div><!--/span-->
						<div class="span6">
							<h2>Perhitungan TF-IDF</h2>
							<p> 
							<table>
								<tr>
									<th>NO</th>
									<th>TF/IDF</th>
								</tr>
								<?php
									$i = 1;
									foreach($_POST['tfIdf'] as $x => $x_value) {
									echo "<tr>";
									echo "<td>". $i ."</td>";
									echo "<td>". $x_value ."</td>";
									echo "</tr>";
									//echo "Key=" . $x . ", Value=" . $x_value;
									//echo "<br>";
									$i++;
									}
								?>
							</table></p>
						</div><!--/span-->
						<div class="span6">
							<h2>Tokenisasi</h2>
							<p> <table>
								<tr>
									<th>NO</th>
									<th>Token</th>
								</tr>
								<?php
									$i = 1;
									foreach($_POST['token'] as $x => $x_value) {
									echo "<tr>";
									echo "<td>". $i ."</td>";
									echo "<td>". $x ."</td>";
									echo "</tr>";
									//echo "Key=" . $x . ", Value=" . $x_value;
									//echo "<br>";
									$i++;
									}
								?>
							</table></p>
						</div><!--/span-->
					</div><!--/row-->
				</div><!--/span-->
			</div><!--/row-->

			<hr>
			<footer>
			<p align="center"> Agus Adi Santoso & Yanuar Putrandi Dweka @Sistem Temu Kembali Informasi - 2017 </p>
			</footer>
	    </div><!--/.fluid-container-->

	    <script src="./js/latest.js"></script>
	    <script src="./js/bootstrap.min.js"></script>
	</body>
</html>