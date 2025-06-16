# Hibrido\_ThemeCustomizer

Módulo Magento 2 que permite alterar a **cor dos botões** do frontend por **store view**, usando um **comando via CLI** ou configuração no backoffice.

---

## Funcionalidades

* Modifica a cor de todos os botões do frontend via terminal.
* Permite aplicar cores específicas por store view.
* Validação do código hexadecimal antes de salvar.
* Suporte para reset da cor com um comando.
* CSS injetado dinamicamente, sem alterar temas ou arquivos do layout.

---

## Instalação

Crie a pasta do vendor caso não exista:

```bash
mkdir -p app/code/Hibrido
cd $_
```

Clone o repositório dentro dessa pasta criada:

```bash
git clone https://github.com/luizfelipess/theme-customizer.git ThemeCustomizer
```

Ative o módulo no Magento:

```bash
bin/magento module:enable Hibrido_ThemeCustomizer
bin/magento setup:upgrade
```

Compile e limpe o cache:

```bash
bin/magento setup:di:compile
bin/magento cache:flush
```

---

## Como usar

### Via CLI

Altere a cor dos botões executando:

```bash
bin/magento color:change <cor_hexadecimal> <store_id>
```

**Parâmetros:**

* `<cor_hexadecimal>`: Código da cor em hexadecimal, com ou sem # (ex: `#ff0000` ou `ff0000`).
* `<store_id>`: ID da store view (veja em **Lojas > Todas as Lojas** no admin).

**Exemplo:**

```bash
bin/magento color:change 000000 1
```

Aplica a cor preta nos botões da store view de ID 1.

### Via configuração no Admin

Caminho no admin:

```
Stores -> Configuration -> Hibrido -> Theme Customizer
```
**Ponto de atenção:** Configuração é por **store-view**

---
### Resetar para a cor padrão

```bash
bin/magento color:change reset <store_id>
```

---

## Sobre o módulo

Desenvolvido para permitir que administradores alterem a cor dos botões do frontend, por store view, de forma simples, sem necessidade de desenvolvimento ou alterações em temas.

**A solução oferece:**

* CLI (`color:change`).
* Configuração no Admin (com color picker).
* Aplicação dinâmica de CSS inline codificado em base64, isolado por store view.

---

## Processo de Concepção e Desenvolvimento

### Entendendo o problema

O cliente precisava de uma forma simples, rápida e segura para alterar a cor dos botões no frontend, por store view, sem depender do time técnico. Era importante que essa solução não mexesse nos temas, nem exigisse deploy ou alterações manuais nos arquivos.

### Como resolvi

Criei duas formas de aplicar a cor:

- Um comando CLI que recebe o código hexadecimal e o ID da store view, com validação para evitar erros básicos.
- Uma configuração no admin, com um color picker para facilitar para quem prefere mudar visualmente.

Ambas as opções geram um CSS inline dinâmico e isolado por store view, que é injetado sem modificar arquivos do tema.

### Por que essa abordagem?

Assim, qualquer pessoa do time consegue fazer a alteração direto, sem precisar mexer em código, deploy ou temas. É rápido, seguro e mantém o sistema organizado.
Além disso, o CSS fica isolado e aplicado só na store view selecionada, garantindo flexibilidade e controle.
---

## Aspectos técnicos importantes

- Validação para garantir que só cores válidas e stores existentes sejam aceitas.
- Uso de CSS inline dinâmico para evitar tocar em arquivos estáticos e permitir atualização sem deploy.
- Código modular, com separação clara de responsabilidades, seguindo padrões como SOLID e PSR.
- Suporte para resetar para a cor padrão via CLI.
---

### Desafios e aprendizados

- Garantir que o valor salvo e recuperado sempre respeitasse o escopo correto da store view.
- Aceitar cores com ou sem o caractere `#` de forma transparente para o usuário.
- Definir seletores CSS genéricos para funcionar com temas variados.

---

## Justificativas técnicas

* **Acessibilidade:** Não exige alteração de código.
* **Escopo correto:** A configuração respeita o nível da store view.
* **Segurança:** Validação de entrada no CLI para evitar erros.
* **Leveza e isolamento:** O CSS é injetado dinamicamente, sem interferir no tema.
* **Modularidade:** O código segue SOLID, PSR-12 e está separado por responsabilidade.

---

## Principais decisões de arquitetura

* **Interface amigável:** CLI + Admin.
* **Validação robusta:**

    * `HexColorValidator`: Valida a cor.
    * `GetStoreById`: Valida o store ID.
    * Escopo respeitando o nível da store view.
* **CSS dinâmico:** Injetado no `<head>` via base64.
* **Design patterns aplicados:**

    * `CssGeneratorInterface`
    * **SoC:** Commands, Observers, Validators, Services.
    * PSR-4, PSR-12, SOLID.
---

## Melhorias futuras

* Suporte a outras customizações (ex.: cor do texto, bordas, fontes).
* Interface para mapeamento de classes CSS em temas personalizados.
* Logs de alterações (cor, data, store view) e opção de rollback.
* Testes Unitarios

---

## Conclusão

O módulo entrega uma solução prática, segura e amigável — via CLI ou backoffice — para alterar dinamicamente a cor dos botões no Magento 2. Leve, não invasivo, e pronto para evoluir com novas funcionalidades.
