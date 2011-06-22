
DESCRIPTION
-----------
Active Directory PHP Standalone application is a PHP based web application. This application can be deployed into any of the webserver with the necessary PHP support provided by the webserver. The core functionality of the application is to connect to Active Directory Federation Server (ADFS) configured and authenticate with Active Directory Account. On successful authentication the Application will display the Active Directory Claims received from the ADFS Server. This application uses WS-FEDERATION protocol to communicate with ADFS server.

INSTALLATION
------------
Prerequisites:
 1) PHP 5.2 enabled or above with OpenSSL.
 2) Web Server (IIS/Apache etc. which has enabled running PHP applications)
 3) Access to an ADFS 2.0 server that can have Relying party trust configured for this site.

Installation Instructions:
1) Download and unzip Active Directory sample to a local directory (Eg: c:\www\AdfsSample)
2) Configure a website pointing to the above local directory (Eg: https://interop.schakra.com/AdfsSample/, where interop.schakra.com is the domain on which the site is configured). Webserver should be configured with to default index page “index.php” for this site.
3) After configuring the website, browse to the URL to see home page of the sample.
4) Active Directory Sample application configuration is driven by a adfsconf.php located in the <InstallationBaseDir>\Conf\Php (Eg: In above example case c:\www\AdfsSample\conf\adfsconf.php) .
The following parameters should be configured 
 a) Adfs Endpoint URL - Endpoint URL of ADFS service.
 b) Realm/spIdentifier - Realm configured in ADFS Relying party configuration.
 c) Encryption certificate and password - Path to the certificate file and password.

A sample configuration file without certificate contifgured is shown below

 public $adfsUrl = 'https://adfsdemo2.com/adfs/ls/';    
 public $spIdentifier = 'urn:federation:php.interop.schakra.com-adfsdemo';    
 public $encryptionCertPath = '';
 public $encryptionCertPassword = '';   

ADFS 2.0 CONFIGURATION (On Windows Server 2008)
-----------------------------------------------
1) Open the ADFS 2.0 Manager
2) Right click Relying Party Trust and select Add Relying Party Trust
3) Start the Wizard:
    a. Select Data Source: Select Manual Configuration
    b. Specify Display Name: Enter an identity for your Drupal site (same as
       6.b under Installation)
    c. Choose Profile: Select SAML 2.0
    d. Configure Certificate: Only set this if you want Encrypted responses (as
       in 6.d under Installation)
    e. Configure URL: Select WS-Federation Passive and enter the path to the
       Active Directory Sample entry point: <Active-Directory-Site-URL>/authhandler.php
    f. Configure Identifier: Add the identity form 6.b under Installation
    g. Choose Issuance Authorization Rules: This setting is determined by the
       system administrator, use Permit All to allow any user access to the
       Drupal site, otherwise configure access individually
    h. Ready to Add Trust: Close the Wizard and continue with Claims
    i. Configure Claims:  This may vary based on configuration and determines
       the values for 6.e under Installation.
        - A sample configuration with mandatory claim "Name ID" is as below
             - Use LDAP Attributes
             - Name the claim: Default
             - Attribute Store: Active Directory
             - LDAP: SAM-Account-Name    Outgoing: Name ID


USAGE
-----
1) Open Browser navigate to ADFS sample (Eg: In our case https://interop.schakra.com/AdfsSample/) Home page will be displayed.
2) Click on login button on home page
3) You will be redirected to ADFS server login page
3) Enter valid Active directory user credentials and click signin
4) ADFS server will redirect to Active Directory sample application and sample displays all the claims attributes received from ADFS as shown in the figure below


IMPLEMENTATION DETAILS
----------------------
Implementation of ADFS PHP sample is divided into 3 different parts which are as follows
 1) ADFS Bridge
 2) Home Page 
 3) Claims Display Page  
Each of the these are described below

ADFS Bridge:
ADFS Bridge implements method for WS-Federation passive redirection to ADFS server for authentication and method to processing the incoming response from ADFS server to process the claims. ADFS Bridge is implemented in the file adfsbridge.php.  ADFS Bridge is driven by the configuration adfsconf.php. More description of the configuration is described in the installation and configuration section of the sample. 

Home Page:
Home Page is the initial home page for this website. It has a login button which implements on click behavior to redirect to the configured ADFS Server for authentication. HomePage uses ADFS Bridge method to redirect to ADFS Server for sign in. Home Page is implemented in index.php and authform.php files in the sample application.

Claims Display:
Claims display page processes the incoming claims from ADFS Server and display them to user. ADFS Server makes a callback to authhandler.php, Authhandler.php uses ADFS  Bridge method to process the claims and then store them in session. The stored session user claims are then displayed after redirecting to index.php.