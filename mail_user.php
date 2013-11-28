

<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap-3.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->


		<link type="text/css" rel="stylesheet" href="home_page.css" />
<link rel="stylesheet" href="font-awesome-4.0.3/css/font-awesome.css">

  </head>



  <body>
  <div class="container">
<?php
  session_start();
  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
      
    }
  }
  if (isset($_SESSION['user_id'])) {   
                    
    if($_SESSION['user_id'] < 1000) {          
      echo('<p align="right">Logged in as ' . $_SESSION['username'] . '<a href="Patient_Profile.php"> [<i class="fa fa-user"></i> Profile] </a>     ' . '<a href="logout.php"> [<i class="fa fa-minus-circle"></i> Log out]</a></p>');
      } else {
      echo('<p align="right">Logged in as ' . $_SESSION['username'] . '<a href="Dentist_Profile.php"> [<i class="fa fa-user"></i> Profile] </a>     ' . '<a href="logout.php"> [<i class="fa fa-minus-circle"></i> Log out]</a></p>');
      }
  } else {
      echo('<p align="right">You are not logged in | '. '<a href="index.php#signin"> Sign in </a> </p>');
  } 
?>

      <?php include("header_bar.php"); ?>
        

    <hr>
    
      <h3 align="center">Retrieving your Account Information</h3>
      
        
        <?php
        
          require_once('connectvars.php');
 
          $connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
          if (!$connection) {
             die("Database connection failed:" . mysql_error());
          }
          $database = mysql_select_db(DB_NAME, $connection);
          if (!$database) {
             die("Database selection failed:" . mysql_error());
          }
        
        
          $email = $_POST['email'];
          echo 'Email entered is ' . $email . '<br/>';
          $subject = 'User Account Information - CSC 667 Dental Website';

          $query = "SELECT * FROM patient_data WHERE email='$email'";
          $data = mysql_query($query);
          if (!$data) {
            die("query failed" . mysql_error());
          } 
          $row = mysql_fetch_array($data);

          
          $msg = 'Your username is: '. $row['username'] . "\n\n".
                 'Click the link below to reset your password:'. "\n" .
                 'http://' . $_SERVER['HTTP_HOST'] . '/~rsanch' . '/reset_password.php' ;
                 

          ini_set("sendmail_from", $email);
          $headers = "From: $email";
          if (mail($email, $subject, $msg, $headers)) {
               echo 'The username and password has been sent to your email address.';
          } else {
               echo 'Sending email failed.';
          }
    
        ?>

<br><hr>

     <div class="footer">
        <p>&copy; Copyrights 2013</p>
      </div>

</div>




    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.0.2/dist/js/bootstrap.min.js"></script>
  </body>
</html>