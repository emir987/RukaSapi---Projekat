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


    <div class="container-custom main_content">

        <div class="donirate-tab">
            <span id="donirate_prikaz">
                 
            </span>
            <a id="promijeni_svotu" href="promijeniSvotu()">Promijeni svotu</a>

        </div>

        <div id="promjena_svote" class="sakrij_svota">
            <div class="input-group mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">€</span>
                </div>
                <input id="svota_input" type="text" class="form-control" value="<?php echo $_GET['svota']?>">
            </div>
            <input type="button" onclick="potvrdiPromjenu()" class="potvrdi w-25" id="potvrdi_promjenu_svote" value="Potvrdi">
        </div>
        <div class="mt-4">
            <h3 class="mb-3">Vaši podaci:</h3>
    
            <form id="user-data-form">

                <div class="form-group d-flex">
                    <input type="text" class="form-control mx-2" name="name" id="name" placeholder="Ime" />
                    <input type="text" class="form-control mx-2" name="surname" id="surname" placeholder="Prezime" />
                </div>

                <div class="form-group d-flex">
                    <input type="text" class="form-control mx-2" name="email" id="email" placeholder="E-mail" />
                    <input type="text" class="form-control mx-2" name="phone" id="phone" placeholder="Telefon" />
                </div>

                <div class="form-group d-flex">
                    <input type="text" class="form-control mx-2" name="address" id="address" placeholder="Adresa" />
                    <input type="text" class="form-control mx-2" name="zip" id="zip" placeholder="Poštanski broj" />
                </div>

            </form> 

            <div>
                <h3 class="mb-3">Plaćanje:</h3>
        
                <form id="placanje_forma">
                    <div class="form-group d-flex">
                        <input id="ccn" type="tel" class="form-control mx-2" name="card-number" id="card-number" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="Broj kartice (xxxx xxxx xxxx xxxx)">                    </div>
                    <div class="form-group d-flex">
                        <input type="text" class="form-control mx-2" name="datum-isticanja" id="datum-isticanja" placeholder="Datum isticanja" />
                        <input type="text" class="form-control mx-2" name="cvv" id="cvv" placeholder="CVV" />
                    </div>
                </form> 
            </div>

            <div>
                <label class="container-check ml-2">Ovlašćujem UdomiME Fondaciju da naplati moju karticu u gore navedenom iznosu. 
                Razumijem da mogu zatražiti povrat novca samo u roku od 15 dana od datuma donacije.
                <input type="checkbox" checked="checked">
                <span class="checkmark-check"></span>
                </label>
            </div>

            <input type="button" onclick="potvrdiPromjenu()" class="potvrdi" id="potvrdi_promjenu_svote" value="Doniraj">
        
            <div class="mt-3">Vaša donacija pomaže pobljašavanjem uslova za život bezdomih životinja. <br> Unaprijed hvala na poklonu.</div>
        </div>
    </div>



     <div class="footer position-relative">
        <img src="res/images/footer.png">
        <div class="footer-space">
            <p>Copyright &copy;Emir & Milica</p>
        </div>
    </div>

    

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/main.js" type="text/javascript"></script>


    <script>
        const promjeniSvotuBtn = document.getElementById("promijeni_svotu");
        const promjenaSvote = document.getElementById("promjena_svote");
        const doniratePrikaz = document.getElementById('donirate_prikaz');
        const svotaInput = document.getElementById('svota_input');
        const userData = document.getElementById('user-data-form');


        $(document).ready(function() {
            var svota = <?php echo $_GET['svota']?>;
            doniratePrikaz.innerHTML = `Donirate ${svota}€.`;

            const http = new XMLHttpRequest();
            var method = "GET";
            var url = "api/user/getUserInfo.php";
            var asynchronous = true;

            http.open(method, url, asynchronous);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.send();
            http.onload = function () {
                var data = JSON.parse(http.responseText);

                if (data.success === 0) {
                    return;
                }

                userData.elements.namedItem("name").value = data.user.name;
                userData.elements.namedItem("surname").value = data.user.surname;
                userData.elements.namedItem("email").value = data.user.email;
                userData.elements.namedItem("phone").value = data.user.phone;
                userData.elements.namedItem("address").value = data.user.address;
                userData.elements.namedItem("zip").value = data.user.zip;

                };
            
        });

        promjeniSvotuBtn.addEventListener("click", function(e) {
            e.preventDefault();
            promjenaSvote.classList.toggle('sakrij_svota');
        });

        potvrdiPromjenu = () => {
            svota = svotaInput.value;
            doniratePrikaz.innerHTML = `Donirate ${svota}€.`;
            promjenaSvote.classList.toggle('sakrij_svota');
        }
        

        //credit card validation

    </script>

</body>

</html>