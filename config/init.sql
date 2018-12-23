create database book_db;

grant all on book_db.* to dbuser@localhost identified by '1234';

create table users (
  id int not null auto_increment primary key,
  name varchar(255),
  profile_image text(255),
  email varchar(255) unique,
  password varchar(255),
  create_date datetime not null,
  update_date datetime
);

create table books (
  id int not null auto_increment primary key,
  title varchar(255) not null,
  reason varchar(255) not null,
  image varchar(255) not null,
  contributor_id int not null,
  create_date datetime not null,
  update_date datetime
);