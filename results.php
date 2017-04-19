<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/header.css">
<link rel="stylesheet" type="text/css" href="css/results.css">
<link rel="stylesheet" type="text/css" href="css/widgEditor.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="css/info.css">
<script type="text/javascript" src="js/widgEditor.js"></script>
<script type="text/javascript" src="js/comments.js"></script> 
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
 
<script language="javascript">
$(document).ready(function() {
	
	$('.category0').click(function(event) {
		var resultID = $(this).find('td').eq(3).text();	
		updateComments(resultID);
	});
	
	$('.category0 input[type=checkbox]').click(function(event) {
		var resultID = $(this).val();	
		updateCommentState(resultID);
		event.stopPropagation();
	});
	
	$('.category1').click(function(event) {
		var resultID = $(this).find('td').eq(3).text();		
		updateComments(resultID);
	});
	
	$('.category1 input[type=checkbox]').click(function(event) {
		var resultID = $(this).val();	
		updateCommentState(resultID);
		event.stopPropagation();
	});
});
</script>
 
<script language="javascript">

	$.tablesorter.addParser({
    id: 'checkbox',
    is: function(s) {
        return false;
    },
    format: function(s, table, cell, cellIndex) {
        var $c = $(cell);
        // return 1 for true, 2 for false, so true sorts before false
        if (!$c.hasClass('updateCheckbox')) {
            $c
            .addClass('updateCheckbox')
            .bind('change', function() {
                $(table).trigger('updateCell', [cell]);
            });
        }
        return ($c.find('input[type=checkbox]')[0].checked) ? 1 : 2;
    },
    type: 'numeric'
});


    $(function(){
		$("table thead th:eq(3)").data("tbody.sorter", false);
		$.tablesorter.formatInt = function (s) {
			var i = parseInt(s);
			return (isNaN(i)) ? null : i;
		};
		$.tablesorter.formatFloat = function (s) {
			var i = parseFloat(s);
			return (isNaN(i)) ? null : i;
		};
	$("#resultsTable").tablesorter(  {headers: {
            0: { sorter: false },
			1: { sorter: false },
			2: { sorter: false },
			3: { sorter: false },
			7: { sorter: 'checkbox' },

        }, emptyTo: 'min', cssInfoBlock : "tablesorter-no-sort", sortMultiSortKey: 'shiftKey' });
    });
</script>

<script language="javascript">

function showCal(name) {
	var lastCal=currentCal;
	var d=new Date(), hasCal=false;

	currentCal = findCalendar(name);

	if (currentCal != null && currentCal.form != null && currentCal.form[currentCal.field]) {
		var calRE = getFormat();

		if (currentCal.form[currentCal.field].value!="" && calRE.test(currentCal.form[currentCal.field].value)) {
			var cd = getDateNumbers(currentCal.form[currentCal.field].value);
			d=new Date(cd[0],cd[1],cd[2]);

			cY=cd[0];
			cM=cd[1];
			dd=cd[2];
		}
		else {
			cY=d.getFullYear();
			cM=d.getMonth();
			dd=d.getDate();
		}

		var calendar=calHeader()+calTitle(d)+calBody(d,dd)+calFooter();

		if (calWin != null && typeof(calWin.closed)!="undefined" && !calWin.closed) {
			hasCal=true;
			calWin.moveTo(winX+calOffsetX,winY+calOffsetY);
		}

		if (!hasCal) {
			if (isIE || isOpera6) {
				calWin=window.open("","cal","toolbar=0,width="+calWidth+",height="+calHeight+",left="+(winX+calOffsetX)+",top="+(winY+calOffsetY));
			}
			else {
				calWin=window.open("","cal","toolbar=0,width="+calWidth+",height="+calHeight+",screenx="+(winX+calOffsetX)+",screeny="+(winY+calOffsetY));
			}
		}

		calWin.document.open();
		calWin.document.write(calendar);
		calWin.document.close();

		calWin.focus();
	}
	else {
		if (currentCal == null) {
			window.status = "Calendar ["+name+"] not found.";
		}
		else if (!currentCal.form) {
			window.status = "Form ["+currentCal.formName+"] not found.";
		}
		else if (!currentCal.form[currentCal.field]) {
			window.status = "Form Field ["+currentCal.formName+"."+currentCal.field+"] not found.";
		}

		if (lastCal != null) {
			currentCal = lastCal;
		}
	}
}
</script>

