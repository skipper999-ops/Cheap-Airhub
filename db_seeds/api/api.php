<?php
include("connection.php");

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    // header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');    
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
}   
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


session_start();


function getToken($length){
    $token = "";
    $codeAlphabet = "ABCDEFGHJKMNPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijkmnpqrstuvwxyz";
    $codeAlphabet.= "123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
       $token .= $codeAlphabet[rand(0, $max-1)];
   }

   return $token;
}


if (isset($_REQUEST['getAirport']) && $_REQUEST['getAirport'] == "getAirport") {


    $data = array();

    // $data['xdsds'] = "SELECT id, municipality, iata_code, iso_country, name, type FROM data WHERE iata_code = '". $_REQUEST['query'] . "'" ;


     $query = mysqli_query($con, "SELECT id, municipality, iata_code, iso_country, name, type FROM data1 WHERE iata_code = '". $_REQUEST['query'] . "'" ) or die(mysqli_error($con));


    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data = $row;
        }
    }


   $res = json_encode($data);
    echo $res;
    exit;

}else if (isset($_REQUEST['search']) && $_REQUEST['search'] == "search") {


    $data = array();

    // $data['xdsds'] = "SELECT id, municipality, iata_code, iso_country, type FROM data WHERE municipality IS NOT NULL AND type = 'large_airport' AND municipality LIKE '". $_REQUEST['query'] ."%' AND iata_code LIKE '". $_REQUEST['query'] ."%' ORDER BY FIELD(iso_country, 'US', 'IN') DESC";

    // $data['ss'] = "SELECT id, municipality, iata_code, iso_country, name, type FROM data1 WHERE municipality IS NOT NULL AND ( type = 'airport' ) AND (municipality LIKE '". $_REQUEST['query'] ."%' OR iata_code LIKE '". $_REQUEST['query'] ."%') ORDER BY FIELD(iso_country, 'United States', 'India') DESC limit 10";

    $query = mysqli_query($con, "SELECT id, municipality, iata_code, iso_country, name, type FROM data1 WHERE municipality IS NOT NULL AND ( type = 'airport' ) AND (municipality LIKE '". $_REQUEST['query'] ."%' OR iata_code LIKE '". $_REQUEST['query'] ."%') ORDER BY FIELD(iso_country, 'United States', 'India') DESC limit 10") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }


    $res = json_encode($data);
    echo $res;
    exit;

  // }else if (isset($_REQUEST['search']) && $_REQUEST['search'] == "search") {


  //   $data = array();

  //   // $data['xdsds'] = "SELECT id, municipality, iata_code, iso_country, type FROM data WHERE municipality IS NOT NULL AND type = 'large_airport' AND municipality LIKE '". $_REQUEST['query'] ."%' AND iata_code LIKE '". $_REQUEST['query'] ."%' ORDER BY FIELD(iso_country, 'US', 'IN') DESC";

  //   $query = mysqli_query($con, "SELECT id, municipality, iata_code, iso_country, name, type FROM data WHERE municipality IS NOT NULL AND ( type = 'large_airport' OR type = 'medium_airport' ) AND (municipality LIKE '". $_REQUEST['query'] ."%' OR iata_code LIKE '". $_REQUEST['query'] ."%') ORDER BY FIELD(iso_country, 'IN', 'US') DESC limit 10") or die(mysqli_error($con));
  //   // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

  //   if (mysqli_num_rows($query) > 0) {
  //       while ($row = mysqli_fetch_assoc($query)) {
  //           $data[] = $row;
  //       }
  //   }


  //   $res = json_encode($data);
  //   echo $res;
  //   exit;
}else if (isset($_REQUEST['login']) && $_REQUEST['login'] == "login") {


    $data = array();

    // $data['xdsds'] = "SELECT id, municipality, iata_code, iso_country, type FROM data WHERE municipality IS NOT NULL AND type = 'large_airport' AND municipality LIKE '". $_REQUEST['query'] ."%' AND iata_code LIKE '". $_REQUEST['query'] ."%' ORDER BY FIELD(iso_country, 'US', 'IN') DESC";

    $query = mysqli_query($con, "SELECT * FROM admin WHERE email = '" . $_POST['email'] ."'") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

            // $data['going'] = $_POST['password'];
            // $data['stored'] = $row['password'];
            // $data['hash'] = password_hash("rasmuslerdorf", PASSWORD_DEFAULT);

            // $data['hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if (password_verify($_POST['password'], $row['password'])) {

                $data['message'] = 'Password is valid!';
                $data['code'] = 200;

                $_SESSION['loggedin'] = true;
                $data['token'] = $row['token'];

            } else {

                $data['message'] = 'Invalid password.';

                $_SESSION['loggedin'] = false;
                $data['code'] = 401;

            }




        }
    }else{

       $data['message'] = 'Invalid Email or Password.';

       $_SESSION['loggedin'] = false;

       $data['code'] = 401;


   }


   $res = json_encode($data);
   echo $res;
   exit;


}else if (isset($_REQUEST['saveDisc']) && $_REQUEST['saveDisc'] == "saveDisc") {

    $data = array();



                $sql = "UPDATE discount SET discount = '". $_REQUEST['discount']  ."' WHERE id = 1"; 

                $result = mysqli_query($con, $sql);

                if(!$result){ 
                    $data['code'] = 401;
                } else{ 
                    $data['code'] = 200;

                } 


   $res = json_encode($data);
   echo $res;
   exit;



 }else if (isset($_REQUEST['sendDisc']) && $_REQUEST['sendDisc'] == "sendDisc") {

    $data = array();


  $query = mysqli_query($con, "SELECT * FROM discount WHERE id = 1") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

          $data = $row;
        }

      }


   $res = json_encode($data);
   echo $res;
   exit;



}else if (isset($_REQUEST['checkSession']) && $_REQUEST['checkSession'] == "checkSession") {


    $data = array();

    // $data['xdsds'] = "SELECT id, municipality, iata_code, iso_country, type FROM data WHERE municipality IS NOT NULL AND type = 'large_airport' AND municipality LIKE '". $_REQUEST['query'] ."%' AND iata_code LIKE '". $_REQUEST['query'] ."%' ORDER BY FIELD(iso_country, 'US', 'IN') DESC";

    $query = mysqli_query($con, "SELECT * FROM admin WHERE id = 1") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

            // $data['going'] = $_POST['password'];
            // $data['stored'] = $row['password'];
            // $data['hash'] = password_hash("rasmuslerdorf", PASSWORD_DEFAULT);

            // $data['hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $data['token'] = $row['token'];
            $data['_REQUEST'] = $_REQUEST['token'] ;

            if ($row['token'] == $_REQUEST['token']) {

                $data['message'] = 'Password is valid!';
                $data['code'] = 200;

            } else {

                $data['message'] = 'Invalid password.';

                $_SESSION['loggedin'] = false;
                $data['code'] = 401;

            }




        }
    }else{

       $data['message'] = 'Invalid Email or Password.';

       $_SESSION['loggedin'] = false;

       $data['code'] = 401;


   }


   $res = json_encode($data);
   echo $res;
   exit;


}else if (isset($_REQUEST['changePass']) && $_REQUEST['changePass'] == "changePass") {


    $data = array();

    
    $query = mysqli_query($con, "SELECT id, email, password FROM admin WHERE email = '" . $_POST['email'] ."'") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

            $data['hash'] = password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

            // $data['going'] = $_POST['password'];
            // $data['stored'] = $row['password'];

            // $data['hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if (password_verify($_POST['old_password'], $row['password'])) {

                $data['message'] = 'Password is valid!';

                $data['hash'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);


                $data['q'] = "UPDATE admin SET password = '". $data['hash']  ."' WHERE id = ". $row['id']; 

                $sql = "UPDATE admin SET password = '". $data['hash']  ."' WHERE id = ". $row['id']; 

                $result = mysqli_query($con, $sql);

                if(!$result){ 
                    $data['code'] = 401;
                } else{ 
                    $data['code'] = 200;

                } 

            } else {

                $data['message'] = 'Invalid password.';

                $_SESSION['loggedin'] = false;
                $data['code'] = 401;

            }




        }
    }else{

       $data['message'] = 'Invalid Email or Password.';

       $_SESSION['loggedin'] = false;

       $data['code'] = 401;


   }


   $res = json_encode($data);
   echo $res;
   exit;


}else if (isset($_REQUEST['sendformDelete']) && $_REQUEST['sendformDelete'] == "sendformDelete") {

    $data = array();


        $sql = "DELETE FROM form_info WHERE id = '".$_REQUEST['id']."'";



        if (mysqli_query($con, $sql)) {
          $data['message'] =  "Record deleted successfully";
          $data['status'] = "SUCCESS";
          $data['code'] = 200;
      } else {

          $data['message'] =  "Error deleting record: " . mysqli_error($con);
          $data['status'] = "ERROR";
          $data['code'] = 401;
      }





  $res = json_encode($data);
  echo $res;
  exit;



}else if (isset($_REQUEST['contactDelete']) && $_REQUEST['contactDelete'] == "contactDelete") {

    $data = array();


        $sql = "DELETE FROM contact_us WHERE id = '".$_REQUEST['id']."'";



        if (mysqli_query($con, $sql)) {
          $data['message'] =  "Record deleted successfully";
          $data['status'] = "SUCCESS";
          $data['code'] = 200;
      } else {

          $data['message'] =  "Error deleting record: " . mysqli_error($con);
          $data['status'] = "ERROR";
          $data['code'] = 401;
      }





  $res = json_encode($data);
  echo $res;
  exit;



}else if (isset($_REQUEST['sendform']) && $_REQUEST['sendform'] == "sendform") {


    $data = array();

    $data['transaction_id'] = getToken(8);


    $sql = "INSERT INTO form_info (traveller_info, phone, transaction_id, email, flight_data, city, state, country, address, zip)
    VALUES ('". $_POST['traveller_info'] . "','". $_POST['phone'] . "', '". $data['transaction_id'] . "' , '". $_POST['email'] . "' , '". $_POST['formed_data'] . "' , '". $_POST['city'] . "' , '". $_POST['state'] . "' , '". $_POST['country'] . "' ,'". $_POST['address'] . "' , '". $_POST['zip'] . "' )";
    
    if (mysqli_query($con, $sql)) {

        $data['message'] = "New record created successfully";
        http_response_code(202);
        $data['status'] = 200;

    } else {

        http_response_code(400);
        $data['message'] = "Error: " . $sql . "<br>" . mysqli_error($con);
        $data['status'] = 400;
        
    }

    $res = json_encode($data);
    echo $res;
    exit;

}else if (isset($_REQUEST['sendformContact']) && $_REQUEST['sendformContact'] == "sendformContact") {


    $data = array();

    $data['transaction_id'] = getToken(8);

    $sql = "INSERT INTO contact_us (first_name, last_name, phone, subject, email, message) VALUES ('". $_POST['first_name'] . "','". $_POST['last_name'] . "','". $_POST['phone'] . "', '". $_POST['subject'] . "' , '". $_POST['email'] . "' , '". $_POST['message'] . "' )";
    
    if (mysqli_query($con, $sql)) {

        $data['message'] = "New record created successfully";
        http_response_code(202);
        

    } else {

        http_response_code(400);
        $data['message'] = "Error: " . $sql . "<br>" . mysqli_error($con);
        
    }

    $res = json_encode($data);
    echo $res;
    exit;

}else if (isset($_REQUEST['getData']) && $_REQUEST['getData'] == "getData") {

    $data = array();


    $query = mysqli_query($con, "SELECT * FROM form_info") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

            $flight_data = json_decode($row['flight_data']);

            $row['flight_data'] = $flight_data;

            $traveller_info = json_decode($row['traveller_info']);

            $row['traveller_info'] = $traveller_info;


            $data[] = $row;
        }
    }

    $res = json_encode($data);
    echo $res;
    exit;

}else if (isset($_REQUEST['getDataContact']) && $_REQUEST['getDataContact'] == "getDataContact") {

    $data = array();


    $query = mysqli_query($con, "SELECT * FROM contact_us") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }

    $res = json_encode($data);
    echo $res;
    exit;

}else if (isset($_REQUEST['getCountries']) && $_REQUEST['getCountries'] == "getCountries") {

    $data = array();


    $query = mysqli_query($con, "SELECT * FROM countries") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }

    $res = json_encode($data);
    echo $res;
    exit;

}else if (isset($_REQUEST['getStates']) && $_REQUEST['getStates'] == "getStates") {

    $data = array();


    $query = mysqli_query($con, "SELECT * FROM states where countryID = '" .  $_REQUEST['country_id'] . "' order by stateID + 0 ASC") or die(mysqli_error($con));
    // $query = mysqli_query($con, "SELECT id,  'municipality',  'iata_code', 'iso_country', 'type' FROM data WHERE 'municipality' IS NOT NULL AND 'type' = large_airport AND 'municipality LIKE 'B%' AND 'iata_code' LIKE 'B%' ORDER BY FIELD('iso_country', 'US', 'IN') DESC ");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }

    $res = json_encode($data);
    echo $res;
    exit;

}



mysqli_close($con);


?>