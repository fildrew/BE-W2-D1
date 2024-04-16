<?php
    include('connect.php');
    $success = 0;
    $userExists = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

          // Check if the username already exists
        $sqlSelect = "SELECT * FROM registration WHERE username = '$username'";
        $stmtSelect = $pdo->prepare($sqlSelect);
        $stmtSelect->execute(['username' => $username]);
        $numRows = $stmtSelect->rowCount();
        if ($numRows > 0) {
            $userExists = 1;
        } else {
             // Insert new user if username does not exist
            $sqlInsert= "INSERT INTO registration (username, password) VALUES ('$username','$password')";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute(['username' => $username, 'password' => $password]);
            $success = 1;
        }
    }
?>

<!-- 

$user = [];
$user['username'] = $_POST['username'] ?? '';
$user['password'] = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
    $stmt = $pdo->prepare("
        SELECT * FROM users
        WHERE username = :username;
    ");

    $stmt->execute([
        'username' => $_POST['username'],
    ]);

    $user_from_db = $stmt->fetch();

    // verificare che c'è una riga risultante
    if ($user_from_db) {
        // confrontare gli hash
        if (password_verify($_POST['password'], $user_from_db["password"])) {
            // se gli hash coincidono => utente loggato, altrimenti errore
            $_SESSION['user_id'] = $user_from_db['id'];
            echo ('Ciao ' . $user_from_db["username"]);
            // header('Location: /IFOA0124/S2L1-cose-di-php/1-login/index.php'); exit;
        };
    }

    // popolare l'array degli errori
    $errors['credentials'] = 'Credenziali non valide';
 -->










<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
    <?php
        if ($userExists) {
            echo '<div class="alert alert-danger alert-dimissible fade show" role="alert"><strong>User already exists!.</strong>You should check in on some of those fields below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    ?>    
    <?php
        if ($success) {
            echo '<div class="alert alert-success alert-dimissible fade show" role="alert"><strong>Success!.</strong>You are succesfully signed up.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    ?>  
        <h1  class="text-center">Signup</h1>
        <div class="container mt-5">
            <form action="sign.php" method="POST">
                <div class="form-group mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="Enter your username" name="username">
                    
                <div class="form-group mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control"placeholder="Enter your password" name="password">
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>