<?php
enum BoardCellState : string{
    case WATER = "WATER";
    case CHECKBOX = "CHECKBOX";
    case SHIP = "SHIP";
    case DESTROYED = "DESTROYED";
    case UNKNOWN = "UNKNOWN";
    case WATER_HIT  = "WATER_HIT";
}

class Board extends GameBase
{
    protected static ?Board $instance = null;

    //protected array $startupJS = [];

    public static function getInstance(): Board
    {
        if(self::$instance == null){
            self::$instance = new Board();
        }
        return self::$instance;
    }

    protected function __construct(){
        parent::__construct();
    }

    public function init(): void
    {
        $state = Game::getInstance()->getCurrentState();
        switch ($state) {
            case GameState::ACCEPTED:
                $this->addMessage('rozmístěte 5 lodí a klikněte na hotovo', MessageLevel::SUCCESS);
                break;
            case GameState::POSITIONED:
                $this->addMessage('čekám, až rozmístí soupeř', MessageLevel::INFO);
                break;
        }
    }

    protected function renderBoard(bool $opponent): void{
        $celCount = pow(Game::getInstance()->gridCellCount, 2);
        $currGame = Game::getInstance()->getCurrentGame();
        $state = Game::getInstance()->getCurrentState();

        $ships = json_decode($currGame[$opponent ? 'opponent_map' : 'my_map'] ?? "[]", true);

        ?> <div class="board <?= $opponent ? 'opponentBoard' : 'myBoard' ?> <?= $state->value ?>">
            <div class="shipGrid">
            <?php
            for ($i = 0; $i < $celCount; $i++) {
                $classes = [];
                if($opponent){
                    switch($state) {
                        case GameState::ACCEPTED:
                            $classes[] = BoardCellState::CHECKBOX->value;
                            break;
                        case GameState::POSITIONED:
                        case GameState::OPPONENT_POSITIONED:
                        case GameState::MY_TURN:
                        case GameState::OPPONENT_TURN:
                        case GameState::WIN:
                        case GameState::DEFEAT:
                            if(in_array($i, $currGame['my_hits'])){
                                $classes[] = BoardCellState::SHIP->value;
                                $classes[] = 'destroyed';
                            }else{
                                if(in_array($i, $currGame['my_shots'] ?? [])){
                                    $classes[] = BoardCellState::WATER_HIT->value;
                                }else{
                                    $classes[] = BoardCellState::UNKNOWN->value;
                                }
                            }
                            break;
                    }

                }else{
                    switch($state){
                        case GameState::ACCEPTED:
                            $classes[] = BoardCellState::CHECKBOX->value;
                            break;
                        case GameState::POSITIONED:
                        case GameState::OPPONENT_POSITIONED:
                        case GameState::OPPONENT_TURN:
                        case GameState::MY_TURN:
                        case GameState::WIN:
                        case GameState::DEFEAT:
                            if(in_array($i, $currGame['opponent_hits'])){
                                $classes[] = BoardCellState::SHIP->value;
                                $classes[] = 'destroyed';
                            }else{
                                if(in_array($i, $currGame['opponent_shots'])){
                                    $classes[] = BoardCellState::WATER_HIT->value;
                                }else{
                                    $classes[] = in_array($i, $ships ?? []) ? BoardCellState::SHIP->value : BoardCellState::WATER->value;
                                }
                            }
                            break;
                    }
                }
                if(count($classes) == 0){
                    $classes[] = BoardCellState::UNKNOWN->value;
                }
                ?>
                <div  data-field="<?= $i ?>" class="field <?= join(' ', $classes) ?>">
                    <?php if($state == GameState::ACCEPTED){ ?>
                            <label class="field-label">
                                <input type="checkbox" name="ship-board[]"  value="<?= $i ?>" class="shipCheck" />
                            </label>
                    <?php } ?>
                </div> <?php
            } ?>
            </div>
            <?php
            if($opponent && $state == GameState::MY_TURN){ ?>
                <input id='shot-input'  type="hidden" name='no-action' value=""/>
            <?php  } ?>
        </div> <?php
    }


    public function render(): void
    {
        $state = Game::getInstance()->getCurrentState();
        if(Game::getInstance()->getCurrentGame() != null){
            /*
            if($state == GameState::MY_TURN){
                $this->startupJS[] = "prepareShot()";
            }*/
             ?>
                <div class="grids">
            <?php
                switch ($state){
                    case GameState::ACCEPTED:
                        $this->renderBoard(false);
                        break;
                    case GameState::POSITIONED:
                        $this->renderBoard(false);

                        break;
                    case GameState::MY_TURN:
                    case GameState::OPPONENT_TURN:
                    case GameState::WIN:
                    case GameState::DEFEAT:
                        $this->renderBoard(false);
                        $this->renderBoard(true);
                        break;
                    case GameState::NONE: ?>
                            <div>NONE</div>
                        <?php
                        break;
                }
            ?>
                </div>
            <script>
                <?php if($state == GameState::MY_TURN){ ?>
                    document.addEventListener("DOMContentLoaded", prepareShot());
                <?php } ?>
            </script>
        <?php }

    }
}