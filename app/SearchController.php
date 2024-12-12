<?php

declare(strict_types=1);

namespace app;

class SearchController
{
    public function __construct(private readonly DB $db)
    {
    }

    public function search(string $query): array
    {
        $results = $this->db->searchFiles($query);

        $paths = [];
        foreach ($results as $result) {
            $pathParts = [];
            $parentId = $result['parent_id'];

            while ($parentId !== null) {
                $parent = $this->db->getFile($parentId);
                array_unshift($pathParts, $parent['name']);
                $parentId = $parent['parent_id'];
            }

            $resultPath = implode('\\', $pathParts) . '\\' . $result['name'];
            $paths []= preg_replace('#\\\\\\\#', '\\', $resultPath);
        }

        return $paths;
    }

    public function formatSearchResults(string $query): string
    {
        $results = implode('<br />', $this->search($query));
        return "<h2>Search Results:</h2><p>$results</p>";
    }
}
