<?php
session_start();
$id = $_GET["id"];

$idUser = 00;
if (isset($_SESSION['id'])){
    $idUser = $_SESSION['id'];
}
?>


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

    <link type="text/css" rel="stylesheet" href="css/lightgallery.min.css" /> 

    <!-- Custom styles for this template -->
    <link href="css/blog-post.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/nav.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


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

    <div class="modal fade" id="modal-adopt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content px-4 py-2 position-relative" style="border-radius: 1.2rem; margin-top:6rem;">
                <img class="udomi_header_img" src="res/images/house.png" alt=""> 
                <div class="udomi_header" style="position:relative;text-align:center;">UDOMI ME</div>
                <form class="mt-4" id="adopt_pet">
                    <div>Zašto baš mene? <img src="res/images/add_dog.png" style="width:28px; margin-bottom:10px;" alt=""></div>
                    <textarea class="form-control" name="message" id="message" rows="3" data-error="Morate unijeti poruku duzine najmanje 20 karaktera."></textarea>
                    <div>
                        Koliko imate članova porodice? 
                        <input name="fam_num" id="family_number" type="number" class="form-control mt-3" value="4" style="display:inline; width: 15%;" min="1" max="9">
                    </div>
                    <div>Živim u 
                        <select id="living" name="living" class="form-control mt-3" style="display:inline; width: auto;">
                            <option value="stan">Stanu</option>
                            <option value="kuca">Kući</option>
                        </select>
                    </div>
                    <input type="submit" value="Pošalji vlasniku" class="btn btn-success btn-block mt-4 btn-log w-50">
                </form>
            </div>
        </div>
    </div>


<!-- Page Content -->
<div class="container">

    
    

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-md-12  col-sm-12">

            <div class="col-lg-12">
                <!-- Title -->
                <div class="d-flex justify-content-between mt-5">
                    <h1 id="petName"></h1>
                    <div class="dodaj_ljubimca_btn mt-2" style="width:15%;min-width:135px;" id="modal_adopt_trigger">
                        <span style="min-width:fit-content">Udomi me</span><img class="add_dog_img" src="res/images/house.png" alt="">
                    </div>
                </div>
                <hr>
            </div>

            

            <div class="row">
                <!-- Preview Image -->
                <div class="col-lg-5 col-md-8 img-hover">
                    <div id="lightgallery" style="display:grid;grid-template-columns:1fr 1fr; gap:15px; grid-auto-rows:205px"></div>
                </div>
                <div class="col-lg-7 col-md-4">

                    <div id="infos"></div>
                    <p id="info"></p>

                </div>
            </div>
            <hr>
            <div class="row">
                <div id="owner" class="col-lg-6"></div>
                <div id="kupi" class="col-lg-6">

                </div>
            </div>
            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Napiši komentar:</h5>
                <div class="card-body">
                    <form id="pokupiFormu" method="post" action="">
                        <!--                        onsubmit="return submitFormComment(this);"-->
                        <div class="form-group">
                            <textarea name="comment" id="addComment" class="form-control" rows="3"></textarea>
                        </div>

                        <!--                        <input name="petID" type="hidden" value="-->
                        <?php //echo $_GET['id'] ?><!--">-->
                        <button type="button" onclick="submitFormComment()" class="btn btn-success">Komentariši</button>
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

<script>
     $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script src="js/lightgallery.min.js"></script>

