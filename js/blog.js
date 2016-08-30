var myImage = document.getElementById("mainImage");

var imageArray = ["images/comp1.jpg","images/comp2.jpg","images/cssLogo.png","images/jsLogo.png", 
				   "images/mysqlLogo.png","images/phpLogo.png","images/webDev1.png","images/code.jpg"];
var imageIndex = 0;

function changeImage() {
	myImage.setAttribute("src",imageArray[imageIndex]);
	imageIndex++;
	if (imageIndex >= imageArray.length) {
		imageIndex = 0;
	}
}

var intervalHandle = setInterval(changeImage,5000);

myImage.onclick =  function() {
	clearInterval(intervalHandle);
};









