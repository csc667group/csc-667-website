
  <!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Patient Profile</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/css/bootstrap.min.css" rel="stylesheet">-->
        
        <!-- Bardhyl's link-->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="/bootstrap/img/favicon.ico">
        <link rel="apple-touch-icon" href="/bootstrap/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/bootstrap/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/bootstrap/img/apple-touch-icon-114x114.png">
        <!-- add backgrouond -->
        <link type="text/css" rel="stylesheet" href="home_page.css" />
        <link rel="stylesheet" href="font-awesome-4.0.3/css/font-awesome.css">
 <!-- CSS code from Bootply.com editor -->     
        <style type="text/css">
            /* custom inclusion of left tab */
            .tabs-left > .nav-tabs {
                border-bottom: 0;
            }

            .tab-content > .tab-pane,
            .pill-content > .pill-pane {
                display: none;
            }

            .tab-content > .active,
            .pill-content > .active {
                display: block;
            }

            .tabs-left > .nav-tabs > li{
                float: none;
            }

            .tabs-left > .nav-tabs > li > a {
                 min-width: 74px;
                 margin-right: 0;
                 margin-bottom: 3px;
            }

            .tabs-left > .nav-tabs {
                float: left;
                margin-right: 19px;
                border-right: 1px solid #ddd;
            }

            .tabs-left > .nav-tabs > li > a {
                margin-right: -1px;
                -webkit-border-radius: 4px 0 0 4px;
                -moz-border-radius: 4px 0 0 4px;
                border-radius: 4px 0 0 4px;
            }

            .tabs-left > .nav-tabs > li > a:hover,
            .tabs-left > .nav-tabs > li > a:focus {
                border-color: #eeeeee #dddddd #eeeeee #eeeeee;
            }

            .tabs-left > .nav-tabs .active > a,
            .tabs-left > .nav-tabs .active > a:hover,
            .tabs-left > .nav-tabs .active > a:focus {
                border-color: #ddd transparent #ddd #ddd;
                *border-right-color: #ffffff;
            }
            
            #profilepic
            {
                width: 250px;
                heigth: 250px;
            }
        </style>
        
        <link type="text/css" rel="stylesheet" href="home_page.css" />
    </head>
    
    <!-- HTML code from Bootply.com editor -->
    
<body>
    

     <div class="container">
<?php
 session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['email'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['email'] = $_COOKIE['email'];
    }
  }
  if (!isset($_SESSION['user_id']) ) { 
    echo '<p class="login">Please <a href="index.php">log in</a> to access this page.</p>';
    exit();
  }
  if ($_SESSION['user_id'] > 1000) {
    echo 'Cannot access this page. You are not a patient!';
    exit();
  }
  if (isset($_SESSION['user_id'])) {   
    echo('<p align="right">Logged in as ' . $_SESSION['email'] . '<a href="Patient_Profile.php"> [<i class="fa fa-user"></i> Profile] </a>     ' . '<a href="logout.php"> [<i class="fa fa-minus-circle"></i> Log out]</a></p>');
  }          
?>  
             <!-- HEADER BAR -->
      <?php include("header_bar.php"); ?>

<?php
                          
                                    require_once('connectvars.php');

                                    // Connect to the database
                                    $connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

                                    if (!$connection) {
                                      die("Database connection failed:" . mysql_error());
                                    }

                                    $database = mysql_select_db(DB_NAME, $connection);
                                    if (!$database) {
                                      die("Database selection failed:" . mysql_error());
                                    }    
?>
<?php                                     
                        if (isset($_POST['appt_request'])) {
                                        //$idee= $_SESSION['user_id'];
                                        $user_id = $_SESSION['user_id'];
                                        $d_user_id = $_POST['dentist'];
                                        $appt_date = $_POST['date'];
                                        $appt_time = $_POST['time'];
                                        $purpose = $_POST['purpose'];
                                        $quer = "INSERT INTO temp_appointments (user_id, d_user_id, appt_date, appt_time, purpose)
                                            VALUES ( '$user_id', '$d_user_id', '$appt_date', '$appt_time', '$purpose')";
                                        mysql_query($quer);
                                        header('Location: '.$_SERVER['REQUEST_URI']);

                                    }
