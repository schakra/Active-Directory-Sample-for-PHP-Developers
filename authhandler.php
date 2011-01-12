<? ob_start(); ?>
<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    include("classes/adfsbridge.php");
    include("classes/adfsuserdetails.php");
    include("conf/adfsconf.php");
?>

<?php if(!isset($_REQUEST['wa'])) : ?>
    Expected context parameter is not provided.
<?php else : ?>
    <?php if($_REQUEST['wa'] == 'wsignin1.0') : ?>
        <?php 
            $adfs = new AdfsBridge();
            try {
                $userDetails = $adfs->getAdfsSignInResponse(
                                AdfsConf::getInstance(),
                                $_REQUEST['wa'],
                                $_REQUEST['wresult'],
                                $_REQUEST['wctx']);

                // Set the user details in session.
                $_SESSION['AdfsUserDetails'] = serialize($userDetails);
                // Expect return url in wctx (set by authform.php)
                header('Location: '. $_REQUEST['wctx']);
            } catch (Exception $e) {
                printf('Message: '.$e->getMessage());
            }
        ?>
    <?php endif; ?>
    <?php if($_REQUEST['wa'] == 'wsignout1.0') : ?>
        <?php
            if (isset($_SESSION['AdfsUserDetails'])) {
                unset($_SESSION['AdfsUserDetails']);
            }            
            exit;
        ?>
    <?php endif; ?>
<?php endif; ?>
<? ob_flush(); ?>