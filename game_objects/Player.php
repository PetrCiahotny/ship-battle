<?php
class Player extends GameBase
{
    protected static ?Player $instance = null;

    public function logged(): bool
    {
        return isset($_SESSION['id']) && $_SESSION['id'] > 0;
    }

    protected function getPasswordHash($password, $user){
        return md5('LODE:'.$password.'123'.$user);
    }

    public function init() : void
    {
        if(GameBase::getRouteAtIndex(0) == 'user') {
            if (self::isPost()) {
                switch (GameBase::getRouteAtIndex(1)) {
                    case 'login':
                        $this->login();
                        break;
                    case 'register':
                        break;
                    case 'logout':
                        $this->logout();
                        break;
                }
            } else {
                if (GameBase::getRouteAtIndex(1) == 'logout') {
                    $this->logout();
                }
            }
        }
    }

    protected function logout() : void{
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
        header("Location: {$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}?route=user/just-logged-out");
        die();
    }

    public function render() : void
    {
        if(GameBase::getRouteAtIndex(1) == 'just-logged-out'){ ?>
                <div>právě jste byl odhlášen</div>
            <?php
            return;
        }
        if(!self::isPost() || !$this->logged()){ ?>
            <div>
                <form method="post" class="cover">
                    <h2><?= GameBase::getRouteAtIndex(1) == 'login' ?  'přihlášení' : 'registrace' ?></h2>
                    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>" id="name" />
                    <input type="password" name="password" value="" id="password" />
                    <input name="action" value="přihlásit se" type="submit"/>
                </form>

                <?php /*include_once ($_SERVER["DOCUMENT_ROOT"] . "/components/login.php") */ ?>
            </div>
        <?php }else{ ?>

        <?php }
    }

    public static function getInstance() : self
    {
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }
/*
    public function info(): void
    {
        if (Player::$instance->logged()) { ?>
            <div><a href="#">uživatel <?= $_SESSION['user'] ?></a> <a
                        href="<?= Game::getInstance()->getRouteLink('/user/logout') ?>">odhlásit</a></div>
        <?php } else { ?>
            <div><a href="<?= Game::getInstance()->getRouteLink("/user/login") ?>">přihlášení</a> / <a
                        href="<?= Game::getInstance()->getRouteLink("/user/register") ?>">registrace</a></div>
        <?php }
    }
*/
    public function getUserLinks() : void
    {
        if(Player::$instance->logged()){ ?>
                <div><a href="#">uživatel <?= $_SESSION['user'] ?></a> <a href="<?= GameBase::getRouteLink('/user/logout') ?>">odhlásit</a></div>
        <?php } else{ ?>
            <div><a href="<?= GameBase::getRouteLink("/user/login") ?>">přihlášení</a> / <a href="<?= GameBase::getRouteLink("/user/register") ?>">registrace</a> </div>
        <?php }
    }

    protected function login()
    {
        try {
                $name = htmlentities($_POST['name'], ENT_QUOTES|ENT_SUBSTITUTE);
                if (strlen($name) > 0) {
                    $password = htmlentities($_POST['password'], ENT_QUOTES|ENT_SUBSTITUTE);
                    if (strlen($password) > 0) {
                        $password = $this->getPasswordHash($password, $name);
                        $res = DB::select("SELECT * FROM lode.uzivatele WHERE jmeno = :jmeno AND heslo = :heslo", [
                                'jmeno' => $name,
                                'heslo' => $password
                        ]);
                        if (count($res) == 1) {
                            $_SESSION['user'] = $res[0]['jmeno'];
                            $_SESSION['id'] = $res[0]['id'];
                            header("Location: {$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}");
                            die();
                        }
                    }
                }
            if (!$this->logged()) {
                $this->addMessage('neplatné heslo nebo uživatel', MessageLevel::ERROR);
            }
        } catch (Throwable $ex) {

        }
    }
}






