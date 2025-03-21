<header>
    <div class="content flex_space">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="">
        </div>
        <div class="navlinks">
            <ul id="menulist">
                <li><a href="#home">home</a></li>
                <li><a href="#about">about</a></li>
                <li><a href="#rooms">rooms</a></li>
                <li><a href="#pages">pages</a></li>
                <li><a href="#news">news</a></li>
                <li><a href="#contact">contact</a></li>
                <li><i class="fa fa-search"></i></li>
                <li><button class="primary-btn">BOOK NOW</button></li>
            </ul>
            <span class="fa fa-bars" onclick="menutoggle()"></span>
        </div>
    </div>
</header>

<script>
    var menulist = document.getElementById('menulist');
    menulist.style.maxHeight = "0px";

    function menutoggle() {
        if (menulist.style.maxHeight == "0px") {
            menulist.style.maxHeight = "100vh";
        } else {
            menulist.style.maxHeight = "0px";
        }
    }
</script>