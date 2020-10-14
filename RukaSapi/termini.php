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

    <div class="modal fade" id="modal-change_appointment" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Promjena termina za šetanje pasa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changeReqForm">
                    <div class="modal-body mx-3">
                        <div class="md-form mb-2">
                            <label data-error="Unesite datum" data-success="right" for="startDate">Datum</label>
                            <input type="date" id="startDate" name="date" class="form-control validate">
                        </div>

                        <div class="md-form mb-2">
                            <label data-error="wrong" data-success="right" for="endDate">Slobodni termini</label>
                            <div id="parent_select">
                                <div class="d-flex align-items-center mb-2">
                                    <select name="from_time" class="form-control mx-1">
                                        <option selected value="8">08:00</option>
                                        <option value="9">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                        <option value="12">12:00</option>
                                        <option value="13">13:00</option>
                                        <option value="14">14:00</option>
                                        <option value="15">15:00</option>
                                        <option value="16">16:00</option>
                                        <option value="17">17:00</option>
                                        <option value="18">18:00</option>
                                        <option value="19">19:00</option>
                                        <option value="20">20:00</option>
                                    </select>
                                    <select name="to_time" class="form-control mx-1" data-error="Unesite ispravno">
                                        <option selected value="9">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                        <option value="12">12:00</option>
                                        <option value="13">13:00</option>
                                        <option value="14">14:00</option>
                                        <option value="15">15:00</option>
                                        <option value="16">16:00</option>
                                        <option value="17">17:00</option>
                                        <option value="18">18:00</option>
                                        <option value="19">19:00</option>
                                        <option value="20">20:00</option>
                                        <option value="21">21:00</option>
                                    </select>
                                    <div id="add_free_appoint">
                                        <i class="fa fa-plus ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="idRequest" id="idRequest">

                    <div class="modal-footer d-flex justify-content-center">
                        <input type="submit" class="btn btn-success" id="changeRequestSubmit" value="Pošalji zahtjev">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-change_accept" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content px-4 py-2" style="border-radius: 1.2rem; margin-top:6rem;">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Promjena termina za šetanje pasa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changeReqRespond">
                    <div class="modal-body mx-3">
                        <h6 class="my-3">Šetač nije slobodan u zakazanom terminu i predložio je sledeće slobodne termine.</h6>

                        <div id="slobodan_datum" class="datum-change">Datum: 2020-12-11</div>
                        <div>
                            <div class="datum-change">
                                <div>Slobodni termini</div>
                                <div id="slobodni_termini"></div>
                            </div>
                            <div class="h7">Odaberite odgovarajuci termin</div>
                            <div id="slobodan_termin" class="d-flex my-2">
                                <select name="from" class="form-control mx-1" id="trajanje_od" onchange="updateTo(this.value)">
                                    <option selected value="8">08:00</option>
                                    <option value="9">09:00</option>
                                    <option value="10">10:00</option>
                                    <option value="11">11:00</option>
                                    <option value="12">12:00</option>
                                    <option value="13">13:00</option>
                                    <option value="14">14:00</option>
                                    <option value="15">15:00</option>
                                    <option value="16">16:00</option>
                                    <option value="17">17:00</option>
                                    <option value="18">18:00</option>
                                    <option value="19">19:00</option>
                                    <option value="20">20:00</option>
                                </select>
                                <select name="to" class="form-control mx-1" id="trajanje_do" data-error="Unesite ispravno">
                                    <option selected value="9">09:00</option>
                                    <option value="10">10:00</option>
                                    <option value="11">11:00</option>
                                    <option value="12">12:00</option>
                                    <option value="13">13:00</option>
                                    <option value="14">14:00</option>
                                    <option value="15">15:00</option>
                                    <option value="16">16:00</option>
                                    <option value="17">17:00</option>
                                    <option value="18">18:00</option>
                                    <option value="19">19:00</option>
                                    <option value="20">20:00</option>
                                    <option value="21">21:00</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="button" class="btn btn-success" id="respondSubmit" value="Promijeni termin">
                </div>
            </div>
        </div>
    </div>

    <div class="content-profil">
        <div class="banner-termini" style="margin-top:55px">
            <div class="banner-space">
            </div>
            <img src="res/images/bannerTop.png">
            <div class="banner-header">Upravljanje terminima</div>
        </div>

        <div class="container position-relative">
            <div class="d-flex justify-content-center w-100">
                <button id="moji_termini_btn" class="btn btn-secondary w-25">Moji termini</button>
                <button id="moji_zahtjevi_btn" class="btn btn-outline-secondary w-25">Moji zahtjevi</button>
            </div>
            <div id="termini" class="mt-3"></div>
            <?php if(!isset($_SESSION['id'])) echo '<div class="warning-login">Da biste koristili ove funkcije morate biti prijavljeni</div>
                                                    <button data-toggle="modal" data-target="#modal-login" class="warning-login-button"><img width=60 src="res/images/login.svg"></button>'?>
        </div>

        <div class="footer position-relative mt-5">
            <img src="res/images/footer.png">
            <div class="footer-space">
                <p>Copyright &copy;Emir & Milica</p>
            </div>
        </div>
    </div>

    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>

        var idUser = <?php echo (isset($_SESSION['id'])) ? $_SESSION['id'] : 'null' ?>;


        $(document).ready(function() {
            if (idUser != null) {
                getMails();
            }
            
        });

        let arrayFree = [];

        function updateTo(val) {
            const trajanjeDo = document.getElementById('trajanje_do');

            optionsHTML = '';

            for (let i = arrayFree[arrayFree.indexOf(parseInt(val))]+1; i < 21; i++) {
                // const element = arrayFree[i-1];
                if (arrayFree.includes(i) === false) break;
                let optionText = i;
                if (i == 8) optionText = '09';
                if (i == 9) optionText = '09';

                optionsHTML += `<option value="${i}">${optionText}:00</option>`;
                console.log(i);
            }
            trajanjeDo.innerHTML = optionsHTML;

            return;
            arrayFree.indexOf(parseInt(val));
            for (let val = 0; val < array.length; val++) {
                const element = array[val];
                
            }
            trajanjeDo.innerHTML = ``;
        }

        function removeSelects(element){
            element.parentNode.parentNode.removeChild(element.parentNode);
        }
        
        const add_free_appoint = document.getElementById('add_free_appoint');
        const parent_select = document.getElementById('parent_select');


        add_free_appoint.addEventListener("click", function (event) {
            const outerSelect = document.createElement("div");
            outerSelect.classList.add("d-flex", "align-items-center","mb-2");

            const minus_parent = document.createElement("div");
            const minusEl = document.createElement("i");
            minusEl.classList.add("fa", "fa-minus", "ml-2");
            minus_parent.appendChild(minusEl);
            minus_parent.setAttribute("onclick","removeSelects(this);");


            const select = document.createElement("select");
            for (let j = 8; j < 20; j++) {
                select.setAttribute("name", "selectChildren");
                select.classList.add("form-control", "mx-1");

                const option = document.createElement("option");
                let hours = (j) + ":00";
                if (j < 10) {
                    hours = "0" + (j) + ":00";
                }
                option.setAttribute("value", j);
                option.innerHTML = hours;
                select.appendChild(option);
            }
            outerSelect.appendChild(select);

            const select2 = document.createElement("select");
            for (let i = 9; i < 21; i++) {
                select2.setAttribute("name", "selectChildren");
                select2.classList.add("form-control", "mx-1");
                select2.dataset.error = "Unesite ispravno";

                const option = document.createElement("option");
                let hours = (i) + ":00";
                if (i < 10) {
                    hours = "0" + (i) + ":00";
                }
                option.setAttribute("value", i);
                option.innerHTML = hours;
                select2.appendChild(option);
            }
            outerSelect.appendChild(select2);
            outerSelect.appendChild(minus_parent);

            parent_select.appendChild(outerSelect);
        })


        const moji_termini_btn = document.getElementById('moji_termini_btn');
        const moji_zahtjevi_btn = document.getElementById('moji_zahtjevi_btn');

        moji_termini_btn.addEventListener("click", function (event) {
            $(".tooltip").tooltip("hide");
            event.target.className = "btn btn-secondary w-25";
            moji_zahtjevi_btn.className  = "btn btn-outline-secondary w-25";
            if (idUser != null) {
                getMails();
            }
        })

        moji_zahtjevi_btn.addEventListener("click", function (event) {
            event.target.className = "btn btn-secondary w-25";
            moji_termini_btn.className  = "btn btn-outline-secondary w-25";
            if (idUser != null) {
                getRequests();
            }
        })

        function getRequests() {
            const termini_element = document.getElementById('termini');

            const http = new XMLHttpRequest();
            const method = "GET";
            const url = "api/admin/getResponse.php?";
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

                    let statusHTML = '';
                    if (request.status == 'Aktivan') {
                        statusHTML = '<span style="color:#d67600">Aktivan</span>'
                    }else if(request.status == 'Zavrsen'){
                        statusHTML = '<span style="color:green">Završen</span>'
                    }

                    var formattedDateSecond = requests[a].date.substring(0, 10);
                    var formattedDate = formattedDateSecond + " :: " + requests[a].date.substring(10, 16) + 'h';
                    
                    let changeHTML = '';

                    if (request.change == 1) {
                        changeHTML = `<img src="res/images/warning.png" style="cursor:pointer" onclick="openChangeDate(${request.id})" width=30 height=30 data-toggle="tooltip" title="Predlog promjene termina">`;
                    }

                    html += `<div id="otkaz${request.id}" class="termin"><div class="termin-header mb-2">
                                <div class="termin-broj">Zahtjev: #${a + 1}</div>
                                <div class="termin-status">${statusHTML}</div>
                            </div>
                            <div class="d-flex termin-body">
                                <img class="slika-profil" src="slike_profil/${request.sitter.photo}" alt="">
                                <div class="termin-content">
                                    <div class="termin-vlasnik">
                                        <div><b>Šetač</b></div>
                                        <div>${request.sitter.name} ${request.sitter.surname}</div>
                                        <div>${request.sitter.phone}</div>
                                    </div>
                                    <div class="termin-ljubimac">
                                        <div><b>Ljubimac</b></div>
                                        <div>Ime: ${request.breed}</div>
                                        <div>Godine: 4</div>
                                    </div>
                                </div>
                                <div class="termin-vrijeme d-flex">
                                    <div class="mr-2">
                                        <div><b>Datum i vrijeme</b></div>
                                        <div>${request.start} (${request.from} - ${request.to})</div>
                                    </div>
                                    ${changeHTML}
                                </div>
                            </div>
                            <div class="message" id="message${request.id}" style="display:none;">
                                <b>Poruka: </b>${request.requestMessage}
                            </div>
                            <div class="termin-footer d-flex">
                                <div class="termin-kreirano">Kreirano: ${formattedDate}</div>
                                <div class="termin-buttons">
                                    <button class="otkazii btn btn-outline-danger btn-cus" onclick="rejectRequest(${request.id}, this, '${request.breed}','${request.sitter.email}', '${request.start}')">Otkazi</button>
                                    <button class="btn btn-outline-info btn-cus" onclick="showMessage(${request.id}, this)">Prikaži više</button>
                                </div>
                            </div></div>`
                }
            

                termini_element.innerHTML = html;

                $('[data-toggle="tooltip"]').tooltip("show");

            }
        }


        const slobodan_termin = document.getElementById('slobodan_termin');

        const slobodni_termini = document.getElementById('slobodni_termini');
        const slobodan_datum = document.getElementById('slobodan_datum');

        function openChangeDate(idRequest) {

            const http = new XMLHttpRequest();
            const method = "POST";
            const url = "api/admin/getAppointmentChange.php?";
            const asynchronous = true;

            http.open(method, url, asynchronous);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.send("idRequest=" + idRequest);

            http.onload = function () {
                const data = JSON.parse(this.responseText);
                console.log(data);
                let terminiHTML = "";
                if (data.success == 1) {
                    arrayFree = [];
                    data.times.forEach(element => {
                        terminiHTML += `<div>${element.fromTime} - ${element.toTime}</div>`
                        let from = element.fromTime.replace(/[:0]/g,'');
                        if (element.fromTime == "10:00") from = "10";
                        if (element.fromTime == "20:00") from = "20";

                        let to = element.toTime.replace(/[:0]/g,'');
                        if (element.toTime == "10:00") to = "10";
                        if (element.toTime == "20:00") to = "20";

                        for (let i = parseInt(from); i <= parseInt(to); i++) {
                            arrayFree.push(i);
                        }
                    });
                    slobodni_termini.innerHTML = terminiHTML;
                    slobodan_datum.innerHTML = `Datum: ${data.startDate}`;
                    respondSubmit.setAttribute("onclick", `submitChange(${data.id_cap}, '${data.startDate}')`);
                    disableSelects(arrayFree);
                    $('#modal-change_accept').modal('show');
                }
                
            }
            
        }

        function disableSelects(arrayFree) {
            const slobodni_termini = document.getElementById("slobodan_termin").getElementsByTagName('select');
            const from = slobodni_termini[0];
            const to = slobodni_termini[1];
            
            Array.from(from.options).forEach(function(option_element) {
                console.log(arrayFree.includes(parseInt(option_element.value)))
                if (arrayFree.includes(parseInt(option_element.value)) === false){
                    console.log(option_element)
                    option_element.disabled = true;
                }
            })
        }

        function getMails() {

            const termini_element = document.getElementById('termini');

            const http = new XMLHttpRequest();
            const method = "GET";
            const url = "api/admin/readMails.php?";
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

                    const formattedDateSecond = requests[a].date.substring(0, 10);
                    const formattedDate = formattedDateSecond + " :: " + requests[a].date.substring(10, 16) + 'h';
                    
                    let statusHTML = '';
                    if (request.status == 'Aktivan') {
                        statusHTML = '<span style="color:#d67600">Aktivan</span>'
                    }else if(request.status == 'Zavrsen'){
                        statusHTML = '<span style="color:green">Završen</span>'
                    }

                    html += `<div class="termin">
                                <div class="termin-header mb-2">
                                <div class="termin-broj">Termin: #${a + 1}</div>
                                <div class="termin-status">${statusHTML}</div>
                            </div>
                            <div class="d-flex termin-body">
                                <img class="slika-profil" src="slike_profil/${request.customer.photo}" alt="">
                                <div class="termin-content">
                                    <div class="termin-vlasnik">
                                        <div><b>Vlasnik</b></div>
                                        <div>${request.customer.name} ${request.customer.surname}</div>
                                        <div>${request.customer.email}</div>
                                    </div>
                                    <div class="termin-ljubimac">
                                        <div><b>Ljubimac</b></div>
                                        <div>Rasa: ${request.breed}</div>
                                        <div>Godine: 4</div>
                                    </div>
                                </div>
                                <div class="termin-vrijeme">
                                    <div><b>Datum i vrijeme</b></div>
                                    <div>${request.start} (${request.from} - ${request.to})</div>
                                </div>
                            </div>
                            <div class="message" id="message${request.id}" style="display:none;">
                                <b>Poruka: </b>${request.requestMessage}
                            </div>
                            <div class="termin-footer d-flex">
                                <div class="termin-kreirano">Kreirano: ${formattedDate}</div>
                                <div class="termin-buttons">
                                    <button class="btn btn-outline-warning btn-cus" onclick="changeRequest(${request.id}, this, '${request.start}')">Izmijeni</button>
                                    <button class="btn btn-outline-danger btn-cus" onclick="rejectRequest(${request.id}, this, '${request.breed}','${request.customer.email}', '${request.start}')">Otkazi</button>
                                    <button class="btn btn-outline-info btn-cus" onclick="showMessage(${request.id}, this)">Prikaži više</button>
                                </div>
                            </div></div>`
                }


                termini_element.innerHTML = html;

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


        function showMessage(id, element) {
            const message = document.getElementById('message' + id);

            if (message.style.display === 'none') {
                message.style.display = 'block';
                element.innerHTML = "Prikaži manje";
            } else {
                message.style.display = "none";
                element.innerHTML = 'Prikaži više';
            }
        }

        const changeRequestForm = document.getElementById('changeReqForm');
        const changeRequestSubmit = document.getElementById('changeRequestSubmit');

        function pushRequests(form) {
            const selectElements = parent_select.getElementsByTagName("select");

            const selects = [];
            for (let i = 0; i < selectElements.length; i++){
                if (i % 2 === 0) {
                    let j = i;
                    const from = selectElements[j];
                    const to = selectElements[j+1];

                    const fromText = selectElements[j].options[selectElements[j].selectedIndex].text;
                    const toText = selectElements[j+1].options[selectElements[j+1].selectedIndex].text;

                    if (!validateTime(from,to)) return false;
                    const select = {from:fromText, to:toText}; 
                    selects.push(select)
                }
            }
            
            form.append("selects",JSON.stringify(selects));
            return true;
        }
        
        function validateTime(fromEl, toEl) {
            if (parseInt(fromEl.value) > parseInt(toEl.value)) return showError(toEl)      
            
            return removeInvaild(toEl)
        }

        const respondSubmit = document.getElementById('respondSubmit');

        function submitChange(id, startDate) {

            const trajanjeOd = document.getElementById('trajanje_od').value;
            const trajanjeDo = document.getElementById('trajanje_do').value;

            const http = new XMLHttpRequest();
            const method = "POST";
            const url = "api/admin/updateChange.php";
            const asynchronous = true;

            http.open(method, url, asynchronous);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.send('id_cap=' + id + "&from=" + trajanjeOd + "&toTime=" + trajanjeDo + "&startDate=" + startDate);

            http.onload = function () {
                const data = JSON.parse(this.responseText);
                console.log(data);
                if (data.success == 1) {
                    $('[data-toggle="tooltip"]').tooltip("hide");
                    getRequests();
                    Swal.fire(
                            'Poslato!',
                            'Uspješno ste poslali zahtjev za promjenu termina i korisnik je obaviješten',
                            'success'
                            )
                $('#modal-change_accept').modal('hide');
                }
            }
        }

        changeRequestForm.onsubmit = function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            
            if (!pushRequests(formData)) return;


            $(changeRequestSubmit).after("<i id='loader-change' class='fa fa-spinner fa-spin'></i>");
            changeRequestSubmit.disabled = true;    
            
            const http = new XMLHttpRequest();
            const method = "POST";
            const url = "api/admin/changeAppointment.php";
            const asynchronous = true;

            http.open(method, url, asynchronous);
            http.send(formData);

            http.onload = function () {
                const data = JSON.parse(this.responseText);
                console.log(data);
                if (data.success == 1) {
                    Swal.fire(
                            'Poslato!',
                            'Uspješno ste poslali zahtjev za promjenu termina i korisnik je obaviješten',
                            'success'
                            )
                $('#modal-change_appointment').modal('hide');
                }else{
                    Swal.fire({
                            icon: 'error',
                            title: 'Greška',
                            text: 'Pokušajte ponovo! :/',
                    })
                }
                const elem = document.getElementById('loader-change');
                elem.parentNode.removeChild(elem);
                changeRequestSubmit.disabled = false;
            }
        };

        function showError(element) {
            $(element).attr('data-original-title', element.dataset.error)
            $(element).tooltip('show');
            $(element).on('shown.bs.tooltip', function () {
                element.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            })
            return false;
        }

        function removeInvaild(element) {
            $(element).attr('data-original-title', '');
            $(element).tooltip('hide');
            return true;
        }

        function changeRequest(idRequest, element, date) {

            const startDate = document.getElementById('startDate');
            startDate.value = date;

            const idRequestHidden = document.getElementById('idRequest');
            idRequestHidden.value = idRequest;
            
            startDate.min = date;

            //max datum je nedelju dana kasnije
            const dateMonthYear = date.split("-");
            const maxDate = new Date(dateMonthYear[0], dateMonthYear[1]-1, dateMonthYear[2]);
            maxDate.setDate(maxDate.getDate() + 7);

            let maxDay = maxDate.getDate().toString();
            const maxYear = maxDate.getFullYear().toString();
            let maxMonth = (maxDate.getMonth() + 1).toString();

            if (maxMonth.length == 1) maxMonth = "0" + month;
            if (maxDay.length == 1) maxDay = "0" + maxDay;
            
            const finalMax = `${maxYear}-${maxMonth}-${maxDay}`;

            startDate.max = finalMax;

            $('#modal-change_appointment').modal('show');
            
        }

        function rejectRequest(idRequest, element, breed, email, date) {

            Swal.fire({
                title: 'Da li ste sigurni?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da',
                cancelButtonText: 'Ne'
                }).then((result) => {
                    console.log(result);
                    if (result.isConfirmed) {
                        element.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Slanje'
                        const http = new XMLHttpRequest();
                        const method = "POST";
                        const url = "api/admin/rejectAppointment.php";
                        const asynchronous = true;

                        http.open(method, url, asynchronous);
                        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        http.send("id=" + idRequest + "&breed=" + breed + "&email=" + email + "&date=" + date);

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
                                Swal.fire({
                                        icon: 'error',
                                        title: 'Greška',
                                        text: 'Pokušajte ponovo! :/',
                                })
                                element.innerHTML = 'Obriši'
                            }
                        }
                    }
                })
            }
    </script>


</body>

</html>