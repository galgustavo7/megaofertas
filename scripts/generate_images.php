<?php
/**
 * Genera imágenes SVG para cada producto usando los colores de su categoría.
 * Uso: php scripts/generate_images.php
 * Las imágenes van a public/images/products/{slug}.svg
 */

$db = new PDO('sqlite:'.__DIR__.'/../database/database.sqlite');

$dir = __DIR__.'/../public/images/products';
if (! is_dir($dir)) {
    mkdir($dir, 0775, true);
}

$products = $db->query(
    "SELECT p.slug, p.name, p.brand, p.emoji, c.color_from, c.color_to
     FROM products p JOIN categories c ON c.id = p.category_id"
)->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $p) {
    $emoji = htmlspecialchars($p['emoji'], ENT_XML1);
    $brand = htmlspecialchars($p['brand'], ENT_XML1);
    $name = htmlspecialchars($p['name'], ENT_XML1);

    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="600" height="600" viewBox="0 0 600 600" role="img" aria-label="{$name}">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="{$p['color_from']}"/>
      <stop offset="1" stop-color="{$p['color_to']}"/>
    </linearGradient>
    <radialGradient id="glow" cx="0.5" cy="0.4" r="0.62">
      <stop offset="0" stop-color="#ffffff" stop-opacity="0.28"/>
      <stop offset="1" stop-color="#ffffff" stop-opacity="0"/>
    </radialGradient>
  </defs>
  <rect width="600" height="600" fill="url(#bg)"/>
  <rect width="600" height="600" fill="url(#glow)"/>
  <circle cx="300" cy="272" r="172" fill="#ffffff" opacity="0.16"/>
  <circle cx="300" cy="272" r="172" fill="none" stroke="#ffffff" stroke-opacity="0.3" stroke-width="2"/>
  <text x="300" y="272" font-size="185" text-anchor="middle" dominant-baseline="central"
        font-family="'Apple Color Emoji','Segoe UI Emoji','Noto Color Emoji','Twemoji Mozilla',sans-serif">{$emoji}</text>
  <text x="300" y="498" font-size="34" font-weight="700" fill="#ffffff" text-anchor="middle"
        font-family="Arial, Helvetica, sans-serif" letter-spacing="1">{$brand}</text>
</svg>
SVG;

    file_put_contents("{$dir}/{$p['slug']}.svg", $svg);
    echo "✓ {$p['slug']}.svg\n";
}

echo "\n" . count($products) . " imágenes generadas en {$dir}\n";
