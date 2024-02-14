create table Blocks
(
    id        int auto_increment
        primary key,
    name      varchar(255)                         not null,
    path      varchar(255)                         not null,
    createdAt datetime default current_timestamp() not null,
    updatedAt datetime default current_timestamp() not null,
    active    tinyint(1) default 0 null
);

create table Configurations
(
    id        int auto_increment,
    name      varchar(255)                         not null,
    value     varchar(255)                         not null,
    language  varchar(255)                         not null,
    createdAt datetime default current_timestamp() not null,
    updatedAt datetime default current_timestamp() not null,
    active    tinyint(1) not null,
    primary key (id, name)
);

create table Page
(
    id              int auto_increment
        primary key,
    name            varchar(50)                          not null,
    seo_title       varchar(255)                         not null,
    seo_description varchar(255)                         not null,
    seo_keywords    varchar(255)                         not null,
    slug            varchar(255)                         not null,
    createdAt       datetime default current_timestamp() not null,
    updatedAt       datetime default current_timestamp() not null,
    active          tinyint(1) default 0 null
);

create table PagesStructures
(
    id         int auto_increment
        primary key,
    page_id    int                                  not null,
    createdAt  datetime default current_timestamp() not null,
    updatedAt  datetime default current_timestamp() not null,
    block_json text null,
    page_order int null,
    block_id   int                                  not null,
    active     tinyint(1) default 0 null,
    constraint PagesStructures_ibfk_1
        foreign key (page_id) references Page (id),
    constraint fk_Blocks
        foreign key (block_id) references Blocks (id)
);

create index page_id
    on PagesStructures (page_id);

create table Resources
(
    id              int auto_increment
        primary key,
    src             varchar(255)                         not null,
    alternativeText varchar(255)                         not null,
    createdAt       datetime default current_timestamp() not null,
    updatedAt       datetime default current_timestamp() not null,
    caption         varchar(255)                         not null,
    name            varchar(255)                         not null,
    active          tinyint(1) default 0 null
);

create table Users
(
    id        int auto_increment
        primary key,
    username  varchar(50) null,
    email     varchar(50) null,
    password  varchar(255) null,
    createdAt datetime default current_timestamp() not null,
    updatedAt datetime default current_timestamp() not null,
    language  varchar(50) null,
    active    tinyint(1) default 0 null
);

create table UsersHasSessions
(
    id        int auto_increment
        primary key,
    user_id   int                                  not null,
    token     varchar(255)                         not null,
    createdAt datetime default current_timestamp() not null,
    updatedAt datetime default current_timestamp() not null,
    active    tinyint(1) default 0 not null,
    expire_at datetime default current_timestamp() not null,
    constraint UsersHasSessions_ibfk_1
        foreign key (user_id) references Users (id)
);

create index user_id
    on UsersHasSessions (user_id);

