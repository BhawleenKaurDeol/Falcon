<?php
header( 'Content-Type: text/html; charset=UTF-8' );
header( "Access-Control-Allow-Origin: *" );
$force_login=false;
include "includes/application_top.php";

// set id for search => numeric
$action='SELECT';
if(isset($_POST['action'])){
    if($_POST['action']=='1'){
        $action='UPDATE';
    }elseif($_POST['action']=='0'){
        $action='INSERT';
    }
}



if(!isset($_REQUEST['id'])){
$_REQUEST['id']='';
}elseif(empty($_REQUEST['id'])){
$_REQUEST['id']='';
	}
$id=$_REQUEST['id']; 

if(!isset($_REQUEST['room'])){
$_REQUEST['room']='';
}elseif(empty($_REQUEST['room'])){
$_REQUEST['room']='';
	}
$room=$_REQUEST['room']; 

// set type for search => string 
if(!isset($_REQUEST['t'])){
$_REQUEST['t']='';
}elseif(empty($_REQUEST['t'])){
$_REQUEST['t']='';
	}
$t=$_REQUEST['t']; 

// set token for security => string
if(!isset($_REQUEST['token'])){
$_REQUEST['token']='-';
}elseif(empty($_REQUEST['token'])){
$_REQUEST['token']='-';
	}
$token=$_REQUEST['token']; 

// set field for search => string
if(!isset($_REQUEST['f'])){
$_REQUEST['f']='*';
}elseif(empty($_REQUEST['f'])){
$_REQUEST['f']='*';
	}
$f=$_REQUEST['f']; 

$result=array();
//set limit => numeric
if(!isset($_REQUEST['l'])){
    $_REQUEST['l']='0';
    }elseif(empty($_REQUEST['l'])){
    $_REQUEST['l']='0';
        }
    $l=$_REQUEST['l']; 

    $limit='';
if($l>0&&is_numeric($l)){
$limit="LIMIT ".$l;
}



$valid_ts[]='users-studentId';
$valid_ts[]='users-staffId';
$valid_ts[]='users-Id';
$valid_ts[]='room-Id';
$valid_ts[]='floor-Id';
$valid_ts[]='building-Id';
$valid_ts[]='building-Id-floor';
$valid_ts[]='floor-Id-room';
$valid_ts[]='campus-Id';
$valid_ts[]='course-Id';
$valid_ts[]='preferences-Id';
$valid_ts[]='preferences-userId';
$valid_ts[]='preferences-User-RoomId';
$valid_ts[]='Addpreferences-User-RoomId';
$valid_ts[]='Delpreferences-User-RoomId';
$valid_ts[]='schedule-Id';
$valid_ts[]='schedule-userId';


$valid_ts[]='users-all';
$valid_ts[]='room-all';
$valid_ts[]='floor-all';
$valid_ts[]='building-all';
$valid_ts[]='campus-all';
$valid_ts[]='course-all';
$valid_ts[]='preferences-all';
$valid_ts[]='schedule-all';

if($action=='UPDATE'){
    $result['result'] = 'false';
    //Ej. api.php?id=1&t=users-Id&token=XXX => by POST for all the fields to be updated
    if(is_numeric($id)&&$id>0&&$t=='users-Id'){
        $table='users';
        $query=build_update_query($table,$_POST,"id_user='".$id."'");       
        $result['query'] = $query;
       // echo $query;
    }

    //Ej. api.php?id=1&t=schedule-userId&token=XXX => by POST for all the fields to be updated
    if(is_numeric($id)&&$id>0&&$t=='schedule-userId'){
        $table='schedule';
        $query=build_update_query($table,$_POST,"user_id='".$id."'");
        $result['query'] = $query;
    }
    //Ej. api.php?id=1&t=schedule-userId&token=XXX => by POST for all the fields to be updated
    if(is_numeric($id)&&$id>0&&$t=='schedule-Id'){
        $table='schedule';
        $query=build_update_query($table,$_POST,"id_schedule='".$id."'");
        $result['query'] = $query;
    }

        //Ej. api.php?id=1&t=preferences-Id&token=XXX => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='preferences-Id'){
    $table='preferences';
    $query=build_update_query($table,$_POST,$id);       
    $result['query'] = $query;
}

    if(!empty($query)&&validate_token($token)&&in_array($t, $valid_ts)){
        if(tep_db_query($query)){
            $result['result'] = 'true';
        }
    }



