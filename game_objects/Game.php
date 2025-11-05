<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/game_objects/GameBase.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Db.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/game_objects/Logger.php";

enum GameState: string
{
    /** Nenastaveno */
    case NOT_SET = "NOT_SET";
    /** Žádná hra */
    case NONE = "NONE";
    /** Hra vytvořena */
    case CREATED = "CREATED";
    /** Připojení druhého hráče */
    case ACCEPTED = "ACCEPTED";
    /** Mám rozmístěné lodě */
    case POSITIONED = "POSITIONED";
    /** Soupeř má rozmístěné lodě */
    case OPPONENT_POSITIONED = "OPPONENT POSITIONED";
    /** Hra začala */
    case STARTED = "STARTED";

    case MY_TURN = "MY_TURN";
    case OPPONENT_TURN = "OPPONENT_TURN";
    case WIN = "WIN";
    case DEFEAT = "DEFEAT";

    public function toString() :string
    {
        return $this->value;
    }
}

class Game extends GameBase
{
    protected static ?Game $instance = null;
    protected static ?string $root = null;

    protected int $historyId = -1;
/*
    protected array $routes = [] {
        get {
            return $this->routes;
        }
    }
*/

    protected GameState $State = GameState::NOT_SET;
/*
    public function getState(): GameState
    {
        return $this->State;
    }
*/
    protected ?array $currentGame = null;
    protected string $playerColumnName = '';
//    protected string $opponentColumnName = '';
//    protected array $positions = [];

    /** @var string nazev sloupce s mapou  */
    protected string $mapColumnName = '';
    //protected string $opponentMapColumnName = '';

    /** @var string getter nazvu sloupce s mapou  */
    public function getMapColumnName(): string
    {
        return $this->mapColumnName;
    }
/*
    public function getPlayerColumnName(): string
    {
        return $this->playerColumnName;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }
*/

    public int $gridCellCount = 10 {
        get {
            return $this->gridCellCount;
        }
    }
    public string $cellSize = '3.5vw' {
        get {
            return $this->cellSize;
        }
    }

    public function resetCurrentState(): void{
        $this->State = GameState::NOT_SET;
    }

    public function getCurrentState(): GameState
    {
        if($this->State == GameState::NOT_SET) {
            $this->State = GameState::NONE;
            if (Player::getInstance()->logged()) {
                $currGame = $this->getCurrentGame();
                $myIndex = 0;
                $opponentIndex = 0;
                if (count($currGame) > 0) {
                    if ($currGame['uzivatel1'] == $_SESSION['id']) {
                        $myIndex = 1;
                    } else {
                        if ($currGame['uzivatel2'] == $_SESSION['id']) {
                            $myIndex = 2;
                        }
                    }
                    $opponentIndex = $myIndex == 1 ? 2 : 1;

                    if ($currGame['vitez'] > 0) {
                        if ($currGame['vitez'] == $_SESSION['id']) {
                            $this->State = GameState::WIN;
                        } else {
                            $this->State = GameState::DEFEAT;
                        }
                    }else {

                        if ($currGame["uzivatel{$opponentIndex}"] > 0) {
                            $this->State = GameState::ACCEPTED;
                            if (strlen($currGame["my_map"])) {
                                $this->State = GameState::POSITIONED;
                                if (strlen($currGame["opponent_map"]) > 0) {
                                    $this->State = GameState::STARTED;
                                    $turns = DB::select("SELECT * FROM lode.tahy WHERE id_hry = :id_hry ORDER BY id", ["id_hry" => $currGame["id"]]);
                                    $turnCount = count($turns);
                                    if ($turnCount > 0) {
                                        if (count($currGame['opponent_hits']) == 5) {
                                            $this->State = GameState::DEFEAT;
                                        } else {
                                            if (count($currGame['my_hits']) == 5) {
                                                $this->State = GameState::WIN;
                                            } else {
                                                $this->State = $turns[$turnCount - 1]['uzivatel'] == $_SESSION['id'] ? GameState::OPPONENT_TURN : GameState::MY_TURN;
                                            }
                                        }
                                    } else {
                                        if ($myIndex == 1) {
                                            $this->State = GameState::MY_TURN;
                                        } else {
                                            $this->State = GameState::OPPONENT_TURN;
                                        }
                                    }
                                }
                            }
                        } else {
                            $this->State = GameState::CREATED;
                        }
                    }
                }
            }
        }
        Logger::log("return...{$this->State->value}");
        return $this->State;
        //echo print_r($currGane, true);
    }


