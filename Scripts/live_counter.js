window.onload = function(){
	
	var c = document.getElementById("counter").textContent;

	var countDownDate = new Date(c).getTime();

	var x = setInterval(function() {

		var now = new Date().getTime();

		var distance = countDownDate - now;
		
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
		document.getElementById("counter").innerHTML = addZeroBefore(hours)+ ":" + addZeroBefore(minutes) + ":" + addZeroBefore(seconds);   

		if (distance < 0) {
			location.reload();
		}
	}, 1000);

	function addZeroBefore(dateNumber) {
		if (dateNumber < 10) {
			dateNumber = '0' + dateNumber;
		}
		return dateNumber;
	}
}