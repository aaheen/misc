/* Slide show for TNG media groupings. Images are loaded into a hidden div, then cycled to the front */

function Slideshow(options) {
	var slidetime = "3.0";
	var controls;
	var sscontrols;
	var slidemsg;

	// Link to pause or resume the slide show
	slidemsg = document.createElement('span');
	slidemsg.id = "slidemsg";
	slidemsg.className = "smaller";
	slidemsg.innerHTML = '&nbsp;&nbsp; <a href="#" onclick="return stopshow();" id="slidetoggle" class="lightlink">' + slidestopmsg + '</a> &nbsp;&nbsp; ';
	jQuery('#LB_titletext').append(slidemsg);

	// Control panel for changing time between slides
	sscontrols = document.createElement('span');
	sscontrols.id = "sscontrols";
	sscontrols.className = "smaller";
	controls = slidesecsmsg + '\n<a href="#" title="' + minussecsmsg + '" onclick="return changeSlideTime(-500)"><img src="' + cmstngpath + 'img/tng_minus.gif" alt="' + minussecsmsg + '" name="minus" class="slidetimes" /></a>\n';
	controls += '<span id="sssecs">' + slidetime + '</span>\n';
	controls += '<a href="#" title="' + plussecsmsg + '" onclick="return changeSlideTime(500)"><img src="' + cmstngpath + 'img/tng_plus.gif" alt="' + plussecsmsg + '" name="plus" class="slidetimes" /></a>\n';
	sscontrols.innerHTML = controls;
	jQuery('#LB_titletext').append(sscontrols);

	this.slides = [];
	this.slides.push(jQuery('#div0'));
	this.slides.push(jQuery('#div1'));

	this.timeout = options.timeout;
	this.front = 1;
	this.back = 0;
	this.ready = 0;
	this.paused = false;

	this.startingID = options.startingID;
	this.previousID = options.mediaID;
	this.mediaID = options.mediaID;
	this.medialinkID = options.medialinkID;
	this.albumlinkID = options.albumlinkID;
	this.cemeteryID = options.cemeteryID;

	this.slides[this.front].css('z-index', 1);
	this.slides[this.back].css('z-index', 0);

	this.next();
}
Slideshow.prototype = {
	// Display the next slide
	next: function() {
		if(this.slides[this.back].html()) {
			this.slides[this.back].show();

            if(jQuery('#div0').length) {
    			var slideheight = jQuery('#div' + this.back).height();
    			var ssheight = jQuery('#slideshow').height();
    			if(!ssheight || ssheight < slideheight) {
    				jQuery('#div' + this.front).height(slideheight);
    				jQuery('#slideshow').height(slideheight);
    			}
    			var slidewidth = jQuery('#div' + this.back).width();
    			var sswidth = jQuery('#slideshow').width();
    			if(!sswidth || sswidth < slidewidth) {
    				jQuery('#div' + this.front).width(slidewidth);
    				jQuery('#slideshow').width(slidewidth);
    			}

    			this.slides[this.front].css('z-index', 2);
    			this.slides[this.back].css('z-index', 1);

				// Fade out the slide in front
    			jQuery('#loadingdiv').hide();
    			var frontslide = this.slides[this.front];
    			frontslide.fadeOut(300, function() {
					frontslide.css('z-index',0);
					frontslide.css('opacity',1);
					if(!myslides.paused)
    					startTimeout(myslides);
					myslides.front = (myslides.front + 1) % 2;
					myslides.back = (myslides.back + 1) % 2;
					myslides.ready = 0;
					myslides.loadslide();
    			});
            }
		}
		else {
			startTimeout(this);
			this.loadslide();
		}
	},
	// Load the next slide
	loadslide: function() {
		var strParams = 'mediaID=' + this.mediaID + '&medialinkID=' + this.medialinkID + '&albumlinkID=' + this.albumlinkID + '&cemeteryID=' + this.cemeteryID;
		var params = {mediaID: this.mediaID, medialinkID: this.medialinkID, albumlinkID: this.albumlinkID, cemeteryID: this.cemeteryID};
		// alert(strParams);
		jQuery.ajax({
			url: showmediaxmlfile,
			data: params,
			dataType: 'html',
			type: 'POST',
			success: getNextSlide
		});
	}
}

// Set time for next slide
function startTimeout(slide) {
	clearTimeout(timeoutID);
    timeoutID = setTimeout((function(){slide.next();}).bind(slide), slide.timeout + 500);
}

// Insert next content into back slide
function getNextSlide(req) {
	var pair;
	var mediaID = "";
	var medialinkID = "";
	var albumlinkID = "";

	var contentstart = req.indexOf('<');
	var arglist = req.substr(0,contentstart).trim();
	var content = req.substr(contentstart);

	// parameters for new slide
	arglist.replace('&amp;','&');
	var args = arglist.split("&");
	for(i = 0; i < args.length; i++) {
		pair = args[i].split("=");
		if(pair[0] == "mediaID")
			mediaID = pair[1];
		else if(pair[0] == "medialinkID")
			medialinkID = pair[1];
		else if(pair[0] == "albumlinkID")
			albumlinkID = pair[1];
	}

	// slide show has finished
	if(!repeat && myslides.previousID == myslides.startingID) {
		stopshow(startmsg);
	}

	myslides.previousID = myslides.mediaID;
	myslides.mediaID = mediaID;
	myslides.medialinkID = medialinkID;
	myslides.albumlinkID = albumlinkID;

	// insert content
    if(jQuery('#div0').length) {
    	jQuery('#div' + myslides.back).hide();
    	jQuery('#div' + myslides.back).html(content);
    }
	myslides.ready = 1;
}

// Pause or resume the slideshow
function stopshow(msg) {
	if(myslides.paused) {
		jQuery('#slidetoggle').html(slidestopmsg);
		myslides.paused = false;
		jQuery('#sscontrols').fadeIn(300);
		timeoutID = setTimeout((function(){myslides.next();}).bind(myslides), myslides.timeout + 500);
	}
	else {
		clearTimeout(timeoutID);
		timeoutID = false;
		myslides.paused = true;
		if(!msg) msg = resumemsg;
		jQuery('#slidetoggle').html(msg);
	   	jQuery('#sscontrols').fadeOut(300);
	}
	return false;
}

// Reveal slide we just jumped to, then fetch next
function jump(mediaID,medialinkID,albumlinkID) {
	if(timeoutID || tnglitbox) {
		clearTimeout(timeoutID);
		timeoutID = false;
		jQuery('#div' + myslides.back).html('');
		jQuery('#div' + myslides.front).animate({opacity:0.4},200, function() {
			jQuery('#loadingdiv').css('display', 'block');
		});

		myslides.previousID = myslides.mediaID;
		myslides.mediaID = mediaID;
		myslides.medialinkID = medialinkID;
		myslides.albumlinkID = albumlinkID;

		startTimeout(myslides);
		myslides.loadslide();
		return false;
	}
	else
		return true;
}

// Jump to another slide out of sequence
function jumpnext(mediaID,medialinkID,albumlinkID) {
	if(timeoutID || tnglitbox) {
		if(myslides.ready) {
			clearTimeout(timeoutID);
			timeoutID = false;
			myslides.next();
			return false;
		}
		else
			return jump(mediaID,medialinkID,albumlinkID);
	}
	else
		return true;
}

// Adjust time between slides
function changeSlideTime(delta) {
	if((myslides.timeout > 1000 && delta < 0) || (myslides.timeout < 10000 && delta > 0))
		myslides.timeout += delta;
	var secs = myslides.timeout / 1000;
	jQuery('#sssecs').html(secs.toPrecision(2));
	return false;
}