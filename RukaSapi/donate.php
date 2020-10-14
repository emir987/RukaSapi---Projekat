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

       <div class="banner-termini" style="margin-top:55px">
            <div class="banner-space">
            </div>
            <img src="res/images/bannerTop.png">
            <div class="banner-header">Doniraj</div>
        </div>

    </header>


    <div class="container">            
        <div class="tab">
            <div class="row">
                <div class="col-lg-2 select-donate">

                    <div id="hrana-button" class="hrana mb-5">
                        <div style="max-width:60px;" class="hrana-image">
                            <img class="w-100" src="res\images\meat.svg" alt="">
                        </div>
                        <div class="hrana-text">
                            Hrana
                        </div>
                    </div>

                    <div id="predmeti-button" class="novac">
                        <div style="max-width:60px;" class="hrana-image">
                            <img class="w-100" src="res\images\petHouse.svg" alt="">
                        </div>
                        <div class="novac-text">
                            Predmeti
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div id="hrana-info" class="donate-info">
                        <div class="d-flex donate-section my-3 justify-content-between">
                            <div style="width:30%">Meso</div>
                            <div class="d-flex align-items-center justify-content-end">
                                <select id="vrsta-mesa" class="m-2" name="vrsta_mesa"data-error="Odaberite vrstu">
                                    <option selected value="svinja">Svinjsko</option>
                                    <option value="ovca">Ovcije</option>
                                    <option value="krava">Kravlje</option>
                                    <option value="kokoska">Pilece</option>
                                    <option value="ostalo">Ostalo</option>
                                </select>
                                <input type="number" placeholder="Kolicina (kg)" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                <input type="button" value="Dodaj" data-sta="Meso" class="btn btn-success" onclick="dodajHranu(this)">
                            </div>
                        </div>
                        <div class="d-flex donate-section my-3 justify-content-between">
                            <div style="width:30%">Granule</div>
                            <div class="d-flex align-items-center justify-content-end">
                                <select id="month-end" class="m-2" name="vrsta_mesa"data-error="Odaberite vrstu">
                                    <option selected value="pas">Za psa</option>
                                    <option value="macka">Za macku</option>
                                </select>                                    
                                <input type="number" placeholder="Kolicina (kg)" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                <input type="button" value="Dodaj" data-sta="Granule" class="btn btn-success" onclick="dodajHranu(this)">
                            </div>
                        </div>
                        <div class="d-flex donate-section my-3 justify-content-between">
                            <div style="width:30%">Ostalo</div>
                            <div class="d-flex align-items-center justify-content-end">
                                <input type="text" placeholder="Sta donirate?" class="m-2" onkeypress="return /[a-z]/i.test(event.key)" data-html="true" data-error="Unesite sta donirate">
                                <input type="number" placeholder="Kolicina (kg)" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                <input type="button" data-sta="Ostalo" value="Dodaj" class="btn btn-success" onclick="dodajHranu(this)">
                            </div>
                        </div>
                    </div>

                    <div id="predmeti-info" class="donate-info" style="display:none">
                        <div class="d-flex donate-section my-3 justify-content-between">
                            <div>Kucica</div>
                            <div class="d-flex align-items-center justify-content-end">
                                <input type="text" placeholder="Kolicina" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajPredmet(this)">
                            </div>
                        </div>

                        <div class="d-flex donate-section my-3 justify-content-between">
                            <div>Igracka</div>
                            <div class="d-flex align-items-center justify-content-end">
                                <input type="text" placeholder="Kolicina" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajPredmet(this)">
                            </div>
                        </div>

                        <div class="d-flex donate-section my-3 justify-content-between">
                            <div>Kucica</div>
                            <div class="d-flex align-items-center justify-content-end">
                                <input type="text" placeholder="Kolicina" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajPredmet(this)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">

                    <div id="odabrano" class="odabrano">
                        <h5 class="text-center">Lista Vasih donacija</h5>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="tab container" style="transform: translateY(60px)">
        <div class="personal_info" id="personal_info_area">
            <div class="form-group d-flex">
                <div class="user-data" id="logged-user-data">Koristi moje podatke</div>
                <div class="user-data" id="new-user-data">Unesi nove podatke</div>
            </div>
 
            <form id="user-data-form">

                <div class="form-group d-flex">
                    <input type="text" class="form-control m-2" name="name" id="name" placeholder="Ime" />
                    <input type="text" class="form-control m-2" name="surname" id="surname" placeholder="Prezime" />
                </div>

                <div class="form-group d-flex">
                    <input type="text" class="form-control m-2" name="email" id="email" placeholder="E-mail" />
                    <input type="text" class="form-control m-2" name="phone" id="phone" placeholder="Phone" />
                </div>

                <div class="form-group d-flex">
                    <input type="text" class="form-control m-2" name="address" id="address" placeholder="Adresa" />
                    <input type="text" class="form-control m-2" name="zip" id="zip" placeholder="Postanski broj" />
                </div>

            </form>

        </div>
    </div>

    <div class="tab container" style="transform: translateY(60px)">
        <div class="zahvalnica" id="zahvalnica">
            
            <div class="zahvalnica-body">
                Poštovani,
                <br><br>
                Rok za dostavu je 3 dana, na adresu: Vučedolska br. 1 - stan 3<br>
                U periodu između 10 - 12h i 17 - 19h.
                <br><br>
                Molimo Vas da poštujete proizvode navedene u odabiru.
                <br><br>
                Uz dostavljene artikle OBAVEZNO je dostaviti račune kao dokaz o njihovoj kupovini,<br>
                i kopiju mail-a koji će Vam uskoro biti poslat.
                <br><br>
                Mi Vam od srca zahvaljujemo, a životinje Vam šalju puno ljubavi!
                <br><br>
                Vi ste dokaz da,<br>
                Njihova sreća vrijedi više!
            </div>  

        </div>
    </div>

   

    <div style="overflow:auto; transform:translateY(50px)" class="mt-4 container">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Nazad</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Dalje</button>
            <button type="button" id="endBtn">Završi</button>
        </div>
    </div>

    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px; transform:translateY(50px)">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
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

    
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/donate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/main.js" type="text/javascript"></script>




</body>

</html>