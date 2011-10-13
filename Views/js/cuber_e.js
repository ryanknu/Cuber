// **
// * Cuber Main Javascript File
// * Compile this file as cuber.js with
// *   http://closure-compiler.appspot.com/home
// * before applying to production.
// *
// * todo: add an auto-compiler. the app_settings table
// * has placeholders for the data required. maaaaybe.
// * or the developers can just suffer.
// ** 

// **
// * If you change this file: RECOMPILE IT
// * kthnx
// **

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

// NOTE

var viewportA = "#viewportA";
var viewportB = "#viewportB";
var currentViewport = "#viewportA";
$(document).ready(function() {
	$(viewportB)[0].style.left = window.innerWidth + "px";
	$(viewportB)[0].style.display = "none";
});

function hide(selector)
{
	$(selector)[0].innerHTML = "";
	$(selector)[0].style.display = "none";
}

function jump_directional(resource, direction)
{
	dir = "+=";
	pos = -1;
	if ( direction == "left" )
	{
		dir = "-=";
		pos = 1;
	}
		
	// get offscreen viewport
	vp = viewportA;
	if ( currentViewport == viewportA )
		vp = viewportB;
	
	// move offscreen viewport in case window has resized
	$(vp)[0].style.left = (pos * window.innerWidth) + "px";
	$(vp)[0].style.display = "block";
	$(vp)[0].style.width = window.innerWidth + "px";
	
	$.ajax({
		url: resource,
		success: function(data, textStatus, jqXHR)
		{
			speed = 200;
			$(vp)[0].innerHTML = ( data );
			$(currentViewport).animate({"left": dir + window.innerWidth + "px"}, speed);
			$(vp).animate({"left": dir + window.innerWidth + "px"}, speed);
			setTimeout('hide("' + currentViewport + '");', speed);
			currentViewport = vp;		
		}
	});
}

function jump_left(resource)
{
	jump_directional(resource, "left");
}

function jump_right(resource)
{
	jump_directional(resource, "right");
}

function load_cube_list()
{
	$.ajax({
		url: "Requests/cube/select.php",
		success: function(data, textStatus, jqXHR)
		{
			$(currentViewport)[0].innerHTML = ( data );
		}
	});
}

function cube_grid_click(str_identifier)
{
	if ( str_identifier == "new" )
	{
		$("#cube_cell_new")[0].innerHTML = "Hang tight, making your cube.";
		$.ajax({
			url: "Requests/cube/create.php",
			success: function(data, textStatus, jqXHR)
			{					
				load_cube_list();
			}
		});
	}
	else
	{
		jump_left("Requests/cube/edit.php?cube=" + str_identifier);
	}
}

function set_grid_click(identifier)
{
	$.ajax({
		url: "Requests/set/list.php?set=" + identifier,
		success: function(data, textStatus, jqXHR)
		{					
			$("#cube_main_right")[0].innerHTML = data;
		}
	});
}

function edit_cube()
{
	$("#cube_main_left").animate({"width": "262px"}, 500);
	$(".flow").animate({"width": "250px"}, 500);
	flows = $(".flow");
	cmr =  $("#cube_main_right")[0];
	cml = $("#cube_main_left")[0];
	cmr.style.display = "inline-block";
	cmr.style.width = (window.innerWidth - 300) + "px";
	cmr.style.height = (window.innerHeight - 125) + "px";
	cml.style.height = (window.innerHeight - 125) + "px";
	$.ajax({
		url: "Requests/set/select.php",
		success: function(data, textStatus, jqXHR)
		{					
			$("#cube_main_right")[0].innerHTML = data;
		}
	});
}