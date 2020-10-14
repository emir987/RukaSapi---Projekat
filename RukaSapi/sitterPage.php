<?php
session_start();
$id = $_GET["id"];
?>
<style>
html {
    scroll-behavior: smooth;
}
</style>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Post - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="css/blog-post.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">


</head>

<body onload="f()">

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


    <!-- Page Content -->
    <div class="container">

        <div class="row  mt-4">

            <!-- Post Content Column -->
            <div class="col-md-12  col-sm-12">

                <div class="col-lg-12">
                    <!-- Title -->
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h1 id="sitterName" class="mt-4"></h1>
                        </div>
                        <div class="">
                            <div class="modal fade" id="modal-request" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title w-100 font-weight-bold">Zakazivanje termina za šetanje pasa</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="form_send_req">
                                            <input type="hidden" name="sitterID" value="<?php echo $_GET["id"] ?>">
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-2">
                                                    <i class="fas fa-user prefix grey-text"></i>
                                                    <label data-error="wrong" data-success="right" for="startDate">Datum</label>
                                                    <input name='start' onkeydown="return false" type="date" id="startDate" class="form-control validate" data-error="Unesite datum.">
                                                </div>

                                                <div class="md-form mb-2">
                                                    <i class="fas fa-envelope prefix grey-text"></i>
                                                    <label data-error="wrong" data-success="right" for="endDate">Trajanje šetnje</label>
                                                    <div class="d-flex">
                                                        <select name="from" class="form-control mx-1" id="trajanje_od">
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

                                                <div class="md-form mb-2">
                                                    <i class="fas fa-tag prefix grey-text"></i>
                                                    <label data-error="wrong" data-success="right" for="dogBreed">Rasa psa</label>
                                                    <input name="breed" data-error="Unesite rasu vašeg ljubimca" type="text" id="dogBreed" class="form-control validate">
                                                </div>

                                                <div class="md-form">
                                                    <i class="fas fa-pencil prefix grey-text"></i>
                                                    <label data-error="wrong" data-success="right" for="messageID">Poruka i specijalni zahtjevi</label>
                                                    <textarea name="message" type="text" id="messageID" class="md-textarea form-control"
                                                        rows="4"></textarea>
                                                </div>

                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button class="btn btn-success" onclick="sendRequest(event)">Pošalji zahtjev</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="btn_modal_request" class="btn btn-secondary btn-rounded mb-4 float-right mt-4">
                                    <span style="font-size: 20px; font-weight: bold">Zakazi</span>
                                    <img width="22" style="margin-left:10px; margin-bottom: 5px" src="res/images/zakazi.png">
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="row">
                    <!-- Preview Image -->
                    <div class="col-lg-5 col-md-4 col-sm-12">
                        <img id="sitterPhoto" class="img-fluid rounded img-responsive" src="http://placehold.it/900x300"
                            alt="">
                    </div>
                    <div class="col-lg-7 col-md-8 col-sm-12">
                        <div id="sitterInfos"></div>
                        <p id="sitterInfo"></p>

                    </div>
                </div>
                <hr>


                <!-- Comments Form -->
                <div class="card my-4">
                    <h5 class="card-header">Ostavi utisak:</h5>
                    <div class="card-body">
                        <form id="reviewForm" method="post" action="">
                            <div class="form-group">
                                <textarea name="review" id="addComment" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="button" onclick="submitFormReview()" class="btn btn-success">Komentariši</button>
                        </form>
                    </div>
                </div>

                <div id="comments"></div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <div class="footer position-relative">
        <img src="res/images/footer.png">
        <div class="footer-space">
            <p>Copyright &copy;Emir & Milica</p>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
    var id = <?php echo $_GET["id"] ?>;
    var userID = <?php echo (isset($_SESSION['id'])) ? $_SESSION['id'] : 'null' ?>;

    </script>

    <script src="js/custom-sitterPage.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
        if (window.location.hash) {
            var hash = window.location.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 500);
        }
    });
    </script>

    <script>
    <?php
        if (isset($_GET['start'])) {
            $startDate = $_GET['start'];
        } else {
            $startDate = null;
        }
    ?>

    const btn_modal_request = document.getElementById('btn_modal_request');

    btn_modal_request.addEventListener('click',function () {
        if (userID == null) {
            $('#modal-login').modal('show');
            return;
        }
        $('#modal-request').modal('show');
    })
    
    const startDateEl = document.getElementById('startDate');
    const fromEl = document.getElementById('trajanje_od');
    const toEl = document.getElementById('trajanje_do');
    const breedEl = document.getElementById('dogBreed');


    fromEl.addEventListener("change", function () {
        console.log(fromEl.value)
        if (parseInt(fromEl.value) > parseInt(toEl.value)) {
            toEl.value = (parseInt(fromEl.value)+1);
        }
        console.log()
    })

    startDateEl.min = new Date().toISOString().split("T")[0];

    document.getElementById('startDate').value = "<?php echo $startDate ?>";

    function validateDate(startDateEl) {
        if (startDateEl.value == '') return showError(startDateEl) 
        
        return removeInvaild(startDate)
    }

    function validateTime(fromEl, toEl) {
        console.log(parseInt(fromEl.value) > parseInt(toEl.value))
        if (parseInt(fromEl.value) > parseInt(toEl.value)) return showError(toEl)      
        
        return removeInvaild(toEl)
    }

    function validateBreed(breedEl) {
        if (breedEl.value < 3) return showError(breedEl)      
        
        return removeInvaild(breedEl);
    }

    
    const formSend = document.getElementById('form_send_req');


    function sendRequest(event) {

        event.preventDefault();

        const forrm = new FormData(formSend)

        if (!validateDate(startDateEl)) return;
            
        if (!validateTime(fromEl, toEl)) return;
        
        if (!validateBreed(breedEl)) return;

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = "api/sitter/sendRequest.php";
        var asynchronous = true;
        http.open(method, url, asynchronous);
        http.send(forrm);


        http.onload = function() {
            var data = JSON.parse(this.responseText);
            console.log(data);
            if (data.success == 1) {
                $('#modal-request').modal('hide');
                Swal.fire({
                    title: 'Uspješna prijava!',
                    text: 'Ubrzo cete dobiti mejl sa potvrdom rezervacije. Ukoliko dođe do promjene termina, obavezno kontaktirajte šetača da promijenite ili otkažete termin.'
                });

            }
        }
    }

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
    </script>

</body>

</html>