<script language="javascript">
addCalendar("Calendar1", "Select Date", "calendarDate", "calendarForm");

setWidth(900, 1, 15, 1);
</script>

<script language="javascript">
$('[data-toggle="collapse"]').on('click', function() {
    var $this = $(this),
            $parent = typeof $this.data('parent')!== 'undefined' ? $($this.data('parent')) : undefined;
    if($parent === undefined) { /* Just toggle my  */
        $this.find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
        return true;
    }

    /* Open element will be close if parent !== undefined */
    var currentIcon = $this.find('.glyphicon');
    currentIcon.toggleClass('glyphicon-plus glyphicon-minus');
    $parent.find('.glyphicon').not(currentIcon).removeClass('glyphicon-minus').addClass('glyphicon-plus');

});
</script>

<script>
var myVar = setInterval(updateComments, 600000);

</script>


</head>

<body>

<?php
	include("header.php");
?>

<?php	//temp
	
	include ("../controller/results.php");
	include ("../controller/comments.php");
	include ("../controller/users.php");

?>


<div id="menu" >
	
	<div id="results">
	
		<?php 
	
			$resultName = "98 ADTE";
		
			echo "<span id='name'>$resultName</span>";
		
		?>
	
		<table id="resultsTable" class="tablesorter">
		
			<thead>
			<tr class="tableHeader">
				<th style="display:none;">formationID</th>
				<th style="display:none;">unitID</th>
				<th style="display:none;">actionID</th>
				<th style="display:none;">id</th>
				
				<th id="job_title" style="min-width: 300px;" >
					<div id="title">Όνομα Εργασίας</div> 
					<div id="chosenDate">
						<form name="calendarForm">
							<input type="text" size="20" id="calendarDate" name="calendarDate" size=20 onChange="updateRecords()"> 
							<a href="javascript:showCal('Calendar1')"><img src="images/calendar.png"></a>
						</form>	
					</div>
				</th>
				<th style="width: 200px; id="creation_date">Ημερομηνία Δημιουργίας</th>
				<th style="width: 200px; id="completion_date">Ημερομηνία Ολοκλήρωσης</th>
				<th style="width: 100px; text-align: center">Ολοκλήρωση Εργασίας</th>
			</tr>
			</thead>
		
			<?php 
			
				$data = array();
				
				$greekMonths = array('Ιαν','Φεβ','Μαρ','Απρ','Μαι','Ιουν','Ιουλ','Αυγ','Σεπ','Οκτ','Νοε','Δεκ');
				
				$time = strtotime(str_replace('/', '-', "21/3/2017"));
				$newformat = date('Y-m-d', $time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 1, 'monada 1', 1, 'Μισθοτροφοδοσία' , 1, "Giacommo", $date, $date);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "20/11/2017"));
				$newformat = date('Y-m-d',$time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 1, 'monada 1', 1, 'Μισθοτροφοδοσία' , 2, "Founder & cio", $date, null);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "29/12/2009"));
				$newformat = date('Y-m-d',$time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 1, 'monada 1', 1, 'Μισθοτροφοδοσία' , 3, "Marco Botton", $date, null);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "20/3/2017"));
				$newformat = date('Y-m-d',$time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 1, 'monada 1', 1, 'Μισθοτροφοδοσία' , 4, "Mariah", $date, $date);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "20/3/2017"));
				$newformat = date('Y-m-d',$time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$time = strtotime(str_replace('/', '-', "22/3/2017"));
				$newformat = date('Y-m-d',$time);
				$date2 = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 1, 'monada 1', 1, 'Μισθοτροφοδοσία' , 5, "Sth else re pousti!", $date, $date2);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "21/3/2017"));
				$newformat = date('Y-m-d', $time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 2, 'monada 2', 1, 'Μισθοτροφοδοσία' , 6, "Giacommo", $date, $date);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "20/11/2017"));
				$newformat = date('Y-m-d',$time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 2, 'monada 2', 1, 'Μισθοτροφοδοσία' , 7, "Founder & cio", $date, null);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "22/03/2017"));
				$newformat = date('Y-m-d',$time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 2, 'monada 2', 1, 'Μισθοτροφοδοσία' , 8, "Marco Botton", $date, null);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "20/3/2017"));
				$newformat = date('Y-m-d',$time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 2, 'monada 2', 1, 'Μισθοτροφοδοσία' , 9, "Mariah", $date, $date);
				array_push($data, $object);
				
				$time = strtotime(str_replace('/', '-', "21/3/2017"));
				$newformat = date('Y-m-d',$time);
				$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$time = strtotime(str_replace('/', '-', "22/3/2017"));
				$newformat = date('Y-m-d',$time);
				$date2 = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
				$object = new Result(1, '98 ADTE', 2, 'monada 2', 1, 'Μισθοτροφοδοσία' , 10, "Sth else 2", $date, $date2);
				array_push($data, $object);
				
				//processing
				
				$category = 0;
				$previousFormationID = -1;
				$previousActionID = -1;
				$previousUnitID = -1;
				$createHeader = false;
				$firstTime = true;
				$categoryName = null;
				for($i=0; $i<count($data); ++$i){
					
					$id = $data[$i]->id;
					$name = $data[$i]->name;
					$creationDate = $data[$i]->creationDate;
					$completionDate = $data[$i]->completionDate;
					$actionID = $data[$i]->actionID;
					$formationID = $data[$i]->formationID;
					$unitID = $data[$i]->unitID;
					
					$createHeader = false;
					if($previousFormationID == -1){
						$createHeader = true;
						$formationName = $data[$i]->formationName;
						$unitName =  $data[$i]->unitName;
						$actionName =  $data[$i]->actionName;
						$categoryName = $formationName.'/'.$unitName.'/'.$actionName;
					} else if(($formationID != $previousFormationID) || ($unitID != $previousUnitID) || ($actionID != $previousActionID)){
						$createHeader = true;
						$formationName = $data[$i]->formationName;
						$unitName =  $data[$i]->unitName;
						$actionName =  $data[$i]->actionName;
						$categoryName = $formationName.'/'.$unitName.'/'.$actionName;
					}
					
					$previousFormationID = $formationID;
					$previousUnitID = $unitID;
					$previousActionID = $actionID;
					
					if($createHeader){
						if(!$firstTime){
							echo "</tbody>";
							$firstTime = false;
						}echo '<tbody class="tablesorter-no-sort"><tr><th colspan="4">'.$categoryName.'</th></tr></tbody><tbody class="sortable">';
					}
					
					if($category == 0){
						$category = 1;
							
						echo "<tr class='category0' ><td style='display:none;'>$formationID</td><td style='display:none;'>$unitID</td><td style='display:none;'>$actionID</td><td style='display:none;'>$id</td><td>$name</td><td>$creationDate</td><td>$completionDate</td>";
						if($completionDate == null){
							echo "<td style='width: 100px'><div style='padding-left: 45px;'><label><input type='checkbox' value='".$id."' name='complete'></label></div></td></tr>";
						}else{
							echo "<td style='width: 100px'><div style='padding-left: 45px;'><label><input type='checkbox' value='".$id."' disabled name='complete' checked ></label></div></td></tr>";
						}
					}else{
						echo "<tr class='category1' ><td style='display:none;'>$formationID</td><td style='display:none;'>$unitID</td><td style='display:none;'>$actionID</td><td style='display:none;'>$id</td><td>$name</td><td>$creationDate</td><td>$completionDate</td>";
						if($completionDate == null){
							echo "<td style='width: 100px'><div style='padding-left: 45px;'><label><input type='checkbox' value='".$id."' name='complete'></label></div></td></tr>";
						}else{
							echo "<td style='width: 100px'><div style='padding-left: 45px;'><label><input type='checkbox' value='".$id."' disabled name='complete' checked ></label></div></td></tr>";
						}
						$category = 0;
					}
				}
				echo "</tbody>";
			
			?>
		
		</table>
	
	</div>

	
	<div id="comments">
	
		<div id="container">
		
			<link rel="stylesheet" type="text/css" href="css/comments.css">
		
			
			
			<div class="row">
			<!-- Contenedor Principal -->
			<div class="comments-container">
				<h1>Περιγραφή & Σχόλια</h1>

				<ul id="comments-list" class="comments-list">
				
				
					<?php
					
						$comments = array();
						$user1 = new User(1, 'Petros Megistanos', 'ΑΝΤΙΣΤΡΑΤΗΓΟΣ.png');
						$comment = new Comment(1, 1, $user1, '27/3/2016 15:45', null, 'Περιγραφή!! Κάτι πρέπει να προσθέσω για να φανεί κάτι!!');
						array_push($comments, $comment);
						
						$user2 = new User(2, 'Nikos Koronas', 'ΑΝΤΙΣΤΡΑΤΗΓΟΣ.png');
						$comment = new Comment(2, 2, $user2, '27/3/2016 15:53', 1, 'Υποσχόλιο για δοκιμή. Κάτι θα προστεθεί. Τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ!');
						array_push($comments, $comment);
						
						$comment = new Comment(3, 2, $user1, '28/3/2016 12:30', 1, 'Υποσχόλιο για δοκιμή 2. Κάτι θα προστεθεί. Τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ!');
						array_push($comments, $comment);
						
						$comment = new Comment(4, 1, $user2, '27/3/2016 17:20', null, 'Προσθήκη νέου σχολίου ρίζα. Κάτι έπρεπε να βάλω για δοκιμή');
						array_push($comments, $comment);
						
						$comment = new Comment(5, 1, $user1, '27/3/2016 17:20', null, 'ΤΕΛΟΣ!!');
						array_push($comments, $comment);
					
						//processing
					
						$previousMessageType= 0;
						for($i=0; $i<count($comments); ++$i){
							
							$comment = $comments[$i];
							$user = $comment->user;
							
							if($comment->type == 1){	//sxolio riza
							
								if($i != 0){	//den einai to prwto sxolio riza
									if($previousMessageType == 1){	//Sto proigoumeno sxolio riza upirxe sxolio paidi
										echo "</ul>";
									}
									echo "</li>";
								}
							
							
							
								echo "<li>";
								echo '<div class="comment-main-level">';
								echo '<div class="comment-avatar"><img src="images/'.$user->photo.'" alt=""></div>';
								echo '<div class="comment-box">';
								echo '<div class="comment-head">';
								echo '<h6 class="comment-name by-author"><a href="#">'.$user->name.'</a></h6>';
								echo '<span>'.$comment->dateTime.'</span>';
								echo '<i class="fa fa-reply"></i>';
								echo '<i class="fa fa-heart"></i>';
								echo '</div>';
								echo '<div class="comment-content">';
								echo $comment->description;
								echo '</div>';
								echo '</div>';
								echo '</div>';
								
								$previousMessageType = 0;
								$existChildMessage = 0;
							
							} else {					//sxolio paidi
								
								if($previousMessageType == 0)	//1o sxolio paidi
									echo '<ul class="comments-list reply-list">';
								
								echo '<li>';
								echo '<div class="comment-avatar"><img src="images/'.$user->photo.'" alt=""></div>';
								echo '<div class="comment-box">';
								echo '<div class="comment-head">';
								echo '<h6 class="comment-name"><a href="*">'.$user->name.'</a></h6>';
								echo '<span>'.$comment->dateTime.'</span>';
								echo '<i class="fa fa-reply"></i>';
								echo '<i class="fa fa-heart"></i>';
								echo '</div>';
								echo '<div class="comment-content">';
								echo $comment->description;
								echo '</div>';
								echo '</div>';
								echo '</li>';
								
								$previousMessageType = 1;
							}
						}
						
						if($previousMessageType == 1){	//Sto proigoumeno sxolio riza upirxe sxolio paidi
							echo "</ul>";
						}
						echo "</li>";
					
					?>
				
			
				</ul>
			</div>
			</div>
			
		</div>
		
		<div id="new_comment">
			<h4>Νέο σχόλιο</h4>
            <form role="form">
                <div >
                    <textarea id="comment" ></textarea>
                </div>
                <button type="submit" id="submit_commet">Submit</button>
            </form>
        </div>
		
	</div>

</div>

<form method="post" action="../index.php?class=debug&action=getAllEvents" >
<input type="submit" >
</form>

</body>
</html>