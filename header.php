<script>
<?php 
$_SESSION['ID_USER']=10;
echo ' let logged_user_id='.$_SESSION['ID_USER'].';';
?>
</script>
<header>
<img src="images/falcon-logo.svg" alt="Logo"class="app-logo">
<button class="menu_top_button" id="menu_top_button"><i class="fa-solid fa-bars fa-2xl"></i></button>

</header>
<aside class="menu_top_container"><nav class="menu_top_nav">
    <ul>
        <li><a href="profile.php">Profile <i class="fa-solid fa-user"></i></a></li>
        <li><a href="login_process.php?logout">Logout <i class="fa-solid fa-right-from-bracket"></i></a></li>
        <li><a href="#">Settings <i class="fa-solid fa-gear"></i></a></li>
        <li><a href="#">Help <i class="fa-solid fa-question"></i></a></li>
    </ul>
</nav>
</aside>
<script>
document.querySelector('.menu_top_button').addEventListener('click',function(){
    document.body.classList.toggle('menu_top_active');
})
    </script>