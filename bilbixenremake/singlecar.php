<?php
include ('core/init.php');
include ('includes/dbconn.php');
include ('includes/session.php');

$db = new DB();

$id = $_GET['id'];

if (isset($_POST['commentsubmit'])) {
    if (!empty($_POST['navn']) && !empty($_POST['email']) && !empty($_POST['tekst'])) {
        $navn = $objCon->real_escape_string($_POST['navn']);
        $email = $objCon->real_escape_string($_POST['email']);
        $tekst = $objCon->real_escape_string($_POST['tekst']);

        if (strlen($name) > 25) {
            $errorname = "Navn må højest indeholde 25 karakterer";
        } elseif (!preg_match("/[[:alnum:]][a-z0-9_\.\-]*@[a-z0-9\.\-]+\.[a-z]{2,4}$/", $email)) {
            $erroremail = "Brug venligst en gyldig email";
        } else {
            $data = [
                'navn' => $navn,
                'email' => $email,
                'tekst' => $tekst,
                'car_id' => $id,
                'godkendt' => 0,
                'dato' => date('Y-m-d')
            ];

            if ($db->create('bb_comments', $data)) {
                $message = "Kommentar afventer godkendelse";
            } else {
                echo "noget gik galt";
//                print_r($data);
            }
        }
    } else {
        $fillall = "Udfyld alle obligatoriske felter";
    }
}
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

        <div class="singlewrapper col-12 col-t-12">

            <div class="singletop">

                <div class="col-8 col-t-12">
                    <h1>
                        Detaljer
                    </h1>
                    <hr>  
                    <div class="singlecar col-12 col-t-12">
                        <?php
                        $singlecar = $db->read("bb_cars", "*", "id = '$id'", "");
//print_r($test22);
//            echo $test22["count"] . "<br />";
                        foreach ($singlecar["results"] as $row) {
                            ?>
                            <div class="singleimg">
                                <img src = "images/<?php echo $row->path ?>" height = "330" width = "525" alt = "lastvogn billede">
                            </div>

                            <div class="singleinfo col-5 col-t-12">
                                <div class="infobit">
                                    <span class="infoname">
                                        <?php
                                        echo $row->carname;
                                        ?>
                                    </span>
                                </div>
                                <div class="infobit">
                                    <p>
                                        Årgang
                                    </p>
                                    <p>
                                        <?php
                                        echo $row->aargang;
                                        ?>
                                    </p>
                                </div>
                                <div class="infobit">
                                    <p>
                                        KM
                                    </p>                                
                                    <p>
                                        <?php
                                        echo number_format($row->kilometer, "0", ",", ".");
                                        ?>
                                    </p>
                                </div>
                                <div class="infobitblue">
                                    <p>
                                        Pris
                                    </p>
                                    <p>
                                        <?php
                                        if (isset($login_session)) {
                                            $moms = 0.1 * $row->pris;
                                            $nomoms = $row->pris - $moms;
                                            echo number_format($nomoms, "0", ",", ".") . " " . "DKK";
                                        } else {
                                            echo number_format($row->pris, "0", ",", ".") . " " . "DKK";
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="singlebottom">
                <section class="comcontainer col-8 col-t-12">
                    <h1>Kommentarer</h1>
                    <div id="singlecomments">

                        <div id="mobicrtcomment">
                            <div id="crtcommentcontents">
                                <div class="kontakt">
                                    <form method="post" enctype="multipart/form-data" action="#comments">
                                        <?php
                                        if (isset($fillall)) {
                                            echo '<p style="margin:0;">' . $fillall . '</p>';
                                        }
                                        ?>
                                        <input type="text" name="navn" placeholder="Navn" required>
                                        <?php
                                        if (isset($errorname)) {
                                            echo '<p style="margin:0;">' . $errorname . '</p>';
                                        }
                                        ?>
                                        <input type="email" name="email" placeholder="Email" required>
                                        <?php
                                        if (isset($erroremail)) {
                                            echo '<p style="margin:0;">' . $erroremail . '</p>';
                                        }
                                        ?>
                                        <textarea name="tekst" placeholder="Besked" required></textarea>
                                        <input type="submit" name="commentsubmit" value="Upload">
                                        <?php
                                        if (isset($message)) {
                                            echo '<p style="margin:0;">' . $message . '</p>';
                                        }
                                        ?>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="comments">
                            <div id="commentscontents">
                                <a href="#comments"></a>
                                <?php
                                $comments = $db->read("bb_comments", "*", "car_id = '$id' AND godkendt = '1'", "");
                                $anycomments = $comments['count'];
                                if ($anycomments) {
                                    foreach ($comments["results"] as $comment) {
                                        ?>
                                        <div class="commentinfo">
                                            <h2>
                                                <?php
                                                echo $comment->navn . '<br>';
                                                echo '<p>' . $comment->dato . '</p>';
                                                ?>
                                            </h2>
                                            <p>
                                                <?php
                                                echo $comment->tekst;
                                                ?>
                                            </p>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<p>" . "Der er ingen kommentarer, vær den første til at skrive din mening!" . "</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div id="crtcomment">
                            <div id="crtcommentcontents">
                                <div class="kontakt">
                                    <form method="post" enctype="multipart/form-data" action="#comments">
                                        <?php
                                        if (isset($fillall)) {
                                            echo '<p style="margin:0;">' . $fillall . '</p>';
                                        }
                                        ?>
                                        <input type="text" name="navn" placeholder="Navn" required>
                                        <?php
                                        if (isset($errorname)) {
                                            echo '<p style="margin:0;">' . $errorname . '</p>';
                                        }
                                        ?>
                                        <input type="email" name="email" placeholder="Email" required>
                                        <?php
                                        if (isset($erroremail)) {
                                            echo '<p style="margin:0;">' . $erroremail . '</p>';
                                        }
                                        ?>
                                        <textarea name="tekst" placeholder="Besked" required></textarea>
                                        <input type="submit" name="commentsubmit" value="Upload">
                                        <?php
                                        if (isset($message)) {
                                            echo '<p style="margin:0;">' . $message . '</p>';
                                        }
                                        ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
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
                    Dette er en skole opgave udviklet udelukkende til brug<br>
                    på Syddanske Erhvervsskole Odense, Vejle. Opgaven er<br>
                    udviklet til eleverne på Web-integrator uddannelsen.
                </p>
            </footer>
        </div>
    </body>
</html>
