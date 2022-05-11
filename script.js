
	let valueDisplays = document.querySelectorAll(".number");
	let inerval = 5000;

	valueDisplays.forEach((valueDisplay) => {
		let startValue = 0;
		let endValue = parseInt(valueDisplays.getAttribute("data-val"));
		let duration = Math.floor(inerval / endValue);
		let counter = setInterval( function () {
			startValue += 1;
			valueDisplay.textContent =  startValue;
			if (startValue == endValue){
				clearInterval(counter);
			}
		});
			
	});
