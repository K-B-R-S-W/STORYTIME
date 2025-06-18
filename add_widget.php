<?php

// List of files to modify
$files = [
    'aboutus.php',
    'avatar2.php',
    'barbie.php',
    'blackadam.php',
    'blackpanther.php',
    'chickenrun.php',
    'contatus.php',
    'johnwick.php',
    'locations.php',
    'Movies.php',
    'notfound.php',
    'oppenheimer.php',
    'thefamilyplan.php'
];

// The code to add at the beginning of each file
$header_code = '<?php require_once __DIR__ . \'/includes/chat-include.php\'; ?>' . PHP_EOL;

// The code to add before </body>
$footer_code = '    <!-- Include chat widget -->
    <?php include_chat_widget(); ?>' . PHP_EOL;

foreach ($files as $file) {
    if (!file_exists($file)) {
        echo "File not found: $file\n";
        continue;
    }

    // Read the file content
    $content = file_get_contents($file);

    // Check if the widget is already added
    if (strpos($content, 'chat-include.php') !== false) {
        echo "Widget already added to: $file\n";
        continue;
    }

    // Add header code after the first <?php or <!DOCTYPE or <html
    $pattern = '/^((?:<\?php|<!DOCTYPE|<html).*?>\n)/i';
    $content = preg_replace($pattern, '$1' . $header_code, $content, 1);

    // Add footer code before </body>
    $content = str_replace('</body>', $footer_code . '</body>', $content);

    // Save the modified content
    file_put_contents($file, $content);
    echo "Added widget to: $file\n";
}

echo "Done!\n";
?> 