<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="view/css/header.css">
<link rel="stylesheet" type="text/css" href="view/css/results.css">
<link rel="stylesheet" type="text/css" href="view/css/comments.css">
<link rel="stylesheet" type="text/css" href="view/css/jquery-ui.css">
<script type="text/javascript" src="view/js/results.js"></script> 
<script type="text/javascript" src="view/js/comments.js"></script> 
<script type="text/javascript" src="view/js/calendar.js"></script>
<script type="text/javascript" src="view/js/jquery.min.js"></script> 
<script type="text/javascript" src="view/js/jquery.tablesorter.min.js"></script>
<script src="view/js/jquery-1.12.4.js"></script>
<script src="view/js/ui.js"></script> 
 
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
addCalendar("Calendar2", "Select Date", "startDate", "startDateForm");

setWidth(900, 1, 15, 1);
</script>

<script language="javascript">
addCalendar("Calendar3", "Select Date", "endDate", "endDateForm");

setWidth(900, 1, 15, 1);
</script>

<script language="javascript">
addCalendar("Calendar4", "Select Date", "startEndingDate", "startEndingDateForm");

setWidth(900, 1, 15, 1);
</script>

<script language="javascript">
addCalendar("Calendar5", "Select Date", "endEndingDate", "endEndingDateForm");

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

