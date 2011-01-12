<? ob_start(); ?>
<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    include_once("classes/adfsbridge.php");
    include_once("classes/adfsuserdetails.php");
    include_once("conf/adfsconf.php");
?>

<?php if(!isset($_REQUEST['authaction'])) : ?>
    <?php if(!isset($_SESSION['AdfsUserDetails'])) : ?>
        <form action="authform.php" method="post" name="login" id="form-login">
            <ul>
                <li id="submenu">
                    <h2>Authentication Control</h2>
                    <div align="center">
                        <br />
                        <input type="submit" name="Submit" class="button" value="Log in" />
                    </div>
                    <input type="hidden" name="authaction" value="Login" />
                </li>
            </ul>
        </form>
    <?php else : ?>
        <form action="authform.php" method="post" name="logout" id="form-logout">
            <ul>
                <li id="submenu">
                    <h2>Authentication Control</h2>
                    <div align="center">
                        <br />
                        <input type="submit" name="Submit" class="button" value="Log out" />
                    </div>
                    <input type="hidden" name="authaction" value="Logout" />
                </li>
            </ul>
        </form>
    <?php endif; ?>
<?php else : ?>
    <?php if($_REQUEST['authaction'] == 'Login') : ?>
        <?php 
            // Redirect to ADFS for Sign In.
            $adfs = new AdfsBridge();
            $adfs->redirectToAdfsSignInUrl(AdfsConf::getInstance(), 'index.php');
        ?>
    <?php endif; ?>
    <?php if($_REQUEST['authaction'] == 'Logout') : ?>
        <?php
            // Clear session and redirect to home page.
            unset($_SESSION['AdfsUserDetails']);
            header('Location: index.php');
        ?>
    <?php endif; ?>
<?php endif; ?>
<? ob_flush(); ?>