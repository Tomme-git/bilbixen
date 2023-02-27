<?php
session_start();
include ('core/init.php');
include ('includes/session.php');

$db = new DB();

$checkifadmin = $db->read('bb_login', '*', 'id = ' . $login_id . ' AND permissions = ' . 1 . '', '');
if ($login_session) {
    if ($checkifadmin['count']) {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>admin</title>
                <link rel="stylesheet" type="text/css" href="style/main.css" />
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

                <?php
                if (isset($_POST['submit'])) {
                    if (!empty($_POST['carname']) && !empty($_POST['aargang']) && !empty($_POST['kilometer']) && !empty($_POST['pris']) && !empty($_FILES['path'])) {
                        $carname = $objCon->real_escape_string($_POST['carname']);
                        $aargang = $objCon->real_escape_string($_POST['aargang']);
                        $kilometer = $objCon->real_escape_string($_POST['kilometer']);
                        $pris = $objCon->real_escape_string($_POST['pris']);

                        $folder = 'images/';
                        $billede = $_FILES['path'];
                        $pic = time() . '_' . $billede['name'];
                        copy($billede['tmp_name'], $folder . $pic);

                        $category = $_POST['category'];

                        if (strlen($carname) > 50) {
                            $errorcarname = "Navn må højest indeholde 50 karakterer";
                        } elseif (!preg_match('/^\d{4}$/', $aargang)) {
                            $erroryear = "Brug venligst et gyldigt årstal til at beskrive årgang";
                        } elseif (!preg_match('/^\d+$/', $kilometer)) {
                            $errorkm = "Brug venligst tal til at beskrive kilometer";
                        } elseif (!preg_match('/^\d+$/', $pris)) {
                            $errorpris = "Brug venligst tal til at beskrive prisen";
                        } else {
                            $data = [
                                'carname' => $carname,
                                'aargang' => $aargang,
                                'kilometer' => $kilometer,
                                'pris' => $pris,
                                'path' => $pic,
                                'bb_category_id' => $category
                            ];

                            if ($db->create('bb_cars', $data)) {
                                $carinserted = "Opslag sendt til databasen";
                            } else {
                                echo "noget gik galt";
                                print_r($data);
                            }
                        }
                    } else {
                        $fillall = "Udfyld alle felterne";
                    }
                }
                ?>

                <section class="wrapper col-12 col-t-12">

                    <div class="mainwrap col-8 col-t-12">

                        <ul id="adminnav" class="col-12 col-t-12">
                            <li class="adnavitem">
                                <a href="admin.php">
                                    Kategorier
                                </a>
                            </li>
                            <li class="adnavitem">
                                <a class="active" href="carinsert.php">
                                    Lav opslag
                                </a>
                            </li>
                            <li class="adnavitem">
                                <a href="edit.php">
                                    Slet og rediger
                                </a>
                            </li>
                            <li class="adnavitem">
                                <a href="comments.php">
                                    Kommentarer
                                </a>
                            </li>
                        </ul>


                        <form class="col-12 col-t-12" method="post" enctype="multipart/form-data" action="">
                            <?php
                            $type = $db->read("bb_category", "*", "", "ORDER BY id ASC ");
                            ?>

                            Type 
                            <select name="category">
                                <?php
                                foreach ($type["results"] as $row) {
                                    ?>
                                    <option value="<?php echo $row->id; ?>" name="<?php echo $row->category; ?>">
                                        <?php echo $row->category; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <br><br>
                            Køretøjs navn:
                            <br> 
                            <input type="text" name="carname">
                            <?php
                            if (isset($errorcarname)) {
                                echo '<p>' . $errorcarname . '</p>';
                            }
                            ?>
                            <br><br>
                            Årgang:
                            <br> 
                            <input type="text" name="aargang">
                            <?php
                            if (isset($erroryear)) {
                                echo '<p>' . $erroryear . '</p>';
                            }
                            ?>
                            <br><br>
                            Kilometer:
                            <br> 
                            <input type="text" name="kilometer">
                            <?php
                            if (isset($errorkm)) {
                                echo '<p>' . $errorkm . '</p>';
                            }
                            ?>
                            <br><br>
                            Pris:
                            <br> 
                            <input type="text" name="pris">
                            <?php
                            if (isset($errorpris)) {
                                echo '<p>' . $errorpris . '</p>';
                            }
                            ?>
                            <br><br>

                            Choose image:<br><br>
                            <input type="file" name="path"><br><br>
                            <input type="submit" name="submit" value="Upload">
                            <?php
                            if (isset($fillall)) {
                                echo '<p>' . $fillall . '</p>';
                            }
                            if (isset($carinserted)) {
                                echo '<p>' . $carinserted . '</p>';
                            }
                            ?>
                        </form>         
                    </div>
                </section>


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
        <?php
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
    exit();
}