# Jak zprovoznit #

## pomoci GITu ## 
nutný nainstalovaný git, případně použit integrovaný Git ve VS 
1. vytvořit adresář (stane se z něj repozitář GITu), Pokud se bude spuštět v XAMPu, tak v podadresáří `C:\xampp\htdocs`
1. naklonovat zdrojové kódy - spustit příkaz v příkazové řádce v adresáři
    `git clone https://github.com/PetrCiahotny/ship-battle.git .`
2. v adresáři se objeví zdrojové kódy a adresář `.git` - zdresář se považuje za repozitář GITu 
2. doporučuji vytvořit si vytvořit větev GITU - pracovní zdrojové kódy bez změny v hlavní větvi (master, nebo main).
Větev pro větev pojmenovanou moje_testy  lze vytvořit pomocí příkazu v repozitáři  
`git checkout -b moje_testy`  
...

## spuštění kontejneru Dockeru ##
`docker-compose up`

## spuštění pomocí XAMPu ##
musí se vytvořit databáze, tabulky a data
v souboru dump/dump.sql jsou kompletní příkazy, stačí celý obsah nakopírovat do příkazového okna PHHMyAdmin a spustit



 
