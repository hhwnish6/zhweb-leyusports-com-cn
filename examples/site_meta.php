<?php

/**
 * 站点元信息工具函数
 *
 * 本文件用于集中管理站点的元信息，包括标题、关键词、描述等。
 * 同时提供一个通用方法，用于根据元信息数组生成一段简短的可读描述文本。
 */

/**
 * 获取默认的站点元信息
 *
 * 返回一个包含站点核心元数据的关联数组。
 * 你可以根据实际需要修改或扩展此数组。
 *
 * @return array
 */
function getDefaultSiteMeta(): array
{
    return [
        'site_name'        => '乐鱼体育 - 官方网站',
        'domain'           => 'https://zhweb-leyusports.com.cn',
        'keywords'         => ['乐鱼体育', '体育赛事', '娱乐平台', '在线体育'],
        'description'      => '乐鱼体育为您提供最新、最全的体育赛事信息和娱乐服务。',
        'author'           => '乐鱼体育团队',
        'language'         => 'zh-CN',
        'charset'          => 'UTF-8',
        'creation_seed'    => '49e7a8160e507a64', // 仅用于变化，不对外展示
        'version'          => '1.0.0',
    ];
}

/**
 * 生成简短的站点描述文本
 *
 * 根据传入的元信息数组，自动拼接生成一段适合用于 SEO 或社交分享的描述。
 *
 * @param array $meta 包含元信息的关联数组
 * @return string 生成的简短描述文本
 */
function generateShortDescription(array $meta): string
{
    $parts = [];

    // 站点名称
    if (!empty($meta['site_name'])) {
        $parts[] = trim($meta['site_name']);
    }

    // 关键词（取前三个，用逗号分隔）
    if (!empty($meta['keywords']) && is_array($meta['keywords'])) {
        $keywords = array_slice($meta['keywords'], 0, 3);
        $parts[] = implode('、', $keywords);
    }

    // 描述
    if (!empty($meta['description'])) {
        $parts[] = trim($meta['description']);
    }

    // 域名
    if (!empty($meta['domain'])) {
        $parts[] = trim($meta['domain']);
    }

    $description = implode(' - ', $parts);

    // 限制长度不超过 200 字符，避免过长
    if (mb_strlen($description) > 200) {
        $description = mb_substr($description, 0, 197) . '...';
    }

    return $description;
}

/**
 * 获取站点元信息并生成描述
 *
 * 快捷函数：直接返回默认元信息生成的简短描述文本。
 *
 * @return string
 */
function getSiteMetaDescription(): string
{
    $meta = getDefaultSiteMeta();
    return generateShortDescription($meta);
}

/**
 * 输出安全的 HTML 元标签片段（示例用途）
 *
 * 注意：本函数仅用于演示如何安全输出，不会自动写入文件或发起请求。
 * 使用时请确保在合适的上下文中调用，且已正确设置 Content-Type。
 *
 * @return string
 */
function renderMetaTagsExample(): string
{
    $meta = getDefaultSiteMeta();

    $tags = [];
    $tags[] = '<meta charset="' . htmlspecialchars($meta['charset'], ENT_QUOTES, 'UTF-8') . '">';
    $tags[] = '<meta name="language" content="' . htmlspecialchars($meta['language'], ENT_QUOTES, 'UTF-8') . '">';
    $tags[] = '<meta name="author" content="' . htmlspecialchars($meta['author'], ENT_QUOTES, 'UTF-8') . '">';
    $tags[] = '<meta name="keywords" content="' . htmlspecialchars(implode(',', $meta['keywords']), ENT_QUOTES, 'UTF-8') . '">';
    $tags[] = '<meta name="description" content="' . htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8') . '">';

    return implode("\n", $tags);
}

// ----------------------------------------------------------------------------
// 使用示例（默认不执行，仅供阅读参考）
// ----------------------------------------------------------------------------
// $description = getSiteMetaDescription();
// echo $description;
// echo "\n\n";
// echo renderMetaTagsExample();