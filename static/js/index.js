"use strict";

$(document).mouseup(
    function (e) {
        if ($(e.target).closest("#profile").length === 0)
            $(".sipka-svg, #login-form, #register-form").attr("opened", "false")
    });

$(".sipka-svg").click(
    function (e) {
        if ($(this).attr("opened") === "false")
            $(this).attr("opened", "true");
        else
            $(this).attr("opened", "false");

        $("#login-form, #register-form").attr("opened", "false");
    });

$("#login").click(
    function (e) {
        $("#login-form").attr("opened", "true");
        $("#register-form").attr("opened", "false");
        $(".sipka-svg").attr("opened", "false");
        $("#login-error").text("");
    }
);
$("#register").click(
    function (e) {
        $("#register-form").attr("opened", "true");
        $("#login-form").attr("opened", "false");
        $(".sipka-svg").attr("opened", "false");
        $("#register-error").text("");
    }
);

$("#search-type-profile").click(
    function (e) {
        $("#search").attr("type", "profile");
    }
);
$("#search-type-article").click(
    function (e) {
        $("#search").attr("type", "article");
    }
);

$(".summary").click(
    function (e) {
        console.log($(this).attr("opened"));
        if ($(this).attr("opened") === "false") {
            $(this).attr("opened", "true");
        }
        else {
            $(this).attr("opened", "false");
        }
    }
);

function login() {
    /* var email_regex = new RegExp("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$");
    console.log(email_regex.test($("#login-username").val())); */
    const uid = $("#login-uid").val();
    const password = $("#login-password").val();
    const stay_logged = $("#login-stay-logged").prop("checked");

    console.log(stay_logged);

    if (!(uid || password)) {
        $("#login-error").text("Není vyplněno uživatelské jméno nebo heslo");
    }
    else {
        $.ajax(
            {
                url: "/static/php/login.php",
                type: "POST",
                data:
                {
                    "uid": uid,
                    "password": password,
                    "stay-logged": stay_logged
                },
                success: function (data) {
                    console.log(`data ${data}`)
                    if (data === "success") {
                        location.reload();
                    }
                    else if (data === "wrong-password") {
                        $("#login-error").text("Bylo zadáno nesprávné heslo");
                    }
                    else if (data === "user-not-found") {
                        $("#login-error").text("Uživatel nebyl nalezen");
                    }
                }
            }
        );
    }
}
function register() {
    console.log("register")
    let uid = $("#register-uid").val();
    const password = $("#register-password").val();
    const repeat_password = $("#register-repeat-password").val();

    console.log(uid, password, repeat_password);

    if (!(uid || password)) {
        $("#register-error").text("Není vyplněno uživatelské jméno nebo heslo");
    }
    else if (password !== repeat_password) {
        $("#register-error").text("Hesla se neshodují");
    }
    else {
        $.ajax(
            {
                url: "/static/php/register.php",
                type: "POST",
                data:
                {
                    "uid": uid,
                    "password": password
                },
                success: function (data) {
                    data = data.split(";");
                    if (data[0] === "registered") {
                        uid = data[1]
                        $.post(
                            {
                                url: "/static/php/login.php",
                                data:
                                {
                                    "uid": uid,
                                    "password": password,
                                    "stay-logged": false
                                },
                                success: function (data) {
                                    console.log(data);
                                    location.reload();
                                }
                            }
                        );
                    }
                    else if (data === "uid-taken") {
                        $("#register-error").text("Jméno už je zabrané");
                    }
                }
            }
        );
    }
    console.log("registergon")
}
function logout() {
    $.ajax(
        {
            url: "/static/php/logout.php",
            type: "POST",
            success: function (data) {
                location.reload();
            }
        }
    );
}

