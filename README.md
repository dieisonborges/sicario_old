<p align="center"><img width="500" src="https://i.ibb.co/VjWzr3Y/logo-branco-preto.jpg" alt="logo-branco-preto" border="0" /></p>
<p align="center">
<a href="https://travis-ci.org/dieisonborges/sicario"><img src="https://travis-ci.org/dieisonborges/sicario.svg" alt="Build Status"></a>
<a href="http://escolhaumalicenca.com.br/licencas/mit/"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# SICARIO
Sistema de Controle, Análise e Relatório de Informação Operacional

## Objetivo

O sistema foi iniciado com a perpectiva de atender as seguintes necessidades de órgãos de manutenção com foco em traego aéreo:

- [Base de Dados de Conhecimento Técnico](https://pt.wikipedia.org/wiki/Base_de_conhecimento).
- [Controle de ticket's de Manutenção](https://pt.wikipedia.org/wiki/Manuten%C3%A7%C3%A3o).
- [Controle de Escalas Técnicas](https://pt.wikipedia.org/wiki/Jornada_de_trabalho)
- [Inventário de Equipamentos](https://pt.wikipedia.org/wiki/Invent%C3%A1rio)


## Valores

- Facilitar a rotina de manutenções corretivas
- Centralizar o conhecimento técnico
- Possibilitar pronta resposta em atividades de manutenção


## Tecnologia Utilizadas

- PHP 7 [documentação](http://www.php.net/)
- Laravel [documentação](https://laravel.com/docs)
- Git [documentação](https://git-scm.com/)
- Vagrant [documentação](https://www.vagrantup.com/)
- MariaDB [documentação](https://mariadb.org/)

## Quero Participar do Projeto
Caso você tenha interesse em contribuir neste projeto, entre em contato [dieisoncomix@gmail.com](mailto: dieisoncomix@gmail.com).

## Como utilizar

Para utlizar:

- Efetue o gitclone

- Configure o .env

- Rode as Migrations
Antes de rodar as migrações, comente o bloco do authserviceprovider que busca as permissions


```console
php artisan migrate
```

- Popule o banco com os Seeders

```console
php artisan db:seed --class=DatabaseSeeder
```

- Rode o composer


```console
composer update
composer dump-autoload
```

## Vulnerabilidades de segurança

Se você descobrir uma vulnerabilidade de segurança no SICARIO, envie um e-mail para Dieison S. Borges por meio de [dieisoncomix@gmail.com](mailto: dieisoncomix@gmail.com). Todas as vulnerabilidades de segurança serão prontamente endereçadas.

## Licença

O SICARIO é um software de código aberto licenciado sob o [MIT license](https://opensource.org/licenses/MIT).