<script src="js/lg-thumbnail.min.js"></script>
<script src="js/lg-fullscreen.min.js"></script>
<script src="js/main.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>

   

    const modal_adopt_btn = document.getElementById('modal_adopt_trigger');

    const userID = <?php echo (isset($_SESSION['id'])) ? $_SESSION['id'] : 'null' ?>;

    modal_adopt_btn.addEventListener('click', function () {
        if (userID == null) {
            $('#modal-login').modal('show');
            return;
        }
        $('#modal-adopt').modal('show');
    })


    const petID = <?php echo $_GET['id'] ?>;

    const message = document.getElementById("message");
    const familyNumber = document.getElementById('family_number');
    const living = document.getElementById('living');

    function checkMessage() {

        if (message.value.length < 20) {
            $(message).attr('data-original-title', message.dataset.error)
            message.classList.add('invalid-input');
            $(message).tooltip('show');
            return false;
        }
        message.classList.remove('invalid-input');
        $(message).attr('data-original-title', '');
        $(message).tooltip('hide');
        return true;
    }

    function adoptPet(event) {
        event.preventDefault();

        if (!checkMessage()) return;
        const formData = new FormData(formAdopt);
        formData.append("petID", petID);

        // for (var pair of formData.entries()) console.log(pair[0] + ', ' + pair[1]);
        // console.log('');
    
        const http = new XMLHttpRequest();

        http.open("POST", "api/pet/adopt.php", true);
        http.send(formData);

        http.onload = function () {
            const data = JSON.parse(this.responseText);
            console.log(data);
            if (data.success == 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Greška',
                    text: 'Već ste poslali zahtjev za udomljavanje ovog ljubimca! :)'
                    })
                $('#modal-adopt').modal('hide');
                $(formAdopt).trigger("reset");
                return;
            }
            if (data.success == 1) {
                $('#modal-adopt').modal('hide');
                $(formAdopt).trigger("reset");
                Swal.fire({
                    title: 'Uspješno poslat zahtjev za udomljavanje!',
                    text: 'Vlasnik je dobio sve vaše informacije i ubrzo će Vas kontaktirati putem e-mail pošte.'
                });
            }
        }
    }

    const formAdopt = document.getElementById('adopt_pet');
    formAdopt.addEventListener('submit', adoptPet);

    const family_number = document.getElementById('family_number');

    family_number.addEventListener('input', (event) => {
        console.log(event.target.value);
        event.target.value = event.target.value.slice(0,1); 
    });


    function f() {

        var h1 = document.getElementById('petName');
        var photo = document.getElementById('photo');
        var info = document.getElementById('info');
        var infos = document.getElementById('infos');

        var http = new XMLHttpRequest();
        var method = "GET";
        var url = "api/pet/getPet.php?id=<?php echo $_GET["id"] ?>";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send();

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            var pet = data.pet;
            const images = pet.images;

            let imageHTML = '';

            for(const image of images){
                const imageSrc = "slike/" + image;
                imageHTML += `<a href="${imageSrc}">
                                <img class="gallery_img" src="${imageSrc}">
                            </a>`;
            }

            document.getElementById('lightgallery').innerHTML = imageHTML;

            lightGallery(document.getElementById('lightgallery')); 

            h1.innerHTML = pet.name;
            info.innerHTML = "<b>Opis:</b><br>" + pet.description;

            infos.innerHTML = '<table class="table table-striped">\n' +
                '  <thead>\n' +
                '    <tr>\n' +
                '      <th scope="col">Težina</th>\n' +
                '      <th scope="col">Visina</th>\n' +
                '      <th scope="col">Godine</th>\n' +
                '      <th scope="col">Kategorija</th>\n' +
                '    </tr>\n' +
                '  </thead>\n' +
                '  <tbody>\n' +
                '    <tr>\n' +
                '      <td>'+pet.weight+' kg</td>\n' +
                '      <td>'+pet.height+' cm</td>\n' +
                '      <td>'+pet.age+' godina</td>\n' +
                '      <td>'+pet.category+'</td>\n' +
                '    </tr>\n' +
                '  </tbody>\n' +
                '</table>';



            var ownerInfo = "<h5>Vlasnik</h5><hr><table><tr><td><b>Ime:</b> " + pet.owner.name + " " + pet.owner.surname + "</td></tr>";
            ownerInfo += "<tr><td><b>Telefon:</b> " + pet.owner.phone + "</td></tr>";
            ownerInfo += "<tr><td><b>Adresa:</b> " + pet.owner.address + "</td></tr></table>";
            owner.innerHTML = ownerInfo;

            loadComments();
        }
    }

    function submitFormComment() {

        var form = document.getElementById('pokupiFormu');
        var formData = new FormData(form);
        formData.append("petID", <?php echo $_GET['id']?>)

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = 'api/comment/postComment.php';
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.send(formData);

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            loadComments();
        }
    }


    function loadComments() {

        var comments = document.getElementById('comments');

        var http = new XMLHttpRequest();
        var method = "GET";
        var url = "api/comment/loadComment.php?id=<?php echo $_GET["id"] ?>";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send();

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            var commentsArray = data.comments || [];
            var html = "";

            for (var a = 0; a < commentsArray.length; a++) {
                $commentID = commentsArray[a].id;
                $comment = commentsArray[a].comment;

                html += `<div class="media mb-4">
                         <img class="d-flex mr-3 rounded-circle commentator_photo" src="slike_profil/${commentsArray[a].commentator.photo}" alt="profilna slika">
                         <div class="media-body">`;
                var commentator = commentsArray[a].commentator.name + " " + commentsArray[a].commentator.surname;
                var ago = '';
                var formattedDate = commentsArray[a].date.substr(0, 10) + ' :: ' + commentsArray[a].date.substring(10, 16) + 'h'
                if (commentsArray[a].hours !== 'no') {
                    ago += commentsArray[a].hours + ' sata';
                } else {
                    ago += formattedDate;
                }
                html += '<span class="mt-0 font-weight-bold">' + commentator + '</span><span class="ml-4 comment" data-toggle="tooltip" data-placement="auto right" title="' + formattedDate + '">' + ago + '</span>';

                html += '<div id="comment' + $commentID + '">' + commentsArray[a].comment + '</div></div>';


                if (commentsArray[a].commentator.userID == <?php echo $idUser ?>) {
                    
                    html += '<button onclick="openEdit(\'' + $comment + '\',' + $commentID + ')" class="mt-3 btn btn-link btn-sm" type="button" >Uredi</button>' +
                    '<button  onclick="deleteComment(' + $commentID + ')" class="mt-3 btn btn-link btn-sm text-danger">Obriši</button >';
                }
                html += '</div>';
                
            }
            if (commentsArray.length > 0) {
                comments.innerHTML = html;
            }

        }
    }

    function deleteComment(id) {
        var http = new XMLHttpRequest();
        var method = "POST";
        var url = "api/comment/deleteComment.php";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send('id=' + id);

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            loadComments();
        };
    }

    function editConfirm(id) {

        var newComment = document.getElementById('newComment').value;

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = "api/comment/updateComment.php";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send('comment=' + newComment + '&id=' + id);

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            if (data.success === 1) {
                loadComments();
            }
        };

    }

    function closeEdit(id, comment) {
        document.getElementById('comment' + id).innerHTML = '<div id="comment' + id + '">' + comment + '</div>';
    }


   function openEdit(comment, id) {
        document.getElementById('comment' + id).innerHTML = '<div class="row">' +
            '<textarea class="form-control" rows="2" style="width: 90%;" id="newComment" type="text">' + comment + '</textarea>' +
            '<span onclick="closeEdit(' + id + ',\'' + comment + '\')" style="cursor:pointer;font-size:1.2rem" id="deletePet" class="mx-2">&times;</span>' +
            '<span onclick="editConfirm(' + id + ')" style="cursor:pointer">&#10003;</span></div>';
    }


</script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

</body>

</html>
