<?php session_start(); ?>
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
    <link rel="stylesheet" href="css/donate.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/select-2-custom.css">

    <script src="js/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script src="js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />


    <script src="https://kit.fontawesome.com/5bd43f344d.js" crossorigin="anonymous"></script>



</head>

<body>

    <!-- Navigation -->

    <style>
        .mySlides {
            display: none;
            padding: 20px 20px 20px;
        }

        /* The Close Button */
        .closeBtn {
            position: absolute;
            display: flex;
            top: -15px;
            right: -18px;
            cursor: pointer;
            width: 35px;
        }

        .custom-control-input:checked~.custom-control-label::before {
            color: #fff;
            border-color: #ce781f;
            background-color: #cc7d1a;
        }

        .voted {
            margin: 20px;
            margin-top: 40px;
            text-align: center;
            font-size: 23px;
            color: green;
            font-weight: 500;
            transition: margin, color, font-size .5s;
        }

        .faq-card-content {
            margin-bottom: 50px;
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
                        <input name="password" type="password" class="" id="password" placeholder="Password"
                            autocomplete="new-password">
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
                            <img src="res/images/profile-user.png" id="slika_profil_dodaj" class="slika_profil_dodaj"
                                alt="" data-imgg="empty">
                        </label>
                        <input type="file" id="profilna_input" style="display: none;" name="slika"
                            accept="image/jpeg, image/png" />
                    </div>
                    <div class="form-group">
                        <input autocomplete="off" name="name" type="text" class="" id="nameRegister" placeholder="Ime"
                            autocomplete="off">
                        <span id="nameError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input name="surname" type="text" class="" id="surnameRegister" placeholder="Prezime"
                            autocomplete="off">
                        <span id="surnameError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input autocomplete="off" name="email" type="email" class="" id="emailRegister"
                            placeholder="Email" autocomplete="off">
                        <span id="emailError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input autocomplete="new-password" name="passwords" type="password" class=""
                            id="passwordRegister" placeholder="Sifra" autocomplete="off">
                        <span id="passwordError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" class="" id="ponoviSifruReg" placeholder="Ponovite sifru"
                            autocomplete="off">
                        <span id="ponoviSifruRegError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input name="phone" type="phone" class="" id="phoneRegister" placeholder="Broj telefona">
                        <span id="phoneError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input name="zip" type="text" class="" id="postanskiBrojReg"
                            placeholder="Unesite postanski broj">
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

    <div class="banner-termini" style="margin-top:55px">
        <div class="banner-space">
        </div>
        <img src="res/images/bannerTop.png">
        <div class="banner-header">Najčešća pitanja</div>
    </div>

    <div class="container px-5">


        <div id="faq-cards" class="grid-faq"></div>

    </div>

    <div id="myModal" class="modal">
        <div id="modal-content" class="modal-content">
            <span class="close cursor" onclick="closeModal()">&times;</span>
        </div>
    </div>


    <div class="footer position-relative" style="margin-top:150px">
        <img src="res/images/footer.png">
        <div class="footer-space">
            <p>Copyright &copy;Emir & Milica</p>
        </div>
    </div>





    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>

    <script>
        $(document).ready(() => {

            const http = new XMLHttpRequest();
            http.open("GET", "api/admin/getFaq.php", true);
            http.send();

            http.onload = function () {
                const data = JSON.parse(this.responseText);
                console.log(data);
                const faqs = data.faqs;

                for (let index = 0; index < faqs.length; index++) {
                    const element = faqs[index];

                    let card = getCard(element);
                    $('#faq-cards').append(card);

                    let modal = getModal(element);
                    $('#modal-content').append(modal);

                }

                const caption = `
                            <div class="caption-container">
                                <div class="d-flex" style="position: absolute; left: 20px; bottom: 20px; height: 40px;">
                                    <img onclick="plusSlides(-1)" src="res/images/prethodna.svg" class="h-100"
                                        style="cursor: pointer;">
                                    <span class="navigation-gallery-text" style="margin-left: 10px;">Prethodna slika</span>
                                </div>
                                <div class="d-flex" style="position: absolute; right: 20px; bottom: 20px; height: 40px;">
                                    <span class=" navigation-gallery-text" style="margin-right: 10px;">Sledeća slika</span>
                                    <img onclick="plusSlides(1)" src="res/images/sledeca.svg" class="h-100" style="cursor: pointer;">
                                </div>
                            </div>`;
                $('#modal-content').append(caption);

            }
        });

        function getCard(item) {


            var odgovor = item.odgovor.substr(0, 83);
            odgovor = odgovor.substr(0, Math.min(odgovor.length, odgovor.lastIndexOf(" "))) + "...";


            return `<div class="faq-card" onclick="openModal();currentSlide(${item.id})">
                            <div class="faq-card-header">
                                <span class="header20-blue">${item.pitanje}</span>
                            </div>
                            <div class="faq-card-content" >
                                <p>${odgovor}</p>
                                <div class="odgovor"><a>odgovor</a></div>
                            </div>
                        </div>`;
        }

        function getModal(item) {

            let pitanje = item.pitanje;

            const first_part = pitanje.substr(0, pitanje.indexOf("<"));
            const second_part = " " + pitanje.substr(pitanje.indexOf(">") + 1, pitanje.length + 1);
            pitanje = first_part.concat(second_part);


            return `<div class="mySlides" onclick="openModal();currentSlide(${item.id})">
                            <div class="" style="box-shadow: none;width:100%; transform: scale(1); padding: 0 3vw;">
                                <div class="faq-card-header h-auto justify-content-center text-center">
                                    <span class="header20-blue">${pitanje}</span>
                                </div>
                                <div class="faq-card-content text-center h-auto pt-5">
                                    <p class="h-auto">${item.odgovor}</p>
                                </div>
                            </div>
                        </div>`;
        }
    </script>

    <script>
        var slideIndex = 1;

        function openModal() {
            $("#myModal").addClass('modal-active');
            showSlides(slideIndex);
        }

        function closeModal() {
            $("#myModal").removeClass('modal-active');
        }

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");

            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length;
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slides[slideIndex - 1].style.display = "flex";
        }
    </script>


</body>

</html>