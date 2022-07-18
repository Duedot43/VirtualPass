<?php
//this page has 3 modes; Normal Teacher and Administrator
//It should have a login option for teacher and administrator teacher will redirect to the normal teacher portal 
//The admin login will "unlock" special info that are not normally displayed on the home page


//NORMAL PAGE
//users registered 
//rooms registered



//ADMINISSTRATOR PAGE
//option to redirect to the normal admin portal (If you feel like it you could redo that? or just intigrate it in here?)
//users registered 
//rooms registered
//number of users currently departed
//number of users current arrived
//users departed with a line graph over the day by the hour
//rooms used with a bar graph by the hour
//if there is anything you would like to add feel free and dont worry about the data collection i will get those for you.
$ini = parse_ini_file('../config/config.ini');
if ($ini['override_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['override_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
if (file_exists("../mass.json")) {
    $mass_json = json_decode(file_get_contents("../mass.json"), true);
    $usersReg = count($mass_json['user']);
    $roomsReg = count($mass_json['room']);
    $usersDep = 0;
    $usersArv = 0;
    foreach ($mass_json['user'] as $user) {
        $user_arr = json_decode(file_get_contents("registered_phid/" . $user), true);
        if ($user_arr['student_activ'] == 0) {
            $usersDep = $usersDep + 1;
        }
    }

    foreach ($mass_json['user'] as $user) {
        $user_arr = json_decode(file_get_contents("registered_phid/" . $user), true);
        if ($user_arr['student_activ'] == 1) {
            $usersArv = $usersArv + 1;
        }
    }
}
?>

<!DOCTYPE html>

<html>

<head>
    <title>VirtualPass</title>
    <link href="/style.css" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-base.min.js" type="text/javascript"></script>
    <!-- Meta Tags Generated via https://www.opengraph.xyz -->
    <link href="/style.css" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="/usr_pre_fls/anychart-base.min.js"></script>
    <script src="/usr_pre_fls/chart.js"> </script>
    <meta name="description" content="The utility that lets you set up your users with a virtual hall pass for administrators to help keep track of where your emplyees are.">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://<?php echo $domain; ?>/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="VirtualPass">
    <meta property="og:description" content="The utility that lets you set up your users with a virtual hall pass for administrators to help keep track of where your emplyees are.">
    <meta property="og:image" content="https://<?php echo $domain; ?>/Images/preview.png">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="<?php echo $domain; ?>">
    <meta property="twitter:url" content="https://<?php echo $domain; ?>/">
    <meta name="twitter:title" content="VirtualPass">
    <meta name="twitter:description" content="The utility that lets you set up your users with a virtual hall pass for administrators to help keep track of where your emplyees are.">
    <meta name="twitter:image" content="https://<?php echo $domain; ?>/Images/preview.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<header>


    <div class=navParent-01>

        <div class="navChild-01">
            <button> Teacher Login </button>
            <p> | </p>
            <button> Admin Login </button>
            <p> | </p>
            <button> Student Login </button>
        </div>

        <div class="navChild-h1">

        </div>
    </div>

    <body>

        <h1> Hello World! </h1>

        <script>
            var his = '<?php if (file_exists("../his.json")) {
                            echo file_get_contents("../his.json");
                        } else {
                            echo "NONE";
                        } ?>';
        </script>
        <script src="/usr_pre_fls/chart.js"> </script>
        <div id="freq"></div>

    </body>

</html>