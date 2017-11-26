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
  bibliografia TEXT,
  curso_id     INT,
  PRIMARY KEY (id),
  FOREIGN KEY (curso_id) REFERENCES curso (id)
);