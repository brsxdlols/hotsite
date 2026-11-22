# Recuperação do hotsite no MK-Auth 25.04

Use este patch no MK-Auth 25.04 (marcador `2504X`), com PHP 7, quando o hotsite retorna `Arquivo layout//index.html nao existe...` e a tabela `sis_hotsite` está vazia.

Recupere o nome do tema no backup da própria instalação. Substitua `TEMA` pelo nome da pasta que contém o `index.html` em `/var/www/layout/`. Execute no servidor com o PHP da instalação:

```sh
php reparar-hotsite-2504.php TEMA --check
php reparar-hotsite-2504.php TEMA --apply
```

O primeiro comando só diagnostica. O segundo, executado como root, salva o estado anterior em `/root/mkauth-hotsite-repair/` e insere a linha apenas se a tabela estiver vazia. Uma segunda aplicação com o mesmo tema mantém a linha existente. Os campos além de `layout` recebem os padrões da tabela. Se você tem backup da linha completa, prefira restaurá-la para preservar o conteúdo do hotsite.

O patch é manual e não faz parte do atualizador. Um novo downgrade pode recriar o problema. Faça backup da configuração e dos arquivos antes do ciclo de atualização. Se arquivos personalizados desaparecerem, restaure-os do backup da mesma instalação. Valide o HTML, os recursos estáticos, a lista de planos e a abertura do cadastro por HTTPS. Um HTTP 200 também pode conter a mensagem de erro.