?>             
      <hr>
    <ul style="list-style-type: none;" style="width: 275px;">
        <li>
              
        </li>
        <li>
            <img src="images/img1.jpg" id="profilepic"> 
            
            
            
            
                                          
            <br> <br>                
            <!-- Search query -->                
            <form  method="post" action="Patient_Profile.php?go"   id="searchform"> 
	      <input  type="text" name="name"> 
	      <a href="Patient_Profile.php#search"><input  type="submit" name="submit" value="Search for Dentist" ></a> 
	    </form> 
            <?php
                                                          
            if(isset($_POST['submit'])){ 
                if(isset($_GET['go'])){ 
                    if(preg_match("/^[  a-zA-Z]+/", $_POST['name'])){ 
                        $name=$_POST['name']; 
                        $sql="SELECT firstname, lastname FROM dentist_data WHERE firstname LIKE '%" . $name .  "%' OR lastname LIKE '%" . $name ."%'"; 	  
                        $result=mysql_query($sql);   //-create  while loop and loop through result set 
                        while($row=mysql_fetch_array($result)){ 
                            $FirstName  =$row['firstname']; 
                            $LastName=$row['lastname']; 
                           // $ID=$row['user_id']; 
	  //-display the result of the array 
                            echo "<ul>\n"; 
                            echo "<li>" . "<a  href=\"Patient_Profile.php?id=\">"   .$FirstName . " " . $LastName .  "</a></li>\n"; 
                            echo "</ul>"; 
                           // $search_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/Dentist_Profile.php#search';
                            //header('Location: ' . $search_url);
                        } 
                    } else{ 
                        echo  "<p>Please enter a search query</p>"; 
                    } 
                } 
            } ?>
            
            
            
        </li>
    </ul>
      

        <div class="container">
        <!-- /row -->
          
            <div class="row">
                
                    <h3 class=""></h3> 

                <!-- tabs left -->
                <div class="tabbable tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#a" data-toggle="tab" class="" contenteditable="false">My Info</a>
                        </li>
                        <li class=""><a href="#b" data-toggle="tab" class="" contenteditable="false">My Dentist</a>
                        </li>
                        <li class=""><a href="#r" data-toggle="tab" class="" contenteditable="false">Request an Appointment</a>
                        </li>
                        <li class=""><a href="#c" data-toggle="tab" class="" contenteditable="false">Past Appointments</a>
                        </li>
                        <li class=""><a href="#d" data-toggle="tab" class="" contenteditable="false">Future Appointments</a>
                        </li>
                    </ul>


                    <!-- Content on the right side inserted in a column-->
                    <div class="col-md-8">   
                        <div class="tab-content">
               
                
                                <?php
                          
                                  
                                
                                
                                //FIRST TAB: My Info
                                echo "<div class=\"tab-pane active\" id=\"a\">";
                                
                                /******** using user's user_id that is logged in   */
                                $queryA = "SELECT * FROM patient_data WHERE user_id = '$_SESSION[user_id]' ";
                                $dataA = mysql_query($queryA);  
                                if (!$dataA) {
                                    die("query failed" . mysql_error());
                                }                                 
                                                             
                                
                                //should only do once, since user_id is specific for only 1 patient
                                if (mysql_num_rows($dataA) == 1) {

                                     $rowA = mysql_fetch_array($dataA);

                                     echo "<strong>ID:</strong>&nbsp;" . ($rowA['user_id']) . "<br>";
                                     echo "<strong>Name:</strong>&nbsp; " . ($rowA['firstname']) . " ";
                                     echo ($rowA['lastname']) . "</strong><br>"; 
                                     
                                     echo "<address> <strong>Address:</strong>&nbsp;". ($rowA['address']) .  ", "
                                     .($rowA['city']) .", ".($rowA['state']) . " " . ($rowA['zipcode']) . 
                                     "<br>
                                     <span class='glyphicon glyphicon-earphone'></span>&nbsp;" . ($rowA['phone']) . "<br>
                                     <span class='glyphicon glyphicon-envelope'></span><a href='mailto:#'>&nbsp;" . ($rowA['email']) . "</a></address>";
                                     echo "<hr>";
                                 }   
                                 
                                 echo "<br>";
                                 
                                echo "<form action = \"edit_info.php\">";
                                
                                /*
                                 * GOES TO editinfo BUTTON 
                                 * form action = "edit_info.php"
                                 * 
                                 * edit_info.php goes back to profile_page 
                                 * after user edits info
                                 */                                   
                                
                                    echo "<input type=\"submit\" value=\"Edit Account Information\" id=\"editinfo\" name=\"editinfo\" />"; 
                                    
                                echo "</form>";
                                    
                                echo "</div>"; 
                                
                                //SECOND TAB: My dentists
                                echo "<div class=\"tab-pane\" id=\"b\">";
                             
	 
            
            
            
            
            
                                
                                /*
                                 * From current patient's user_id, it is sent to be searched in 
                                 * "list_of_patients" in order to find dentists that patient is
                                 * associated with.
                                 * 
                                 * Afterwards, while loop reads through dentist_id from "list_of_patients"
                                 * and prints out info of each of the patient's dentists
                                 */
                                
                                $queryB = "SELECT * FROM list_of_patients WHERE patient_id = '$_SESSION[user_id]' ";
                                $dataB = mysql_query($queryB);  
                                if (!$dataB) {
                                    die("query failed" . mysql_error());
                                }                                 
                                                             
                                
                                
                                while ($rowB = mysql_fetch_array($dataB)) {

                                    $queryX = "SELECT * FROM dentist_data WHERE user_id = '$rowB[dentist_id]' ";
                                    
                                    $dataX = mysql_query($queryX);
                                    if (!$dataX) {
                                        die("query failed" . mysql_error());
                                    }  
                                    
                                    $rowX = mysql_fetch_array($dataX);
                                     
                                     echo "<strong>Name:</strong> " . ($rowX['firstname']) . " ";
                                     echo ($rowX['lastname']) . "</strong><br>";
                                     echo "<strong>License #:</strong> " . ($rowX['licensenumber']) . "<br>";
                                     echo "<strong>Specialties:</strong> " . ($rowX['d_specialties']) . "<br>"; 
                                     echo "<address> <strong>Address:</strong>". ($rowX['address']) .  ", "
                                     .($rowX['city']) .", ".($rowX['state']) . " " . ($rowX['zipcode']) .
                                             "<br>
                                     <span class='glyphicon glyphicon-earphone'></span>&nbsp;" . ($rowX['phone']) . "<br>
                                     <span class='glyphicon glyphicon-envelope'></span><a href='mailto:#'>&nbsp;" . ($rowX['email']) . "</a></address>";
                                     echo "<hr>";
                                      
                                 }                                  
                             
                                
                                
                                echo "</div>";
                                
                                //TAB: Request Appointment
                                echo "<div class=\"tab-pane\" id=\"r\">";
                                
                                /******** using user's user_id that is logged in   */
                                $queryR = "SELECT * FROM patient_data WHERE user_id = '$_SESSION[user_id]' ";
                                $dataR = mysql_query($queryR);  
                                if (!$dataR) {
                                    die("query failed" . mysql_error());
                                }                                 
                                if (mysql_num_rows($dataR) == 1) {
                                  //View current requests.
                                    $q="SELECT * FROM temp_appointments WHERE user_id = '$_SESSION[user_id]' ";
                                    $q2=  mysql_query($q);
                                    echo "<h4>Pending Appointment Requests:</h4>";
                                    echo "<h6>***All pending requests will show up in your future appointments if your Dentist Approves them. Otherwise they will be deleted.***</h6><hr>";
                                    echo "<table id=\"currentrequeststable\" style=\"border:5px;\">
                                        <tr>
                                            <th style=\"width:200px;\">Dentist</th>
                                            <th style=\"width:200px;\">Date</th>
                                            <th style=\"width:100px;\">Time</th>
                                            <th style=\"width:600px;\">Purpose</th>
                                        </tr>";
                                        while ($rowq = mysql_fetch_array($q2)) {
                                            $p = "SELECT * FROM dentist_data WHERE user_id = '$rowq[d_user_id]'  ";
                                            $p2 = mysql_query($p);
                                            $p3 = mysql_fetch_assoc($p2);
                                            echo "<tr>
                                                <td>".$p3['firstname']." ".$p3['lastname']."</td>
                                                <td>".$rowq['appt_date']."</td>
                                                <td>".$rowq['appt_time']."</td>
                                                <td>".$rowq['purpose']."</td>
                                            </tr>";
                                        }
                                        echo "</table>";
                                    
                                    //GETTING ALL DENTISTS USER HAS
                                    //Request an appointment
                                 echo "<br>";
                                 echo "<h4>Request an Appointment:</h4><hr>";
                                echo "<form id=\'request_appt\' role=\"form-inline\" role=\"form\" enctype=\"multipart/form-data\" method=\"post\" action=".$_SERVER['PHP_SELF'].">";
                                
                                /*
                                 * User inputs appointment request info
                                 * sends to temp_appointments to be
                                 * viewed and confirmed by requested
                                 * dentist
                                 */       
                                $queryDID = "SELECT * FROM list_of_patients WHERE patient_id = '$_SESSION[user_id]' ";
                                $dataID = mysql_query($queryDID);  
                                if (!$dataID) {
                                    die("query failed" . mysql_error());
                                } 
                                    echo "<div class=\"form-group\">";
                                    echo "<label for=\"dentist\">Dentist</label><br>";
                                    echo "<select class=\"form-control input-small\" name=\"dentist\" style=\"width:200px;\">";
                                    while ($rowDID = mysql_fetch_array($dataID)) {
                                        $id=$rowDID[dentist_id];
                                        $getD = "SELECT * FROM dentist_data WHERE user_id = '$rowDID[dentist_id]'  ";
                                        $querydent = mysql_query($getD);
                                        $dname = mysql_fetch_assoc($querydent);
                                        if (!$dname) {
                                            die("query failed" . mysql_error());
                                        }
                                        echo "<option value=" . $id . ">". $dname[firstname] ." ". $dname[lastname] ."</option>";
                                    }
                                    echo "</select></div>";
                                    
                                    echo "<div class=\"form-group\">";
                                    echo "<label for=\"date\">Date</label><br>";
                                    echo "<input class=\"form-control input-small\" type=\"date\" name=\"date\"></div>";
                                    
                                    echo "<div class=\"form-group\">";
                                    echo "<label for=\"time\">Time</label><br>";
                                    echo "<input class=\"form-control input-small\" type=\"time\" name=\"time\" value=\"00:00:00\"></div>";
                                    
                                    echo "<div class=\"form-group\">";
                                    echo "<label for=\"purpose\">Purpose</label><br>";
                                    echo "<input class=\"form-control input-small\" type=\"text\" name=\"purpose\" style=\"width:600px;\"></div>";
                                    
                                    echo "<input type=\"submit\" value=\"Send Appointment Request\" id=\"appt_request\" name=\"appt_request\" />"; 
                                    
                                echo "</form>";
                                    
                                echo "</div>";
                                }
                                
                                /*THIRD TAB: My Past APpointments
                                
                                    Search user_id in appointments, and list them in query
                                 * IF appt_Date < today, post here
                                
                                *******************************/                                
                                
                                echo "<div class=\"tab-pane\" id=\"c\">";
                                
                                //GETTING ONLY PAST APPOINTMENTS                               
                                $queryC = "SELECT * FROM appointments WHERE user_id = '$_SESSION[user_id]' 
                                                    AND appt_Date < CURRENT_DATE
                                                    ORDER BY appt_Date DESC";
                                $dataC = mysql_query($queryC);  
                                if (!$dataC) {
                                    die("query failed" . mysql_error());
                                }   
                                
                                //Reading each appointment
                                while ($rowC = mysql_fetch_array($dataC)) {
                                
                                    $queryY = "SELECT * FROM dentist_data WHERE user_id = '$rowC[d_user_id]' ";
                                    
                                    $dataY = mysql_query($queryY);
                                    if (!$dataY) {
                                        die("query failed" . mysql_error());
                                    }  
                                    
                                    $rowY = mysql_fetch_array($dataY);
                                     
                                     echo "<strong>Appointment with: " . ($rowY['firstname']) . " ";
                                     echo ($rowY['lastname']) . "</strong><br>";

                                     echo "Date: " . ($rowC['appt_Date']) . "<br>";
                                     echo "Time: " . ($rowC['appt_Time']) . "<br>";
                                     
                                     echo "Address: " . ($rowY['address']) . "<br>";
                                     echo "Telephone #: " . ($rowY['phone']) . "<br>";
                                     echo "Email: " . ($rowY['email']) . "<br>";
                                     
                                     echo "Purpose: " . ($rowC['purpose']) . "<br>";                                     
                                    
                                     echo "<br>";
                                 }                                      
                                
                                echo "</div>";
                                
                                
                                /******FOURTH TAB: My Future Appointments
                                
                                    Search user_id in appointments, and list them in query
                                 * IF appt_Date >= today && appt_Time >= currentTime,
                                 * post here
                                
                                *******************************/
                                echo "<div class=\"tab-pane\" id=\"d\">";
                                
                                
                                //GETTING ONLY FUTURE APPOINTMENTS
                                $queryD = "SELECT * FROM appointments WHERE user_id = '$_SESSION[user_id]' 
                                            AND appt_Date > CURRENT_DATE
                                            ORDER BY appt_Date";
                                $dataD = mysql_query($queryD);  
                                if (!$dataD) {
                                    die("query failed" . mysql_error());
                                }   
                                
                                //Reading each appointment
                                while ($rowD = mysql_fetch_array($dataD)) {
                                    
                                    $queryZ = "SELECT * FROM dentist_data WHERE user_id = '$rowD[d_user_id]' ";
                                    
                                    $dataZ = mysql_query($queryZ);
                                    if (!$dataZ) {
                                        die("query failed" . mysql_error());
                                    }  
                                    
                                    $rowZ = mysql_fetch_array($dataZ);
                                     
                                     echo "<strong>Appointment with: " . ($rowZ['firstname']) . " ";
                                     echo ($rowZ['lastname']) . "</strong><br>";

                                     echo "Date: " . ($rowD['appt_Date']) . "<br>";
                                     echo "Time: " . ($rowD['appt_Time']) . "<br>";
                                     
                                     echo "Address: " . ($rowZ['address']) . "<br>";
                                     echo "Telephone #: " . ($rowZ['phone']) . "<br>";
                                     echo "Email: " . ($rowZ['email']) . "<br>";
                                     
                                     echo "Purpose: " . ($rowD['purpose']) . "<br>";                                     

                                     echo "<br>";
                                 }                                      
                                                    
                                
                                
                                echo "</div>";
                                
                                ?>
                        </div>
                    </div>
    <!-- /tabs -->
                </div>
            </div>
    <!-- /row -->
        </div> 
        <hr class="">
        
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script type='text/javascript' src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/js/bootstrap.min.js"></script>


        <!-- JavaScript jQuery code from Bootply.com editor -->
        
        <script type='text/javascript'>
            $(document).ready(function() {
            });
        
        </script>
        
    </body>
</html>