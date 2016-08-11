var context = {paused:false, curr:0, linkNumber:0, elapsed:0} //context of the page.
var intervals = [] // the intervals per id
setInterval(clock,1000);
remoteControl();

//pauses the cycling
function pause()
{
	context.paused = true
	showText("▐▐", 3000);
}

//resume the cycling
function play()
{
	context.paused = false
	showText("►", 3000);
}

function setIframeToNext()
{
	setCurrent(getNext())
	showText("►►", 3000);
}

function setIframeToPrevious()
{
	setCurrent(getPrevious())
	showText("◀◀", 3000);
}

//sets the current frame to the id.
function setCurrent(id)
{
	pushToBack(); //front goes to back
	pushToFront(id); // id goes to front
	context.elapsed = 0; // and elapsed time is now zero cause we switched the iframe.
	context.curr = id; // now id is the new current id.
}

//push the current iframe to back.
function pushToBack()
{
	front = document.getElementById("front");
	if(front)
	{
		front.setAttribute("id", context.curr); // set back
	}
}
//push an iframe to front.
function pushToFront(id)
{
	buffer = document.getElementById(id);
	if(buffer)
	{
		buffer.setAttribute("id", "front"); //placed to front
	}
}

//calculates the id of the next frame.
function getNext()
{
	return context.curr+1>=context.linkNumber ? 0 : context.curr + 1
}

//gets the id of the previous frame
function getPrevious()
{
	return context.curr-1<0 ? context.linkNumber-1 : context.curr -1
}

//accessor for the intervals
function getCurrentInterval()
{
	return intervals[context.curr] 
}

//setter for the intervals
function appendFrameInterval(interval)
{
	intervals[context.linkNumber] = interval
}

//creates a new iframe.
function appendIframe(src)
{
	var iframe = document.createElement('iframe');
	iframe.setAttribute("id", context.linkNumber);
	iframe.src = src;
	document.body.appendChild(iframe);
}

//append a new iframe.
function append(src, interval)
{
	appendFrameInterval(interval) // adding the interval
	appendIframe(src) // and adding the actual link as a buffer.
	context.linkNumber++ // there's one more iframe
}

//show text for X milliseconds
function showText(text, timeout)
{
	over = document.getElementById("over");
	if(over)
	{
		over.innerHTML = text;
	}
	setTimeout(resetText,timeout);
}

//reset the text shown.
function resetText()
{
	over = document.getElementById("over");
	if(over)
	{
		over.innerHTML = "";
	}
}

//creates a new iframe.
function appendIframe(src)
{
	var iframe = document.createElement('iframe');
	iframe.setAttribute("id", context.linkNumber);
	iframe.src = src;
	document.body.appendChild(iframe);
}

//append a new iframe.
function append(src, interval)
{
	appendFrameInterval(interval) // adding the interval
	appendIframe(src) // and adding the actual link as a buffer.
	context.linkNumber++ // there's one more iframe
}

// The clock of the page. 
function clock()
{
	if(!context.paused)
	{
		while(getCurrentInterval()<=context.elapsed) // skips pages with 0 s.
		{
			setIframeToNext();
		}
		context.elapsed+=1;
	}
}

function remoteControl()
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
		console.log( "SOMETHING?" );

	    if (xmlhttp.readyState==4)
		{
		    if (xmlhttp.status==200)
		    {
	/*	    	front = document.getElementById("front");
				if(xmlhttp.responseText != front.name)
				{
					buffer_src(xmlhttp.responseText);
				}
	*/
				console.log( "REMOTE CONTROL "+xmlhttp.responseText );
				action = xmlhttp.responseText;
				if (action=="right")
					setIframeToNext();
				if (action=="left")
					setIframeToPrevious();
				if (action=="play")
					play();
				if (action=="pause")
					pause();
				remoteControl();
		    }
		    else
			{
				console.log( "REMOTE CONTROL ERROR" );
				setTimeout( remoteControl, 1000 );
			}
		}
	}
	xmlhttp.open("GET","http://localhost:8182",true);
	xmlhttp.send();
}
