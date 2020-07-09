use DB_Teste;

create table tbTrackEmail(
id int primary key identity,
email varchar(255),
nome varchar(255),
dataEnvio varchar(255),
aberto bit
);

GO
create procedure P_GravaAcesso
@email varchar(255),
@nome varchar(255),
@data varchar(255)
AS
insert into tbTrackEmail values (@email,@nome,@data,1);

select * from tbTrackEmail;

insert into tbTrackEmail values ('lucas9.la2@gmail.com','lucas','06/07/2020',1);

delete tbTrackEmail;
