<?php

/************************************
*   @author       Mian Saleem       *
*   @package      SMA3              *
*   @subpackage   install           *
************************************/

$installFile = "../SMA_POS";
$indexFile = "../index.php";
$configFolder = "../app/config";
$configFile = "../app/config/config.php";
$dbFile = "../app/config/database.php";
if (is_file($installFile)) {

    $step = isset($_GET['step']) ? $_GET['step'] : '';
    switch ($step) {
        default: ?>
        <ul class="steps">
            <li class="active pk">Checklist</li>
            <li>Verify</li>
            <li>Database</li>
            <li>Site Config</li>
            <li class="last">Done!</li>
        </ul>
        <h3>Pre-Install Checklist</h3>
        <?php
        $error = FALSE;
        if (!is_writeable($indexFile)) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Index File (index.php) is not write able!</div>";
        }
        if (!is_writeable($configFolder)) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Config Folder (app/config/) is not write able!</div>";
        }
        if (!is_writeable($configFile)) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Config File (app/config/config.php) is not write able!</div>";
        }
        if (!is_writeable($dbFile)) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Database File (app/config/database.php) is not writable!</div>";
        }
        if (phpversion() < "5.4") {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Your PHP version is ".phpversion()."! PHP 5.4 or higher required!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> You are running PHP ".phpversion()."</div>";
        }
        if (!extension_loaded('mcrypt')) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Mcrypt PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> Mcrypt PHP extension loaded!</div>";
        }
        if (!extension_loaded('mysqli')) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Mysqli PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> Mysqli PHP extension loaded!</div>";
        }
        if (!extension_loaded('mbstring')) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> MBString PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> MBString PHP extension loaded!</div>";
        }
        if (!extension_loaded('gd')) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> GD PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> GD PHP extension loaded!</div>";
        }
        if (!extension_loaded('curl')) {
            $error = TRUE;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> CURL PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> CURL PHP extension loaded!</div>";
        }
        if (!extension_loaded('zip')) {
            echo "<div class='alert alert-error'><i class='icon-remove'></i> ZIP PHP extension missing!<br>Auto Update Won't Work!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> ZIP PHP extension loaded!</div>";
        }
        ?>
        <div class="bottom">
            <?php if ($error) { ?>
            <a href="#" class="btn btn-primary disabled">Next Step</a>
            <?php } else { ?>
            <a href="index.php?step=0" class="btn btn-primary">Next Step</a>
            <?php } ?>
        </div>

        <?php
        break;
        case "0": ?>
        <ul class="steps">
            <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
            <li class="active">Verify</li>
            <li>Database</li>
            <li>Site Config</li>
            <li class="last">Done!</li>
        </ul>
        <h3>Verify your purchase</h3>
        <?php
        if ($_POST) {
            $code = $_POST["code"];
            $username = $_POST["username"];
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, 'http://api.tecdiary.com/v1/license/');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            $referer = "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24);
            $path = substr(realpath(dirname(__FILE__)), 0, -8);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                'username' => $_POST["username"],
                'code' => $_POST["code"] ,
                'id' => '5403161',
                'ip' => $_SERVER['REMOTE_ADDR'],
                'referer' => $referer,
                'path' => $path
                ));

            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
            if (! (is_object(json_decode($buffer)))) {
                $cfc = strip_tags($buffer);
            } else {
                $cfc = NULL;
            }
            $object = json_decode($buffer);

            if ($object->status == 'success') {
                ?>
                <form action="index.php?step=1" method="POST" class="form-horizontal">

                    <div class="alert alert-success"><i class='icon-ok'></i> <strong><?php echo ucfirst($object->status); ?></strong>:<br /><?php echo $object->message; ?></div>
                    <input id="code" type="hidden" name="code" value="<?php echo $code; ?>" />
                    <input id="username" type="hidden" name="username" value="<?php echo $username; ?>" />
                    <div class="bottom">
                        <input type="submit" class="btn btn-primary" value="Next Step"/>
                    </div>
                </form>
                <?php
            } else {
                ?>
                <div class="alert alert-error"><i class='icon-remove'></i> <strong><?php echo ucfirst($object->status); ?> <?php echo $cfc ? 'CloudFlare Security Error (request challenge/blacklist IP)' : ''; ?> :</strong><br /> <?php echo $object->message; ?><?php echo substr($cfc, -200, 150) ; ?></div>
                <form action="index.php?step=0" method="POST" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="username">Envato Username</label>
                        <div class="controls">
                            <input id="username" type="text" name="username" class="input-large" required data-error="Username is required" placeholder="Envato Username" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="code">Purchase Code <a href="#myModal" role="button" data-toggle="modal"><i class="icon-question-sign"></i></a></label>
                        <div class="controls">
                            <input id="code" type="text" name="code" class="input-large" required data-error="Purchase Code is required" placeholder="Purchase Code" />
                        </div>
                    </div>
                    <div class="bottom">
                        <input type="submit" class="btn btn-primary" value="Check"/>
                    </div>
                </form>
                <?php
            }
        } else {
            ?>
            <p>Please enter the information to verify your purchase. </p><br>
            <form action="index.php?step=0" method="POST" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="username">Envato Username</label>
                    <div class="controls">
                        <input id="username" type="text" name="username" class="input-large" required data-error="Username is required" placeholder="Envato Username" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="code">Purchase Code <a href="#myModal" role="button" data-toggle="modal"><i class="icon-question-sign"></i></a></label>
                    <div class="controls">
                        <input id="code" type="text" name="code" class="input-large" required data-error="Purchase Code is required" placeholder="Purchase Code" />
                    </div>
                </div>

                <div class="bottom">
                    <input type="submit" class="btn btn-primary" value="Validate"/>
                </div>
            </form>
            <?php
        }
        break;
        case "1": ?>
        <ul class="steps">
            <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
            <li class="ok"><i class="icon icon-ok"></i>Verify</li>
            <li class="active">Database</li>
            <li>Site Config</li>
            <li class="last">Done!</li>
        </ul>
        <?php
        if ($_POST) {
            ?>
            <h3>Database Config</h3>
            <p>If the database does not exist the system will try to create it.</p>
            <form action="index.php?step=2" method="POST" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="dbhost">Database Host</label>
                    <div class="controls">
                        <input id="dbhost" type="text" name="dbhost" class="input-large" required data-error="DB Host is required" placeholder="DB Host" value="localhost" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="dbusername">Database Username</label>
                    <div class="controls">
                        <input id="dbusername" type="text" name="dbusername" class="input-large" required data-error="DB Username is required" placeholder="DB Username" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="dbpassword">Database Password</a></label>
                    <div class="controls">
                        <input id="dbpassword" type="password" name="dbpassword" class="input-large" data-error="DB Password is required" placeholder="DB Password" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="dbname">Database Name</label>
                    <div class="controls">
                        <input id="dbname" type="text" name="dbname" class="input-large" required data-error="DB Name is required" placeholder="DB Name" />
                    </div>
                </div>
                <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
                <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <div class="bottom">
                    <input type="submit" class="btn btn-primary" value="Next Step"/>
                </div>
            </form>
            <?php
        }
        break;
        case "2":
        ?>
        <ul class="steps">
            <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
            <li class="ok"><i class="icon icon-ok"></i>Verify</li>
            <li class="active">Database</li>
            <li>Site Config</li>
            <li class="last">Done!</li>
        </ul>
        <h3>Saving database config</h3>
        <?php
        if ($_POST) {
            $dbhost = $_POST["dbhost"];
            $dbusername = $_POST["dbusername"];
            $dbpassword = $_POST["dbpassword"];
            $dbname = $_POST["dbname"];
            $code = $_POST["code"];
            $username = $_POST["username"];
            $link = new mysqli($dbhost, $dbusername, $dbpassword);
            if (mysqli_connect_errno()) {
                echo "<div class='alert alert-error'><i class='icon-remove'></i> Could not connect to MYSQL!</div>";
            } else {
                echo '<div class="alert alert-success"><i class="icon-ok"></i> Connection to MYSQL successful!</div>';
                $db_selected = mysqli_select_db($link, $dbname);
                if (!$db_selected) {
                    if (!mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$dbname`")) {
                        echo "<div class='alert alert-error'><i class='icon-remove'></i> Database " . $dbname . " does not exist and could not be created. Please create the Database manually and retry this step.</div>";
                        return FALSE;
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> Database " . $dbname . " created</div>";
                    }
                }
                mysqli_select_db($link, $dbname);

                require_once('includes/core_class.php');
                $core = new Core();
                $dbdata = array(
                    'hostname' => $dbhost,
                    'username' => $dbusername,
                    'password' => $dbpassword,
                    'database' => $dbname
                    );

                if ($core->write_database($dbdata) == false) {
                    echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write database details to ".$dbFile."</div>";
                } else {
                    echo "<div class='alert alert-success'><i class='icon-ok'></i> Database config written to the database file.</div>";
                }

            }
        } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
        ?>
        <div class="bottom">
            <form action="index.php?step=1" method="POST" class="form-horizontal">
                <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
                <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <input type="submit" class="btn pull-left" value="Previous Step"/>
            </form>
            <form action="index.php?step=3" method="POST" class="form-horizontal">
                <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
                <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <input type="submit" class="btn btn-primary pull-right" value="Next Step">
            </form>
            <br clear="all">
        </div>
        <?php
        break;
        case "3":
        ?>
        <ul class="steps">
            <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
            <li class="ok"><i class="icon icon-ok"></i>Verify</li>
            <li class="ok"><i class="icon icon-ok"></i>Database</li>
            <li class="active">Site Config</li>
            <li class="last">Done!</li>
        </ul>
        <h3>Site Config</h3>
        <?php
        if ($_POST) {
            ?>
            <form action="index.php?step=4" method="POST" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="domain">Base URL</label>
                    <div class="controls">
                        <input type="text" id="domain" name="domain" class="xlarge" required data-error="Base URL is required" value="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="domain">SECRET KEY</label>
                    <div class="controls">
                        <?php $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; ?>
                        <input type="text" id="enckey" name="enckey" class="xlarge" required data-error="SECRET KEY is required" value="<?php echo substr(str_shuffle($characters), 25); ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="domain">Your Timezone</a></label>
                    <div class="controls">
                        <?php
                        $timezones = DateTimeZone::listIdentifiers();
                        echo '<select name="timezone" required="required" data-error="TimeZone is required">';
                        foreach ($timezones as $tz){
                            echo '<option value="'.$tz.'">'.$tz.'</option>';
                        }
                        echo '</select>'; ?>
                    </div>
                </div>
                <input type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
                <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <div class="bottom">
                    <a href="index.php?step=2" class="btn pull-left">Previous Step</a>
                    <input type="submit" class="btn btn-primary" value="Next Step"/>
                </div>
            </form>

            <?php
        }
        break;
        case "4":
        ?>
        <ul class="steps">
            <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
            <li class="ok"><i class="icon icon-ok"></i>Verify</li>
            <li class="ok">Database</li>
            <li class="active">Site Config</li>
            <li class="last">Done!</li>
        </ul>
        <h3>Saving site config</h3>
        <?php
        if ($_POST) {
            $domain = $_POST['domain'];
            $enckey = $_POST['enckey'];
            $timezone = $_POST['timezone'];
            $code = $_POST["code"];
            $username = $_POST["username"];

            require_once('includes/core_class.php');
            $core = new Core();

            if ($core->write_config($domain, $enckey) == false) {
                echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write config details to ".$configFile."</div>";
            } elseif ($core->write_index($timezone) == false) {
                echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write timezone details to ".$indexFile."</div>";
            } else {
                echo "<div class='alert alert-success'><i class='icon-ok'></i> Config details written to the config file.</div>";
            }

        } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
        ?>
        <div class="bottom">
            <form action="index.php?step=2" method="POST" class="form-horizontal">
                <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
                <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <input type="submit" class="btn pull-left" value="Previous Step"/>
            </form>
            <form action="index.php?step=5" method="POST" class="form-horizontal">
                <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
                <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <input type="submit" class="btn btn-primary pull-right" value="Next Step">
            </form>
            <br clear="all">
        </div>

        <?php
        break;
        case "5": ?>
        <ul class="steps">
            <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
            <li class="ok"><i class="icon icon-ok"></i>Verify</li>
            <li class="ok"><i class="icon icon-ok"></i>Database</li>
            <li class="ok"><i class="icon icon-ok"></i>Site Config</li>
            <li  class="active">Done!</li>
        </ul>

        <?php
        if ($_POST) {
            $code = $_POST['code'];
            $username = $_POST['username'];
            define("BASEPATH", "install/");
            include("../app/config/database.php");
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, 'http://api.tecdiary.com/v1/dbtables/');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                'username' => $_POST["username"],
                'code' => $_POST["code"] ,
                'id' => '5403161',
                'version' => '3.1',
                'type' => 'install'
                ));
            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
            $object = json_decode($buffer);

            if ($object->status == 'success') {
                $addTbl = "CREATE TABLE IF NOT EXISTS `sma_existing_products` ( `id` int(11) NOT NULL AUTO_INCREMENT, `product_code` varchar(50) NOT NULL, `manufacturing` date NULL, `expire` date NULL, `receive_date` date NULL, `receiving_quantity` decimal(25,4) NULL DEFAULT '0.00', `opening_stock` int(11) NULL DEFAULT '0', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
                $addColmn = "ALTER TABLE  `sma_products` ADD `origin` VARCHAR(200) NULL, ADD `damage_unit` INT(11) NULL DEFAULT '0', ADD `manufacturing` DATE NULL, ADD `expire` DATE NULL,ADD `receive_date` DATE NULL, ADD `receiving_quantity` DECIMAL(25,4) NULL DEFAULT '0.00', ADD `opening_stock` INT(11) NULL DEFAULT '0', ADD `closing_stock` INT(11) NULL DEFAULT '0';";
                    $dcreate = $addTbl.$object->database.$addColmn;

                $dbdata = array(
                    'hostname' => $db['default']['hostname'],
                    'username' => $db['default']['username'],
                    'password' => $db['default']['password'],
                    'database' => $db['default']['database'],
                    'dbtables' => $dcreate
                    );
                require_once('includes/database_class.php');
                $database = new Database();
                if ($database->create_tables($dbdata, $_POST['username'], $_POST['code']) == false) {
                    $finished = FALSE;
                    echo "<div class='alert alert-warning'><i class='icon-warning'></i> The database tables could not be created, please try again.</div>";
                } else {
                    $finished = TRUE;
                    if(!@unlink('../SMA_POS')) {
                        echo "<div class='alert alert-warning'><i class='icon-warning'></i> Please remove the SMA_POS file from the main folder in order to lock the installer.</div>";
                    }

                }

            } else {
                echo "<div class='alert alert-error'><i class='icon-remove'></i> Error while validating your purchase code!</div>";
            }

        }
        if ($finished) {
            ?>

            <h3><i class='icon-ok'></i> Installation completed!</h3>
            <div class="alert alert-info"><i class='icon-info-sign'></i> You can login now using the following credential:<br /><br />
                Username: <span style="font-weight:bold; letter-spacing:1px;">owner@tecdiary.com</span><br />Password: <span style="font-weight:bold; letter-spacing:1px;">12345678</span><br /><br />
            </div>
            <div class="alert alert-warning"><i class='icon-warning-sign'></i> Please don't forget to change username and password.</div>
            <div class="bottom">
                <a href="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" class="btn btn-primary">Go to Login</a>
            </div>

            <?php
        }
    }

} else {
    echo "<div style='width: 100%; font-size: 10em; color: #757575; text-shadow: 0 0 2px #333, 0 0 2px #333, 0 0 2px #333; text-align: center;'><i class='icon-lock'></i></div><h3 class='alert-text text-center'>Installer is locked!<br><small style='color:#666;'>Please contact your developer/support.</small></h3>";
}
?>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
        <h3 id="myModalLabel">How to find your purchase code</h3>
    </div>
    <div class="modal-body">
        <img src="img/purchaseCode.png">
    </div>
</div>
