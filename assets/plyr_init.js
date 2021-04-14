document.addEventListener("DOMContentLoaded", function(){
 const players = Plyr.setup('.rex-plyr',{
	 youtube: { 
		 noCookie: true
	 },
	 vimeo: {
	        dnt: false
	 },
	 iconUrl: 'vendor/plyr/dist/plyr.svg',
         blankVideo: 'vendor/plyr/dist/blank.mp4'
 });	
});
