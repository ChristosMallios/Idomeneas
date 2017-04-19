function viewResults() {
	
	var formation = $("#formations").children(".ui-selected").map(function () {
				return $(this).attr('id');
			}).get().join('; ');
	
	var unit = $("#units").children(".ui-selected").map(function () {
				return $(this).attr('id');
			}).get().join('; ');	
			
	var actions = $("#actions").children(".ui-selected").map(function () {
				return $(this).attr('id');
			}).get().join('; ').split(";");

	document.getElementById("formation").value = formation;
	document.getElementById("unit").value = unit;
		
	if(actions != ""){
		actionData = document.getElementById("actionData");
			
		for(var i=0; i<actions.length; ++i){
			var option = document.createElement("option");
			option.text = actions[i];
			option.selected = "selected";
			actionData.add(option);
		}
	} else
		document.getElementById("");
	
	return true;
}