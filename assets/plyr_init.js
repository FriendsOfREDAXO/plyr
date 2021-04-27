document.addEventListener("DOMContentLoaded", function(){
 const players = Plyr.setup('.rex-plyr',{
	 youtube: { 
		 noCookie: true
	 },
	 vimeo: {
	        dnt: true
	 },
         iconUrl: '/assets/addons/plyr/vendor/plyr/dist/plyr.svg',
         blankVideo: '/assets/addons/plyr/vendor/plyr/dist/blank.mp4'
 });	
});
