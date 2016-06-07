function buffer_src(src)
{
	var buffer = document.createElement('iframe');
	buffer.setAttribute("id", "buffer");
	buffer.src = src;
	buffer.name = src;
	document.body.appendChild(buffer);
	setTimeout(function() { push_buffer(); }, 5000);
}

function push_buffer()
{
	front = document.getElementById("front");
	buffer = document.getElementById("buffer");
	front.style.WebkitAnimationName = "out";
	buffer.style.WebkitAnimationName = "in";
	setTimeout(function() { swap(); }, 2000);
}

function swap()
{
	front = document.getElementById("front");
	buffer = document.getElementById("buffer");
	buffer.setAttribute("id", "front");
	front.parentNode.removeChild(front);
}

function loadXMLDocAutoUpdate()
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{
	    xmlhttp=new XMLHttpRequest();
	}
	else
	{
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    	front = document.getElementById("front");
			if(xmlhttp.responseText != front.name)
			{
				buffer_src(xmlhttp.responseText);
			}
	    }
	}
	xmlhttp.open("GET","subpages/behaviour.php",true);
	xmlhttp.send();
}

setInterval(loadXMLDocAutoUpdate,15000);
