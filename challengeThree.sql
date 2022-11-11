CREATE TABLE usuario (
	id int auto_increment,
    cpf varchar(11) unique not null,
    nome varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE info (
	id int auto_increment,
    cpf varchar(11),
    genero ENUM ('M','F'),
    ano_nascimento int,
    PRIMARY KEY (id),
    FOREIGN KEY (cpf) REFERENCES usuario(cpf)
);

INSERT INTO `desafio_superlogica`.`usuario` (`id`, `cpf`, `nome`) VALUES ('1', '16798125050', 'Luke Skywalker');
INSERT INTO `desafio_superlogica`.`usuario` (`id`, `cpf`, `nome`) VALUES ('2', '59875804045', 'Bruce Wayne');
INSERT INTO `desafio_superlogica`.`usuario` (`id`, `cpf`, `nome`) VALUES ('3', '04707649025', 'Diane Prince');
INSERT INTO `desafio_superlogica`.`usuario` (`id`, `cpf`, `nome`) VALUES ('4', '21142450040', 'Bruce Banner');
INSERT INTO `desafio_superlogica`.`usuario` (`id`, `cpf`, `nome`) VALUES ('5', '83257946074', 'Harley Quinn');
INSERT INTO `desafio_superlogica`.`usuario` (`id`, `cpf`, `nome`) VALUES ('6', '07583509025', 'Peter Parker');

INSERT INTO `desafio_superlogica`.`info` (`cpf`, `genero`, `ano_nascimento`) VALUES ('16798125050', 'M', '1976');
INSERT INTO `desafio_superlogica`.`info` (`cpf`, `genero`, `ano_nascimento`) VALUES ('59875804045', 'M', '1960');
INSERT INTO `desafio_superlogica`.`info` (`cpf`, `genero`, `ano_nascimento`) VALUES ('04707649025', 'F', '1988');
INSERT INTO `desafio_superlogica`.`info` (`cpf`, `genero`, `ano_nascimento`) VALUES ('21142450040', 'M', '1954');
INSERT INTO `desafio_superlogica`.`info` (`cpf`, `genero`, `ano_nascimento`) VALUES ('83257946074', 'F', '1970');
INSERT INTO `desafio_superlogica`.`info` (`cpf`, `genero`, `ano_nascimento`) VALUES ('07583509025', 'M', '1972');

SELECT 
	CONCAT(u.nome, " - ", i.genero) as 'usuário', 
    IF(YEAR(CURDATE())-i.ano_nascimento>50, "SIM", "NÃO") as 'maior_50_anos'
FROM usuario as u 
INNER JOIN info as i on u.cpf = i.cpf
WHERE i.genero = 'M'
AND u.id != 2
ORDER BY u.nome DESC;
