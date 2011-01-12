<?php    
    if(!isset($_SESSION)) {
        session_start();
    }
    include_once("classes/adfsbridge.php");
    include_once("classes/adfsuserdetails.php");
    include_once("conf/adfsconf.php"); 
    include_once("showarray.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Active Directory Federation Services - Authentication Demo</title>
        <link href="css/default.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="wrapper">
        <?php include 'include/header.php'; ?>
            <div id="page">
                <div id="content">
                    <div id="welcome">
                        <h1>ADFS Authentication Demo</h1>
                        <?php if(!isset($_SESSION['AdfsUserDetails'])) : ?>
                            <p>
                                This sample demonstrate authentication to a site using ADFS.
                            </p>
                            <p>
                                Click on the 'Log In' button to authenticate with ADFS Server.
                            </p>                        
                        <?php else : ?>
                            <?php
                                // Show User ID and attributes.
                                $userDetails = unserialize($_SESSION['AdfsUserDetails']);         
                                echo '<b>Name Identifier: </b>'. $userDetails->nameIdentifier;  
                                
                                echo '<h4>Attributes: </h4>';
                                htmlShowArray($userDetails->attributes);
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="sidebar">
                    <ul>
                        <?php include 'authform.php'; ?>
                        <?php include 'include/solutions.php'; ?>
                        <?php include 'include/learnmore.php'; ?>
                    </ul>
                </div>
                <div style="clear: both; height: 1px"></div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </body>
</html>