$result['post']=$_POST;
} // END OF ACTION=UPDATE


if($action=='INSERT'){
    $result['result'] = 'false';
    //Ej. api.php?t=users-Id&token=XXX => by POST for all the fields to be INSERTED
    if($t=='users-Id'){
        $table='users';
        $query=build_insert_query($table,$_POST);       
        $result['query'] = $query;
    }

    //Ej. api.php?id=1&t=schedule-userId&token=XXX => by POST for all the fields to be INSERTED
    if(is_numeric($id)&&$id>0&&$t=='schedule-userId'){
        $table='schedule';
        $query=build_insert_query($table,$_POST);
        $result['query'] = $query;
    }

    //Ej. api.php?id=1&t=schedule-userId&token=XXX => by POST for all the fields to be INSERTED
    if(is_numeric($id)&&$id>0&&$t=='schedule-Id'){
        $table='schedule';
        $query=build_insert_query($table,$_POST);
        $result['query'] = $query;
    }

        //Ej. api.php?id=1&t=preferences-Id&token=XXX => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='preferences-Id'){
    $table='preferences';
    $query=build_insert_query($table,$_POST);       
    $result['query'] = $query;
}

    if(!empty($query)&&validate_token($token)&&in_array($t, $valid_ts)){
       if(tep_db_query($query)){
           $result['result'] = 'true';
        }
    }



$result['post']=$_POST;
} // END OF ACTION=INSERT



