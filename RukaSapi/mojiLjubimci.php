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
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/nav.css">

    <script src="js/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

        .banner {
            background-color: #EFEECE;
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

    <div class="content-profil">
        <div class="banner-termini" style="margin-top:55px">
            <div class="banner-space"></div>
            <img src="res/images/bannerTop.png">
            <div class="banner-header">Moji ljubimci</div>
        </div>
        
        <div id="pets" class="my_pets container mb-4 pb-4">

        </div>

        


        <div class="container">
            <h2 class="text-center">Zahtjevi za udomljavanje</h2>
            <select class="form-control" style="width: 15%;" id="exampleFormControlSelect1">
                <option selected value="svi">Svi</option>
                <option value="aktivan">Aktivni</option>
                <option value="zavrsen">Zavrseni</option>
                <option value="otkazan">Otkazani</option>
            </select>

            <div id="termini" class="mt-3"></div>
        </div>





        <div class="footer position-relative mt-5">
            <img src="res/images/footer.png">
            <div class="footer-space">
                <p>Copyright &copy;Emir & Milica</p>
            </div>
        </div>
    </div>


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>

        $(document).ready(function() {
            getMyPets();
            getPetRequests();
        });

        function getPetRequests() {

            const zahtjevi_element = document.getElementById('termini');

            const http = new XMLHttpRequest();
            const method = "GET";
            const url = "api/pet/adoptRequest.php";
            const asynchronous = true;

            http.open(method, url, asynchronous);
            http.send();

            http.onload = function () {
                const data = JSON.parse(this.responseText);
                console.log(data);
                let requests = data.requests || [];
                html = "";

                for (var a = 0; a < requests.length; a++) {

                    const request = requests[a];

                    var formattedDateSecond = request.date.substring(0, 10);
                    var formattedDate = formattedDateSecond + " :: " + requests[a].date.substring(10, 16) + 'h';
                    let living = '';
                    if (request.living = "stan") {
                        living = 'stanu';
                    }else{
                        living = 'kući';
                    }
                    
                    html += `<div class="termin termin-small"><div class="termin-header mb-2">
                                <h5 class="termin-broj">${request.petName}</h5>
                                <div class="termin-status">${request.status}</div>
                            </div>
                            <div class="d-flex termin-body">
                                <img class="slika-profil" src="slike_profil/${request.user.photo}" alt="">
                                <div class="termin-content">
                                    <div class="termin-vlasnik" style="max-width: 55%">
                                        <div><b>Uslovi:</b></div>
                                            <div>&bullet; Broj clanova u porodici: ${request.fam_num}</div>
                                            <div>&bullet; Živi u ${living}</div>
                                    </div>
                                    <div class="termin-vrijeme-udomi" style="text-align:left">
                                        <div><b>Kontakt</b></div>
                                        <div>&bullet; Ime: ${request.user.userName} ${request.user.surname}</div>
                                        <div>&bullet; Telefon: ${request.user.phone}</div>
                                        <div>&bullet; Email: ${request.user.email}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="termin-footer"><b>Poruka:</div>
                            <div class="pb-3"></b> ${request.message}</div>

                            <div class="termin-footer d-flex">
                                <div class="termin-kreirano">Kreirano: ${formattedDate}</div>
                                <div class="termin-buttons">
                                    <button class="btn btn-outline-danger btn-cus position-relative" onclick="rejectRequest(${request.id}, this,'${request.petName}', '${request.breed}','${request.user.email}')">Obrisi</button>
                                    <button class="btn btn-outline-info btn-cus" onclick="acceptRequest(${request.id}, ${request.petID}, this)">Udomljen</button>
                                </div>
                            </div></div>`
                }


                zahtjevi_element.innerHTML = html;
            }
        }

        function rejectRequest(idRequest, element, petName, breed, email) {

             Swal.fire({
                title: 'Da li ste sigurni?',
                text: "!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da',
                cancelButtonText: 'Ne'
                }).then((result) => {
                    console.log(result);
                    return;
                    if (result.isConfirmed) {

                    element.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Slanje'
                    const http = new XMLHttpRequest();
                    const method = "POST";
                    const url = "api/pet/rejectRequest.php";
                    const asynchronous = true;

                    http.open(method, url, asynchronous);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.send("id=" + idRequest + "&petName=" + petName + "&breed=" + breed + "&email=" + email);

                    http.onload = function () {
                        const data = JSON.parse(this.responseText);
                        if (data.success == 1) {
                            Swal.fire(
                                    'Otkazano!',
                                    'Uspješno ste odbili zahtjev i korisnik je obaviješten',
                                    'success'
                                    )
                            const terminEl = element.parentElement.parentElement.parentElement;
                            terminEl.remove();
                        }else{
                            element.innerHTML = 'Obriši'
                        }
                    }
                }
            })
        }

        function getMyPets() {

            const petsElement = document.getElementById('pets');

            const http = new XMLHttpRequest();
            const method = "GET";
            const url = "api/pet/getMyPets.php";
            const asynchronous = true;

            http.open(method, url, asynchronous);
            http.send();

            http.onload = function () {
                const data = JSON.parse(this.responseText);
                console.log(data);
                html = "";

                const pets = data.pets;

                for (var a = 0; a < pets.length; a++) {

                    const pet = pets[a];

                    var formattedDateSecond = pet.date.substring(0, 10);
                    var formattedDate = formattedDateSecond + " :: " + pet.date.substring(10, 16) + 'h';
                    let color = '#cca000';
                    if (pet.status == 'aktivan') {
                        color = '#17bd1f';
                    }
                    
                    html += `<div class="card-item m-3 position-relative">
                                <div class="cancel">
                                    <img src="res/images/cross.png">
                                </div>
                                <img src="slike/${pet.image}" alt="${pet.name}" style="width:100%">
                                <div class="container-item">
                                    <h4 class="text-center"><b>${pet.name}</b></h4> 
                                    <div class="text-center" style="color:${color};">Status: ${pet.status}</div>
                                    <div class="text-center"><u>Objavljeno</u></div>
                                    <p class="text-center">${formattedDate}</p> 
                                </div>
                            </div>`;
                }


                petsElement.innerHTML = html;

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


        function acceptRequest(id, petID, element) {

            Swal.fire({
                title: 'Da li ste sigurni?',
                text: "Potvrđujete da prihvatate ovaj zahtjev i svi ostali se brišu!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da',
                cancelButtonText: 'Ne'
                }).then((result) => {
                if (result.isConfirmed) {
                    const http = new XMLHttpRequest();
                    http.open("POST", "api/pet/confirmAdopt.php", true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.send("id=" + id + "&petID=" + petID);

                    http.onload = function () {
                        const data = JSON.parse(this.responseText);
                        console.log(data);
                        if (data.success == "1") {
                            Swal.fire(
                                'Udomljen!',
                                'Čestitamo! Vaš ljubimac je našao novi dom :)',
                                'success'
                                )
                        }
                    }  
                }
            })
        }
    </script>


</body>

</html>