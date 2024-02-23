<?php
header( 'Content-Type: text/html; charset=UTF-8' );
header( "Access-Control-Allow-Origin: *" );
include "includes/application_top.php";

// set id for search => numeric
if(!isset($_REQUEST['id'])){
$_REQUEST['id']='';
}elseif(empty($_REQUEST['id'])){
$_REQUEST['id']='';
	}
$id=$_REQUEST['id']; 

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

$result=array();

$valid_ts[]='users-studentId';
$valid_ts[]='users-staffId';
$valid_ts[]='users-Id';
$valid_ts[]='room-Id';
$valid_ts[]='floor-Id';
$valid_ts[]='building-Id';
$valid_ts[]='campus-Id';
$valid_ts[]='course-Id';
$valid_ts[]='preferences-Id';
$valid_ts[]='schedule-Id';


$valid_ts[]='users-all';
$valid_ts[]='room-all';
$valid_ts[]='floor-all';
$valid_ts[]='building-all';
$valid_ts[]='campus-all';
$valid_ts[]='course-all';
$valid_ts[]='preferences-all';
$valid_ts[]='schedule-all';

// FOR type user-studentId
    //Ej. api.php?id=100414326&t=users-studentId&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='users-studentId'){
    $table='users';
	$query="SELECT $f from $table where student_id='$id'";
}
// FOR type user-staffId
    //Ej. api.php?id=100414326&t=users-staffId&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='users-staffId'){
    $table='users';
	$query="SELECT $f from $table where staff_id='$id'";
}
    //Ej. api.php?id=2&t=users-Id&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='users-Id'){
    $table='users';
	$query="SELECT $f from $table where id_user='$id'";
}
    //Ej. api.php?id=1&t=room-Id&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='room-Id'){
    $table='room';
	$query="SELECT $f from $table where id_room='$id'";
}
    //Ej. api.php?id=1&t=floor-Id&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='floor-Id'){
    $table='floor';
	$query="SELECT $f from $table where id_floor='$id'";
}
    //Ej. api.php?id=1&t=building-Id&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='building-Id'){
    $table='building';
	$query="SELECT $f from $table where id_building='$id'";
}
    //Ej. api.php?id=1&t=campus-Id&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='campus-Id'){
    $table='campus';
	$query="SELECT $f from $table where campus='$id'";
}

    //Ej. api.php?id=1&t=course-Id&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='course-Id'){
    $table='course';
	$query="SELECT $f from $table where course='$id'";
}

    //Ej. api.php?id=1&t=preferences-Id&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='preferences-Id'){
    $table='preferences';
	$query="SELECT $f from $table where preferences='$id'";
}

    //Ej. api.php?id=1&t=schedule-Id&token='XXX' => by either GET or POST
if(is_numeric($id)&&$id>0&&$t=='schedule-Id'){
    $table='schedule';
	$query="SELECT $f from $table where schedule='$id'";
}


// FOR type users-all
    //Ej. api.php?t=users-all&token='XXX' => by either GET or POST - ("l" variable can be used to limit the results &l=2)
    if($t=='users-all'){
        $table='users';
        $query="SELECT $f from $table order by id_user";
    }
// FOR type building-all
    //Ej. api.php?t=building-all&token='XXX' => by either GET or POST - ("l" variable can be used to limit the results &l=2)
    if($t=='building-all'){
        $table='building';
        $query="SELECT $f from $table order by id_building";
    }
// FOR type campus-all
    //Ej. api.php?t=campus-all&token='XXX' => by either GET or POST - ("l" variable can be used to limit the results &l=2)
    if($t=='campus-all'){
        $table='campus';
        $query="SELECT $f from $table order by id_campus";
    }
// FOR type course-all
    //Ej. api.php?t=course-all&token='XXX' => by either GET or POST - ("l" variable can be used to limit the results &l=2)
    if($t=='course-all'){
        $table='course';
        $query="SELECT $f from $table order by id_course";
    }
// FOR type floor-all
    //Ej. api.php?t=floor-all&token='XXX' => by either GET or POST - ("l" variable can be used to limit the results &l=2)
    if($t=='floor-all'){
        $table='floor';
        $query="SELECT $f from $table order by id_floor";
    }
// FOR type preferences-all
    //Ej. api.php?t=preferences-all&token='XXX' => by either GET or POST - ("l" variable can be used to limit the results &l=2)
    if($t=='preferences-all'){
        $table='preferences';
        $query="SELECT $f from $table order by id_preferences";
    }
// FOR type room-all
    //Ej. api.php?t=room-all&token='XXX' => by either GET or POST - ("l" variable can be used to limit the results &l=2)
    if($t=='room-all'){
        $table='room';
        $query="SELECT $f from $table order by id_room";
    }
// FOR type schedule-all
    //Ej. api.php?t=schedule-all&token='XXX' => by either GET or POST - ("l" variable can be used to limit the results &l=2)
    if($t=='schedule-all'){
        $table='schedule';
        $query="SELECT $f from $table order by id_schedule";
    }


   

function validate_token($token){
    $result=false;
    if($token=='XXX'){
        $result=true;
    }
    return $result;
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

		$tep_query = tep_db_query($query.' '.$limit);
        
       
      
      //  print_r($rows); 
	    while ( $results = tep_db_fetch_array( $tep_query ) ) {
            foreach($rows as $key=>$value){
                $result[][$value]=$results[$value];
            }  
    }
 //   print_r($results);
echo json_encode($result);
}
}   
    ?>
<script src="resource://devtools/client/jsonview/lib/require.js" data-main="resource://devtools/client/jsonview/viewer-config.js"></script>