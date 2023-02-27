<?php
session_start();
include ('core/init.php');
include ('includes/session.php');

$db = new DB();

$checkifadmin = $db->read('bb_login', '*', 'permissions = ' . 1 . '', '');

if (isset($_GET['cid'])){
    $catid = $_GET['cid'];
}

if (isset($_GET['carsid'])){
    $carsid = $_GET['carsid'];
}

if (isset($_GET['commentid'])){
    $comid = $_GET['commentid'];
}




if ($login_session) {
    if ($checkifadmin['count']) {

        if (isset($comid)) {
            $data = [
                'godkendt' => 1
            ];

            if ($db->update("bb_comments", $data, "id=$comid")) {
                header("location: comments.php");
            }
        }

        $readcategory = $db->read("bb_category", "*", "", "");

//$db->update("cms_category", $data, $where);

        if (isset($_POST['sbmtupdcat'])) {
            $category = $_POST['category'];

            $data = [
                'category' => $category,
            ];

            if ($db->update('bb_category', $data, "id=$catid")) {
//        header("location: cms.php");
//        echo "Opslag sendt til databasen";
                $_SESSION['message'] = 'kategori redigeret';
                header("Location: admin.php");
            } else {
                echo "noget gik galt";
            }
        }

        if (isset($_POST['sbmtupdcars'])) {
            $carname = $_POST['carname'];
            $aargang = $_POST['aargang'];
            $kilometer = $_POST['kilometer'];
            $pris = $_POST['pris'];

            $folder = 'images/';
            $billede = $_FILES['path'];
            $pic = time() . '_' . $billede['name'];
            copy($billede['tmp_name'], $folder . $pic);

            $category = $_POST['category'];

            $data = [
                'carname' => $carname,
                'aargang' => $aargang,
                'kilometer' => $kilometer,
                'pris' => $pris,
                'path' => $pic,
                'bb_category_id' => $category
            ];

            if ($db->update('bb_cars', $data, "id=$carsid")) {
//        header("location: cms.php");
//        echo "Opslag sendt til databasen";
                $_SESSION['message'] = 'Bil redigeret';
                header("Location: edit.php");
            } else {
                echo "noget gik galt";
            }
        }
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>admin</title>
                <link rel="stylesheet" type="text/css" href="style/main.css" />
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

                <section class="wrapper col-12 col-t-12">
                    <section class="mainwrap col-8 col-t-12">
                        <?php
                        if (isset($_GET['cid'])) {
                            ?>
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

                            <h1>Rediger kategori</h1>

                            <form class="admform col-4 col-t-4" method="post" enctype="multipart/form-data" action="#">
                                <script>document.querySelector("form").setAttribute("action", "")</script>
                                <label>
                                    Nyt kategorinavn:
                                    <br> 
                                    <input type="text" name="category">
                                </label>

                                <br>

                                <input type="submit" name="sbmtupdcat" value="Indsæt">

                            </form>

                            <?php
                        } elseif ($_GET['carsid']) {
                            ?>

                            <ul id="adminnav" class="col-12 col-t-12">
                                <li class="adnavitem">
                                    <a href="admin.php">
                                        Kategorier
                                    </a>
                                </li>
                                <li class="adnavitem">
                                    <a href="carinsert.php">
                                        Lav opslag
                                    </a>
                                </li>
                                <li class="adnavitem">
                                    <a class="active" href="edit.php">
                                        Slet og rediger
                                    </a>
                                </li>
                                <li class="adnavitem">
                                    <a href="comments.php">
                                        Kommentarer
                                    </a>
                                </li>
                            </ul>

                            <h1>Rediger bil</h1>
                            <form class = "admform col-4 col-t-4" method = "post" enctype = "multipart/form-data" action = "">

                                <label>
                                    Kategori:
                                    <br>
                                    <select name="category">

                                        <?php
                                        foreach ($readcategory["results"] as $row) {
                                            ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->category; ?></option>
                                            <?php
                                        }
                                        ?>

                                    </select>

                                </label>

                                <br>

                                <label>
                                    Navn:
                                    <br>
                                    <input type="text" name="carname">
                                </label>

                                <br><br>

                                <label>
                                    Årgang:
                                    <br>
                                    <input type="number" name="aargang">
                                </label>

                                <br><br>

                                <label>
                                    Kilometer:
                                    <br>
                                    <input type="number" name="kilometer">
                                </label>

                                <br><br>

                                <label>
                                    Pris:
                                    <br>
                                    <input type="number" name="pris">
                                </label>

                                <br><br>

                                <label>
                                    Billede:
                                    <br>
                                    <input type="file" name="path"><br><br>
                                </label>

                                <br>

                                <input type="submit" name="sbmtupdcars" value="Indsæt">
                            </form>
                            <?php
                        }
                        ?>
                        <div class="row"></div>

                        <?php
//                        if (isset($_SESSION['message'])) {
//                            echo "<p style='color: #00ff00;'>" . $_SESSION['message'] . "</p>";
//                            unset($_SESSION['message']);
//                        }
                        ?>
                    </section>

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