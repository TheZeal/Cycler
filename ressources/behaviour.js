//pauses the cycling
function pause()
{
	meta["paused"] = true
}

//resume the cycling
function play()
{
	meta["paused"] = false
}

//accelerate the elapsed time. Goes up to x1000
function accelerate()
{
	meta["elapsedIncrement"] = Math.min(meta["elapsedIncrement"]*2, 1024*1024)
}

//decelerate the elapsed time. Goes up to /1000
function decelerate()
{
	meta["elapsedIncrement"] = Math.max(meta["elapsedIncrement"]/2, 1)
}

//push an iframe to front.
function swap(id)
{
	front = document.getElementById("front");
	if(front)
	{
		front.setAttribute("id", meta["current"]); // set back
	}
	buffer = document.getElementById(id);
	if(buffer)
	{
		buffer.setAttribute("id", "front"); //placed to front
	}
	meta["elapsed"] = 0 // and elapsed time is now zero cause we switched the iframe.
	meta["current"] = id
}

//calculates the id of the next frame.
function increment()
{
	return meta["current"]+1>=meta["size"] ? 0 : meta["current"] + 1
}

//gets the id of the previous frame
function decrement()
{
	return meta["current"]-1<0 ? meta["size"]-1 : meta["current"] -1
}

//switch the frame to next
function next()
{
	swap(increment())
}

//switch the frame to previous
function previous()
{
	swap(decrement())
}

//accessor for the intervals
function getCurrentInterval()
{
	return intervals[meta["current"]] 
}

//setter for the intervals
function appendFrameInterval(interval)
{
	intervals[meta["size"]] = interval
}

//creates a new iframe.
function appendIframe(src)
{
	var iframe = document.createElement('iframe');
	iframe.setAttribute("id", meta["size"]);
	iframe.src = src;
	document.body.appendChild(iframe);
}

//append a new iframe.
function append(src, interval)
{
	appendFrameInterval(interval) // adding the interval
	appendIframe(src) // and adding the actual link as a buffer.
	meta["size"]++ // there's one more iframe
}

// A clock function - allows the time to be stopped, or sped up.
function clock()
{
	if(!meta["paused"])
	{
		while(getCurrentInterval()<=meta["elapsed"]/1024) // skips pages with 0 s.
		{
			next();
		}
		meta["elapsed"]+=meta["elapsedIncrement"]
	}
}

var meta = {paused:false, current:0, size:0, elapsed:0, elapsedIncrement:1024}; //meta values of the page. I tolerate access to meta from anywhere.
var intervals = [] // the intervals per id, cause thats the only thing we need apart from meta. Set/access from a function.
setInterval(clock,1000); // launches the descisionnal clock (it decides wether it should call next() or not.)
