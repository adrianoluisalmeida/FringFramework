# TRABALHO PRÁTICO PROJETO E GERÊNCIA DE BANCO DE DADOS 

##Objetivo
  Criar uma aplicação que consiga comunicar-se com dois SGBDs diferentes, onde um seja relacional e outro orientado a documento.
  
##Solução
Pensando nesse problemática, surgiu o
**Busca DCG** 
*O portal que facilita suas escolhas de Disciplinas Complementares e te aproxima da sua área de Interesse.*

##Desenvolvimento

* Linguagem php 5.6
* psql (PostgreSQL) 9.6.6
* Mysql  Ver 14.14 Distrib 5.7.19
* MongoDB shell version v3.4.10
* Bibliotecas utilizadas: PDO php, MongoClient php, Twig Flexible Templates (Fring Framework)

## Tabelas

No arquivo createTables.sql está os scripts para a criação das taelas do banco **gbd** no mysql. No postgresql basta alterar os campos primary key (id) para serial e os tinyint para smallint ou int. No caso do mongo nenhuma criação é necessária, as coleções são geradas automáticamente no ato do cadastro.

## Instalação

Para instalar é necessário instalar as bibliotecas:

* php5.6
* apache2 e habilitar  ( a2enmod rewrite )
* php5.6
* php5.6-mongo
* php5.6-pgsql
* php5.6-mysql 
* habilitar extension=pdo.so e extension=pdo_mysql.so no php.ini


Após instalar todas as dependências é só abrir o projeto no navegador local:
exemplo: http://localhost/gbd

## Configurações de Banco
Para configurar os bancos, basta ir no arquivo: app/config/database.php e setar as suas configurações.

## Desenvolvido por:
   
Adriano Luis de Almeida (https://github.com/adrianoluisalmeida)
   
Joel Ferreira da Silva (https://github.com/Joel054)
   