function update_settings() {
    let error = false;
    $("#nastaveni-username-report").text("");
    $("#nastaveni-uid-report").text("");
    $("#nastaveni-avatar-report").text("");
    let fd = new FormData();

    const username = $("#nastaveni-username").val();
    if (!username) {
        $("#nastaveni-username-report").text("Uživatelské jméno není vyplněno");
        error = true;
    }
    else {
        fd.append("username", username);
    }
    const uid = $("#nastaveni-uid").val();
    if (!uid) {
        $("#nastaveni-uid-report").text("UID není vyplněno");
        error = true;
    }
    else {
        fd.append("uid", uid);
    }
    const img = $("#nastaveni-avatar").val();
    if (img) {
        let input = $("#nastaveni-avatar").prop("files")[0];
        const img_url = (window.URL ? URL : webkitURL).createObjectURL(input);
        const img_size = (input.size / 1024) / 1024;
        let img_obj = new Image();
        img_obj.src = img_url;

        if (!(img_obj.height === img_obj.width)) {
            $("#nastaveni-avatar-report").text("Avatar není čtverec");
            error = true;
        }
        else {
            img_obj.height = 128;
            img_obj.width = 128;

            fd.append("file", input);
        }
    }

    if (!error) {
        $.ajax(
            {
                url: "/static/php/update_settings.php",
                type: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    switch (data) {
                        case "avatar-bad-format":
                            $("#nastaveni-avatar-report").text("Formát avataru není podporován.");
                            break;
                        case "id-bad-format":
                            $("#nastaveni-uid-report").text("UID obsahuje neplatné znaky");
                            break;
                        case "id-taken":
                            $("#nastaveni-uid-report").text("UID už je zabrané");
                            break;
                        case "":
                            setTimeout(() => { location.reload() }, 500);
                            break;
                    }
                },
                error: function (data) {
                    console.log("error");
                }
            }
        );
    }
}
function update_avatar(input) {
    console.log(input);
    const img_url = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
    const img_size = (input.files[0].size / 1024) / 1024;
    let img_obj = new Image();
    img_obj.src = img_url;
    console.log(img_size);
    img_obj.onload = function () {
        console.log(img_obj.height, img_obj.height)
        if (!(img_obj.height === img_obj.width)) {
            $("#nastaveni-avatar-report").text("Avatar není čtverec");
        }
        else {
            img_obj.height = 128;
            img_obj.width = 128;
            $('#nastaveni-avatar-img')[0].src = img_url;
        }
    };
}

function novy_clanek() {
    const nadpis = $("#novy-clanek-headline").val();
    const kategorie = $("#novy-clanek-categories").val();
    const content = $("#novy-clanek-content").val();
    const sources = $("#novy-clanek-sources").val();

    console.log(nadpis, kategorie, content, sources);
    console.log(nadpis == "" || kategorie == "" || content == "" || sources == "");

    if (nadpis == "" || kategorie == "" || content == "" || sources == "") {
        $("#novy-clanek-error").text("Některé pole není vyplněno");
    }
    else {

        $.ajax(
            {
                url: "/static/php/add_clanek.php",
                type: "POST",
                data:
                {
                    "nadpis": nadpis,
                    "kategorie": kategorie,
                    "content": content,
                    "sources": sources
                },
                success: function (data) {

                    var status, id;
                    [status, id] = data.split(" ");
                    console.log(data);
                    console.log(status);
                    console.log(id);
                    if (status == "success") {
                        $("#novy-clanek-error").text("Článek byl úspěšně odeslán");
                        location.href = `/clanek/${id}`;
                    }
                    else if (status == "headline-taken") {
                        $("#novy-clanek-error").text("Nadpis je už zabraný");
                    }
                }
            }
        );
    }
}
function update_clanek() {
    const nadpis = $("#novy-clanek-headline").val();
    const kategorie = $("#novy-clanek-categories").val();
    const content = $("#novy-clanek-content").val();
    const sources = $("#novy-clanek-sources").val();
    const id = window.location.pathname.split("/")[2];
    console.log("id", id);

    console.log(nadpis, kategorie, content, sources);
    console.log(nadpis == "" || kategorie == "" || content == "" || sources == "");

    if (nadpis == "" || kategorie == "" || content == "" || sources == "") {
        $("#novy-clanek-error").text("Některé pole není vyplněno");
    }
    else {
        $.ajax(
            {
                url: "/static/php/update_clanek.php",
                type: "POST",
                data:
                {
                    "id": id,
                    "nadpis": nadpis,
                    "kategorie": kategorie,
                    "content": content,
                    "sources": sources
                },
                success: function (data) {
                    console.log(data);
                    if (data == "success") {
                        $("#novy-clanek-error").text("Článek byl úspěšně editován");
                        location.href = `/clanek/${id}`;
                    }
                    else if (data == "headline-taken") {
                        $("#novy-clanek-error").text("Nadpis je už zabraný");
                    }
                }
            }
        );
    }
}
function delete_clanek() {
    if (!confirm("Opravdu chcete tento článek smazat?")) return;
    const id = window.location.pathname.split("/")[2];

    $.ajax(
        {
            url: "/static/php/delete_clanek.php",
            type: "POST",
            data:
            {
                "id": id
            },
            success: function (data) {
                if (data == "success") {
                    $("#novy-clanek-error").text("Článek byl úspěšně odstraněn");
                    location.href = "/";
                }
                else {
                    $("#novy-clanek-error").text("Při odstraňování se vyskytla neznámá chyba");
                }
            }
        }
    );
}

// Login
function login_page() {
    $("[login]").each(
        function (index) {
            $(this).attr("login", "true");
        }
    );
}
function login_author() {
    $("[login-author]").each(
        function (index) {
            $(this).attr("login-author", "true");
        }
    );
}