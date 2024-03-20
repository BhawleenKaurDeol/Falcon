<header>

<a href="index.php" class="link-logo"><img src="images/eagle.svg" alt="Logo"class="app-logo"></a>
<h1><?=$page_title?></h1>
<button class="menu_top_button" id="menu_top_button"><img src="<?=get_user_picture($_SESSION['ID_USER'])?>" alt="" class="settings_btn"></button>

</header>
<aside class="menu_top_container"><nav class="menu_top_nav">
    <ul>
        <li><a href="profile2.php">Profile <i class="fa-solid fa-user"></i></a></li>
        <li><a href="#">Settings <i class="fa-solid fa-gear"></i></a></li>
        <li><a href="#">Help <i class="fa-solid fa-question"></i></a></li>
        <li><a href="login_process.php?logout">Logout <i class="fa-solid fa-right-from-bracket"></i></a></li>
    </ul>
</nav>
</aside>
<script>
document.querySelector('.menu_top_button').addEventListener('click',function(){
    document.body.classList.toggle('menu_top_active');
})
    </script>