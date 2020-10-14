<?php
session_start();

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/appointmentCss.css">
    <link rel="stylesheet" href="css/donate.css">
    <link rel="stylesheet" href="css/custom.css">

    <link rel="stylesheet" href="css/nav.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>
</head>

<body>

<style>
    .banner-appointment{
        position:absolute;
        bottom:20px;
        left: 50%;
        transform: translateX(-50%);
        text-shadow: 2px 2px 5px white;
        font-size: 4rem;
        font-weight:400;
    }
    @media only screen and (max-width: 991px) {
    .banner-appointment{
            display:none;
        }
    }
</style>

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

    <div class="modal fade" id="modal-sitter" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content px-4 py-2" style="border-radius: 1.2rem; margin-top:6rem;">
                <h2 class="text-center mt-2">Postani šetač pasa</h2>
                <form id="becomeForm" action="api/sitter/register.php" method="post" class="form-container-reg">

                <div class="form-group mt-4">
                    <label for="motivation" class="login-font">Motivaciona poruka</label>
                    <input name="motivation" type="text" class="form-control" id="motivation" autocomplete="off">
                    <span class="text-danger" id="motivationError"></span>
                </div>
                <div class="form-group">
                    <label for="infoReg" class="login-font">Više informacija</label>
                    <textarea name="info" class="form-control" id="infoReg" autocomplete="off"></textarea>
                    <span class="text-danger" id="infoRegError"></span>
                </div>
                <div class="form-group">
                    <label for="maxPetWeigh" class="login-font">Maksimalna težina psa za šetanje</label>
                    <input name="maxWeight" type="text" class="form-control" id="maxWeight">
                    <span class="text-danger" id="maxWeightError"></span>
                </div>
                <div class="form-group">
                    <label for="price" class="login-font">Cijena</label>
                    <input name="price" type="text" class="form-control" id="price">
                    <span class="text-danger" id="maxWeightError"></span>
                </div>
               
                <button name="submit" onclick="becomeSitter()" style="margin: 30px auto 0 auto;" type="button"
                        class="btn btn-success m-auto d-block">
                    Prijavi se
                </button>
            </form>
            </div>
        </div>
    </div>
                  
         <div class="position-relative mt-5">
                <img class="d-block w-100" src="res/images/bgwlk.jpg" alt="Frist Slide">
                <button class="btn btn-primary postani_setac_btn" data-toggle="modal" data-target="#modal-sitter">Postani setac</button>
                <div>
                    <h1 class="banner-appointment">Šetanje ljubimaca</h1>
                </div>
        </div>

    <!--form-->
    <div id="change_container" class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-3 fixme">
                <form>

                    <!--                location-->
                    <div class="form-group">
                        <label for="location">Lokacija</label>
                        <input oninput="findSitters()" type="text" class="form-control" id="location"
                            placeholder="ZIP">
                    </div>

                    <!--                date-->
                    <div class="form-group">
                        <label for="startDateID">Datum</label>
                        <input oninput="findSitters()" id="startDateID" type="date" name="startDate"
                            max="2021-12-31" class="form-control">
                    </div>



                    <!--                pet size-->
                    <div class="form-group">
                        <label class="form-row">Max težina(kg)</label>
                        <label class="radio-inline mr-lg-2"><input checked value="0" onchange="findSitters()" type="radio"
                                name="sizeRadio">10</label>
                        <label class="radio-inline mr-lg-2"><input value="10" onchange="findSitters()" type="radio"
                                name="sizeRadio">20</label>
                        <label class="radio-inline mr-lg-2"><input value="20" onchange="findSitters()" type="radio"
                                name="sizeRadio">30</label>
                        <label class="radio-inline mr-lg-2"><input value="30" onchange="findSitters()" type="radio"
                                name="sizeRadio">30+</label>
                    </div>

                </form>
            </div>
            <div class="col-lg-1">
                <div class="vl mt-n5"></div>
            </div>
            <div class="row" id="showMore"></div>
            <!--        Pet sitters-->
            <div id="ss" class="col-lg-8">
                <div class="row" id="sitters">
                    <h4 class="text-center col-lg-12">Nismo pronašli nijednog radnika koji odgovara vašem kriterijumu.</h4>
                    <h6 class="text-center col-lg-12">Pokušajte da promjenite kriterijum ili promijenite lokaciju.</h6>
                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/custom-appointment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/main.js" type="text/javascript"></script>

    <script>
        function becomeSitter() {

        const form = document.getElementById('becomeForm');
        const formData = new FormData(form);

        var motivationError = document.getElementById('motivationError');
        var infoRegError = document.getElementById('infoRegError');
        var maxWeightError = document.getElementById('maxWeightError');

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = 'api/sitter/register.php';
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.send(formData);


        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);


            if (data.success === 1) {
                $('#modal-sitter').modal('hide');
            } else {
                motivationError.innerText = data.error.motivationMessage;
                infoRegError.innerText = data.error.infoMessage;
                maxWeightError.innerText = data.error.maxWeightMessage;
            }
        }
    }
    </script>


</body>

</html>
