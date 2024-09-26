<?php
//require __DIR__ . '/vendor/autoload.php';
define('STDIN',fopen("php://stdin","r"));
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */

function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Docs API PHP Quickstart');
    $client->setScopes([Google_Service_Docs::DOCUMENTS, Google_Service_Sheets::SPREADSHEETS, Google_Service_Slides::PRESENTATIONS, Google_Service_Docs::DRIVE]);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');

    //HESER
    /*


        $authUrl = $client->createAuthUrl();
        dd($authUrl);

    */
    //HESER

    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory('token.json');
    if (file_exists($credentialsPath)) {

        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode("4/1AX4XfWhR_jAqYvnK0xQUPvn1bCWVKPlmDw-tsVbj9nb-__JlO94BeIyuaRA");

        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path)
{
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}



// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Docs($client);
$driveService = new Google_Service_Drive($client);

// Prints the title of the requested doc:
// https://docs.google.com/document/d/195j9eDD3ccgjQRttHhJPymLJUCOUjs-jmwTrekvdjFE/edit
$documentId = '1hijJJ12pwo-ZMn5pMhw9RvqZRLyDpLfgKRKqL7z8Sx8';
$doc = $service->documents->get($documentId);

printf("The document title is: %s\n", $doc->getTitle());

/*HESER*/
$copyTitle = 'Copy - '.$doc->getTitle();
$copy = new Google_Service_Drive_DriveFile(array(
    'name' => $copyTitle
));
$driveResponse = $driveService->files->copy($documentId, $copy);
$documentCopyId = $driveResponse->id;

$requests = array();
$requests[] = new Google_Service_Docs_Request(array(
    'replaceAllText' => array(
        'containsText' => array(
            'text' => "#NOMBRE",
            'matchCase' => true,
        ),
        'replaceText' => "GIANCARLA",
    ),
));
$requests[] = new Google_Service_Docs_Request(array(
    'replaceAllText' => array(
        'containsText' => array(
            'text' => "#FECHA",
            'matchCase' => true,
        ),
        'replaceText' => "23/01/2020",
    ),
));
$batchUpdateRequest = new Google_Service_Docs_BatchUpdateDocumentRequest(array(
    'requests' => $requests
));

$response = $service->documents->batchUpdate($documentCopyId, $batchUpdateRequest);

dd( $response );


/*
$document_edit_url = "https://docs.google.com/document/d/".$documentCopyId."/edit";
header('Location: '.$document_edit_url);
exit();
*/

/*END HESER*/

