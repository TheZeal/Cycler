function remove_link(id)
{
	var div = document.getElementById("page_" + id);
	if(div)
	{
		div.style.webkitAnimationName = "on_delete";
		div.setAttribute("id", "foo");
		document.getElementById("link_" + id).removeAttribute("id");
		document.getElementById("delay_" + id).removeAttribute("id");
		button = document.getElementById("remove_" +id);
		button.removeAttribute("id");
		button.removeAttribute("onclick");
		handler = (function(div)
		{
		    return function()
		    {
		        return delete_elem(div);
		    }
		}(div));
		setTimeout(handler, 1000);
	}
	id++;
	while(div = document.getElementById("page_" + id))
	{
		div.setAttribute("id", "page_" + (id-1));
		document.getElementById("link_" + id).setAttribute("id", "link_" + (id-1));
		document.getElementById("delay_" + id).setAttribute("id", "delay_" + (id-1));
		button = document.getElementById("remove_" +id);
		button.setAttribute("id", "remove_" + (id-1));
		button.setAttribute("onclick", "remove_link(" + (id-1) + ")");
		id++;
	}
}

function delete_elem(elem)
{
	elem.parentNode.removeChild(elem);
}

function append_link()
{
	id = 1;
	while(document.getElementById("page_" + id))
	{
		id++;
	}
	container = document.getElementById("link_list");
	div = document.createElement("div");
	div.setAttribute("class", "link_container");
	div.setAttribute("id", "page_"+id);
	div.style.webkitAnimationName = "on_create";
	wrapper = document.createElement("div");
	wrapper.setAttribute("class", "link_wrapper");
	textarea = document.createElement("textarea");
	textarea.setAttribute("id", "link_"+id);
	textarea.setAttribute("cols", "80");
	textarea.setAttribute("rows", "1");
	textarea.setAttribute("placeholder", "http://your-adress.here");
	wrapper.appendChild(textarea);
	input = document.createElement("input");
	input.setAttribute("type", "text");
	input.setAttribute("id", "delay_" + id);
	input.setAttribute("placeholder", "delay(s)");
	wrapper.appendChild(input);
	button = document.createElement("button");
	button.setAttribute("id", "remove_"+id);
	button.setAttribute("class", "removebutton");
	button.innerHTML = "delete";
	wrapper.appendChild(button);
	wrapper.appendChild(document.createElement("br"));
	div.appendChild(wrapper);
	container.appendChild(div);
	handler = (function(div, id)
	{
	    return function()
	    {
	        return activate(div, id);
	    }
	}(div, id));
	setTimeout(handler, 1000);
}

function activate(elem, id)
{
	elem.style = null;
	document.getElementById("remove_"+id).setAttribute("onClick", "remove_link("+id+")");
}

function post_changes()
{
	form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", window.location.href.replace("&validate=1", "").replace("&reset=1", "").replace("&deleteall=1", "") +"&validate=1");
	id = 1;
	while(document.getElementById("page_" + id))
	{
		field = document.createElement("input");
		field.setAttribute("type", "hidden");
		field.setAttribute("name", "link_"+id);
		field.setAttribute("value", document.getElementById("link_"+id).value);
		form.appendChild(field);
		field = document.createElement("input");
		field.setAttribute("type", "hidden");
		field.setAttribute("name", "delay_"+id);
		field.setAttribute("value", document.getElementById("delay_"+id).value);
		form.appendChild(field);
		id++;
	}
	document.body.appendChild(form);
	form.submit();
}
