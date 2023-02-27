<?php
include ('core/init.php');
include ('includes/session.php');

$db = new DB();
?>

<!DOCTYPE html>
<html lang="da">
    <head>
        <meta charset="UTF-8">
        <title>En bedre løsning til dit bilsalg - Bilbixen</title>
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

        <div id="promos">
            <div id="promowrap" class="col-8 col-t-12">
                <article id="left" class="col-4 col-t-">
                    <h1>Hvad er bilbixen?</h1>
                    <h2>En bedre løsning til dit bilsalg</h2>
                    <p>
                        Én samlet portal til både private og virksomheder. 
                        Nemt, hurtigt og lige til - du
                        opnår altid den højeste pris på markedet.
                    </p>
                </article>

                <article id="right" class="col-4 col-t-">
                    <h1>Her får du altid den bedste pris for din bil</h1>
                    <h2>Bilbixen den smarte løsning</h2>
                    <p>
                        Din bil vises til hele Danmark så snart
                        din annonce er oprettet. På den måde
                        får du altid den bedste pris for din bil
                    </p>
                </article>
            </div>
        </div>

        <div class="row"></div>
        <div id="howitworkswrap">
            <section class="howitworks col-8 col-t-12">
                <h1>Hvordan virker bilbixen?</h1>
                <div class="hiwimgwrap">
                    <div class="figwrap">
                        <figure>
                            <img src="images/camera.png" alt="Billede af et kamera">
                            <figcaption>1. Opret annonce</figcaption>
                        </figure>
                    </div>
                    <div class="figwrap">
                        <figure>
                            <img src="images/+.png" alt="Billede af lig med">
                        </figure>
                    </div>
                    <div class="figwrap">
                        <figure>
                            <img src="images/location.png" alt="Billede af en lokations pin">
                            <figcaption class="test">2. Vises i hele DK</figcaption>
                        </figure>
                    </div>
                    <div class="figwrap">
                        <figure>
                            <img src="images/=.png" alt="Billede af lig med">
                        </figure>
                    </div>
                    <div class="figwrap">
                        <figure>
                            <img src="images/cash.png" alt="Billede af et valutasymbol, dollar tegn">
                            <figcaption class="test">3. Bedste pris</figcaption>
                        </figure>
                    </div>
                </div>
            </section>
        </div>

        <div class="row"></div>
        <div id="randcarwrap">
            <section class="randcar col-8 col-t-12">
                <h1>Dagens super tilbud</h1>
                <div id="tilbudwrap">
                    <?php
                    $categories = $db->read("bb_category", "*", "", "ORDER BY rand() LIMIT 3 ");

//                        print_r($category);
                    foreach ($categories['results'] as $category) {
                        $fkid = $category->id;
                        $cars = $db->read("bb_cars", "*", "bb_category_id=$fkid", "ORDER BY rand() ASC LIMIT 1");
//            echo $test22["count"] . "<br />";
                        ?>
                        <div class="stwrap">
                            <div class="supertilbud">
                                <?php
                                if (isset($category)) {
                                    echo "<h1>" . $category->category . "</h1>";
                                }
                                if (isset($cars["results"])) {
                                    foreach ($cars["results"] as $car) {
                                        ?> 
                                        <div class="todaycars">
                                            <div class="todaytop">
                                                <img src = "images/<?php echo $car->path ?>" alt = "billede af køretøj" >
                                            </div>

                                            <div class="todaybottom">
                                                <div class="todaybottomcar">
                                                    <div class="todayprice">
                                                        <?php
                                                        if (isset($login_session)) {
                                                            $moms = 0.1 * $car->pris;
                                                            $nomoms = $car->pris - $moms;
                                                            echo '<p>' . number_format($nomoms, "0", ",", ".") . ' ' . 'DKK' . '</p>';
                                                        } else {
                                                            echo '<p>' . number_format($car->pris, "0", ",", ".") . ' ' . 'DKK' . '</p>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                    $supercarid = $car->id;
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
                                                    '<p class="carname">' . $car->carname . '</p>'
                                                    . '<p>' . ' Årgang - ' . $car->aargang . '</p>'
                                                    . '<p>' . ' KM - ' . number_format($car->kilometer, "0", ",", ".") . '</p>'
                                                    ;
                                                    ?>
                                                </div>
                                                <div class="todayallinfo">
                                                    <?php
                                                    echo '<a href="singlecar.php?id=' . $supercarid . '">' . '<p>' . "Se alle informationer" . '</p></a>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </section>
        </div>

        <div class="row"></div>

        <div id="footerwrap">
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
                    Dette er en skole opgave udviklet udelukkende til brug<br class="displaynone">
                    på Syddanske Erhvervsskole Odense, Vejle. Opgaven er<br class="displaynone">
                    udviklet til eleverne på Web-integrator uddannelsen.
                </p>
            </footer>
        </div>

    </body>
</html>