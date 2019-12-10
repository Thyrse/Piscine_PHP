window.addEventListener("load", function() {
    var toggle_login = document.getElementById('toggle_login');
    var toggle_basket = document.getElementById('toggle_basket');
    var toggle_user = document.getElementById('toggle_user');
    var connect = document.getElementsByClassName('sign_in');
    var basket = document.getElementsByClassName('preview_basket');
    var user = document.getElementsByClassName('infos_user');
    var deleted = document.getElementById('delete_confirm');

    if (connect.length != 0)
    {
	    function AppearConnect() {
            connect[0].addEventListener("click", function(e){
                var styles = window.getComputedStyle(toggle_login);
                var value = styles.getPropertyValue('display');
                if (value == "none")
                {
                    toggle_login.style.display = "block";
                }
                else if (value == "block")
                {
                    toggle_login.style.display = "none";
                }
            })
        }
        AppearConnect();
    }
    if (basket.length != 0)
    {
        function AppearBasket() {
            basket[0].addEventListener("click", function(e){
                var styles = window.getComputedStyle(toggle_basket);
                var value = styles.getPropertyValue('display');
                if (value == "none")
                {
                    toggle_basket.style.display = "flex";
                }
                else if (value == "flex")
                {
                    toggle_basket.style.display = "none";
                }
            })
        }
        AppearBasket();
    }
    if (user.length != 0)
    {
        function AppearPanel() {
            user[0].addEventListener("click", function(e){
                var styles = window.getComputedStyle(toggle_user);
                var value = styles.getPropertyValue('display');
                if (value == "none")
                {
                    toggle_user.style.display = "flex";
                }
                else if (value == "flex")
                {
                    toggle_user.style.display = "none";
                }
            })
        }
        AppearPanel();
    }
    if (deleted !== null)
    {
        function clicked() {
            deleted.addEventListener("click", function(e){
            if (confirm('Voulez-vous vraiment effectuer cette action ?')) {
                return true;
            } else {
                e.preventDefault();
                return false;
            }
            })
         }
        clicked();
    }
});