<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$db = new \app\DB();
$loader = new \app\Loader();

$structure = $loader->parse(new \SplFileObject(__DIR__ . '/files.txt'));

function saveToDb(\app\DB $db, array $structure, ?int $parentId = null): void
{
    foreach ($structure as $name => $children) {
        if (is_array($children)) {
            $fileId = $db->insertFile($name, $parentId, true);
            saveToDb($db, $children, $fileId);
        } else {
            $db->insertFile($children, $parentId, false);
        }
    }
}

saveToDb($db, $structure, null);
