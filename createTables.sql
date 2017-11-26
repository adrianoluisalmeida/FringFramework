CREATE TABLE curso (
  id              INTEGER AUTO_INCREMENT,
  nome            VARCHAR(100),
  semestres       TINYINT,
  departamento    TEXT,
  vagas           TINYINT,
  apresentacao    TEXT,
  PRIMARY KEY (id)
);

CREATE TABLE disciplina (
  id           INT AUTO_INCREMENT,
  nome         VARCHAR(50),
  codigo       VARCHAR(20),
  objetivos    TEXT,
  programa     TEXT,
  curso_id     INT,
  PRIMARY KEY (id),
  FOREIGN KEY (curso_id) REFERENCES curso (id)
);



ALTER DATABASE gbd CHARSET = UTF8 COLLATE = utf8_general_ci;

select * from disciplina;
insert into curso values (3, "Administração III", 8, "Sociais e Humanas", 44, "O curso ADMINISTRAÇÃO");


drop table curso;


