

## Základní příkazy GITu: ## 

`git init`
vytvoří repozitář

`git status`  
zobrazí stav souborů v repozitáři

`git add <soubor>`  
přidá soubor ke sledování/commitu

`git add --all'    
`git add -A`        
přidá všechny soubory v repozitáři ke sledování/commitu

`git restore --staged <soubor>`  
odstraní soubor ze seznamu souborů pro commit

`git commit -m 'popis změn'`
commit (uložení změn) v aktální větvi

`git checkout -b VETEV`  
Vytvoří novou větev

`git checkout VETEV`  
přepnutí se do požadované větve

`git merge VETEV`
sloučení VETVE do aktuální větve

`# komentar` - komentář

## Vlatnictví repozitáře

`git config user.name`  
zobrazí jméno vlastníka repozitáře  
`git config --global user.name`  
zobrazí jméno globálního vlastníka repozitářů


`git config user.email`   
zobrazí email vlastníka repozitáře  
`git config --global user.name`  
zobrazí email globalniho vlastníka repozitářů

`git config user.name "JMENO"`  
nastaví jméno vlastníka repozitáře

`git config user.name "EMAIL"`  
nastaví email vlastníka repozitáře


## Práce se vzdáleným repozitářem

`git remote -v`  
zobrazení seznamu vzdáleného repozitáře

`git remote add "origin" git@github.com:Uziv/Repo.git`  
přidání adresy a jména vzdáleného repozitáře do lokálního repozitáře

`git remote set-url "origin" git@github.com:User/UserRepo.git`  
změna adresy vzdáleného repozitáře v lokálním repozitáři

`git push origin <vetev>`  
nahrání větve <vetev> na vzdálený repozitář


## GitIgnore

soubor .gitignore
syntaxe:
`adresar/` - ignoruje adresar
`*.txt` - ignoruje textové soubory
`!readme.md`  kromě readme.md







