# Sistema de Gestão Logística - UNIPAR EAD

Este é um projeto prático desenvolvido para a disciplina da UNIPAR EAD no curso de Análise e Desenvolvimento de Sistemas.

## 🎯 Objetivo do Projeto
Criar um gerenciador logístico web utilizando arquitetura Full-Stack, permitindo o cadastro e gestão de produtos, endereços, transportadoras e a geração de fretes com múltiplos produtos associados, além do acompanhamento detalhado via relatórios.

## 🛠️ Tecnologias Utilizadas
- **Front-end:** HTML5, CSS3, Bootstrap 5, JavaScript (AJAX para requisições dinâmicas)
- **Back-end:** PHP
- **Banco de Dados:** MySQL (via XAMPP / phpMyAdmin)
- **Design (UX/UI):** Protótipos e componentes vetorizados no Figma

## ⚙️ Funcionalidades
- [x] Cadastro de Produtos, Transportadoras e Endereços
- [x] Central de Edição para atualização de registros cadastrados
- [x] Geração de Fretes dinâmicos (Relação 1 para N com múltiplos produtos)
- [x] Relatório de Fretes Gerados com filtro por intervalo de datas
- [x] Visualização detalhada de produtos vinculados ao frete via janela modal (AJAX)
- [x] Exclusão direta de fretes com remoção em cascata no banco de dados
- [x] Exportação e Impressão de Relatórios formatados em PDF

## 🚀 Como executar o projeto
1. Certifique-se de ter o [XAMPP](https://www.apachefriends.org/pt_br/index.html) instalado e com os serviços **Apache** e **MySQL** ativos.
2. Clone ou extraia este repositório na pasta `C:\xampp\htdocs\logistica`.
3. Abra o **phpMyAdmin** (`http://localhost/phpmyadmin`) e importe o banco de dados `logistica_unipar.sql`.
4. Acesse `http://localhost/logistica` no seu navegador.