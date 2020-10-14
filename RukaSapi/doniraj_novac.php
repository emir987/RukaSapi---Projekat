<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ruka Sapi</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/donate.css">
    <link rel="stylesheet" href="css/donirajNovac.css">
    <script src="https://kit.fontawesome.com/5bd43f344d.js" crossorigin="anonymous"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>

<body>

    <!-- Navigation -->

    <header>

        <nav class="navbar navbar-expand-lg navbar-light bg-custom fixed-top p-0">
            <a class="navbar-brand nav-item nav-link" href="index.php">
                <img class="w-75" style="text-align: center;" src="res/images/logotip.png" alt="">
            </a>

            <button id="toggle-hamburger" class="navbar-toggler my-2 ml-auto" tycustom data-toggle="collapse"
                data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                aria-label="Toggle navigation">
                <div id="nav-icon1">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <div class="collapse navbar-collapse mobile-nav" id="navbarTogglerDemo03">
                <div class="navbar-nav m-auto align-items-center justify-content-center">
                    <div id="nav-links-left" class="d-flex px-4 ml-n3">
                        <li class="dropdown">
                            <a class="nav-link nav-item from-left">DONIRAJ</a>
                            <ul class="dropdown-menu">
                                <li><a href="donate.php">HRANA</a></li>
                                <li><a href="doniraj_novac.php">NOVAC</a></li>
                            </ul>
                        </li>
                        <a class="nav-item nav-link from-left" href="appointment.php">ŠETAJ</a>
                    </div>
                    <a class="nav-link logo-nav-item" style="width: 130px;" href="index.php">
                        <img class="logo" style="text-align: center;" src="res/images/logotip.png" alt="">
                    </a>
                    <div id="nav-links-right" class="d-flex px-4">
                        <a class="nav-item nav-link from-left" href="faq.php">FAQ</a>
                        <li class="dropdown">
                            <a class="nav-item nav-link from-left">PROFIL</a>
                            <ul class="dropdown-menu">
                                <li><a href="termini.php">TERMINI</a></li>
                                <li><a href="mojiLjubimci.php">MOJI LJUBIMCI</a></li>
                                <?php
                                    if (isset($_SESSION['id'])){
                                        if ($_SESSION['id'] == 1) {
                                            echo '<li><a href="dashboard.php">DODIJELI IMENA</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </li>
                    </div>
                </div>
            </div>

            <a href="favourites.php" class="favourites mx-3">
                <img class="logo" style="width: 40px;" src="res/images/dogHeart.svg" alt="">
            </a>

            <div class="my_dropdown profil-drop mx-3">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"></button>

                <div class="dropdown-menu dropdown-menu-right">
                    <?php
                        if (isset($_SESSION['id'])){
                            echo '<a class="dropdown-item" href="api/user/logout.php?location=' . urlencode($_SERVER['REQUEST_URI']) . '">Logout</a>';
                        }else{
                            echo '<button data-toggle="modal" data-target="#modal-login" role="button" class="dropdown-item">Prijavi se</button>
                                  <button data-toggle="modal" data-target="#modal-register" role="button" class="dropdown-item">Registruj se</button>';
                        }
                    ?>
                </div>
            </div>
        </nav>


    </header>

    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content px-4 py-2" style="border-radius: 1.2rem; margin-top:6rem;">
                <h2 class="text-center mt-2">Prijava</h2>
                <form id="loginForm" class="p-3 mt-2 form-border">
                    <div class="form-group">
                        <label id="checkEmail" for="email" class="text-center h5">Email</label>
                        <input name="email" type="email" class="" id="email" placeholder="Email">
                        <span id="emailError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label id="checkPw" for="password" class="text-center h5">Password</label>
                        <input name="password" type="password" class="" id="password" placeholder="Password" autocomplete="new-password">
                        <span id="passwordError" class="text-danger"></span>
                    </div>

                    <button onclick="submitFormLogin()" name="submit" type="button"
                            class="btn btn-success btn-block mt-5 btn-log">PRIJAVI SE
                    </button>
                    <button onclick="window.open('register.php','_self')" type="button"
                            class="btn btn-block btn-log-reg">REGISTRUJ SE
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content px-4 py-2" style="border-radius: 1.2rem; margin-top:6rem;">
                <h2 class="text-center mt-2">Registracija</h2>
                <form id="regForm" class="p-3 form-border" autocomplete="off" enctype="multipart/form-data">
                    <div class="position-relative">
                        <label for="profilna_input" class="dodaj_profilnu_label">
                            <span id="close_profil" class="zatvori_slika" onclick="zatvori_profilna(this, event)">
                                <i class="fa fa-times " aria-hidden="true"></i>
                            </span>
                            <img src="res/images/profile-user.png" id="slika_profil_dodaj" class="slika_profil_dodaj" alt="" data-imgg="empty">
                        </label>
                        <input type="file" id="profilna_input" style="display: none;" name="slika"
                        accept="image/jpeg, image/png" />
                    </div>
                    <div class="form-group">
                        <input autocomplete="off" name="name" type="text" class="" id="nameRegister" placeholder="Ime" autocomplete="off">
                        <span id="nameError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input name="surname" type="text" class="" id="surnameRegister" placeholder="Prezime" autocomplete="off">
                        <span id="surnameError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input autocomplete="off" name="email" type="email" class="" id="emailRegister" placeholder="Email" autocomplete="off">
                        <span id="emailError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input autocomplete="new-password" name="passwords" type="password" class="" id="passwordRegister" placeholder="Sifra" autocomplete="off">
                        <span id="passwordError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" class="" id="ponoviSifruReg" placeholder="Ponovite sifru" autocomplete="off">
                        <span id="ponoviSifruRegError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input name="phone" type="phone" class="" id="phoneRegister" placeholder="Broj telefona">
                        <span id="phoneError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input name="zip" type="text" class="" id="postanskiBrojReg" placeholder="Unesite postanski broj">
                        <span id="zipError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input name="address" type="text" class="" id="gradReg" placeholder="Drzava">
                        <span id="drzavaError" class="text-danger"></span>
                    </div>

                    <button name="submit" onclick="register()" type="button"
                            class="btn btn-block mt-5 btn-reg">REGISTRUJ SE
                    </button>

                </form>
            </div>
        </div>
    </div>


    <div class="container main_content">

        <div class="d-flex">
            <div class="slika">
                <img class="w-100" src="res/images/donirajSlika.png" alt="doniraj za kucicu">
            </div>
            <div class="content">
                <h2>Doniraj sada</h2>
                <label class="container-input mt-5">Jednokratna pomoc
                    <input type="radio" checked="checked" name="radio">
                    <span class="checkmark mt-1"></span>
                </label>
                <label class="container-input">Mjesečna pretplata
                    <input type="radio" name="radio">
                    <span class="checkmark mt-1"></span>
                </label>

                <div class="grid-svota my-4">

                    <div>
                        <input id="svota-1" type="radio" value="50" class="svota-inp" name="svota">
                        <label class="svota" for="svota-1">€50</label>
                    </div>
                    <div>
                        <input id="svota-2" type="radio" value="30" class="svota-inp" name="svota">
                        <label class="svota" for="svota-2">€30</label>
                    </div>
                    <div>
                        <input id="svota-3" type="radio" value="15" class="svota-inp" name="svota" checked>
                        <label class="svota" for="svota-3">€15</label>
                    </div>
                    <div>
                        <input id="svota-4" type="radio" value="5" class="svota-inp" name="svota">
                        <label class="svota" for="svota-4">€5</label>
                    </div>

                    <div class="dvije_kolone d-flex p-0">
                        <div class="input-group">
                            <input id="svota-5" type="radio" value="NaN" class="svota-inp" name="svota">
                            <label class="input-group-text px-4" for="svota-5">€</label>
                            <input onclick="selectRadio()" type="number" class="form-control w-100 h-100"
                                id="inlineFormInputGroupUsername2" placeholder="Drugi iznos" min="2" max="10000000">
                        </div>
                    </div>

                </div>

                <h4>Odaberite način plaćanja</h4>
                <div class="d-flex mt-3">
                    <div class="nacin-placanja" onclick="plati()">Kartica</div>
                    <div class="nacin-placanja">Paypal</div>
                </div>

                <div class="mt-5">
                    Problemi s donacijama? Posjetite naš FAQ za odgovore na najčešća pitanja. I dalje imate problema?
                    Pošaljite nam email.
                </div>
            </div>
        </div>
    </div>




    <div class="footer position-relative">
        <img src="res/images/footer.png">
        <div class="footer-space">
            <p>Copyright &copy;Emir & Milica</p>
        </div>
    </div>

    <!-- /.container -->

    <!-- Footer -->

    <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    selectRadio = () => {
        const radio = document.getElementById("svota-5");
        radio.checked = true;
    }

    plati = () => {
        const svota = document.querySelector('input[name="svota"]:checked').value;
        window.location.href = "http://localhost/rukasapi/plati.php?svota=" + svota;
    }
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/main.js" type="text/javascript"></script>




</body>

</html>