if($action=='SELECT'){

    // FOR type user-studentId
        //Ej. api.php?id=100414326&t=users-studentId&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='users-studentId'){
        $table='users';
        $query=$action." $f from $table where student_id='$id'";
    }
    // FOR type user-staffId
        //Ej. api.php?id=100414326&t=users-staffId&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='users-staffId'){
        $table='users';
        $query=$action." $f from $table where staff_id='$id'";
    }
        //Ej. api.php?id=2&t=users-Id&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='users-Id'){
        $table='users';
        $query=$action." $f from $table where id_user='$id'";
    }
        //Ej. api.php?id=1&t=room-Id&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='room-Id'){
        $table='room';
        $query=$action." $f from $table where id_room='$id'";
    }
       //Ej. api.php?id=1&t=floor-Id-room&token=XXX => by either GET or POST
       if(is_numeric($id)&&$id>0&&$t=='floor-Id-room'){
        $table='room';
        $query=$action." $f from $table where id_floor='$id' and status_$table='active' order by code_$table";
    }
        //Ej. api.php?id=1&t=floor-Id&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='floor-Id'){
        $table='floor';
        $query=$action." $f from $table where id_floor='$id'";
    }
        //Ej. api.php?id=1&t=building-Id-floor&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='building-Id-floor'){
        $table='floor';
        $f='id_floor,code_floor,name_floor,id_building';
        $query=$action." $f from $table where id_building='$id' and status_$table='active' order by name_$table";
       // echo $query;
    }
        //Ej. api.php?id=1&t=building-Id&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='building-Id'){
        $table='building';
        $query=$action." $f from $table where id_building='$id'";
    }
        //Ej. api.php?id=1&t=building-Id&token=XXX => by either GET or POST
        if(is_numeric($id)&&$id>0&&$t=='building-Id'){
            $table='building';
            $query=$action." $f from $table where id_building='$id'";
        }
    
        //Ej. api.php?id=1&t=campus-Id&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='campus-Id'){
        $table='campus';
        $query=$action." $f from $table where campus='$id'";
    }
    
        //Ej. api.php?id=1&t=course-Id&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='course-Id'){
        $table='course';
        $query=$action." $f from $table where course='$id'";
    }
    
        //Ej. api.php?id=1&t=preferences-Id&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='preferences-Id'){
        $table='preferences';
        $query=$action." $f from $table where preferences='$id'";
    }
    
        //Ej. api.php?id=1&t=preferences-UserId&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='preferences-UserId'){
        $table='preferences';
        $query=$action." $f from $table where id_user='$id'";
    }
     
    
        //Ej. api.php?id=1&t=schedule-Id&token=XXX => by either GET or POST
    if(is_numeric($id)&&$id>0&&$t=='schedule-Id'){
        $table='schedule';
        $query=$action." $f from $table where id_schedule='$id'";
    }
    
        //Ej. api.php?id=1&t=schedule-userId&token=XXX => by either GET or POST
        if(is_numeric($id)&&$id>0&&$t=='schedule-userId'){
            $table='schedule';
            $query=$action." $f from $table where id_user='$id'";
        }
    
    
    // FOR type users-all
        //Ej. api.php?t=users-all&token=XXX => by either GET or POST - ("l" variable can be used to limit the results &l=2)
        if($t=='users-all'){
            $table='users';
            $query=$action." $f from $table order by id_user";
        }
    // FOR type building-all
        //Ej. api.php?t=building-all&token=XXX => by either GET or POST - ("l" variable can be used to limit the results &l=2)
        if($t=='building-all'){
            $table='building';
            $query=$action." $f from $table order by id_building";
        }
    // FOR type campus-all
        //Ej. api.php?t=campus-all&token=XXX => by either GET or POST - ("l" variable can be used to limit the results &l=2)
        if($t=='campus-all'){
            $table='campus';
            $query=$action." $f from $table order by id_campus";
        }
    // FOR type course-all
        //Ej. api.php?t=course-all&token=XXX => by either GET or POST - ("l" variable can be used to limit the results &l=2)
        if($t=='course-all'){
            $table='course';
            $query=$action." $f from $table order by id_course";
        }
    // FOR type floor-all
        //Ej. api.php?t=floor-all&token=XXX => by either GET or POST - ("l" variable can be used to limit the results &l=2)
        if($t=='floor-all'){
            $table='floor';
            $query=$action." $f from $table order by id_floor";
        }
    // FOR type preferences-all
        //Ej. api.php?t=preferences-all&token=XXX => by either GET or POST - ("l" variable can be used to limit the results &l=2)
        if($t=='preferences-all'){
            $table='preferences';
            $query=$action." $f from $table order by id_preferences";
        }
    // FOR type room-all
        //Ej. api.php?t=room-all&token=XXX => by either GET or POST - ("l" variable can be used to limit the results &l=2)
        if($t=='room-all'){
            $table='room';
            $query=$action." $f from $table order by id_room";
        }
    // FOR type schedule-all
        //Ej. api.php?t=schedule-all&token=XXX => by either GET or POST - ("l" variable can be used to limit the results &l=2)
        if($t=='schedule-all'){
            $table='schedule';
            $query=$action." $f from $table order by id_schedule";
        }
    
    //echo $query;
    if(!empty($query)&&validate_token($token)&&in_array($t, $valid_ts)){
    
        $sql = "SHOW COLUMNS FROM $table";
    $columns = tep_db_query($sql);
    while($row = tep_db_fetch_array($columns)){
        $rows[]=$row['Field'];
    }
    
    if($f!='*'){
        $f_array=explode( ',', $f );
        $rows=array_intersect($rows, $f_array);
    }
    
    
    $tep_query = tep_db_query($query);
    $total=mysqli_num_rows($tep_query);
    if($total>0){
     //   $result['result'] = 'true';
            $tep_query = tep_db_query($query.' '.$limit);    
          
          //  print_r($rows); 
          $i=0;
            while ( $results = tep_db_fetch_array( $tep_query ) ) {
                
                foreach($rows as $key=>$value){
                    $result[$i][$value]=$results[$value];
                }  
                $i++;
        }
       
    
    }
    }   
    } // END OF ACTION=SELECT
