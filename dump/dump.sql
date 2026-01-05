CREATE DATABASE IF NOT EXISTS lode DEFAULT CHARACTER SET utf8mb4  ;
USE lode;

DROP TABLE IF EXISTS uzivatele;
CREATE TABLE lode.uzivatele (
                             id int NOT NULL AUTO_INCREMENT,
                             jmeno varchar(50) NOT NULL,
                             heslo varchar(36) CHARACTER SET utf8mb4   NOT NULL,
                             PRIMARY KEY (id),
                             UNIQUE KEY jmeno_uniq (jmeno)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- heslo heslo
INSERT into lode.uzivatele (jmeno, heslo) VALUES ('uziv1', '97dfa7efb6f037e54910bb2c69f61bc3');
INSERT into lode.uzivatele (jmeno, heslo) VALUES ('uziv2', '75247b485112695716c1355153b14bb7');
INSERT into lode.uzivatele (jmeno, heslo) VALUES ('uziv3', 'b399d2a55a0b8fae323091630be2cfb4');

CREATE TABLE lode.bitvy (
                       id int NOT NULL AUTO_INCREMENT,
                       uzivatel1 int NOT NULL,
                       uzivatel2 int default 0,
                       velikost_hry int NOT NULL,
                       mapa1 text CHARACTER SET utf8mb4   NOT NULL,
                       mapa2 text CHARACTER SET utf8mb4   NOT NULL,
                       vitez int DEFAULT 0,
                       cas_start datetime NOT NULL,
                       PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE lode.tahy (
                      id int NOT NULL AUTO_INCREMENT,
                      id_hry int NOT NULL,
                      uzivatel int NOT NULL,
                      souradnice int NOT NULL,
                      zasah tinyint NOT NULL,
                      cas datetime NOT NULL,
                      PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

