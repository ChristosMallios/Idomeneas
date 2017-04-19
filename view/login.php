<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="view/css/login.css">
<link rel="stylesheet" type="text/css" href="view/css/jquery-ui.css">
 
<script src="view/js/ui.js"></script> 

</head>

<body>
	<div id="login">
		<form method="post" action="index.php?class=user&action=login">
			<label for="username">Όνομα Χρήστη</label>
			<input id="username" name="username" type="text" >
			<label for="password">Κωδικός Πρόσβασης</label>
			<input id="password" name="password" type="text" >
			<input type="submit" value="Είσοδος" class="ui-button ui-corner-all ui-widget">
		</form>
		<?php
			if(checkArr($_GET, "error")){
				$error = $_GET["error"];
				if($error = "NoMatch")
					echo '<span id="error">Λανθασμένα στοιχεία εισόδου. Παρακαλώ προσπαθήστε ξανά.</span>';
			} else
				echo '<span style="visibility:hidden" id="error">Λανθασμένα στοιχεία εισόδου. Παρακαλώ προσπαθήστε ξανά.</span>';
				
		?>
	</div>
	
	<div id="main_text">
		<div id="logo">
			<div id="image">
				<img src="view/images/ASDEN.png" alt="Έμβλημα Ασδέν" >
			</div>
		</div>
		
		<div id="terms_of_use">
			<div id="terms">Όροι Χρήσης</div>
		</div>
	</div>
	
</body>
</html>