function validate_token($token){
    $result=false;
    if($token=='XXX'){
        $result=true;
    }
    return $result;
}
function build_update_query($table,$post,$where){
    $action='UPDATE';
    $sql_final='';
    $sql = "SHOW COLUMNS FROM $table";
    $columns = tep_db_query($sql);
    while($row = tep_db_fetch_array($columns)){
        $rows[]=$row['Field'];
    }
    $f_temp=array();
    foreach($post as $key => $value){
        $f_temp[]=$key;
    }
   
        $rows=array_intersect($rows,$f_temp);
        $update_arr=array();
       // print_r($rows);
        foreach($rows as $key => $value){
            $update_arr[]="`".$value."` = '".$post[$value]."'" ;
        }
        
        $update_str=implode(',',$update_arr);
     

        $sql_final="$action $table SET $update_str WHERE $where";


    return $sql_final;
}
function build_insert_query($table,$post){
    $action='INSERT';
    $sql_final='';
    $sql = "SHOW COLUMNS FROM $table";
    $columns = tep_db_query($sql);
    while($row = tep_db_fetch_array($columns)){
        $rows[]=$row['Field'];
    }
    $f_temp=array();
    foreach($post as $key => $value){
        $f_temp[]=$key;
    }
   
        $rows=array_intersect($rows,$f_temp);
        $insert_arr=array();
        $values_arr=array();
      //  print_r($rows);
        foreach($rows as $key => $value){
            $insert_arr[]="`".$value."`" ;
            $values_arr[]="'".$post[$value]."'";
        }
        
        $insert_str=implode(',',$insert_arr);
        $values_str=implode(',',$values_arr);

        $sql_final="$action INTO $table ($insert_str) VALUES ($values_str)";

    return $sql_final;
}

   //Ej. api.php?id=1&room=1&t=preferences-User-RoomId&token=XXX => by either GET or POST
   if(is_numeric($id)&&$id>0&&is_numeric($room)&&$room>0&&$t=='preferences-User-RoomId'){
    $table='preferences';
    $query=$action." $f from $table where id_user='$id' and id_room='$room'";
   // echo $query;
   $tep_query=tep_db_query($query); 
   $total=mysqli_num_rows($tep_query);
   if($total>0){
       
       $new_query="DELETE FROM `falcon`.`preferences` WHERE `id_user` = '$id' and `id_room` = '$room'";
       $result['result'] = 'false';
   }else{
    $new_query="INSERT INTO `preferences`(`id_user`, `id_room`) VALUES ('$id', '$room')";

    $result['result'] = 'true';
   }
   tep_db_query($new_query); 
   
}
   //Ej. api.php?id=1&room=1&t=preferences-User-RoomId&token=XXX => by either GET or POST
   if(is_numeric($id)&&$id>0&&is_numeric($room)&&$room>0&&$t=='Addpreferences-User-RoomId'){
    $table='preferences';
    $query=$action." $f from $table where id_user='$id' and id_room='$room'";
   // echo $query;
   $tep_query=tep_db_query($query); 
   $total=mysqli_num_rows($tep_query);

       
       $new_query="DELETE FROM `falcon`.`preferences` WHERE `id_user` = '$id' and `id_room` = '$room'";
       $result['result'] = 'false';
       tep_db_query($new_query); 
    $new_query2="INSERT INTO `preferences`(`id_user`, `id_room`) VALUES ('$id', '$room')";

    $result['result'] = 'true';
   
   tep_db_query($new_query2); 
   
}
   //Ej. api.php?id=1&room=1&t=preferences-User-RoomId&token=XXX => by either GET or POST
   if(is_numeric($id)&&$id>0&&is_numeric($room)&&$room>0&&$t=='Delpreferences-User-RoomId'){
    $table='preferences';
    $query=$action." * from $table where id_user='$id' and id_room='$room'";
   // echo $query;
   $tep_query=tep_db_query($query); 
   $total=mysqli_num_rows($tep_query);

       
       $new_query="DELETE FROM `falcon`.`preferences` WHERE `id_user` = '$id' and `id_room` = '$room'";
       $result['result'] = 'true';
   
   tep_db_query($new_query); 
   
}

echo json_encode($result);
//print_r($result);
    ?>