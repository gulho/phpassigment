SELECT `id`, MAX(`version`) AS `version`, `content`
FROM content
GROUP BY `id`;