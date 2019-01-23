## Dependências

- MySQL Server 5.7
- PHP 7.0

## Build

Primeiro, clone o repositório. Abra a pasta baixada e navegue até `docs/` e importe o arquivo `sgpa_cleaned.sql` para a o seu MySQL Server (nota: o projeto está configurado com as credenciais padrão(root/root) para fins de desenvolvimento). Após isso, navegue para `src/` e execute o servidor embutido do PHP:

```bash
php -S localhost:<port>
```

Após isso, abra `localhost:<port>` no seu navegador.

## Demo

Ao invés de seguir os passos acima, uma versão funcional do projeto pode ser facilmente acessada [aqui](https://kevinws.com.br/p3/sgpa).

## Funcionalidades
No sistema de gestão de produtividade acadêmica desenvolvido, o usuário pode:

- Registrar novos colaboradores
- Adicionar novos projetos/publicações/orientações
- Alterar o status de um projeto (em desenvolvimento/em progresso/concluído).
- Recuperar projetos, publicações e orientações de um colaborador ou de todo o laboratório.
- Gerar o relatório de produtividade acadêmica de todo o laboratório.

## Classes
O sistema desenvolvido possui as seguintes clases:

- `Autoload`: classe utilitária implementada com dois objetivos específicos: 
    - Importar automaticamente em todos os arquivos o código-fonte das classes que eu utilizo métodos (sem necessidade de dar `require` nesses arquivos manualmente).
    - Invocar a classe `Database` para disponibilizar uma nova instância do banco de dados automaticamente para as classes em que houver necessidade.
- `Collaborator`: super-classe responsável por reunir os métodos comuns aos colaboradores do laboratório. As seguintes classes herdam desta:
    - `Student`: classe específica para os métodos relacionados aos alunos (verificar tipo do aluno (graduação, pós, etc), se ele está disponível para ser co-autor de algum projeto, dentre outros).
    - `Teacher`: classe que abrange o único método específico relacionado aos professores (listagem de professores).
- `Database`: classe responsável por efetuar a conexão do sistema com o banco de dados.
- `Production`: super-classe responsável por reunir os métodos comuns às produções acadêmicas (projeto, publicação e orientação). As seguintes classes herdam desta:
    - `Orientation`: classe que abrange os métodos que dizem respeito às orientações acadêmicas (cadastro de orientação, adição de orientador/orientando, denre outros).
    - `Project`: classe específica para os métodos relacionados aos projetos (cadastro/edição/finalização de projeto, listagem de colaboradores do projeto, listagem de projetos, dentre outros).
    - `Publication`: classe específica para os métodos relacionados às publicações acadêmcias (cadastro de publicação, listagem de publicações, adição de autores, dentre outros).

## Distribuição dos Métodos

Buscou-se reunir os métodos relativos a uma determinada classe em suas respectivas classes. Dessa forma, os métodos relativos aos alunos estão na classe `Student`, métodos relativos aos professores estão na classe `Teacher` e assim sucessivamente.
- `getters` e `setters` genéricos estão disponíveis nas superclasses `Collaborator` e `Production`.
- `getters` e `setters` de atributos específicos de uma classe (como o grau de um aluno) estão disponíveis nas subclasses específicas (`Student`, `Publication`, `Orientation` e `Project`).
- Métodos comuns a todos os colaboradores estão na classe `Collaborator`: cadastro, listagem de pesquisadores, exibir número de colaboradores por tipo, listagem de produções por colaborador, dentre outros.
- Métodos específicos dos alunos (checar se um estudante está disponível, listar estudantes de graduação) estão na classe `Student`.
- A listagem de professores pertence à classe `Teacher`.
- Métodos comuns às produções acadêmicas estão na classe `Production`.
- Métodos específicos aos projetos, publicações e orientações (como a listagem e a adição de colaboradores) estão, respectivamente, nas classes `Project`, `Publication` e `Orientation`.
- A conexão com o banco de dados está na classe `Database`.

## Herança
Como colaboradores possuem métodos comuns (relacionados ao cadastro e alguns getters genéricos como `getName`, `getEmail`, etc), foi criada uma superclasse `Collaborator` que reúne estes métodos.

Além disso, foi criada uma classe `Production` que abrange os métodos comuns às produções acadêmicas (como os getters e a instância do banco no construtor).

A vantagem dessa abordagem está na eliminação da reescrita de um mesmo método em diversas (como na passagem da instância do banco de dados, declarado apenas nos construtores das superclasses); não foi identificada desvantagem.
## Classe abstrata
Poderia ter sido implementada uma classe abstrata relativa à produção acadêmica e estas herdariam dela, mas achei mais conveniente estabelecer uma interface para isso. Portanto, classes abstratas não foram implementadas.

## Interface
Foi utilizada uma interface denominada `iProduction`. Nela foram declarados os métodos `setData()` e `register()` - métodos estes que devem ser implementados pelas classes responsáveis pelas produções acadêmicas (projetos, publicações e orientações).

A vantagem disso reside de que tais classes que implementam esta interface só podem ser implementadas se estes métodos também forem implementados - dessa forma há a garantia de que métodos cruciais estejam presentes; não foi observada desvantagem.

## Polimorfismo
Devido ao uso de banco de dados, não houve uso de métodos abstratos ao longo das classes. A exceção à isso é na interface `iProduction` - que define os métodos abstratos a serem implementados nas classes relativas às produções acadêmicas.

Dessa forma, possíveis reescritas de método (como nos cadastros de colaboradores) foram substituídas por atributos nas tabelas. Por exemplo: no cadastro de colaborador há um campo que identifica o tipo (aluno, professor, pesquisador, etc) - assim, ao invés de ter vários métodos para cadastro, há apenas um e a distinção entre cada um desses tipos se dá através desse campo.

## Tratamento de Exceções
Todas as interações relacionadas às operações de CRUD com o banco de dados e com as requisições HTTP (como visto em todos os métodos de cadastro) tiveram suas exceções tratadas.

As validações referentes às entradas de dados (formulários e afins) foram tratadas no front, utilizando HTML e JS. Portanto não foram tratadas exceções referentes a isso.

Dessa forma, evitou-se que mensagens de erro complexas e informações sensíveis (como as credenciais do banco e as queries executadas) fossem exibidas ao usuário. Não foram detectadas desvantagens.
## Extensibilidade
Devido à existência de poucas subclasses (com duas classes herdando de uma única superclasse e três herdando outra), foi feito apenas o uso de herança - conforme explicitado anteriormente.

Caso haja necessidade, o sistema pode ser facilmente expandido para a adição de novos tipos de colaboradores ou de novas modalidades de produção acadêmica, mas até o momento ele não foi largamente estendido.

## Reuso
Além dos `getters` e `setters`, vários métodos foram bastante reutilizados ao longo do código. Alguns exemplos são os mmétodos `getInstance()` da classe `Database` e o método `load()` da classe `Autoload` - invocado em todas as páginas construídas. Assim, bastava invocar o método caso necessário - ao invés de precisar reescrevê-lo em todas as chamadas; não houve desvantagem observada.

## Licença

Este projeto está licenciado sob a licença MIT.