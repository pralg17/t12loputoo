//Extension continues ------> Retrieving and managing saved websites

//Retrieving data from Firebase
var links = firebase.database().ref('Favourites').on('value', GetData, DataError);

function GetData(data){

    //Removing table row regeneration
    var table_rows = document.querySelectorAll('#table_row');
    for(i = 0; i < table_rows.length; i++){
      table_rows[i].remove();
    }


    var Urls = data.val();
    if(data.val() === null){
      console.log("Databse is empty");
      return;
    }
    var keys = Object.keys(Urls);
    if(keys === null){
      return;
    }

    //Creating the table for URL-s and tags
    var table = document.getElementById('site_table');

    for(i = 0; i < keys.length; i++){
      var k = keys[i];
      var link = Urls[k].Url;
      var tag = Urls[k].Tag;
      var date = Urls[k].Added;

      var t_row = document.createElement('tr');
      t_row.setAttribute('id', 'table_row');
      table.appendChild(t_row);

      var td1 = document.createElement('td');
      var td2 = document.createElement('td');
      var td3 = document.createElement('td');
      var td4 = document.createElement('td');
      t_row.appendChild(td1);
      t_row.appendChild(td2);
      t_row.appendChild(td3);
      t_row.appendChild(td4);

      var td1_content = document.createElement('a');
      td1_content.setAttribute('id', 'url_listing');
      td1_content.setAttribute('href', link);
      td1_content.innerHTML += link;
      td1.appendChild(td1_content);

      td2.setAttribute('id', "url_tag");
      td2.innerHTML += tag;

      td3.setAttribute('id', "added_date");
      td3.innerHTML += date;

      var td4_content1 = document.createElement('button');
      td4_content1.setAttribute('id', "delete_button");
      td4_content1.setAttribute('type', "button");
      td4_content1.className = "btn btn-danger btn-sm";

      var td4_content2 = document.createElement('span');
      td4_content2.className = "glyphicon glyphicon-trash";

      td4_content1.appendChild(td4_content2);
      td4.appendChild(td4_content1);

    }

}

//Getting the refrence for deletion
var rootRef = firebase.database().ref('Favourites');
rootRef.on('value', function(snapshot){

  var data = snapshot.val();
  var keys = Object.keys(data);

  for(i = 0; i < keys.length; i++){
    var del_buttons = document.querySelectorAll('#delete_button');
    for(i = 0; i < del_buttons.length; i++){
      del_buttons[i].addEventListener('click', deleteData.bind(null,  keys[i]), false);
    }
  }

});


function DataError(data){
    console.log("An error occurred, while retrieving data");
    console.log(err);
}

//Adding an eventlistener to the search button
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById("search_button").addEventListener("click", searchDataByTag);
});


function deleteData(tr_key){

  var rootRef = firebase.database().ref().child('Favourites').child(tr_key);
  rootRef.once('value', function(snapshot){
    console.log(snapshot.val(), "has been removed");
    if(snapshot.val() === null){
      console.log("Data does not exist");
    } else {
      rootRef.remove();
    }
  });

}

function searchDataByTag(){
	
	var value = document.getElementById('search_field').value;	
	
	var ref = firebase.database().ref('Favourites').orderByChild('Tag').equalTo(value);
	ref.on('value', function(snapshot){
		
				
		var table_rows = document.querySelectorAll('#table_row2');
		for(i = 0; i < table_rows.length; i++){
			table_rows[i].remove();
		}
		
		
		var data = snapshot.val();
		
		if(data === null){
			console.log("No data was found");
			return;
		}
		
		var keys = Object.keys(data);
		
		var table = document.getElementById('new_table');
		
		for(i = 0; i < keys.length; i++){
			var k = keys[i];
			var link = data[k].Url;
			var tag = data[k].Tag;
			var date = data[k].Added;
			
			var t_row = document.createElement('tr');
			t_row.setAttribute('id', 'table_row2');
			table.appendChild(t_row);

			var td1 = document.createElement('td');
			var td2 = document.createElement('td');
			var td3 = document.createElement('td');
			var td4 = document.createElement('td');
			t_row.appendChild(td1);
			t_row.appendChild(td2);
			t_row.appendChild(td3);
			t_row.appendChild(td4);

			var td1_content = document.createElement('a');
			td1_content.setAttribute('id', 'url_listing2');
			td1_content.setAttribute('href', link);
			td1_content.innerHTML += link;
			td1.appendChild(td1_content);

			td2.setAttribute('id', "url_tag2");
			td2.innerHTML += tag;

			td3.setAttribute('id', "added_date2");
			td3.innerHTML += date;
			
		}
		
	});
	
}
