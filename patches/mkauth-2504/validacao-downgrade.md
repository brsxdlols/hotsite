# Validação no ciclo de downgrade

| Versão | `sis_hotsite` | Resultado da página inicial |
| --- | --- | --- |
| 26.03 | Tabela ausente | Tema padrão e tema personalizado abriram |
| 26.01 | Tabela vazia | Tema personalizado abriu com a seleção em `sis_opcao.layhotsite` |
| 25.08 | Tabela vazia | HTTP 200 com `Arquivo layout//index.html nao existe...` |
| 25.04 (PHP 7) | Tabela vazia | Mesmo erro; home voltou após aplicar o patch |

O template personalizado permaneceu disponível na transição em que o erro apareceu. O template `padrao/index.html` estava presente na 26.03 e já faltava na 26.01. Arquivos PHP personalizados, como o endpoint de dados do tema, já estavam ausentes na 26.03, embora a página inicial abrisse.

Na 25.04, a primeira aplicação do patch gravou o backup e inseriu uma linha. A segunda aplicação com o mesmo tema manteve a configuração. Após recuperar também os arquivos personalizados do backup da instalação, a home, a API de planos e o formulário público abriram por HTTPS. O teste não enviou cadastros.

Para automatizar a recuperação, o processo de atualização precisa guardar a configuração e os arquivos do hotsite antes da mudança de versão e restaurá-los quando o destino exigir. O patch publicado é manual e seu escopo é o seletor de tema da 25.04.
