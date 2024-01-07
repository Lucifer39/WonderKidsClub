<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csvFile"])) {
    $uploadedFile = $_FILES["csvFile"]["tmp_name"];

    $lines = file($uploadedFile, FILE_IGNORE_NEW_LINES);

    // Remove the first row (header)
    array_shift($lines);

    $output = [];

    foreach ($lines as $line) {
        $data = str_getcsv($line, ",", '"');

        $word = $data[1];
        $question = $data[2];
        $answer = $data[3];

        // Filter out the current answer to get other options
        $options = array_filter($lines, function($line) use ($answer) {
            $optionData = str_getcsv($line, ",", '"');
            return $optionData[3] !== $answer;
        });

        // Shuffle and slice the options to get random ones
        shuffle($options);
        $options = array_slice($options, 0, 3);

        // Extract the answer texts
        $options = array_map(function($line) {
            $optionData = str_getcsv($line, ",", '"');
            return $optionData[3];
        }, $options);

        // Include the correct answer in the options array
        $options[] = $answer;
        shuffle($options); // Shuffle options

        $correct_option_number = array_search($answer, $options);

        $output[] = [
            'question' => $question . " " . $word,
            'options' => $options,
            'correct_option_number' => $correct_option_number + 1,
        ];
    }

    $outputCSV = '"question","option1","option2","option3","option4","correct_option_number"' . "\n";
    foreach ($output as $row) {
        $rowCSV = '"' . $row['question'] . '","' . implode('","', $row['options']) . '","' . $row['correct_option_number'] . '"' . "\n";
        $outputCSV .= $rowCSV;
    }

    $outputDirectory = "../outputs/";
    if (!is_dir($outputDirectory)) {
        mkdir($outputDirectory, 0777, true);
    }

    $timestamp = date("Ymd_His"); // Get current timestamp
    $outputFileName = $outputDirectory . 'output_' . $timestamp . '.csv'; // Add timestamp to filename
    file_put_contents($outputFileName, $outputCSV);

    echo json_encode([
        'message' => 'CSV processing completed. Click the link below to download the processed CSV file:',
        'downloadLink' => $outputFileName,
    ]);
} else {
    echo json_encode(['message' => 'Invalid request.']);
}
?>
