# Modex

1) Heros Martins Padilha Celestino, Cristian Emanuel Bueno Soares

2) Informática 2, turma A

3) Site de venda de roupas online

4)

Descrição do Projeto — Site de Venda de Roupas

A ideia do projeto é criar um site de vendas de roupas, com uma navegação simples e organizada. O objetivo é permitir que qualquer pessoa consiga navegar pelos produtos, filtrando facilmente o que deseja comprar, além de ter um sistema básico de login e cadastro.

Ao acessar o site, o usuário poderá criar uma conta (cadastro) ou fazer login, para poder visualizar os produtos disponíveis. Não é necessário ter uma conta para apenas navegar pelas roupas, mas o login pode ser exigido em ações futuras (como adicionar ao carrinho, por exemplo).

As roupas serão organizadas por categorias principais, como:

    Camisas
    Calças
    Jaquetas
    Bermudas
    Outros

Dentro de cada categoria, haverá também a opção de filtrar por estilo de roupa, como:

    Streetwear
    Esporte fino
    Casual
    Formal
    Básico

Esses filtros permitem que o usuário encontre mais rapidamente o tipo de peça que está procurando.


Funcionalidades principais do site

O site será dividido em páginas simples, com as seguintes funções:

    Página de login e cadastro: onde o usuário pode se registrar ou entrar com sua conta;
    Página de listagem de produtos: exibe todos os produtos cadastrados, com filtros por categoria e estilo;
    Filtros: o usuário pode selecionar uma categoria (ex: “Camisa”) e depois escolher um estilo (ex: “Streetwear”) para ver apenas as roupas que se encaixam nesse filtro;
    Página de detalhes do produto: ao clicar em um item, o usuário pode ver informações completas da roupa, como descrição, preço, tamanho, estilo e uma imagem.


Modelagem do Banco de Dados – DER

Para organizar a estrutura do banco de dados, será utilizado um DER (Diagrama Entidade-Relacionamento). Para representar as principais entidades do sistema e os relacionamentos entre elas.

As entidades principais serão:

    Usuário (com dados como nome, e-mail e senha);
    Produto (com nome, descrição, preço, imagem, etc.);
    Categoria (como camisa, calça, etc.);
    Estilo (como streetwear, casual, etc.).

Cada produto estará relacionado com uma categoria e um estilo. O DER vai mostrar essas ligações de forma visual e será a base para a criação do banco de dados que o site vai usar.
