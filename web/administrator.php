<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="css/pure-web.css">
    <link rel="stylesheet" href="css/pure.css"/>
    <link rel="stylesheet" href="css/pure-form.css"/>
    <link rel="stylesheet" href="css/side-menu.css">
</head>

<?php if (login_check($mysqli) == true) : ?>
<?php if (check_overadmin($mysqli) == true) : ?>
<div id="layout">
    <a href="" id="menuLink" class="menu-link">
        <span></span>
    </a>

    <div id='menu'>
            <div class='pure-menu pure-menu-open'>
                <a class='pure-menu-heading' align='center' href='main.php'><img src='img/logo.png'></a>
                    <ul>
                    <li><a href='my_projects.php'>Mine projekter</a></li>
                    <li><a href='all_projects.php'>Alle projekter</a></li>
                    <li><a href='history.php'>Min historik</a></li>
                    <li><a href='contact.php'>Kontakt</a></li>
                    <?php if (check_admin($mysqli) == true) : ?>
                    <li> <a href='new_project.php'>Nyt projekt</a></li>
                    <li> <a href ='sql_table_to_pdf/generate-pdf.php'> Print </a></li>
                    <?php endif; ?>
                    <?php if (check_overadmin($mysqli) == true) : ?>
                    <li> <a href='administrator.php'>Administrator</a></li>
                    <?php endif; ?>
                    <li><a class='logout' href='includes/logout.php'>Log ud</a></li>
                </ul>
            </div>
        </div>

    <div id="main">
        <div class="header">
            <h1>Administrator side</h1>
        </div>

        <div class="content">
            <p>

            Her kan du vælge en ny email adresse, hvor alle emails i kontakt vil blive sendt til.<br>
            Den nuværende email er: <?php echo get_mail($mysqli); ?><br><br>
            Indtast den nye email adresse, hvis du ønsker at ændre den:<br>
                <form class="pure-form pure-form-stacked" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                    <div>
                        <label for="newemail"></label>
                        <input id ="newemail" type="string" name="newemail"/><br>
                        <input class="btn left" name="email" type="submit" value="Godkend"> 
                    </div>
                </form>

                <?php
                    if (isset($_REQUEST['newemail'])) {
                        update_email($mysqli, $_REQUEST['newemail']);
                        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=administrator.php">';
                    }
                ?>
                <br><br><br>
                
                <?php user_table($mysqli); ?> <br><br>
                
                Vælg et id på den du ønsker, at lave til super admin.<br>   
                Dette medføre, at du ikke kan tilgå administrator siden mere.<br>
                (Der kan kun være en super administrator på en gang)<br>
                
                <form>
                <div>
                    <label for="id"><b>Bruger-id</b></label>
                    <input id ="id" type="int" name="id" required />
                </div>
                    <input class="btn left" type="submit" value="Ny admin">
                    <?php 
                        if (isset($_REQUEST['id']) && get_userState($mysqli, $_REQUEST['id']) == 1) {
                            $oldAdmin = $_SESSION['user_id'];
                            $newAdmin = $_REQUEST['id'];
                            echo "<META HTTP-EQUIV='Refresh' Content='0; URL=admin_confirmation.php?nid=$newAdmin&oid=$oldAdmin'?>";
                        }
                    ?>
                </form>
            </p>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>
</body>
    <?php else : ?>
        <?php header('Location: ./main.php'); ?>
    <?php endif; ?>
    <?php else : ?>
        <p>
            <span class="error">Du har ikke rettigheder til at komme ind på siden.</span> Gå venligst tilbage til <a href="index.php">login siden</a>.
        </p>
    <?php endif; ?>
</body>

</html>
