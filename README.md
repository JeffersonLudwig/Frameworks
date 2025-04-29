## Comparativo CodeIgniter vs. Yii2

| Característica        | CodeIgniter                                  | Yii2                                             |
| :-------------------- | :------------------------------------------- | :----------------------------------------------- |
| **Desempenho** | Rápido, leve                                 | Alto desempenho, otimizado para escalabilidade   |
| **Curva de Aprendizado** | Mais suave, bom para iniciantes             | Mais íngreme devido à maior complexidade         |
| **Recursos Out-of-the-box** | Menos recursos nativos, mais dependência de bibliotecas | Muitos recursos integrados (ORM, templates, etc.) |
| **Escalabilidade** | Bom para projetos pequenos e médios           | Ideal para projetos médios e grandes com alta demanda |
| **Segurança** | Boa segurança básica                           | Recursos de segurança robustos e abrangentes     |
| **Extensibilidade** | Flexível, permite mais escolhas               | Altamente extensível e personalizável             |
| **Ferramentas de Desenvolvimento** | Menos ferramentas integradas                 | Gii (gerador de código) poderoso                 |
| **Documentação** | Clara e fácil de entender                     | Abrangente e bem organizada                      |
| **Comunidade** | Grande e ativa                               | Ativa, mas talvez ligeiramente menor             |
| **Complexidade** | Mais simples                                  | Mais complexo e estruturado                     |
| **Casos de Uso** | Aplicações web simples, sites, APIs pequenas | Aplicações web complexas, portais, APIs robustas |

### Resumo em Tópicos

**CodeIgniter:**

* Leve e Rápido
* Simples
* Fácil Configuração
* Boa Documentação
* Arquitetura MVC
* Segurança básica
* Comunidade Ativa
* Flexibilidade
* URLs Amigáveis
* Bibliotecas e Helpers

**Yii2:**

* Alto Desempenho
* Rico em Recursos
* Arquitetura MVC
* Forte Segurança
* Extensibilidade
* Suporte a Banco de Dados
* Caching Multi-Tier
* RESTful API
* Gii (Gerador de Código)
* Documentação Abrangente
* Comunidade Ativa
* Uso de Namespaces e Traits

# Frameworks

**Estudante:** Jefferson Alan Schmidt Ludwig, Iraê Ervin Gruber da Silva,Lucas Kesler

**Disciplina:** PROGRAMAÇÃO III

**Turma:** SMO11-8

**Instituição:** Unoesc

## Descrição do Projeto

Este projeto consiste em um sistema de autenticação simples de usuários com:

* Cadastro de usuários (nome, e-mail e senha).
* Login com validação de e-mail e senha.
* Exibição de uma área restrita com saudação personalizada
* Armazenamento do e-mail em cookie, se o usuário optar
* Logout com destruição da sessão.

## Estrutura do Projeto
```bash
A1/
├── Cadastro_Login/
│   ├── cadastro.php         
│   ├── login.php            
│   ├── logout.php           
│   ├── processa_cadastro.php 
│   └── processa_login.php    
├── Classes/
│   ├── Autenticador.php    
│   ├── Sessao.php          
│   └── Usuario.php         
├── dashboard.php          
└── index.php              
```
## Instruções para Executar Localmente

* Ambiente de desenvolvimento web: VSCODE
* PHP
* Servidor web: Apache
* MySQL

**Acesse a aplicação através do seu navegador:`http://localhost/A1/`**
