# Recuperação do hotsite após downgrade

O erro `Arquivo layout//index.html nao existe...` apareceu na 25.08 e persistiu na 25.04. Este patch atende instalações 25.08 ou anteriores com PHP 7 ou 8 quando existe a tabela `sis_hotsite` com a coluna `layout`, a tabela está vazia e há um template instalado. A recuperação com gravação foi validada na 25.04. Em outras versões, confira o diagnóstico antes da aplicação.

Na instalação afetada, confirme o erro na home e execute:

```sh
php reparar-hotsite-2504.php --auto --check
php reparar-hotsite-2504.php --auto --apply
```

`--auto` lê o tema gravado em `sis_opcao.layhotsite`. Se a opção estiver ausente, ambígua ou apontar para um template inválido, informe explicitamente o nome do tema do backup no lugar de `--auto`. O segundo comando, executado como root, cria um backup privado em `/root/mkauth-hotsite-repair/` antes de inserir. Uma segunda execução com o mesmo tema mantém a linha existente. Para preservar campos adicionais, use a linha completa do backup quando disponível.

O script é manual. Para execução automática, o atualizador precisa chamá-lo no servidor após detectar o erro no hotsite e validar a resposta novamente após a recuperação. Faça backup antes do ciclo de downgrade. Arquivos personalizados que desapareceram devem ser recuperados do backup da própria instalação. Valide o HTML, CSS, JavaScript e as rotas usadas pelo tema. Confira o conteúdo, pois o erro pode vir com HTTP 200.

Consulte a [validação por versão](validacao-downgrade.md).
