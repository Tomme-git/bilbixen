<?php
session_start();
include ('core/init.php');
include ('includes/session.php');

$db = new DB();

$checkifadmin = $db->read('bb_login', '*', 'id = ' . $login_id . ' AND permissions = ' . 1 . '', '');

$readcategory = $db->read('bb_category', "*", "", "");

if ($login_session) {
    if ($checkifadmin['count']) {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Kategori Oversigt | Bilbixen</title>
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
                                    <h2>G??R SOM 10.000 ANDRE</h2>
                                </section>
                                <section>                    
                                    <h3 class="smalltext">S??LG DIN BIL P?? BILBIXEN</h3> 
                                </section>
                            </div>
                            <div class="car">
                                <img src="images/car-banner.png" height="200" alt="car-banner">
                            </div>
                        </section>
                    </header>
                </div>

                <div class="row"></div>

                <section class="wrapper col-12 col-t-12">

                    <div class="mainwrap col-8 col-t-12">

                        <ul id="adminnav" class="col-12 col-t-12">
                            <li class="adnavitem">
                                <a class="active" href="admin.php">
                                    Kategorier
                                </a>
                            </li>
                            <li class="adnavitem">
                                <a href="carinsert.php">
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

                        <section class="editcontent col-12 col-t-12">

                            <h2>
                                Oversigt
                            </h2>

                            <div class="table col-12 col-t-12">

                                <div class="trow header blue col-12 col-t-12">

                                    <div class="cell col-3 col-t-3">
                                        ID
                                    </div>
                                    <div class="cell col-3 col-t-3">
                                        Kategori navn
                                    </div>
                                    <div class="cell col-3 col-t-3">
                                        Rediger
                                    </div>
                                    <div class="cell col-3 col-t-3">
                                        Slet
                                    </div>
                                </div>
                                <?php
                                foreach ($readcategory["results"] as $row) {
                                    ?>

                                    <div class="trow col-12 col-t-12">
                                        <div class="cell col-3 col-t-3">
                                            <?php
                                            echo $row->id;
                                            ?>
                                        </div>
                                        <div class="cell col-3 col-t-3">
                                            <?php
                                            echo $row->category;
                                            ?>
                                        </div>
                                        <div class="cell col-3 col-t-3">
                                            <a href="update.php?cid=<?php echo $row->id ?>">Rediger</a>
                                        </div>                                  
                                        <div class="cell col-3 col-t-3">
                                            <a href="delete.php?cid=<?php echo $row->id ?>">Slet</a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <a id="inscat" class="col-12 col-t-12" href="catinsert.php">Inds??t ny kategori</a>
                            </div>

                            <?php
                            if (isset($_SESSION['delerror'])) {
                                echo "<p style='color: red;'>" . $_SESSION['delmenuerror'] . "</p>";
                                unset($_SESSION['delerror']);
                            }
                            ?>
                        </section>
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
                        p?? Syddanske Erhvervsskole Odense, Vejle. Opgaven er<br>
                        udviklet til eleverne p?? Web-integrator uddannelsen.
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