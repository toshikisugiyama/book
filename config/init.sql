create database book_db;

grant all on book_db.* to dbuser@localhost identified by '1234';

create table users (
  id int not null auto_increment primary key,
  name varchar(255),
  image text(255),
  email varchar(255) unique,
  password varchar(255),
  del_flg tinyint(1) not null default 0,
  create_date datetime not null,
  update_date datetime
);

create table books (
  id int not null auto_increment primary key,
  title varchar(255) not null,
  reason varchar(255) not null,
  image varchar(255) not null,
  del_flg tinyint(1) not null default 0,
  create_date datetime not null,
  update_date datetime
);