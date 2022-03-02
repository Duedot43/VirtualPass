<?php
if (isset($_POST['confirm'])) {
    if ($_POST['confirm'] == 'Yes') {
        header("Location:delusr.php");
    }
    else if ($_POST['confirm'] == 'No') {
        header("Location:stupid.php");
    } 
}
?>
Are you sure you would like to delete the user?<br>
<form method="post">

<input type="submit" name="confirm" value="Yes">
<input type="submit" name="confirm" value="No">
</form>
