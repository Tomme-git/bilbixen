<?php
include ('core/init.php');
include ('includes/dbconn.php');
include ('includes/session.php');

$db = new DB();
?>

<!DOCTYPE html>
<html lang="da">
    <head>
        <meta charset="UTF-8">
        <title>Find en bil der passer til dig | Bilbixen</title>
        <link rel="stylesheet" type="text/css" href="style/main.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="hdrcontainer">
            <header class="col-8 col-t-12">
                <div id="tophdrwrap">
                    <div id="logowrap">
                        <a href="index.php">
                            <img class="logo" src="images/logo.png" alt="Bilbixen-logo">
                        </a>
                    </div>

                    <nav>
                        <ul class="desknav">
                            <li><a href="findbil.php"><p>Find bil</p></a></li>
                            <li><a href="#"><p>Om os</p></a></li>
                            <li><a href="#"><p>Kontakt</p></a></li>
                            <?php
                            if (isset($login_session)) {
                                ?>
                                <li>
                                    <p style="padding-right: 5px;">Logget ind som:</p>
                                    <?php
                                    echo "<p style='color: #9f977f;'>" . $login_session . "</p>";
                                    ?>
                                </li>
                                <li>
                                    <?php
                                    echo "<a href='logout.php'>" . " " . "Log ud</a>";
                                    ?>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li><a href="login.php">Forhandler-login</a></li>
                                <?php
                            }
                            ?>

                        </ul>
                        <div class="mobiloginnav">
                            <ul>
                                <?php
                                if ($login_session) {
                                    ?>
                                    <li>
                                        <p style="padding-right: 5px;">Logget ind som:</p>
                                        <?php
                                        echo "<p style='color: #9f977f;'>" . $login_session . "</p>";
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo "<a href='logout.php'>" . " " . "Log ud</a>";
                                        ?>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a href="login.php">Forhandler-login</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="mobinav">
                            <button class="dropbtn"><img src="images/menu.png"></button>
                            <div class="dropdown-content">
                                <a href="findbil.php"><p>Find bil</p></a>
                                <a href="#"><p>Om os</p></a>
                                <a href="#"><p>Kontakt</p></a>
                                <?php
                                if ($login_session) {
                                    echo "<a href='logout.php'><p>" . " " . "Log ud</p></a>";
                                } else {
                                    ?>
                                    <a href="login.php"><p>Forhandler-login</p></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="row"></div>

                <section class="hdrwrapper col-12 col-t-12">
                    <div class="dolikewrap">
                        <section>
                            <h2>GØR SOM 10.000 ANDRE</h2>
                        </section>
                        <section>                    
                            <h3 class="smalltext">SÆLG DIN BIL PÅ BILBIXEN</h3> 
                        </section>
                    </div>
                    <div class="car">
                        <img src="images/car-banner.png" height="200" alt="car-banner">
                    </div>
                </section>
            </header>
        </div>

        <div class="row"></div>       

        <div class="findbilwrapper col-12 col-t-12">

            <div id="cars" class="col-8 col-t-12">
                <div class="carwrap">
                    <?php
                    $category = "SELECT * FROM bb_category";
                    $catres = mysqli_query($objCon, $category);
                    while ($catrow = mysqli_fetch_array($catres)) {
                        ?>

                        <h2>
                            <?php echo $catrow['category']; ?>
                        </h2>
                        <div class="carparent">
                            <?php
                            $cars = "SELECT * FROM bb_cars WHERE bb_category_id = '" . $catrow['id'] . "'" . "ORDER BY rand() LIMIT 3";
                            $carres = mysqli_query($objCon, $cars);
                            while ($carrow = mysqli_fetch_array($carres)) {
                                ?>
                                <div class="carinfowrap">
                                    <div class="carinfo">
                                        <div class="todaytop">
                                            <img src = "images/<?php echo $carrow['path'] ?>" height = "220" width = "350" alt = "Billede af <?php echo $carrow['carname'] ?>">
                                        </div>
                                        <div class="todaybottom">

                                            <div class="todaybottomcar">
                                                <div class="todayprice">
                                                    <?php
                                                    if (isset($login_session)) {
                                                        $moms = 0.1 * $carrow['pris'];
                                                        $nomoms = $carrow['pris'] - $moms;
                                                        echo '<p>' . number_format($nomoms, "0", ",", ".") . ' ' . 'DKK' . '</p>';
                                                    } else {
                                                        echo '<p>' . number_format($carrow['pris'], "0", ",", ".") . ' ' . 'DKK' . '</p>';
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                $supercarid = $carrow['id'];
                                                $supercomments = $db->read('bb_comments', '*', 'car_id = ' . $supercarid . ' AND godkendt = ' . 1 . '', '');
                                                $commentamount = $supercomments['count'];
                                                ?>
                                                <div class="todaycomments">
                                                    <div class="commentlinkwrap">
                                                        <?php
                                                        echo '<a href="singlecar.php?id=' . $supercarid . '#comments">' . '<p>' . $commentamount . '</p></a>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                                echo
                                                '<p class="carname">' . $carrow['carname'] . '</p>'
                                                . '<p>' . ' Årgang - ' . $carrow['aargang'] . '</p>'
                                                . '<p>' . ' KM - ' . number_format($carrow['kilometer'], "0", ",", ".") . '</p>'
                                                ;
                                                ?>
                                                <div class="todayallinfo">
                                                    <?php
                                                    echo '<a href="singlecar.php?id=' . $supercarid . '">' . '<p>' . "Se alle informationer" . '</p></a>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>

        <div class="row"></div>        
        <aside class="col-2"></aside>

        <footer class="col-8 col-t-12">
            <ul>
                <li><span class="bold">Bilbixen A/S</span></li>
                <li>Brugtvognsvej 100</li>
                <li>3784 Brugtvogn City</li>
                <li>+45 637 726 78</li>
                <li>hello@bilbixen.com</li>
            </ul>

            <p>
                <span class="bold">Information</span><br>
                Dette er en skole opgave udviklet udelukkende til brug<br>
                på Syddanske Erhvervsskole Odense, Vejle. Opgaven er<br>
                udviklet til eleverne på Web-integrator uddannelsen.
            </p>
        </footer>
    </body>
</html>