    public function init(): void
    {
        if (Player::getInstance()->logged()) {
            $currGame = $this->getCurrentGame();
            if (GameBase::getRouteAtIndex(0) == 'game') {
                switch (GameBase::getRouteAtIndex(1)) {
                    case 'action':  
                        $action = $_POST['action'];
                        $postId = -1;
                        
                        if(strpos($action, '@')  !== false){
                            $temp = explode('@', $action);
                            $action = $temp[0];
                            $postId = intval($temp[1]);
                        }
                        switch($action){
                            case 'create-game':
                                if ($this->getCurrentGame() == null) {
                                    Db::query("INSERT INTO lode.bitvy (uzivatel1, velikost_hry, cas_start, mapa1, mapa2)
                                        VALUES ({$_SESSION["id"]}, 10, NOW(), '', '')");
                                    $this->resetCurrentGame();
                                } else {
                                    $this->addMessage('nelze založit další hru', MessageLevel::INFO);
                                }
                                self::reload();
                                break;
                            case 'cancel-game':
                                $id = $currGame['id'];
                                DB::query("UPDATE lode.bitvy SET vitez = -1 WHERE id= :id AND uzivatel1 = :user AND uzivatel2 = 0",
                                        ["id" => $id, "user" => $_SESSION["id"]]);
                                Game::getInstance()->resetCurrentGame();
                                self::reload();
                                break;                                
                            case 'join-game':
                                $id = $postId;
                                Db::query("UPDATE lode.bitvy SET uzivatel2 = {$_SESSION['id']} 
                                    WHERE id= :id AND uzivatel2 = 0", ["id" => $id]);
                                DB::query("UPDATE lode.bitvy SET vitez = -10 WHERE uzivatel1 = :me AND uzivatel2 = 0 AND vitez = 0", ["me" => $_SESSION["id"]]);
                                Game::getInstance()->resetCurrentGame();
                                self::reload();
                                break;
                            case 'position-set':      
                                                      
                                $positions = $_POST['ship-board'] ?? [];                                
                                if (is_array($positions)) {
                                    if (count($positions) == 5) {
                                        $positionsInt = [];
                                        //prevod POST stringu na int
                                        foreach ($positions as $pos) {
                                            $positionsInt[] = intval($pos);
                                        }
                                        $posJoined = json_encode($positionsInt);
                                        Db::query("UPDATE lode.bitvy SET {$this->getMapColumnName()} = '{$posJoined}' WHERE id = {$currGame['id']}");
                                        $this->resetCurrentGame();
                                        $this->addMessage("Pozice nastaveny", MessageLevel::SUCCESS);
                                        self::reload();
                                    } else {
                                        $this->addMessage("Počet lodí musí být 5", MessageLevel::ERROR);
                                    }
                                }                                
                                break;
                            case 'shot':
                                if($postId > -1){
                                    $oppMap = json_decode($currGame['opponent_map']) ?? [];
                                    $hit = in_array($postId, $oppMap) ? 1 : 0;
                                    Db::query("INSERT INTO lode.tahy (id_hry, uzivatel, zasah, souradnice, cas) 
                                            VALUES (:id_hry, :uzivatel, :zasah, :souradnice, NOW())",
                                            ['id_hry'=>$currGame['id'], 'uzivatel'=>$_SESSION['id'],
                                                    'zasah'=>$hit, 'souradnice'=>$postId]);
                                    $this->resetCurrentGame();
                                    $this->resetCurrentState();
                                    $currGame = $this->getCurrentGame();
                                    $vitez = -1;
                                    if(count($currGame['my_hits']) == 5){
                                        $vitez = $_SESSION['id'];
                                    }else{
                                        if(count($currGame['opponent_hits']) == 5){
                                            $vitez = $currGame['opponent_id'];
                                        }
                                    }
                                    if($vitez > 0){
                                        DB::query("UPDATE lode.bitvy SET vitez = :vitez WHERE id = :game_id",
                                                ['game_id'=>$currGame['id'],'vitez'=>$vitez]);
                                    }
                                }
                                self::reload();
                                break;
                            case 'close-resume':
                                if(isset($_SESSION['game'])){
                                    unset($_SESSION['game']);
                                }
                                self::reload();
                                break;
                            }
                            
                        break;
                    case 'show-game':
                        $id = GameBase::getRouteAtIndex(2) ?? -1;
                        if($id > 0){
                            $this->historyId = $id;
                        }
                        Game::getInstance()->resetCurrentGame();
                        break;
                    case 'give-up':
                        $id = GameBase::getRouteAtIndex(2);
                        $currGame = Game::getInstance()->getCurrentGame();
                        if ($currGame != null) {
                            Logger::log("give-up");
                            Logger::log($currGame);
                            Logger::log("konec give-up");
                            Db::query("UPDATE lode.bitvy SET vitez = :vitez
                            WHERE id= :id AND :user_id IN (uzivatel1, uzivatel2) AND vitez = 0",
                                    ["id" => $id, "user_id" => $_SESSION['id'], "vitez" => $currGame['opponent_id']]);
                            Game::getInstance()->resetCurrentGame();
                        }
                        break;
                }
            }
        }
        $this->resetCurrentState();
        $currState = $this->getCurrentState();
        $currGame = $this->getCurrentGame();
        switch ($currState){
            case GameState::NONE:
                break;
            case GameState::CREATED:
                $this->addMessage("čekám na soupeře", MessageLevel::INFO);
                
                break;
            case GameState::MY_TURN:
                $this->addMessage("jsem na tahu", MessageLevel::INFO);
                break;
            case GameState::OPPONENT_TURN:
                $this->addMessage("soupeř je na tahu", MessageLevel::INFO);
                break;
            case GameState::ACCEPTED:
                $this->addMessage("hra přijata", MessageLevel::INFO);
                $_SESSION['game'] = $currGame['id'];
                break;
            default:
                $this->addMessage("stav hry: ".$this->getCurrentState()->toString(), MessageLevel::INFO);
                break;
        }
        
        if($currGame && intval($currGame['opponent_id']) > 0){
            $this->addMessage('soupeř: '.$currGame['opponent'], MessageLevel::SUCCESS);
        }
        //$this->addMessage($currState->value.' *** '.($_SESSION['game'] ?? -1), MessageLevel::SUCCESS);
    }

    protected function getAvailableGames(): array
    {
        $games = Db::select(
                "SELECT DISTINCT b.id, b.uzivatel1, b.uzivatel2, b.velikost_hry,
                    date_format(b.cas_start, '%d. %m. %Y %H:%i') start, u.jmeno as opponent, u.id as opponent_id
                    FROM lode.bitvy b
                    INNER JOIN lode.uzivatele u ON u.id = b.uzivatel1  
                    WHERE :user_id NOT IN (b.uzivatel1, b.uzivatel2) AND uzivatel2 = 0
                        AND b.vitez = 0", ['user_id' => $_SESSION['id']]);
        return $games;
    }


    public function resetCurrentGame(): void
    {
        $this->currentGame = null;
    }

    public function getCurrentGame(): array
    {
        $userId = $_SESSION['id'] ?? null;
        if ($userId === null) {
            return [];
        }
        if ($this->currentGame === null) {
            $params = ['user_id' => $userId];
            $params['id_hry'] = $_SESSION['game'] ??  $this->historyId;

            $currentGame = Db::select("SELECT b.*, DATE_FORMAT(cas_start, '%d.%m.%Y %H:%i:%s') start_cas_format, COALESCE(u.jmeno, '---') AS opponent, COALESCE(u.id, 0) opponent_id, 
	                    CASE WHEN uzivatel1 = :user_id THEN mapa1 ELSE mapa2 END as my_map,
                        CASE WHEN uzivatel1 = :user_id THEN mapa2 ELSE mapa1 END as opponent_map,
                        CASE WHEN uzivatel1 = :user_id THEN 1 ELSE 2 END as my_index
                    FROM lode.bitvy b 
                        LEFT OUTER JOIN lode.uzivatele u ON u.id IN (uzivatel1, uzivatel2) AND (u.id = 0 OR u.id <> :user_id)
                            WHERE :user_id IN (uzivatel1, uzivatel2) "
                                ." AND (b.id = :id_hry OR vitez = 0) "
                                ."LIMIT 1",
                    $params);

            if (count($currentGame) > 0) {
                $this->currentGame = $currentGame[0];
                if ($this->currentGame['uzivatel1'] == $_SESSION['id']) {
                    $this->mapColumnName = 'mapa1';
                    $this->playerColumnName = 'uzivatel1';
                } else {
                    if ($this->currentGame['uzivatel2'] == $_SESSION['id']) {
                        $this->mapColumnName = 'mapa2';
                        $this->playerColumnName = 'uzivatel2';
                    }
                }
                $turns = DB::select("SELECT * FROM lode.tahy WHERE id_hry = :id_hry ORDER BY id",
                        ["id_hry" => $this->currentGame['id']]);
                $this->currentGame['turns'] = $turns;

                $this->currentGame['my_hits'] = [];
                $this->currentGame['opponent_hits'] = [];

                $this->currentGame['my_shots'] = [];
                $this->currentGame['opponent_shots'] = [];

                foreach ($turns as $turn) {
                    if($turn['uzivatel'] == $_SESSION['id']){
                        $this->currentGame['my_shots'][] = $turn['souradnice'];
                        if($turn['zasah'] == 1){
                            $this->currentGame['my_hits'][] = $turn['souradnice'];
                        }
                    }else{
                        $this->currentGame['opponent_shots'][] = $turn['souradnice'];
                        if($turn['zasah'] == 1){
                            $this->currentGame['opponent_hits'][] = $turn['souradnice'];
                        }
                    }
                }
            } else {
                $this->currentGame = [];
            }
        }
        return $this->currentGame;
    }

    protected function inHistoryGame(): void{
        $game = $this->getCurrentGame();
        $stateClass = '';
        switch ($game['vitez']) {
            case $_SESSION['id']:
                $stateClass = 'green';
                break;
            case $game['opponent_id']:
                $stateClass = 'red';
                break;
        }
        ?>
            <div class="gameInfo" style="background-color: <?= $stateClass ?>">Hra z <?= $this->currentGame['start_cas_format'] ?>
                <?= $this->currentGame['vitez'] == $_SESSION['id'] ? 'Vítězství' : 'Prohra' ?> Protihráč: <?= $game['opponent'] ?> </div>
        <?php
    }


    public function renderForm() : void{
        $currentGame = $this->getCurrentGame();
        $state = $this->getCurrentState();
        $availGames = $this->getAvailableGames();
        ?>        
        <form enctype="application/x-www-form-urlencoded" method="post" action="<?= GameBase::getRouteLink("game/action") ?>">
        <?php
        switch($state){                      
            case GameState::NONE: ?>
                <button name="action" value="create-game">založit hru</button>
                <fieldset >
                    <legend>dostupné hry</legend>
                    <ul>
                    <?php
                        if(count($availGames) == 0){ ?>
                            <li>žádné hry pro připojení</li>
                        <?php } else {
                            foreach ($availGames as $game) { ?>
                                <li> [<?= $game['id'] ?>] <?= $game['opponent'] ?>
                                    <button type="submit" name="action" value="join-game@<?= $game['id'] ?>">
                                        hrát
                                    </button>
                                </li><?php 
                            }
                        } ?>
                    </ul>
                </fieldset>
                <div>
                    <a href="<?= GameBase::getRouteLink('history') ?>">historie</a>
                </div>
                <?php
                break;
            case GameState::CREATED: ?>
                <button name="action" value="cancel-game">zrušit hru</button>
                <?php
                break;
            case GameState::ACCEPTED:
                ?>
                <button name="action" value="position-set">hotovo</button>
                <?php
                break;
            case GameState::WIN:
            case GameState::DEFEAT:
                ?>
                <button name="action" value="close-resume">zavřít</button>
                <?php
                break;
        }
        Board::getInstance()->render();
        ?>
        </form>
        <?php
    }

    public function render(): void
    {
        if (Player::getInstance()->logged()) {            
            $currentGame = $this->getCurrentGame();
            $this->renderForm();
            if ($currentGame != null) {
                if($currentGame['vitez'] == 0){
                    
                    switch ($this->getCurrentState()) {
                        case GameState::CREATED:
                        case GameState::POSITIONED:
                        case GameState::OPPONENT_TURN:
                            ?>
                            <script> setTimeout(()=>{document.location.href = document.location.href}, 1000);</script>
                            <?php
                            break;
                    }
                }
            } 
        } else { ?>
            <div>nejste přihlášen</div>
        <?php }
    }
/*
    public function getRouteAtIndex(int $index): string
    {
        return $index < count($this->routes) ? $this->routes[$index] : '';
    }
*/
    protected function __construct()
    {
        parent::__construct();
        $this->State = GameState::NOT_SET;
        self::$root = $_SERVER["DOCUMENT_ROOT"];
        /*
        if (isset($_GET['route'])) {
            $parts = explode('?', $_GET['route'], 2);
            $this->routes = explode('/', trim($parts[0], "/"));
        } else {
            $this->routes = [];
        }*/
    }

    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new Game();
        }
        return self::$instance;
    }
/*
    public function getRouteLink(string $route): string
    {
        return "/index.php?route=" . $route;
    }
*/
    public function getRoot(): string
    {
        return self::$root;
    }


}

