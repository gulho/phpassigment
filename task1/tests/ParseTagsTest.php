<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Src\ParseTags;

final class ParseTagsTest extends TestCase
{
    #[DataProviderExternal(TagsDataProvider::class, 'correctTags')]
    public function testParseTagsCorrect(string $tag, array $expected): void {
        $result = ParseTags::parseTags($tag);

        $this->assertArrayHasKey($expected[0], $result, "Result is not have correct key");
    }

    #[DataProviderExternal(TagsDataProvider::class, 'incorrectTags')]
    public function testParseTagsIncorrect(string $tag): void {
        $result = ParseTags::parseTags($tag);

        $this->assertEmpty($result, "Method return not null");
    }
}

final class TagsDataProvider {
    public static function correctTags(): array {
        return [
            ['[TAG_NAME:description]data[/TAG_NAME]', ['TAG_NAME', 'description', 'data']],
            ['[MY_TAG:description for my tag]my data[/MY_TAG]', ['MY_TAG', 'description for my tag', 'my data']],
        ];
    }

    public static function incorrectTags(): array {
        return [
            ['[!@#$%^&*(:)(*&^%$#@S!][/!@#$%^&*]'],
        ];
    }
}