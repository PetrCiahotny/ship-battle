<?php
/*
 * Copyright (c) 2025.
 * Petr Ciahotný
 */

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
        if(GameBase::getParamByKey(0) == 'user') {
            if (self::isPost()) {
                switch (GameBase::getParamByKey(1)) {
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
                if (GameBase::getParamByKey(1) == 'logout') {
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
        self::reload();
        die();
    }

    public function render() : void
    {
        if(!self::isPost() || !$this->logged()){
            ?>
            <div>
                <form method="post" class="cover">
                    <h2><?= GameBase::getParamByKey(1) == 'login' ?  'přihlášení' : 'registrace' ?></h2>
                    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>" id="name" />
                    <input type="password" name="password" value="" id="password" />
                    <button name="action" value="login-button" type="submit">přihlásit se</button>
                </form>
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

    public function getUserLinks() : void
    {
        if(Player::$instance->logged()){ ?>
                <div><span>uživatel: <?= $_SESSION['user'] ?></span> <a href="<?= GameBase::getLinkUrl('/user/logout') ?>">odhlásit</a></div>
        <?php } else{ ?>
            <div><a href="<?= GameBase::getLinkUrl("/user/login") ?>">přihlášení</a> / <a href="<?= GameBase::getLinkUrl("/user/register") ?>">registrace</a> </div>
        <?php }
    }

    protected function login()
    {
        try {
            $name = htmlentities($_POST['name'], ENT_QUOTES|ENT_SUBSTITUTE);
                if (mb_strlen($name) > 0) {
                    $password = htmlentities($_POST['password'], ENT_QUOTES|ENT_SUBSTITUTE);
                    if (mb_strlen($password) > 0) {
                        $password = $this->getPasswordHash($password, $name);
                        $res = DB::select("SELECT * FROM lode.uzivatele WHERE jmeno = :jmeno AND heslo = :heslo", [
                                'jmeno' => $name,
                                'heslo' => $password
                        ]);
                        if (count($res) == 1) {
                            $_SESSION['user'] = $res[0]['jmeno'];
                            $_SESSION['id'] = $res[0]['id'];
                            //self::reload();
                            //die();
                        }
                    }
                }
            if (!$this->logged()) {
                $this->addMessage('neplatné heslo nebo uživatel', MessageLevel::ERROR);
            }else{
                $this->addMessage('jste přihlášen', MessageLevel::SUCCESS);
            }
        } catch (Throwable $ex) {
            echo $ex->getMessage();
        }
    }
}






