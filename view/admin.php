<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="view/css/header.css">
<link rel="stylesheet" type="text/css" href="view/css/home.css">
<link rel="stylesheet" type="text/css" href="view/css/jquery-ui.css">
<script type="text/javascript" src="view/js/results.js"></script>
 
<script src="view/js/jquery-1.12.4.js"></script>
<script src="view/js/ui.js"></script> 


<?php
	include_once("controller/formations.php");
?>

<script>
	$( function() {
		$("#insert-formations").change(function() {

			var formation = $("#insert-formations option:selected").val();

			$.ajax({
				url: 'index.php?class=formations&action=getUnits',
				type: 'GET',
				cache: false,
				data: {"formation" : formation},
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function(units) {

					var myDiv = document.getElementById("createUnitsTable");
					myDiv.innerHTML = "";
					myDiv.innerHTML = myDiv.innerHTML + 'Μονάδες: ';
					
					var selectList = document.createElement("select");
					selectList.id = "mySelect";
					myDiv.appendChild(selectList);
					
					var i, element;

					for(i=0; i<units.length; ++i){
						var option = document.createElement("option");
						option.value = units[i].id;
						option.text = units[i].name;
						selectList.appendChild(option);
					}
				}
				
			});
		});
	});
</script>

</head>

<body>

<?php
	include("view/header.php");
?>

<div id="showAllFormations">
	<h3>Διαχείριση Σχηματισμών</h3>
	<table border="1">
		<tr>
			<th>Σχηματισμοί</th>
			<th>Επιλογές</th>
		</tr>
		<?php
			
			for($i=0; $i<count($formations); ++$i){
				$name = $formations[$i]->name;
				$id = $formations[$i]->id;
				echo '<tr>';
				echo "<td>$name</td>";
				echo "<td>Edit|Delete</td>";
				echo '</tr>';
			}
			
		?>
	</table>

</div>

<div id="showAllUnits">

	<h3>Διαχείριση Μονάδων</h3>
	
	Επιλογή Σχηματισμού : 
	<select id="insert-formations">
		<option value='-1'>-</option>
		<?php
			for($i=0; $i<count($formations); ++$i){
				$name = $formations[$i]->name;
				$id = $formations[$i]->id;
				echo "<option value='$id'>$name</option>";
			}
		?>
	</select>

		
	<div id="createUnitsTable"></div>
		

</div>



</body>
</html>