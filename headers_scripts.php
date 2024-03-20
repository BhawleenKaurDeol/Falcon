<script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    <script src="vendors/jquery/jquery-3.4.1.js"></script>
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" />
    <script src="vendors/select2/js/select2.min.js"></script>
    <script src="vendors/sweetalert/sweetalert-v2.11.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <script src="javascript/general.js" defer></script>
    <script>
<?php 

echo ' let logged_user_id=\''.$_SESSION['ID_USER'].'\'; ';
if(isset($_GET)){
    foreach($_GET as $key => $value){
        echo 'let _JS_VAR_'.$key.'=\''.$value.'\'; ';
    }
    if(!isset($_GET['disabled'])){
        echo 'let _JS_VAR_disabled=\'off\'; ';
    }
    if(!isset($_GET['active_room'])){
        echo "let _JS_VAR_active_room=''; ";
    }
    if(!isset($_GET['active_building'])){
        echo "let _JS_VAR_active_building=''; ";
    }
    
}

?>
</script>