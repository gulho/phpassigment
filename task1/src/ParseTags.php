<?php

namespace Src;

class ParseTags
{
    private static $pattern = '/\[(\w+):([^\]]+)\](.*?)\[\/\1\]/s';

    public static function parseTags(string $tagLine): array
    {
        $result = [];
        if (preg_match_all(ParseTags::$pattern, $tagLine, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $tagName = $match[1];
                $description = $match[2];
                $data = $match[3];

                $result[$tagName] = [
                    'description' => $description,
                    'data' => $data
                ];
            }
        }
        return $result;
    }
}
