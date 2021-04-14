document.addEventListener("DOMContentLoaded", function(){
 const players = Plyr.setup('.rex-plyr',{
	 youtube: { 
		 noCookie: true
	 },
	 vimeo: {
	        dnt: false
	 },
	 iconUrl: 'plyr.svg',
         blankVideo: 'blank.mp4'
 });	
});
