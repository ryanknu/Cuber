function fadeLeaveBox(eID)
{
	eText = jQuery("#" + eID)[0];
	eLabel = jQuery("#label_" + eID)[0];
	if ( eText.value.length < 1 )
	{
		if ( ieLT9() )
		{
			eLabel.style.color = "#999";
			eLabel.style.display = "block";
		}
		else
		{
			eLabel.style.opacity = "1";
		}
	}
}

function log(msg) {
    setTimeout(function() {
        throw new Error(msg);
    }, 0);
}

function ieLT9()
{
	return jQuery.browser.msie && 
		parseInt(jQuery.browser.version, 10) < 9;
}

function fadeEnterIELT9(eID, event)
{
	LEN = 1;
	if ( event.keyCode == 8 )
		LEN = 2;
	eText = jQuery("#" + eID)[0];
	eLabel = jQuery("#label_" + eID)[0];
	if ( eText.value.length > LEN )
		eLabel.style.display = "none";
	else
	{
		eLabel.style.color = "#CCC";
		eLabel.style.display = "block";
	}
}

function fadeEnterBox(eID, event)
{
	//log("enterbox " + event.keyCode);
	if ( ieLT9() )
		return fadeEnterIELT9(eID, event);
	
	LEN = 0;
	if ( event.keyCode == 8 )
		LEN = 1;
	
	eText = jQuery("#" + eID)[0];
	eLabel = jQuery("#label_" + eID)[0];
	if ( eText.value.length > LEN )
		eLabel.style.opacity = "0";
	else
		eLabel.style.opacity = ".7";
}