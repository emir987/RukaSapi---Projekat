<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location:login.php");
}

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
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body onload="f()">

<style>
    .obrisi{
        cursor: pointer;
        border-radius: 50%;
        padding: 3px;
        border: 1px solid transparent;
        transition: all .3s ease;
    }

    .obrisi:hover{
        border: 1px solid #ff8c8c;
        background-color: #fff4f4;
        transform:scale(1.08)
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
            
    <div class="banner mb-5">
        <img src="res/images/bannerTop.png" width="100%" height=100% alt="">
        <h1 class="text-center naslov">Poruke</h1>
    </div>
</header>


<div class="container">
    <table class="table table-condensed table-hover">
        <tbody id="fillMe">

        </tbody>
    </table>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>

<script>

    function f() {

        var fillMe = document.getElementById('fillMe');

        var http = new XMLHttpRequest();
        var method = "GET";
        var url = "api/admin/readMails.php?";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.send();

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            var messages = data.requests || [];
            html = "";

            for (var a = 0; a < messages.length; a++) {

                let shortMessage = messages[a].requestMessage.substr(0, 58);
                shortMessage = shortMessage.substr(0, Math.min(shortMessage.length, shortMessage.lastIndexOf(" "))) + "...";

                var formattedDateSecond = messages[a].date.substring(0, 10);
                var formattedDate= formattedDateSecond + " at " + messages[a].date.substring(10, 16)  + 'h';

                html += '<tr >\n' +
                    '            <td onclick="showMessage(' + messages[a].id + ')"><strong>' + messages[a].commentator.name + " " + messages[a].commentator.surname + '</strong></td>\n' +
                    '            <td onclick="showMessage(' + messages[a].id + ')" id="messageHere"><span>' + shortMessage + '</span></td>\n' +
                    '            <td onclick="showMessage(' + messages[a].id + ')"><strong>' + formattedDate + '</strong></td>\n' +
                    '            <td style="text-align:end"><img onclick="deleteRequest(' + messages[a].id + ')" class="obrisi" src="https://img.icons8.com/material/24/000000/delete-forever--v2.png"/></td>\n' +
                    '        </tr>' +
                    '<tr style="display: none" id="showMessage' + messages[a].id + '">' +
                    '<td id=""  colspan="3"><span><b>Start:</b> ' + messages[a].start + '</span><span class="ml-5"><b>End: </b>' + messages[a].end + '</span><br><br><b>Breed: </b> ' + messages[a].breed + ' <br><br><b>Message:</b> ' + messages[a].requestMessage + ' </td>' +
                    '</tr>';


            }


            fillMe.innerHTML = html;

        }
    }

    function deleteRequest(id) {

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = "api/sitter/deleteMails.php";
        var asynchronous = true;
        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send('id=' + id);

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            f();
        }

    }


    function showMessage(id) {
        var td = document.getElementById('showMessage' + id);
        if (td.style.display === 'none') {
            td.style.display = 'table-row';
        } else {
            td.style.display = 'none';
        }
    }


</script>

</body>
</html>
