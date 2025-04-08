document.addEventListener("DOMContentLoaded", function () {
    let request = new XMLHttpRequest();

    let submit = false;

    function requestData() {
        "use strict";
        request.open("GET", "Api.php?benutzername=" + document.getElementById("username").value, true);
        request.onreadystatechange = processData;
        request.send(null);

    }

    function processData() {
        "use strict";
        if (request.readyState === 4) { // Uebertragung = DONE
            if (request.status === 200) { // HTTP-Status = OK
                if (request.responseText != null)
                    process(request.responseText); // Daten verarbeiten
                else console.error("Dokument ist leer");
            } else console.error("Uebertragung fehlgeschlagen");
        }
    }

    function process(data) {
        let dataObject = JSON.parse(data);
        console.log(dataObject);

        // prüfe ob der Benutzername bereits vergeben ist
        if (dataObject[0] == "ok") {
            document.getElementById("nameprüfen").innerHTML = "Benutzer ist verfügbar";
            document.getElementById("schicken").disabled = false;

        } else {
            document.getElementById("nameprüfen").innerHTML =
                "Benutzername ist vergeben. Bitte einen anderen Namen eingeben";
            document.getElementById("schicken").disabled = true;
            console.log("Button disabled", document.getElementById("schicken").disabled);
        }
    }

    function passwordCheck() {
        let starkheit = document.getElementById("starkheit");
        let passwort = document.getElementById("password").value;
        let passwortLaenge = passwort.length;
        // weniger als 4 Zeichen : schwach
        const element = document.createElement("span");

        starkheit.innerHTML = "";

        if (passwortLaenge < 4) {
            element.id = "schwach";
            element.innerHTML = "schwach";
            starkheit.appendChild(element);
        }
        // zwischen 4 und 8 Zeichen : ok
        else if (passwortLaenge >= 4 && passwortLaenge <= 8) {
            element.id = "ok";
            element.innerHTML = "ok";
            starkheit.appendChild(element
            );
        }
        // mehr als 8 Zeichen : stark

        else {
            element.id = "stark";
            element.innerHTML = "stark";
            starkheit.appendChild(element);
        }
    }

    document.getElementById("password").addEventListener("input", function () {
        passwordCheck();
    });

    // requestData() aufrufen bei Eingabe der Name
    document.getElementById("username").addEventListener("input", function () {
        requestData();
    });

});