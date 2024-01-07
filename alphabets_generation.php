<?php

// Function to generate SVG content for a given character
function generateSVG($char) {
    $svgContent = "<svg width='100' height='100' xmlns='http://www.w3.org/2000/svg'>
        <text x='50%' y='50%' alignment-baseline='middle' text-anchor='middle' font-family='Arial' font-size='100' stroke='black' stroke-width='5' fill='none'>$char</text>
    </svg>";

    return $svgContent;
}



// Create a directory to store the SVG files if it doesn't exist
$directory = './uploads/alphabets';
if (!is_dir($directory)) {
    mkdir($directory);
}

// Generate and save SVG files for capital alphabets
for ($i = 65; $i <= 90; $i++) {
    $char = chr($i); // Convert ASCII code to character
    $svgContent = generateSVG($char);
    $filename = $directory . "/$char.svg";
    file_put_contents($filename, $svgContent);
    echo "SVG file for $char created: $filename\n";
}

// Generate and save SVG files for digits
for ($i = 0; $i <= 9; $i++) {
    $char = (string) $i;
    $svgContent = generateSVG($char);
    $filename = $directory . "/$char.svg";
    file_put_contents($filename, $svgContent);
    echo "SVG file for $char created: $filename\n";
}

?>

<img src="./uploads/alphabets/A.svg">
