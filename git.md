## Základní příkazy GITu: ## 

Git je v informatice distribuovaný systém správy verzí vytvořený Linusem Torvaldsem pro vývoj jádra Linuxu

GIT repozitář je adresář, v kterém se vytvoří adresář `.git` pomocí příkazu `git init`.  
Příkazy GIT mají většinou v sobě integrovány programovací editory, kde jsou příkazy dostupné 
pomocí GUI (graphic user interface) - tlačítka, menu atd.  

V repozitáři GITU je jedna hlavní větev (master, main), ve které by měl být čistý, otestovaný kód - poslední 
zveřejněná verze.

Soubory v repozitáři mohou nabývat různé stavy:
- Sledované soubory (Staged) - u souborů se sledují změny
- Nesledované soubory (Untracked) - u souborů se nesledují změny
- Sledované soubory označené pro commit

Stav souuborů lze zjistit příkazem `git status`

Změny v souborech lze natrvalo uložit v historii aktuální větve pomocí příkazu commit  - commity v historii
už nelze měnit - mají přidělený hash, a stávají se trvalou historii větve

Označit soubor pro commit a sledování lze příkazem `git add NAZEV_SOUBORU`
Označit všechny soubory pro commit a sledování lze příkazem `git add .`



Vývoj se provádí na vývojové větvi vytvořené pomocí příkazu `git switch -c vyvoj` - vytvoří větev "vyvoj" 
a přepne se do ní.
Přepínat mezi větvemi lze příkazem `git switch NAZEV_VETVE`
Větví se může vytvořit více a přepinat se mezi něma. 
Pokud se ale ve větvích upravují stejné soubory, tak při spojování větví může nastat konflikt, 
kerý se musí řešit ručně.
Doporučuji na začátek mí jen jednu hlavní a jednu pracovní větev

Seznam větví lze zobrazit příkazem `git branch`



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

Každý lokální repozitář by měl mít v konfiguraci zadáno jméno a email - informace se zapisují do historie commitů 

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


## GitIgnore ##
Soubor, který umožňuje ignorovat soubory, nebo adresáře v repozitáři. 
Například adresář .vscode, kde je konfigurace 
Visual Studia Code - každý programátor může mít nastavení VSCode jiné.  

soubor .gitignore
syntaxe:
`adresar/` - ignoruje adresar
`*.txt` - ignoruje textové soubory
`!readme.md`  kromě readme.md







