create table users (
    id            integer      unsigned primary key auto_increment,
    username      varchar(127) not null unique,
    email         varchar(127) not null,
    password_hash char(60),
    admin         boolean      not null default false
) engine = InnoDB;

create table wikis (
    id        integer      unsigned primary key auto_increment,
    title     varchar(127) not null,
    parent_id integer unsigned, -- version précédente
    author_id integer unsigned,
    document  text,
    created   timestamp    not null default CURRENT_TIMESTAMP,
    foreign key (author_id) references users(id) on update cascade on delete set null,
    foreign key (parent_id) references wikis(id) on update cascade on delete cascade
) engine = InnoDB;