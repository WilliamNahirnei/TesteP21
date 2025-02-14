# 🏪 Loja Mágica de Tecnologia  
🚀 *Projeto para gestão de pedidos e clientes e pedidos com um backend em PHP e frontend puro (HTML, CSS e JS).*

---

## 📥 Clonando o Repositório
Para começar, clone o repositório em sua máquina local:
```sh
git clone git@github.com:WilliamNahirnei/loja-magica.git
cd loja-magica
```

---

## 🛠 Criando o Banco de Dados
O banco de dados utilizado é **MySQL**. Para configurá-lo, utilize o arquivo.sql na raiz do projeto:  
```
Isso criará o banco de dados e as tabelas necessárias para o funcionamento da aplicação.

---

## ⚙ Configurando a Conexão com o Banco de Dados
Antes de rodar o projeto, configure a conexão no arquivo:  
📂 **`envsConfigs/.database.env`**

🔹 **Exemplo de configuração:**
```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=MagicStore
DB_USER=root
DB_PASS=root
```
⚠ **Certifique-se de que esses dados correspondem às configurações do seu MySQL.**

---

## ▶ Executando o Servidor
O backend é construído em **PHP** e pode ser rodado usando o servidor embutido:

```sh
php -S localhost:8000
```
Agora, acesse a aplicação em:  
📌 **http://localhost:8000/Front**  

🚀 **Para navegar, utilize o menu disponível na interface.**

---

## 🏗 Estrutura do Projeto
A estrutura de diretórios está organizada da seguinte forma:

📂 **`Src/`** → Contém a lógica principal do **backend**.  
📂 **`Front/`** → Contém o código do **frontend**.  

---

## ⚠ O Desafio e Melhorias Futuras
O desafio não foi completamente finalizado devido ao tempo disponível para execução. Algumas melhorias que gostaria de conseguido implementar:

✅ **📧 Envio de E-mails**  
- Integração para notificar clientes sobre mudanças nos pedidos.  

✅ **📦 Melhor Estruturação de Pedidos**  
- Os produtos e suas quantidades deveriam estar em uma **tabela relacional** (`pedido_produto`) ao invés de colunas diretas.  
- O **valor total** da ordem deveria ser calculado dinamicamente com base nos produtos e quantidades.  

✅ **📌 Melhorias no Código**  
- Criar **constantes** para mensagens, parâmetros de requisição entre outros.  
- Criar uma **classe Enum** para os status dos pedidos no backend.  
- Melhor abstração da **conexão do frontend com o backend**, utilizando um arquivo **`.env`** para configurar a URL e porta.  
- Revisar e otimizar os arquivos **CSS**, removendo **repetições** de código.
- Implementar **melhores validações nos campos**, garantindo que os dados inseridos estejam corretos e seguros.  
- Criar um **sistema mais bonito e intuitivo para exibição de mensagens no frontend**, tanto para mensagens de sucesso, alerta, quanto para mensagens vindas do backend via API.  
---

🚀 **Obrigado por conferir a Loja Mágica de Tecnologia!** 🪄✨
