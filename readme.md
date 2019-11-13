# Sistema de Reembolso
Sistema de cadastro de Reembolsos

## Tecnologias 
- Banco de dados: MySQL
- Linguagem: PHP
- Framework: Laravel
- API: Rest
- Versionamento: Github
- Arquitetura: MVC

## Postman
Publicado no [Postman](https://documenter.getpostman.com/view/4134279/SW7UaqAH?version=latest), documento com as requisições com os padrões utilizados no sistema.

## Autenticação
Para autenticação foi utilizado [JWT Auth](https://jwt-auth.readthedocs.io/en/develop/) : 

**Instalação via composer**
> composer require tymon/jwt-auth

**Publicando pacote do arquivo de configuração**
> php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

## Requisições com Token 
Inserir token em uma pasta no Postman para execução de requisições
1. Edit Folder
2. Authorization 
3. Mudar tipo para "Bearer Token" 
4. No campo token, inserir token do login.


