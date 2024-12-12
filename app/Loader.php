<?php

declare(strict_types=1);

namespace app;

class Loader
{
    public function parse(\SplFileObject $file): array
    {
        $lines = [];
        foreach ($file as $line) {
            if ($line !== '') {
                $lines []= $line;
            }
        }

        $structure = [];
        foreach ($lines as $line) {
            $matches = [];
            preg_match('#(\x20*)(\w.*)\n#', $line, $matches);
            [$haystack, $indent, $objectName] = $matches;
            $level = strlen($indent) / 4;
            $structure []= ['objectName' => $objectName, 'level' => $level];
        }

        $hierarchy = $this->collectChildren($structure, 0);

        return $hierarchy;
    }

    private function collectChildren(array $structure, int $forLevel): array
    {
        $children = [];

        for ($objectIndex = 0; $objectIndex < count($structure); $objectIndex++) {
            ['objectName' => $objectName, 'level' => $level] = $structure[$objectIndex];

            if ($level === $forLevel) {
                $lookahead = 1;
                while (true) {
                    if (!array_key_exists($objectIndex + $lookahead, $structure)
                        || $structure[$objectIndex + $lookahead]['level'] === $level
                    ) {
                        break;
                    }
                    $lookahead++;
                }

                $nextLevel = $this->collectChildren(array_slice($structure, $objectIndex, $lookahead), $forLevel + 1);

                if (count($nextLevel) === 0) {
                    $children []= $objectName;
                } else {
                    $children[$objectName] = $nextLevel;
                }
            }
        }

        return $children;
    }
}
