<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="view/css/header.css">
<link rel="stylesheet" type="text/css" href="view/css/newEvent.css">
<link rel="stylesheet" type="text/css" href="view/css/jquery-ui.css">
<script type="text/javascript" src="view/js/results.js"></script>
 
<script src="view/js/jquery-1.12.4.js"></script>
<script src="view/js/ui.js"></script> 


<?php
	include_once("controller/formations.php");
?>

<script>

</script>
  
</head>

<body>

<?php
	include("view/header.php");
?>

<div id="main_body">

	<table>
		<th>
			<td>Όνομα Σχηματισμού</td>
			<td>Επιλογές</td>
		</th>
			<?php
				for($i=0; $i<count($formationsList); ++$i){
					$name = $formationsList[$i]->name;
					$id = $formationsList[$i]->id;
					echo "<td>$name</td>";
					echo "<td>Edit|Delete</td>";
				}
			?>
	</table>
</div>
</body>
</html>