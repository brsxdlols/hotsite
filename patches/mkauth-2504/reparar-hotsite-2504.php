<?php
// MK-Auth 25.08 e anteriores — verifique a compatibilidade da instalação. — recupera o seletor do hotsite quando a tabela está vazia.
if (PHP_SAPI !== 'cli') {
    exit;
}
umask(0077);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $theme = $argv[1] ?? '';
    $mode = $argv[2] ?? '--check';
    if ($argc > 3 || $theme === '' || !in_array($mode, ['--check', '--apply'], true)) {
        throw new RuntimeException('Uso: php reparar-hotsite-2504.php TEMA|--auto [--check|--apply]');
    }
    $version = trim(file_get_contents('/opt/mk-auth/etc/update.diz'));
    if (!preg_match('/\A([0-9]{4})[A-Z]\z/', $version, $match)
        || (int)$match[1] > 2508 || !in_array(PHP_MAJOR_VERSION, [7, 8], true)) {
        throw new RuntimeException('Este patch exige MK-Auth 25.08 ou anterior com PHP 7 ou 8.');
    }
    require '/opt/mk-auth/include/conexao.php';
    $db = new mysqli(CONHOSTNAME, CONUSERNAME, CONPASSWRD, CONDATABASE);
    if ($mode === '--apply') {
        $db->query('LOCK TABLES sis_hotsite WRITE, sis_opcao READ');
    }
    try {
        $option = $db->query("SELECT valor FROM sis_opcao WHERE nome='layhotsite'")->fetch_all(MYSQLI_ASSOC);
        if ($theme === '--auto') {
            if (count($option) !== 1 || !isset($option[0]['valor'])) {
                throw new RuntimeException('layhotsite não contém um tema único. Informe o tema do backup.');
            }
            $theme = $option[0]['valor'];
        }
        if (!preg_match('/\A[a-zA-Z0-9][a-zA-Z0-9_-]{0,119}\z/', $theme)) {
            throw new RuntimeException('Nome de tema inválido.');
        }
        $template = "/var/www/layout/$theme/index.html";
        if (!is_file($template) || !is_readable($template) || filesize($template) === 0) {
            throw new RuntimeException("Template ausente ou vazio: $template");
        }
        $rows = $db->query('SELECT layout FROM sis_hotsite LIMIT 2')->fetch_all(MYSQLI_ASSOC);
        if ($rows === [['layout' => $theme]]) {
            echo "Tema $theme já configurado. Nenhuma alteração.\n";
            return;
        }
        if ($rows) {
            throw new RuntimeException('sis_hotsite contém dados. Revise o caso antes de alterar.');
        }
        echo "sis_hotsite vazia. Tema proposto: $theme. layhotsite atual: ", json_encode($option), "\n";
        if ($mode === '--check') {
            return;
        }
        $directory = '/root/mkauth-hotsite-repair';
        if ((!is_dir($directory) && !mkdir($directory, 0700)) || is_link($directory)
            || (fileperms($directory) & 0077) !== 0) {
            throw new RuntimeException('O diretório de backup precisa ser privado.');
        }
        $backup = $directory . '/before-' . bin2hex(random_bytes(12)) . '.json';
        $snapshot = json_encode([
            'sis_hotsite' => $rows, 'layhotsite' => $option, 'tema_inserido' => $theme
        ], JSON_PRETTY_PRINT);
        if ($snapshot === false) {
            throw new RuntimeException('Falha ao serializar o backup.');
        }
        $handle = fopen($backup, 'xb');
        if (!$handle || fwrite($handle, $snapshot) !== strlen($snapshot) || !fclose($handle)) {
            throw new RuntimeException('Falha ao gravar o backup.');
        }
        $statement = $db->prepare('INSERT INTO sis_hotsite (layout) VALUES (?)');
        $statement->bind_param('s', $theme);
        $statement->execute();
        echo "Tema restaurado. Backup em $backup\n";
    } finally {
        if ($mode === '--apply') {
            $db->query('UNLOCK TABLES');
        }
    }
} catch (Throwable $error) {
    fwrite(STDERR, $error->getMessage() . "\n");
    exit(1);
}

