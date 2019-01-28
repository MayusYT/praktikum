<head>
    <title>Database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<?php
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'test');


// INSERT
if (isset($_POST['vname']) and isset($_POST['nname']) and isset($_POST['email']) and isset($_POST['pw']) and isset($_POST['insert'])) {
    $vorname = $_POST['vname'];
    $nachname = $_POST['nname'];
    $email = $_POST['email'];
    $passwort = $_POST['pw'];
    insert($vorname, $nachname, $email, $passwort);
    $pdo = closeSQL();

    echo "<h3>Eintrag hinzufügen:</h3>";
    echoForm();

// EDIT
} elseif (isset($_GET['id']) and isset($_POST['vname']) and isset($_POST['nname']) and isset($_POST['email']) and isset($_POST['pw']) and isset($_POST['edit'])) {
    $vorname = $_POST['vname'];
    $nachname = $_POST['nname'];
    $email = $_POST['email'];
    $passwort = $_POST['pw'];
    $id = $_POST['id'];

    update($id, $vorname, $nachname, $email, $passwort);
    $pdo = closeSQL();

    echo "<h3>Eintrag updaten:</h3>";
    echoFormPreDefined($vorname, $nachname, $email, $passwort);

// DROP
}  elseif (isset($_GET['id'])) {

    $id = $_GET['id'];
    drop($id);
    $pdo = closeSQL();

    echo "<h3>Eintrag hinzufügen:</h3>";
    echoForm();

// Alles andere
} else {
    echo "<h3>Eintrag hinzufügen:</h3>";
    echoForm();
}

    echo "<h3>Bestehende Datenbank:</h3>";
    select();
    $pdo = closeSQL();


function initSQL() {
    return new PDO('mysql:host=localhost;dbname=test', 'root', 'test');
}

function closeSQL() {
    return null;
}

function select() {
    $conn = initSQL();
    $sql = "SELECT * FROM users";

    echo "<table class=\"table table-striped\">";
        echo "<tr>";
            echo "<th>Vorname</th>";
            echo "<th>Nachname</th>";
            echo "<th>E-Mail</th>";
            echo "<th>Passwort</th>";
            echo "<th>Bearbeiten</th>";
        echo "</tr>";
    foreach ($conn->query($sql) as $row) {
        $id = $row['id'];
        $email = $row['email'];
        $pw = $row['passwort'];
        $name = $row['vorname'];
        $lastname = $row['nachname'];

        echo "<tr>";
            echo "<td>".$name."</td>";
            echo "<td>".$lastname."</td>";
            echo "<td>".$email."</td>";
            echo "<td>".$pw."</td>";
            echo "<td><form action=\"database.php\" method=\"post\"><input type='submit' class='edit' name=''><img alt='edit' src='img/edit.svg' style='height: .8em; margin-right: .4em;'></form><img alt='del' src='img/trashcan.svg' style='height: .8em;' onclick='location.href=\"/Praktikum/database.php?id=".$id."\"'></td>";
        echo "</tr>";

    }
    echo "</table>";
}

function echoForm() {
    echo "<form action=\"database.php\" method=\"post\">
        <input class=\"form-control\" placeholder=\"Vorname\" type=\"text\" name=\"vname\" required=\"required\"/> <br>
        <input class=\"form-control\" placeholder=\"Nachname\" type=\"text\" name=\"nname\" required=\"required\"/> <br>
        <input class=\"form-control\" placeholder=\"E-Mail\" type=\"text\" name=\"email\" required=\"required\"/> <br>
        <input class=\"form-control\" placeholder=\"Passwort\" type=\"text\" name=\"pw\" required=\"required\"/> <br>
        <input type=\"submit\" class=\"btn btn-outline-primary\" name=\"insert\" value=\"Hinzufügen\" /> <br>
        </form>";
}

function echoFormPreDefined($vorname, $nachname, $email, $pw) {
    echo "<form action=\"database.php\" method=\"post\">
        <input class=\"form-control\" placeholder=\"Vorname\" value='$vorname' type=\"text\" name=\"vname\" required=\"required\"/> <br>
        <input class=\"form-control\" placeholder=\"Nachname\" value='$nachname' type=\"text\" name=\"nname\" required=\"required\"/> <br>
        <input class=\"form-control\" placeholder=\"E-Mail\" value='$email' type=\"text\" name=\"email\" required=\"required\"/> <br>
        <input class=\"form-control\" placeholder=\"Passwort\" value='$pw' type=\"text\" name=\"pw\" required=\"required\"/> <br>
        <input type=\"submit\" class=\"btn btn-outline-primary\" name=\"insert\" value=\"Updaten\" /> <br>
        </form>";
}

function insert($name, $lastname, $email, $pw) {
    try {
        $conn = initSQL();
        $sql = "INSERT INTO users (email, passwort, vorname, nachname) VALUES ('$email', '$pw', '$name', '$lastname')";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql);
        echo "<div class='infobox'>> New record created successfully</div>";

    } catch(PDOException $e) {

        echo $sql . "<br>" . $e->getMessage();

    }
}

function drop($id) {
    try {
        $conn = initSQL();
        $sql = "delete from users 
                where id = '$id'
                limit 1";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql);
        echo "<div class='infobox'>> Record dropped successfully</div>";
    } catch(PDOException $e) {
        echo "<div class='errorbox'>> An error occured: <br>".$sql . "<br>" . $e->getMessage()."</div>";
    }
}

function update($id, $name, $lastname, $email, $pw) {
    try {
        $conn = initSQL();
        $sql = "UPDATE users
                SET email = '$email', passwort = '$pw', vorname = $name, nachname = $lastname
                WHERE id = '$id'";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql);
        echo "<div class='infobox'>> New record created successfully</div>";

    } catch(PDOException $e) {
        echo "<div class='errorbox'>> An error occured: <br>".$sql . "<br>" . $e->getMessage()."</div>";
    }
}

?>

<script>

    function sendData(){
        //get the input value
        let $someInput = $('#someInput').val();
        $.ajax({
            //the url to send the data to
            url: "ajax/url.ajax.php",
            //the data to send to
            data: {someInput : $someInput},
            //type. for eg: GET, POST
            type: "POST",
            //datatype expected to get in reply form server
            dataType: "json",
            //on success
            success: function(data){
                //do something after something is recieved from php
            },
            //on error
            error: function(){
                //bad request
            }
        });
    }

</script>
