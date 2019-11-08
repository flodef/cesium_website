function openMenu() {
	
	var menu = document.querySelector("header nav ul");
	
	var maxHeight = (menu.childElementCount * 2 + 1) + "rem";
	
	if (menu.style.height != maxHeight) {
		
		menu.style.height = maxHeight;
		
	} else {
		
		menu.style.height = "0rem";
		
	}
	
}

document.querySelector("header nav button").addEventListener("click", openMenu);

