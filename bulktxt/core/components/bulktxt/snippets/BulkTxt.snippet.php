<?php

require_once __DIR__ . '/../../vendor/Michelf/MarkdownExtra.inc.php';

use Michelf\MarkdownExtra;

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['txt_files'])) {
    // Define the target directory for file uploads
    $targetDirectory = 'uploads/';

    // Check if target directory exists, if not then create it
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
    }

    // Get form inputs
    $templateId = $_POST['template_id'];
    $parentResourceId = $_POST['resource_id'] ?? 0;
    $published = isset($_POST['published']) && $_POST['published'] === 'true';

    // Create an array to store the uploaded file names
    $uploadedFiles = array();

    // Loop through each uploaded file
    foreach ($_FILES['txt_files']['tmp_name'] as $key => $tmpName) {
        $fileName = $_FILES['txt_files']['name'][$key];
        $fileSize = $_FILES['txt_files']['size'][$key];
        $fileType = $_FILES['txt_files']['type'][$key];
        $fileError = $_FILES['txt_files']['error'][$key];
        $fileTmpName = $_FILES['txt_files']['tmp_name'][$key];

        // Check if the file is a valid .txt file
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExtension !== 'txt') {
            echo "Error: Only .txt files are allowed.";
            continue;
        }

        // Move the uploaded file to the target directory
        $newFilePath = $targetDirectory . $fileName;
        move_uploaded_file($fileTmpName, $newFilePath);

        // Read the file contents
        $fileContents = file_get_contents($newFilePath);

        // Convert the markup code to HTML using MarkdownExtra
        $htmlContent = MarkdownExtra::defaultTransform($fileContents);

        // Remove underscores from the file name for the page title
        $pageTitle = str_replace('_', ' ', pathinfo($fileName, PATHINFO_FILENAME));

        // this will check if the same pagetitle already exist and will not upload the file, to prevent duplicate/resubmit I encountered.
        $duplicateContent = $modx->getObject('modResource', array('pagetitle' => $pageTitle));
        if ($duplicateContent) {
            echo "Error:'$pageTitle' already exists. $fileName upload failed <br>";
            unlink($newFilePath);
            continue;
        }

        // Check the resource type of the parent resource
        $parentResource = $modx->getObject('modResource', $parentResourceId);
        $showInTree = true;
        if ($parentResource && $parentResource->get('class_key') === 'Collections\Model\CollectionContainer') {
            $showInTree = false;
        }

        // Create a new resource in MODX
        $resource = $modx->newObject('modResource');
        $resource->set('pagetitle', $pageTitle); // Set the page title without underscores
        $resource->set('alias', $pageTitle);
        $resource->set('content', $htmlContent);
        $resource->set('template', $templateId);
        $resource->set('parent', $parentResourceId);
        $resource->set('published', $published);
        $resource->set('show_in_tree', $showInTree);  // Set 'show_in_tree' based on parent resource type
        $resource->save();

        // Add the uploaded file name to the array
        $uploadedFiles[] = $fileName;

        // Delete the uploaded file
        unlink($newFilePath);

        // Output success message
        echo "File uploaded and resource created: $fileName<br>";
    }

    // Create or append to the JSON file
    $jsonFile = 'uploaded_files.json';
    $jsonContents = json_encode($uploadedFiles);
    file_put_contents($jsonFile, $jsonContents, FILE_APPEND | LOCK_EX);
}

// remove all stored data so prevent duplication when page was reloaded
unset($_POST);
unset($_FILES);


?>