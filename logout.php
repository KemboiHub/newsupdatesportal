<?php/*

include ('config.php');

session_start();
session_unset();
session_destroy();

header('location:../loginsystem/login_form.php');
*/
?>
<?php
session_start();
include("login system/config.php");
//$_SESSION['login']=="";
session_unset();
session_destroy();

?>
<script language="javascript">
document.location="http://localhost/newsportal/login%20system/login_form.php";
</script>