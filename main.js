function replaceTextWithInputs(id) {
    let namelabel = document.getElementById(id + "_name");
    let lastnamelabel = document.getElementById(id + "_lastname");
    let email = document.getElementById(id + "_email");
    let pw = document.getElementById(id + "_pw");
    let node = document.getElementById(id + "_node");

    node.innerHTML=
        "<form id='" + id + "_form' action='database.php' method='post'></form>" +
            "<td><input class='form-control' form='" + id + "_form' name='vname' type='text' size='" + namelabel.innerText.length + "' value='" + namelabel.innerText + "'></td>" +
            "<td><input class='form-control' form='" + id + "_form' name='nname' type='text' size='" + lastnamelabel.innerText.length + "' value='" + lastnamelabel.innerText + "'></td>" +
            "<td><input class='form-control' form='" + id + "_form' name='email' type='text' size='" + email.innerText.length + "' value='" + email.innerText + "'></td>" +
            "<td><input class='form-control' form='" + id + "_form' name='pw' type='text' size='" + pw.innerText.length + "' value='" + pw.innerText + "'></td>" +
            "<td><input form='" + id + "_form' name='edit' type='submit' class='updatebtn' value='update'><img alt='del' src='img/trashcan.svg' style='height: .8em;' onclick='location.href=\"/Praktikum/database.php?id=" + id +"'/>" +
            "<input form='" + id + "_form' name='id' type='hidden' value='" + id + "'>";

}
