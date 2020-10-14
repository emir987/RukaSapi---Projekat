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

<body onload="loadData()">

    <!-- Navigation -->

    <style>
        .mySlides {
            display: none;
            padding: 20px 20px 20px;
        }

        /* The Close Button */
        .closeBtn {
            position: absolute;
            display:flex;
            top: -15px;
            right: -18px;
            cursor:pointer;
            width:35px;
        }

        .custom-control-input:checked~.custom-control-label::before {
            color: #fff;
            border-color: #ce781f;
            background-color: #cc7d1a;
        }

        .voted{
            margin:20px;
            margin-top: 40px;
            text-align: center;
            font-size: 23px;
            color: green;
            font-weight: 500;
            transition: margin, color, font-size .5s;
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

    <div class="modal fade" id="modal-add_new" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content px-4 py-2" style="border-radius: 1.2rem; margin-top:6rem;">
                <div class="header" style="position:relative">
                    <!-- <img style="position:absolute" src="res/images/add_dog.png"> -->
                    Dodajte ljubimca
                </div>
                <div class="content">
                    <form id="dodaj-ljubimca" action="api/pet/addPet.php" method="POST" enctype="multipart/form-data">

                        <div class="form-row my-3">
                            <div class="col">
                                <div>
                                    <div class="form-group m-0">
                                        <input placeholder="Ime" name="name" type="text" class="form-control" id="inputNamel4" aria-describedby="helpId">
                                        
                                    </div>
                                    <div class="d-flex">
                                        <label class="form-check-label" style="color:red" for="no-name">Bez imena</label>
                                        <input onchange="noName(this)" class="w-auto my-auto ml-2" name="no-name" value="0"  type="checkbox" id="no-name">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <select name="gender" class="js-example-basic-single select-main" id="gender">
                                    <option value="0"  disabled selected hidden>Odaberite pol</option>
                                    <option value="musko">Musko</option>
                                    <option value="zensko">Zensko</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-row my-3">
                            <div class="col">
                                <select onchange="selectRasa(this)" name="category" class="js-example-basic-single select-main" id="inputCategory4">
                                    <option value="0" disabled selected hidden>Odaberite vrstu ljubimca..</option>
                                    <option value="pas">Pas</option>
                                    <option value="macka">Macka</option>
                                </select>  
                            </div>
                            <div class="col">
                                <select name="breed" class="js-example-basic-single select-main" id="breed" disabled>
                                    <option value="0" disabled selected hidden>Odaberite rasu</option>
                                </select>  
                            </div>           
                        </div>

                        <div class="form-row my-3">
                            <div class="col">
                                <input name="height" type="number" class="form-control" id="height" placeholder="Visina (cm)">
                            </div>
                            <div class="col">
                                <input name="weight" type="number" class="form-control" id="weight" placeholder="Tezina (kg)">
                            </div>
                        </div>

                        <div class="form-row my-3">
                            <div class="col">
                                <select name="age" class="js-example-basic-single select-main" id="age">
                                    <option value="0" disabled selected hidden>Odaberite starost</option>
                                    <option value="0">Stene</option>
                                    <option value="1">1 godina</option>
                                    <option value="2">2 godina</option>
                                    <option value="3">3 godina</option>
                                    <option value="4">4 godina</option>
                                    <option value="5">5 godina</option>
                                    <option value="6">6 godina</option>
                                    <option value="7+">7+ godina</option>
                                </select>  
                            </div>
                            <div class="col">
                                <select name="growth" class="js-example-basic-single select-main" id="growth">
                                    <option value="0" disabled selected hidden>Odaberite rast</option>
                                    <option value="mali">Mali</option>
                                    <option value="srednji">Srednji</option>
                                    <option value="veliki">Veliki</option>
                                </select>  
                            </div>
                        </div>

                        <div class="form-row my-3">
                            <div class="col">
                                <input name="color" type="text" class="form-control" id="color" placeholder="Boja dlake">
                            </div>
                            <div class="col">
                                <select name="hair_length" class="js-example-basic-single select-main" id="hairLength">
                                    <option value="0" disabled selected hidden>Odaberite duzinu dlake</option>
                                    <option value="kratka">Kratka</option>
                                    <option value="srednja">Srednja</option>
                                    <option value="duga">Duga</option>
                                </select>  
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" id="about" rows="3" name="description" placeholder="Opis:"></textarea>
                        </div>

                        <input type="hidden" name="ownerID" value="<?php echo $_SESSION['id'] ?>">

                        <h6 class="text-center">Odaberite slike</h6>

                        <div class="grid-gallery">
                            <div class="position-relative">
                                <span id="close0" class="zatvori_slika" onclick="zatvori_slika(0, this)">
                                    <i class="fa fa-times " aria-hidden="true"></i>
                                </span>
                                <label for="slika_input" class="dodaj_slika_label w-100 h-100">
                                    <img id="slika_0" src="res/images/new_pet.png" class="slika_dodaj" style="max-width:200px" alt="" data-imgg="empty">
                                </label>
                            </div>
                            
                            <div class="position-relative">
                                <span id="close1" class="zatvori_slika" onclick="zatvori_slika(1, this)">
                                    <i class="fa fa-times " aria-hidden="true"></i>
                                </span>
                                <label for="slika_input" class="dodaj_slika_label">
                                    <img id="slika_1" src="res/images/new_pet.png" class="slika_dodaj" alt="" data-imgg="empty">
                                </label>
                            </div>

                            <div class="position-relative">
                                <span id="close2" class="zatvori_slika" onclick="zatvori_slika(2, this)">
                                    <i class="fa fa-times " aria-hidden="true"></i>
                                </span>
                                <label for="slika_input" class="dodaj_slika_label">
                                    <img id="slika_2" src="res/images/new_pet.png" class="slika_dodaj" alt=""  data-imgg="empty">
                                </label>
                            </div>

                            <div class="position-relative">
                                <span id="close3" class="zatvori_slika" onclick="zatvori_slika(3, this)">
                                    <i class="fa fa-times " aria-hidden="true"></i>
                                </span>
                                <label for="slika_input" class="dodaj_slika_label">
                                    <img id="slika_3" src="res/images/new_pet.png" class="slika_dodaj" alt=""  data-imgg="empty">
                                </label>
                            </div>

                        </div>

                        <div class="form-group">
                            <input value="Add" name="submit" type="submit" id="addButton"
                                class="btn btn-primary">
                        </div>
                        
                        <input type="file" multiple id="slika_input" style="display: none;" name='slike[]'
                            accept="image/jpeg, image/png" />

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="banner" style="margin-top:20px">
        <img src="res/images/banner.png" width="100%" height=100% alt="">
        <div class="d-flex">
            <div class="search ">
                <form class="header-search-form d-flex">
                    <input id="getSearch" type="text" onkeyup="reduceLimit();loadData()" placeholder="Search...">
                    <div class="dodaj_ljubimca_btn ml-2" id="dodaj_ljubimca_btn">
                        <span>Dodaj</span><img class="add_dog_img" src="res/images/add_dog.png" alt="">
                    </div>
                </form>
            </div>
            <div class="filter-mobile dropdown">

                <!-- Button trigger modal -->
                <img src="res/images/filter.svg" alt="" width=25 data-toggle="modal" data-target="#exampleModal">

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content ">

                            <div class="modal-body d-flex flex-row justify-content-around">
                                <button style="position:absolute; right:10px" type="button" class="close"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="mt-3">
                                    <div id="category-small">
                                        <h3 class="">Kategorija</h3>
                                        <label class="containers mt-4">Pas
                                            <input name="cat" onclick="reduceLimit()"
                                                class="messageCheckbox" type="checkbox" checked="checked" value="pas">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="containers">Mačka
                                            <input name="cat" onclick="reduceLimit()"
                                                class="messageCheckbox" type="checkbox" checked="checked" value="macka">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="containers">Ostalo
                                            <input name="cat" onclick="reduceLimit()"
                                                class="messageCheckbox" type="checkbox" checked="checked" value="ostalo">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                                <div id="weight-small" class="mt-3">
                                    <h3>Weight <span style="font-size: 17pt; color: #4d4d4d">(kg)</span></h3>
                                    <div class="fw-size-choose d-flex">
                                        <div class="sc-item col-lg-1">
                                            <input onclick="reduceLimit()" type="radio"
                                                name="sc-s" checked="checked" id="all-s" value=1>
                                            <label for="all-s">Sve</label>
                                        </div>
                                        <div class="sc-item col-lg-1">
                                            <input onclick="reduceLimit()"  checked type="radio"
                                                name="sc-s" id="xs-size" value="XS">
                                            <label for="xs-size">1-4</label>
                                        </div>
                                        <div class="sc-item col-lg-1">
                                            <input onclick="reduceLimit()" type="radio"
                                                name="sc-s" id="s-size" value="S">
                                            <label for="s-size">5-9</label>
                                        </div>
                                    </div>
                                    <div class="fw-size-choose d-flex">

                                        <div class="sc-item col-lg-3">
                                            <input onclick="reduceLimit()" type="radio"
                                                name="sc-s" id="m-size" value="M">
                                            <label for="m-size">10-19</label>
                                        </div>
                                        <div class="sc-item col-lg-3">
                                            <input onclick="reduceLimit()" type="radio"
                                                name="sc-s" id="l-size" value="L">
                                            <label for="l-size">20-29</label>
                                        </div>
                                        <div class="sc-item col-lg-3">
                                            <input onclick="reduceLimit()" type="radio"
                                                name="sc-s" id="xl-size" value="XL">
                                            <label for="xl-size">30+</label>
                                        </div>
                                    </div>
                                    <button style="" onclick="loadData()" type="button" class="btn btn-success d-flex ml-auto mt-3"
                                        data-dismiss="modal" aria-label="Close">
                                        Filtriraj
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div id="fiksirajExpand" class="mt-5 position-relative">
        <div class="container">

            <div class="filter-lg" style="position: absolute; left:30px">
                <div style="margin-top: 50px">
                    <div id="category-large">
                        <h3 class="">Kategorija</h3>
                        <label class="containers mt-4">Pas
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                type="checkbox" checked="checked" value="pas">
                            <span class="checkmark"></span>
                        </label>
                        <label class="containers">Mačka
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                type="checkbox" checked="checked" value="macka">
                            <span class="checkmark"></span>
                        </label>
                        <label class="containers">Ostalo
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                type="checkbox" checked="checked" value="ostalo">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="mt-5">
                    <h3>Težina <span style="font-size: 17pt; color: #4d4d4d">(kg)</span></h3>

                    <div id="weight-large" class="fw-size-choose">
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" checked
                                id="all-l" value=1>
                            <label for="all-l">Sve</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="xs-size-l"
                                value="XS">
                            <label for="xs-size-l">1-4</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="s-size-l"
                                value="S">
                            <label for="s-size-l">5-9</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="m-size-l"
                                value="M">
                            <label for="m-size-l">10-19</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="l-size-l"
                                value="L">
                            <label for="l-size-l">20-29</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="xl-size-l"
                                value="XL">
                            <label for="xl-size-l">30+</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-10 col-md-12 offset-lg-1 offset-md-0 px-4 px-sm-5">
                <div class="row section-1" id="showMore"></div>
                <div class="text-center">
                    <button class="btn btn-info" type="button" id="loadMore">Prikaži još</button>
                </div>

            </div>

        </div>

        <div class="footer position-relative">
            <img src="res/images/footer.png">
            <div class="footer-space">
                <p>Copyright &copy;Emir & Milica</p>
            </div>
        </div>
    </div>

   

    <!-- /.container -->

    <!-- Modals new names -->


    <!-- Small modal -->
    <div>
        <div id="newNameModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div id="give-name" class="modal-content">
                    
                </div>
            </div>
        </div>
    </div>

    


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/custom-index.js" type="text/javascript"></script>

    <script>

    var idUser = <?php echo (isset($_SESSION['id'])) ? $_SESSION['id'] : 'null' ?>;
    
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    </script>


</body>

</html>