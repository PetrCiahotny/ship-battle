<?php
    include_once "../Db.php";
    include_once "../consts.php";

    $logged = false;
    $message = '';
    function getPasswordHash($password, $user){
        return md5('LODE:'.$password.'123'.$user);
    }
    function login()
    {
        $name = $_POST['name'];
        $localLogged = false;
        if (strlen($name) > 0) {
            $password = $_POST['password'];
            if (strlen($password) > 0) {
                $password = getPasswordHash($password, $name);
                $res = DB::select("SELECT * FROM lode.uzivatele WHERE jmeno = :jmeno AND heslo = :heslo", [
                    'jmeno' => $name,
                    'heslo' => $password
                ]);
                if (count($res) == 1) {
                    $_SESSION['user'] = $res[0]['jmeno'];
                    $_SESSION['id'] = $res[0]['id'];
                    $localLogged = true;
                }
            }
        }
        return $localLogged;
    }

    $is_post = $_SERVER["REQUEST_METHOD"] == "POST";
    if($is_post) {
        $logged = login();
        if(!$logged) {
            $message = 'Neplatné přihlášení jako ';
        }
    }

?>
<!DOCTYPE html>
<html>
    <?php  include_once "../components/head.php"; ?>
    <body>
        <?php  include_once "../components/header.php"; ?>
        <?php
            if(strlen($message) > 0){ ?>
                <div><?= $message ?></div>
            <?php }
            if(!$logged){
                include_once "../components/login.php";
            }else{ ?>
                <div>Jste přihlášen jako <?= $_SESSION['user'] ?></div>
            <?php }
         ?>
    </body>
</html>
