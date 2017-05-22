//Extension start -----> Save favourite websites

//Links array for duplication check
var links_array = [];

var siteURL = window.location.href;

//Performing double check for duplicates
//Otherwise people can add duplicate websites
//Will throw log an error If you're using the extension for the first time
window.addEventListener('DOMContentLoaded', dataCheck(siteURL));

console.log("Extension loaded");

window.addEventListener('copy', function(){

    //Getting the URL and adding it to Firebase
    var newURL = window.location.href;
    var duplicate_check = dataCheck(newURL);
    var date_added = getCurrentDateAndTime();
    var new_tag = prompt("What tag do you wish to add for this website?");

    if(duplicate_check === true || new_tag === null || new_tag === ""){

      console.log("An error occurred while adding to favourites");
      console.log("Either the website already exists or you didn't enter a tag for the website");
      return;

    } else {

        firebase.database().ref('Favourites/').push({
            Url: newURL,
            Tag: new_tag,
            Added: date_added
        });

        console.log(newURL, "Added to favourites");

    }

  });

//Duplication check
function dataCheck(data){

  var found;
	var rootRef = firebase.database().ref().child("Favourites");
	rootRef.on('value', function(snapshot){

		var Urls = snapshot.val();
		var keys = Object.keys(Urls);

		for(i = 0; i < keys.length; i++){
			var k = keys[i];
			var link = Urls[k].Url;
			links_array.push(link);
		}

	});

  for(i = 0; i < links_array.length; i++){
    if(links_array[i] === data){
      found = true;
    } else {
      found = false;
    }
  }

  links_array = []; //Emptying the array

  return found;

}

function getCurrentDateAndTime(){

  var currentDate = new Date();

  var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

  var month = currentDate.getMonth();
  var year = currentDate.getFullYear();
  var monthday = currentDate.getDate();

  var hours = currentDate.getHours();
  var minutes = currentDate.getMinutes();
  var seconds = currentDate.getSeconds();

  var dateString = monthday + '.' + months[month] + '.' + year;
  var timeString = addZeroBefore(hours) + ':' + addZeroBefore(minutes) + ':' + addZeroBefore(seconds);

  var full_dnt = dateString + " " + timeString;

  return full_dnt;

}

function addZeroBefore(timeNumber) {
    if (timeNumber < 10) {

        timeNumber = '0' + timeNumber;

    }

    return timeNumber;
}
