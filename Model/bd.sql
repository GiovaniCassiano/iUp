 Create database teste;
 use database;
/**/
 Create table usuario(
    _id             int         not null primary key,
    _nome           Varchar(30) not null,
    _rg             Varchar(40) not null,
    _cpf            Varchar(40) not null,
    _anoNascimento  date
);
/**/
 Create table cliente(
    _id     int  not null not null,
    _data   date not null not null,
    constraint foreign key _id references usuario (_id) 
);
/**/
 Create table teste(
     _id         int not null primary key,
     _numero     int not null, 
     constraint foreign key _id references usuario (_id)
);