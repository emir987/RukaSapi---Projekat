let currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
    // This function will display the specified tab of the form ...


    $(".tab").eq(n).css("display", "block");

    // ... and fix the Previous/Next buttons:
    if (n == 0) {
        $("#prevBtn").css('display', 'none');
        $("#endBtn").css('display', 'none');
    } else {
        $("#prevBtn").css('display', 'inline');
    }
    if (n == ($(".tab").length - 1)) {
        $("#doniraj-text").html('Hvala Vam!');
        $("#nextBtn").css('display', 'none');
        $("#prevBtn").css('display', 'none');
        $("#endBtn").css('display', 'block');
    } else {
        $("#nextBtn").html('Dalje');
    }

    // ... and run a function that displays the correct step indicator:
    fixStepIndicator(n)
}

$("#endBtn").on('click', function () {
    location.reload();
});

function nextPrev(n) {
    // This function will figure out which tab to display

    // Exit the function if any field in the current tab is invalid:
    // Hide the current tab:
    $('.tab').eq(currentTab).css('display', 'none');
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
    if (currentTab >= $('.tab').length) {
        // submit form
        return false;
    }

    // Otherwise, display the correct tab:
    showTab(currentTab);
}


function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    $(".step").each(function () {
        $(this).removeClass("active");
    });

    //... and adds the "active" class to the current step:
    $(".step").eq(n).addClass("active");

}

const predmeti_button = document.getElementById('predmeti-button');
const predmeti_section = document.getElementById('predmeti-info');
const hrana_button = document.getElementById('hrana-button');
const hrana_section = document.getElementById('hrana-info');


predmeti_button.addEventListener('click', function () {
    predmeti_section.style.display = "flex";
    hrana_section.style.display = "none";
})

hrana_button.addEventListener('click', function () {
    hrana_section.style.display = "flex";
    predmeti_section.style.display = "none";
})

function dodajPredmet(element) {
    console.log();
    const kolicina = element.previousElementSibling;
    const predmet = element.parentElement.previousElementSibling;

    if (!provjeriVrstu(predmet)) return;
    if (!provjeriKolicinu(kolicina)) return;

    const ispisElement = $('#odabrano');
    ispisElement.append(`<p>${ispisElement[0].childElementCount}. ${predmet.innerText} (${kolicina.value})</p>`)
}


function dodajHranu(element) {
    const vrsta = element.previousElementSibling.previousElementSibling;
    const kolicina = element.previousElementSibling;

    if (!provjeriVrstu(vrsta)) return;
    if (!provjeriKolicinu(kolicina)) return;

    const ispisElement = $('#odabrano');
    ispisElement.append(`<p>${ispisElement[0].childElementCount}. ${element.dataset.sta}(${vrsta.value}) - ${kolicina.value}kg</p>`)
}

function provjeriVrstu(element) {
    if (element.value == '') {
        $(element).attr('data-original-title', element.dataset.error)
        element.classList.add('invalid-input');
        $(element).tooltip('show');
        return false;
    }
    element.classList.remove('invalid-input');
    $(element).attr('data-original-title', '');
    $(element).tooltip('hide');
    return true;
}

function provjeriKolicinu(element) {
    if (element.value == '') {
        $(element).attr('data-original-title', element.dataset.error)
        element.classList.add('invalid-input');
        $(element).tooltip('show');
        return false;
    }
    element.classList.remove('invalid-input');
    $(element).attr('data-original-title', '');
    $(element).tooltip('hide');
    return true;
}

const loggedUserData = document.getElementById('logged-user-data');
const newUserData = document.getElementById('new-user-data');
const userData = document.getElementById('user-data-form');


loggedUserData.addEventListener('click', function () {

    var http = new XMLHttpRequest();
    var method = "GET";
    var url = "api/user/getUserInfo.php";
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send();
    http.onload = function () {
        var data = JSON.parse(http.responseText);

        if (data.success === 0) {
            $('#modal-login').modal('show');
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

newUserData.addEventListener('click', function () {
    [...userData.elements].forEach((input) => input.value = '');
});