<div id="menu" >
	
	<div id="results">
	
		<?php 
	
			$resultName = "98 ADTE";
		
			//echo "<span id='name'>$resultName</span>";
		?>
		
		<div id="selectCreationDate" style="display:inline-block; margin-right: 40px;">
			<form>
				<div class="searchDiv">
					<label class="searchLabel" for="selectCreationDateRange">Ημέρα Δημιουργίας</label><br/>
				</div>
				<select class="searchSelect" name="selectCreationDateRange" id="selectCreationDateRange" onChange="selectCreationDateEvent();" >
					<option selected disabled hidden style='display: none' value=''></option>
					<option value="currentDay">Τρέχουσα ημέρα</option>
					<option value="allDays">Όλων των ημερών</option>
					<option value="previousDay">Προηγούμενης ημέρας</option>
					<option value="rangeDays">Διάστημα ημερών</option>
				</select>
			</form>
		</div>
		
		<div id="selectComleteDate" style="display:inline-block; margin-right: 40px;">
			<form >
				<div class="searchDiv">
					<label class="searchLabel" for="selectCompleteDateRange">Ημέρα Ολοκλήρωσης</label><br/>
				</div>
				<select class="searchSelect" name="selectCompleteDateRange" id="selectCompleteDateRange" onChange="selectCompleteDateEvent();" >
					<option selected disabled hidden style='display: none' value=''></option>
					<option value="currentDay">Τρέχουσα ημέρα</option>
					<option value="allDays">Όλων των ημερών</option>
					<option value="previousDay">Προηγούμενης ημέρας</option>
					<option value="rangeDays">Διάστημα ημερών</option>
				</select>
			</form>
		</div>
		
		<div id="selectState" style="display:inline-block">
			<form >
				<div class="searchDiv">
					<label class="searchLabel" for="selectState">Κατάσταση</label><br/>
				</div>
				<div class="searchSelect">
					<select name="selectState" id="selectState" style="width: 158px;">
						<option selected disabled hidden style='display: none' value=''></option>
						<option value="currentDay">Ολοκληρωμένη</option>
						<option value="allDays">Μη ολοκληρωμένη</option>
						<option value="previousDay">Όλες</option>
					</select>
				</div>
			</form>
		</div>
		
		<div style="display: block;">
			<div id="startDivForm" style="display:inline-block">
				<form name="startDateForm">
					<input type="text" size="20" id="startDate" name="startDate" size=20 readonly style="visibility:hidden" > 
					<a href="javascript:showCal('Calendar2')"><img src="view/images/calendar.png"  id="startDateIcon" style="visibility:hidden"></a>
				</form>	
				<form name="endDateForm">
					<input type="text" size="20" id="endDate" name="endDate" size=20 readonly style="visibility:hidden" > 
					<a href="javascript:showCal('Calendar3')"><img src="view/images/calendar.png" id="endDateIcon" style="visibility:hidden"></a>
				</form>	
			</div>
			
			<div id="endDivForm" style="display:inline-block">
				<form name="startEndingDateForm">
					<input type="text" size="20" id="startEndingDate" name="startEndingDate" size=20 readonly style="visibility:hidden" > 
					<a href="javascript:showCal('Calendar4')"><img src="view/images/calendar.png"  id="startEndingDateIcon" style="visibility:hidden"></a>
				</form>	
				<form name="endEndingDateForm">
					<input type="text" size="20" id="endEndingDate" name="endEndingDate" size=20 readonly style="visibility:hidden" > 
					<a href="javascript:showCal('Calendar5')"><img src="view/images/calendar.png" id="endEndingDateIcon" style="visibility:hidden"></a>
				</form>	
			</div>
		</div>

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
							<input type="text" size="20" id="calendarDate" name="calendarDate" size=20 readonly > 
							<a href="javascript:showCal('Calendar1')"><img src="view/images/calendar.png"></a>
						</form>	
					</div>
				</th>
				<th style="width: 200px; id="creation_date">Ημερομηνία Δημιουργίας</th>
				<th style="width: 200px; id="completion_date">Ημερομηνία Ολοκλήρωσης</th>
				<th style="width: 100px; text-align: center">Ολοκλήρωση Εργασίας</th>
			</tr>
			</thead>
		
			<?php 
			
				$greekMonths = array('Ιαν','Φεβ','Μαρ','Απρ','Μαι','Ιουν','Ιουλ','Αυγ','Σεπ','Οκτ','Νοε','Δεκ');
				
				$category = 0;
				$previousFormationID = -1;
				$previousActionID = -1;
				$previousUnitID = -1;
				$createHeader = false;
				$firstTime = true;
				$categoryName = null;
				for($i=0; $i<count($results); ++$i){
					
					$id = $results[$i]->id;
					$name = $results[$i]->name;
					$date = $results[$i]->startDate;
					$time = strtotime($date);
					$newformat = date('Y-m-d', $time);
					$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
					$creationDate = $date;
					if($results[$i]->endDate != null){
						$time = strtotime($results[$i]->endDate);
						$newformat = date('Y-m-d', $time);
						$date = $greekMonths[date('m', strtotime($newformat))-1]. ' '. date('j', strtotime($newformat)).', '.date('Y', strtotime($newformat));
						$completionDate = $date;
					} else
						$completionDate = $results[$i]->endDate;
					$actionID = $results[$i]->action->id;
					$formationID = $results[$i]->action->unit->formation->id;
					$unitID = $results[$i]->action->unit->id;
					
					$createHeader = false;
					if($previousFormationID == -1){
						$createHeader = true;
						$formationName = $results[$i]->action->unit->formation->name;
						$unitName =  $results[$i]->action->unit->name;
						$actionName =  $results[$i]->action->name;
						$categoryName = $formationName.'/'.$unitName.'/'.$actionName;
					} else if(($formationID != $previousFormationID) || ($unitID != $previousUnitID) || ($actionID != $previousActionID)){
						$createHeader = true;
						$formationName = $results[$i]->action->unit->formation->name;
						$unitName =  $results[$i]->action->unit->name;
						$actionName =  $results[$i]->action->name;
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
							
						echo "<tr class='category0' id='$id' ><td style='display:none;'>$formationID</td><td style='display:none;'>$unitID</td><td style='display:none;'>$actionID</td><td style='display:none;'>$id</td><td>$name</td><td>$creationDate</td><td>$completionDate</td>";
						if($completionDate == null){
							echo "<td style='width: 100px'><div style='padding-left: 45px;'><label><input id='checkbox_$id' type='checkbox' value='".$id."' name='complete'></label></div></td></tr>";
						}else{
							echo "<td style='width: 100px'><div style='padding-left: 45px;'><label><input id='checkbox_$id' type='checkbox' value='".$id."' disabled name='complete' checked ></label></div></td></tr>";
						}
					}else{
						echo "<tr class='category1' id='$id' ><td style='display:none;'>$formationID</td><td style='display:none;'>$unitID</td><td style='display:none;'>$actionID</td><td style='display:none;'>$id</td><td>$name</td><td>$creationDate</td><td>$completionDate</td>";
						if($completionDate == null){
							echo "<td style='width: 100px'><div style='padding-left: 45px;'><label><input id='checkbox_$id' type='checkbox' value='".$id."' name='complete'></label></div></td></tr>";
						}else{
							echo "<td style='width: 100px'><div style='padding-left: 45px;'><label><input id='checkbox_$id' type='checkbox' value='".$id."' disabled name='complete' checked ></label></div></td></tr>";
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
			
			<div class="row">
			
			<div class="comments-container">				
				
					<h1 id="commentsHeader"></h1>
				
					<?php
					
						$comments = array();
						if(count($comments) != 0){
							echo "<h1>Περιγραφή & Σχόλια</h1>";
							echo '<ul id="comments-list" class="comments-list">';
						}
						
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
								echo '<div class="comment-avatar"><img src="view/images/'.$user->photo.'" alt=""></div>';
								echo '<div class="comment-box">';
								echo '<div class="comment-head">';
								echo '<h6 class="comment-name by-author"><a href="#">'.$user->name.'</a></h6>';
								echo '<span>'.$comment->dateTime.'</span>';
								echo '<i class="reply"></i>';
								echo '<i class="delete"></i>';
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
								echo '<div class="comment-avatar"><img src="view/images/'.$user->photo.'" alt=""></div>';
								echo '<div class="comment-box">';
								echo '<div class="comment-head">';
								echo '<h6 class="comment-name"><a href="*">'.$user->name.'</a></h6>';
								echo '<span>'.$comment->dateTime.'</span>';
								echo '<i class="reply"></i>';
								echo '<i class="delete"></i>';
								echo '</div>';
								echo '<div class="comment-content">';
								echo $comment->description;
								echo '</div>';
								echo '</div>';
								echo '</li>';
								
								$previousMessageType = 1;
							}
						}
						
						if($previousMessageType == 1)	//Sto proigoumeno sxolio riza upirxe sxolio paidi
							echo "</ul>";
						
						if(count($comments) != 0){
							echo "</li>";
							echo "</ul>";
						}
				
					?>
				
			</div>
			</div>
			
		</div>
		
		<button id="createComment" class="ui-button ui-corner-all ui-widget" style="float: right; display: block; margin-top: 15px; clear: both; visibility: hidden;" onClick="viewNewComment();">Εισαγωγή σχόλιου</button>
			
		<div id="new_comment" style="visibility: hidden;">
			<h4 style="clear: both; display: block; margin-top: 15px;">Νέο σχόλιο</h4>
            <form role="form">
				<input type="text" id="action" style="visibility: hidden;">
				<input type="text" id="commentID" style="visibility: hidden;">
                <div >
                    <textarea id="comment" ></textarea>
                </div>
                <button class="ui-button ui-corner-all ui-widget" type="button" id="submit_comment" onClick="submitComment('add');">Καταχώρηση σχολίου</button>
            </form>
        </div>
		
	</div>

</div>

</body>
</html>