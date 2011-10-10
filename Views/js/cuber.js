$.extend({URLEncode:function(c){var o='';var x=0;c=c.toString();var r=/(^[a-zA-Z0-9_.]*)/;
  while(x<c.length){var m=r.exec(c.substr(x));
    if(m!=null && m.length>1 && m[1]!=''){o+=m[1];x+=m[1].length;
    }else{if(c[x]==' ')o+='+';else{var d=c.charCodeAt(x);var h=d.toString(16);
    o+='%'+(h.length<2?'0':'')+h.toUpperCase();}x++;}}return o;},
URLDecode:function(s){var o=s;var binVal,t;var r=/(%[^%]{2})/;
  while((m=r.exec(o))!=null && m.length>1 && m[1]!=''){b=parseInt(m[1].substr(1),16);
  t=String.fromCharCode(b);o=o.replace(m[1],t);}return o;}
});

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