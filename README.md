# Gerenciador Logístico em PHP

Projeto prático desenvolvido para a disciplina de **Fundamentos de Programação para Internet** da **UNIPAR EAD**.

## Sobre o projeto
Sistema web simples de gerenciamento logístico rodando localmente no **XAMPP**, com telas em **HTML**, **Bootstrap** e **JavaScript**, e lógica em **PHP**.

## Funcionalidades
- **Cadastros e edição (com ID):** cadastro e edição de **Produtos**, **Endereços** (Origem e Destino) e **Transportadores**.
- **Geração de frete (1 para muitos):** permite vincular um transportador, origem, destino e **vários produtos** no mesmo frete, adicionando campos dinamicamente com JavaScript.
- **Formatação de dados em PHP:** formatação de valores monetários em reais (`R$`) e datas no padrão brasileiro (`DD/MM/AAAA`).
- **Relatório diário:** filtro de fretes por data e download do relatório em formato `.csv`.

## Tecnologias utilizadas
- **PHP** (backend e sessão)
- **HTML** e **Bootstrap** (interface e menu de navegação)
- **JavaScript** (inclusão/remoção dinâmica de campos de produto)
- **XAMPP** (servidor local Apache)
- **Git e GitHub** (versionamento)

## Como executar no XAMPP
1. Copie a pasta do projeto para `C:\xampp\htdocs\apoentrega\`.
2. Abra o **XAMPP Control Panel** e inicie o **Apache**.
3. Acesse no navegador: `http://localhost/apoentrega/`

## Autor
- **Aluno:** [Seu Nome Completo]
- **RA:** 09064122
- **Curso / Disciplina:** Fundamentos de Programação para Internet — UNIPAR EAD
- **Polo:** Francisco Beltrão