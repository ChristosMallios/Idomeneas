function updateCommentState(eventID){
	
	$.ajax({
        url: 'index.php?class=comments&action=updateState',
        type: 'GET',
        cache: false,
        data: {"eventID" : eventID},
		//contentType: "application/json; charset=utf-8",
		//dataType: "json",
        success: function(data) {
			
			var id = 'checkbox_'+eventID;
			var checkBox = document.getElementById(id);
			checkBox.disabled = true;
		}
		//priptwsi fail??
	});
}

function updateComments(eventID){
	
	$.ajax({
        url: 'index.php?class=comments&action=get',
        type: 'GET',
        cache: false,
        data: {"eventID" : eventID},
		contentType: "application/json; charset=utf-8",
		dataType: "json",
        success: function(comments) {
			
			insertStartList = false;
			var list = document.getElementById("comments-list");
			document.getElementById("commentsHeader").innerHTML = eventID;
			document.getElementById("commentsHeader").style.visibility = "hidden";
			document.getElementById("comment").value = "";
			
			if(list == null){
				list = document.createElement('ul');
				list.setAttribute("id", "comments-list");
				list.setAttribute("class", "comments-list");
				insertStartList = true;
			}
			list.innerHTML = "";
			
			var previousMessageType= 0;
			var i, comment, li, li_child, ul, divMainLvl, divAvatar, divComment, divContent, divHead, span, spanTxt, htmlI, description, photo, h6, nameTxt, htmlA;
			for(i=0; i<comments.length; ++i){
				
				comment = comments[i];
							
				if(comment.type == 1){	
					
					if(i != 0){	
						//echo "</li>";
						//alert("append to li");
						li.appendChild(divMainLvl);
						if(previousMessageType == 1){							
							//echo "</ul>";
							//alert("append to ul ");
							//console.log(ul);
							li.appendChild(ul);
						}
						list.appendChild(li);
						console.log(list);
					}	
					
					//echo "<li>";
					li=document.createElement('li');
					//echo '<div class="comment-main-level">';
					//alert("1");
					divMainLvl = document.createElement("div");
					divMainLvl.setAttribute("class", "comment-main-level");
					span = document.createElement("span");
					span.style.display = "none";
					spanTxt= document.createTextNode(comment.id);
					span.appendChild(spanTxt);
					divMainLvl.appendChild(span);
					//echo '<div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>';
					//alert("2");
					divAvatar = document.createElement("div");
					divAvatar.setAttribute("class", "comment-avatar");
					//alert("2-1");
					photo = document.createElement("img");
					photo.setAttribute("src", "view/images/"+comment.user.photo);
					photo.setAttribute("alt", "");
					//alert(photo);
					//console.log(photo);
					divAvatar.appendChild(photo);
					divMainLvl.appendChild(divAvatar);
					//alert("3");
					//echo '<div class="comment-box">';
					divComment = document.createElement("div");
					divComment.setAttribute("class", "comment-box");
					//echo '<div class="comment-head">';
					divHead =  document.createElement("div");
					divHead.setAttribute("class", "comment-head");
					//echo '<h6 class="comment-name by-author"><a href="#">'.$user->name.'</a></h6>'; ---
					h6 = document.createElement("h6");
					h6.setAttribute("class", "comment-name by-author");
					htmlA = document.createElement('a');
					nameTxt= document.createTextNode(comment.user.name);
					htmlA.appendChild(nameTxt);
					htmlA.href = "#";
					h6.appendChild(htmlA);
					divHead.appendChild(h6);
					//echo '<span>'.$comment->dateTime.'</span>';
					//alert("4");
					span = document.createElement("span");
					spanTxt= document.createTextNode(comment.dateTime);
					span.appendChild(spanTxt);
					divHead.appendChild(span);
					//alert("5");
					//echo '<i class="edit"></i>';
					htmlI = document.createElement("img");
					htmlI.setAttribute("class", "icons");
					htmlI.setAttribute("src", "view/images/edit.png");
					htmlI.setAttribute("alt", "");
					htmlI.setAttribute("onclick", "viewComment('edit', '"+comment.id+"', '"+comment.description+"');");
					divHead.appendChild(htmlI);
					//echo '<i class="delete"></i>';
					if(i != 0){
						htmlI = document.createElement("img");
						htmlI.setAttribute("class", "icons");
						htmlI.setAttribute("src", "view/images/delete.png");
						htmlI.setAttribute("alt", "");
						htmlI.setAttribute("onclick", "deleteComment("+comment.id+");");
						divHead.appendChild(htmlI);
					}
					//echo '<i class="reply"></i>';
					if(i != 0){
						htmlI = document.createElement("img");
						htmlI.setAttribute("class", "icons");
						htmlI.setAttribute("src", "view/images/reply.png");
						htmlI.setAttribute("alt", "");
						var replyData = "\\n \\n \\n-------Απάντηση------------ \\n Από: "+comment.user.name+" \\n Ημερομηνία: "+comment.dateTime+" \\n \\n "+comment.description+" \\n";
						htmlI.setAttribute("onclick", "viewComment('reply', '"+comment.id+"', '"+replyData+"');");
						divHead.appendChild(htmlI);
					}
					//echo '</div>';
					divComment.appendChild(divHead);
					//echo '<div class="comment-content">';
					divContent =  document.createElement("div");
					divContent.setAttribute("class", "comment-content");
					//echo $comment->description;
					description = document.createTextNode(comment.description);
					divContent.appendChild(description);
					//echo '</div>';
					divComment.appendChild(divContent);
					//echo '</div>';
					divMainLvl.appendChild(divComment);
					//echo '</div>';
					li.appendChild(divMainLvl);
							
					previousMessageType = 0;
					existChildMessage = 0;		
				} else {					//sxolio paidi
				
					/*			
					if($previousMessageType == 0)	//1o sxolio paidi
						echo '<ul class="comments-list reply-list">';
					*/
					
					if(previousMessageType== 0){
						ul = document.createElement("div");
						ul.setAttribute("class", "comments-list reply-list");
					}		
		
					//echo '<li>';
					li_child = document.createElement("li");
					span = document.createElement("span");
					span.style.display = "none";
					spanTxt= document.createTextNode(comment.id);
					span.appendChild(spanTxt);
					li_child.appendChild(span);
					//echo '<div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>';
					divAvatar = document.createElement("div");
					divAvatar.setAttribute("class", "comment-avatar");
					photo = document.createElement("img");
					photo.setAttribute("src", "view/images/"+comment.user.photo);
					photo.setAttribute("alt", "");
					divAvatar.appendChild(photo);
					li_child.appendChild(divAvatar);
					
					//echo '<div class="comment-box">';
					divComment = document.createElement("div");
					divComment.setAttribute("class", "comment-box");
					//echo '<div class="comment-head">';
					divHead =  document.createElement("div");
					divHead.setAttribute("class", "comment-head");
					//echo '<h6 class="comment-name"><a href="*">'.$user->name.'</a></h6>';
					h6 = document.createElement("h6");
					h6.setAttribute("class", "comment-name");
					htmlA = document.createElement('a');
					nameTxt= document.createTextNode(comment.user.name);
					htmlA.appendChild(nameTxt);
					htmlA.href = "#";
					h6.appendChild(htmlA);
					divHead.appendChild(h6);
					//echo '<span>'.$comment->dateTime.'</span>';
					span = document.createElement("span");
					spanTxt= document.createTextNode(comment.dateTime);
					span.appendChild(spanTxt);
					divHead.appendChild(span);
					//echo '<i class="edit"></i>';
					htmlI = document.createElement("img");
					htmlI.setAttribute("class", "icons");
					htmlI.setAttribute("src", "view/images/edit.png");
					htmlI.setAttribute("alt", "");
					htmlI.setAttribute("onclick", "viewComment('edit', '"+comment.id+"', '"+comment.description+"');");
					divHead.appendChild(htmlI);
					//echo '<i class="delete"></i>';
					htmlI = document.createElement("img");
					htmlI.setAttribute("class", "icons");
					htmlI.setAttribute("src", "view/images/delete.png");
					htmlI.setAttribute("alt", "");
					htmlI.setAttribute("onclick", "deleteComment("+comment.id+");");
					divHead.appendChild(htmlI);
					//echo '</div>';
					divComment.appendChild(divHead);
					//echo '<div class="comment-content">';
					divContent =  document.createElement("div");
					divContent.setAttribute("class", "comment-content");
					//echo $comment->description;
					description = document.createTextNode(comment.description);
					divContent.appendChild(description);
					//echo '</div>';
					divComment.appendChild(divContent);
					//echo '</div>';
					li_child.appendChild(divComment);
					//echo '</li>';
					ul.appendChild(li_child);
					//console.log(ul);
						
					//$previousMessageType = 1;
					previousMessageType = 1;
				}
			}

			if(comments.length != 0)
				li.appendChild(divMainLvl);
			
			if(previousMessageType == 1)
				li.appendChild(ul);

			//echo "</li>";
			
			if(comments.length != 0)
				list.appendChild(li);
			
			//document.getElementsByClassName("row")[0].appendChild(h1);
			//document.getElementById("commentsHeader").
			if(insertStartList){
				document.getElementsByClassName("comments-container")[0].appendChild(list); 
			}
			
			if(comments.length == 0){
				document.getElementsByClassName("comments-container")[0].style.visibility = "hidden";
			}  else{
				document.getElementsByClassName("comments-container")[0].style.visibility = "visible";
			}
			

			document.getElementById("new_comment").style.visibility = "visible";
			document.getElementById("action").value = "add";
        }
    });
	
}

