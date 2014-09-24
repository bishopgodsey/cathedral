create table marriage(
    marriage_id int not null primary key auto_increment,
    num_marriage varchar(24) not null,
    date_marriage date not null,
    nom_celebrant varchar(128),
    prenom_celebrant varchar(128),
    diocese_id int not null,
    parroisse_id int not null,
    lieu_celebration_id int default NULL,
    conjoint_id int DEFAULT NULL,
    conjointe_id int default NULL,
    parrain_id INT DEFAULT NULL,
    marraine_id INT DEFAULT NULL,
    no_catholique_conjoint_id int DEFAULT NULL,
    no_catholique_conjointe_id int default NULL,
    no_catholique_parrain_id INT DEFAULT NULL,
    no_catholique_marraine_id INT DEFAULT NULL,
    created_on datetime NOT NULL,
    created_by INT NOT NULL,
    modified_on datetime DEFAULT NULL,
    modified_by DATETIME DEFAULT NULL
    
);
