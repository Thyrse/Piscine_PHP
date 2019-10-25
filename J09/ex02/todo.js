window.addEventListener("load", function() {
    var list = document.getElementById('ft_list');
	var button = document.getElementById('button');
	var task;

	function checkCookie()
	{
		list.innerHTML = decodeURIComponent(getCookie('list'));
	}
	function getCookie(name)
	{
		var nom = name + "=";
		var ca = document.cookie.split(';');
		for(var i = 0; i < ca.length; i++)
		{
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1);
			if (c.indexOf(nom) == 0)
			{
				return c.substring(nom.length,c.length);
			}
		}
		return "";
	}
	function setCookie(name, value, exdays)
	{
		var d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		var expires = "expires=" + d.toUTCString();
		document.cookie = name + "=" + value + "; " + expires;
	}
    button.addEventListener("click", function(e) {
        var newdiv = prompt("Inserer une nouvelle ToDo");
        if (newdiv.length !== 0 && newdiv.trim())
        {
			task = document.createElement("div");
			task.setAttribute("class", "todo");
            task.innerHTML = newdiv;
            list.prepend(task);
		}
		date = new Date;
		date.setMonth(date.getMonth()+1);
		date = date.toUTCString();
		setCookie('list', encodeURIComponent(list.innerHTML), 1);
    });
    document.addEventListener("click", function(e) {
        if (e.target.className == 'todo')
        {
            if (confirm('Voulez-vous vraiment supprimer ce to do ?')) {
				e.target.remove();
				setCookie('list', encodeURIComponent(list.innerHTML), 1);
            }
        }
	});
	checkCookie();
});