function viewNewComment(){
	document.getElementById("new_comment").style.visibility = "visible";
	document.getElementById("action").value = "add";
}

function viewComment(action, commentID, comment){
	document.getElementById("new_comment").style.visibility = "visible";
	if(comment != null)
		document.getElementById("comment").value = comment;
	document.getElementById("action").value = action;
	document.getElementById("commentID").value = commentID;
}

function deleteComment(commentID){
	document.getElementById("action").value = "delete";
	document.getElementById("commentID").value = commentID;
	submitComment();
}

function submitComment(){
	
	var userID = document.getElementById("userID").innerHTML;
	
	var commentID = document.getElementById("commentID").value;
	var action = document.getElementById("action").value;
	var eventID = document.getElementById("commentsHeader").innerHTML;
	var description = document.getElementById("comment").value.trim();
	
	if(action == "delete"){
		
		$.ajax({
			url: 'index.php?class=comments&action=delete',
			type: 'POST',
			cache: false,
			data: {"commentID" : commentID},

			success: function(data) {
				
				updateComments(eventID);
			}
			//priptwsi fail??
		});
	} else if(action == "edit"){
		
		$.ajax({
			url: 'index.php?class=comments&action=update',
			type: 'POST',
			cache: false,
			data: {"description" : description, "commentID" : commentID},

			success: function(data) {
				
				updateComments(eventID);
			}
			//priptwsi fail??
		});
		
	} else if(action == "reply") {
		
		description = description.split(/-------Απάντηση------------/g)[0].trim();

		$.ajax({
			url: 'index.php?class=comments&action=add',
			type: 'POST',
			cache: false,
			data: {"description" : description, "eventID" : eventID, "userID" : userID, "parent" : commentID},

			success: function(data) {
				
				updateComments(eventID);
			}
			//priptwsi fail??
		});
	} else {

		$.ajax({
			url: 'index.php?class=comments&action=add',
			type: 'POST',
			cache: false,
			data: {"description" : description, "eventID" : eventID, "userID" : userID},

			success: function(data) {
				
				updateComments(eventID);
				document.getElementById("container").scrollTop = document.getElementById("container").scrollHeight;
			}
			//priptwsi fail??
		});
	} 
	
	document.getElementById("action").value = "add";
}
