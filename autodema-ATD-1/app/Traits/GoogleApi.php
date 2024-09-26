<?php

namespace App\Traits;

use App\Document;
use Google_Client;
use Google_Service_Docs;
use Google_Service_Docs_BatchUpdateDocumentRequest;
use Google_Service_Docs_Request;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_Request;
use Google_Service_Slides;
use Google_Service_Slides_BatchUpdatePresentationRequest;
use Google_Service_Slides_Request;
use http\Env\Response;
use Illuminate\Support\Facades\Log;
use Psr\Log\NullLogger;

require '../vendor/autoload.php';

trait GoogleApi
{
    public function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Docs API PHP Quickstart');
        //$client->setScopes(Google_Service_Docs::DOCUMENTS);
        //$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        //$client->setScopes(Google_Service_Slides::PRESENTATIONS);
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
        $credentialsPath = $this->expandHomeDirectory('token.json');
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            dd("Open the following link in your browser:\n%s\n", $authUrl);
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
    public function expandHomeDirectory($path)
    {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }


    //////////REPLACE TEXT///////////////
    //FUNCION DE HESER
    public function replaceDocsText($replacedText, $replaceText){
        $request = new Google_Service_Docs_Request(array(
            'replaceAllText' => array(
                'containsText' => array(
                    'text' => $replacedText,
                    'matchCase' => true,
                ),
                'replaceText' => $replaceText,
            ),
        ));
        return $request;
    }

    //FUNCION DE HESER
    public function replaceSheetsText($replacedText, $replaceText){
        $request =  new Google_Service_Sheets_Request([
            'findReplace' => [
                'find' => $replacedText,
                'replacement' => $replaceText,
                'allSheets' => true
            ]
        ]);
        return $request;
    }

    //FUNCION DE HESER
    public function replaceSlidesText($replacedText, $replaceText){
        $request =  new Google_Service_Slides_Request(array(
            'replaceAllText' => array(
                'containsText' => array(
                    'text' => $replacedText,
                    'matchCase' => true
                ),
                'replaceText' => $replaceText
            )
        ));
        return $request;
    }

    //////////REPLACE IMAGE///////////////
    //DOCS
    public function replaceDocsImage($imgUrl,$textReplace, $document){
        $requests = array();
        $deleteRequests = array();
        $deleteRequestsHeaders = array();
        $deleteRequestsFooters = array();

        $docContent = $document->getBody()->getContent();
        $docHeaders = $document->getHeaders();
        $docFooters = $document->getFooters();

        foreach ($docHeaders as $docHeader) {
            $docHeaderContent = $docHeader['content'];
            $deleteRequestsHeaders = $this->getTexPositionByReadingStructuralElements($docHeaderContent, $imgUrl,$textReplace, $docHeader['headerId']);
            foreach ($deleteRequestsHeaders as $deleteRequestsHeader) {
                $requests[] = $deleteRequestsHeader;
                //dd($deleteRequestsHeaders);
            }
        }
        foreach ($docFooters as $docFooter) {
            $docFooterContent = $docFooter['content'];
            $deleteRequestsFooters = $this->getTexPositionByReadingStructuralElements($docFooterContent, $imgUrl,$textReplace, $docFooter['footerId']);
            foreach ($deleteRequestsFooters as $deleteRequestsFooter) {
                $requests[] = $deleteRequestsFooter;
            }
        }

        $deleteRequests = $this->getTexPositionByReadingStructuralElements($docContent, $imgUrl,$textReplace);

        foreach ($deleteRequests as $deleteRequest) {
            $requests[] = $deleteRequest;
        }

        return $requests;
    }


    /*LEER ELEMENTOS ESTRUCTURALES*/
    public function readParagraphElement($element){
        $text_run = $element['textRun'];
        if(!$text_run){
            return '';
        }
        return $text_run['content'];
    }

    public function deleteText($text, $startIndex, $segmentId = null){
        $textLength = strlen($text);
        $endIndex = ($startIndex + $textLength);

        $range = array(
            'startIndex' => $startIndex,
            'endIndex' => $endIndex
        );

        //SI MODIFICAMOS UN HEADER O FOOTER
        if ($segmentId){
            $range['segmentId'] = $segmentId;
        }

        $request = new Google_Service_Docs_Request(array(
            'deleteContentRange' => array(
                'range' => $range,
            ),
        ));

        return $request;
    }

    public function insertImage($imageURL, $index, $height, $width, $segmentId = null){
        $location = array(
            'index' => $index,
        );

        //SI MODIFICAMOS UN HEADER O FOOTER
        if ($segmentId){
            $location['segmentId'] = $segmentId;
        }

        $request = new Google_Service_Docs_Request(array(
            'insertInlineImage' => array(
                'uri' => $imageURL,
                'location' => $location,
                'objectSize' => array(
                    'height' => array(
                        'magnitude' => $height,
                        'unit' => 'PT',
                    ),
                    'width' => array(
                        'magnitude' => $width,
                        'unit' => 'PT',
                    ),
                )
            )
        ));

        return $request;
    }

    /*ENONTRAR TEXTO AL LEER ELEMENTOS ESTRUCTURALES*/
    public function getTexPositionByReadingStructuralElements($elements, $imageURL,$textReplace, $segmentId = null){
        $startIndexOfText = 0;
        $requests = array();
        $temp_requests = array();

        //OBTENEMOS TODOS LOS ELEMENTOS DE LA ESTRUCTURA: HEADER, BODY O FOOTER
        foreach ($elements as $value) {
            $value = (array) $value;
            if (array_key_exists('paragraph',$value)){
                $elements = $value['paragraph']['elements'];
                foreach ($elements as $elem) {
                    $textInElement = $this->readParagraphElement($elem);
                    $lastPos = 0;

                    //ENCONTRAMOS TODAS LAS OCURRENCIAS DEL SUBSTRING EN EL STRING
                    //PARA ELLO VAMOS ENCONTRANDO LA PRIMERA OCURRENCIA, DESPUÉS DE CIERTO CARACTER
                    while (($lastPos = strpos($textInElement, $textReplace, $lastPos))!== false) {
                        $startIndexOfText = $elem['startIndex']+$lastPos;
                        //EN LA PRIMERA OCURRENCIA, INSERTAMOS LA IMAGEN
                        $requests[] = $this->insertImage($imageURL, $startIndexOfText, 50, 50, $segmentId);
                        //$requests[] = $this->deleteText($textReplace, $startIndexOfText,$segmentId);
                        //CONFIGURAMOS COMO ÚLTIMA POSICIÓN, LA ÚLTIMA LETRA ENCONTRADA
                        $lastPos = $lastPos + strlen($textReplace);
                    }
                }
            }elseif (array_key_exists('table',$value)){
                $table = $value['table'];
                foreach ($table['tableRows'] as $row) {
                    $cells = $row['tableCells'];
                    foreach ($cells as $cell) {
                        $temp_requests = $this->getTexPositionByReadingStructuralElements($cell['content'], $imageURL,$textReplace, $segmentId);
                        if($temp_requests){
                            foreach ($temp_requests as $temp_request) {
                                $requests[] = $temp_request;
                            }
                        }
                    }
                }
            }elseif (array_key_exists('tableOfContents',$value)){
                $toc = $value['tableOfContents'];
                $temp_requests = $this->getTexPositionByReadingStructuralElements($toc['content'], $imageURL,$textReplace, $segmentId);
                if($temp_requests){
                    foreach ($temp_requests as $temp_request) {
                        $requests[] = $temp_request;
                    }
                }
            }
        }

        return $requests;
    }

    //SPREADSHEETS
    public function replaceSheetsImage($imgUrl,$textReplace){
        $request =  new Google_Service_Sheets_Request([
            'findReplace' => [
                'find' => $textReplace,
                'replacement' => '=IMAGE("'.$imgUrl.'")',
                'allSheets' => true
            ]
        ]);

        return $request;
    }

    //SPREADSHEETS
    public function replaceSlidesImage($imgUrl,$textReplace, $document){

        $slides = $document->getSlides();
        $requests = array();

        foreach ($slides as $slide){

            $pageElements = $slide['pageElements'];
            foreach ($pageElements as $pageElement){


                if(isset($pageElement["shape"]["text"]["textElements"])){
                    $textElements = $pageElement["shape"]["text"]["textElements"];

                    foreach ($textElements as $textElement){

                        if( strpos($textElement["textRun"]["content"], $textReplace) !== false  ){

                            $pageObjectId = $slide["objectId"];
                            $textRectangleObjectId = $pageElement["objectId"];
                            $size = $pageElement["size"];
                            $transform = $pageElement["transform"];

                            $requests[]=new Google_Service_Slides_Request(array(
                                'createImage' => array(
                                    'url' => $imgUrl,
                                    'elementProperties' => array(
                                        'pageObjectId' => $pageObjectId,
                                        'size' => $size,
                                        'transform' => $transform
                                    )
                                )
                            ));

                            $requests[]=new Google_Service_Slides_Request(array(
                                'deleteObject' => array(
                                    'objectId' =>$textRectangleObjectId
                                )
                            ));



                        }
                    }
                }


            }
        }

        return $requests;
    }












    /*COPIAR UN DOCUMENTO DESDE UN TEMPLATE*/
    //FUNCION DE HESER
    public function uploadDocumentToDrive($driveService,$fileMetadata, $content){
        Log::channel("documents")->debug('UPLOADING DOCUMENT');
        $attempts = 0;
        do {
            try
            {
                Log::channel("documents")->debug('UPLOADED DOCUMENT');
                return $driveService->files->create($fileMetadata, array(
                    'data' => $content,
                    'uploadType' => 'resumable',
                    'fields' => 'id'));
            } catch (\Exception $e) {
                $attempts++;
                Log::channel("documents")->warning('UPLOADING DOCUMENT ATTEMPT '.$attempts);
                Log::channel("documents")->warning('UPLOADING DOCUMENT ERROR: '.$e->getMessage());
                sleep(1+1*$attempts);
                continue;
            }
            break;
        } while($attempts < Document::RETRYS);
    }
    public function copyFromTemplate($templateDocumentId, $copyTitle, $driveService){
        Log::channel("documents")->debug($templateDocumentId.' - COPYING ');
        $attempts = 0;
        $copy = new Google_Service_Drive_DriveFile(array(
            'name' => $copyTitle
        ));
        do {
            try
            {
                $driveResponse = $driveService->files->copy($templateDocumentId, $copy);
                Log::channel("documents")->debug($driveResponse->id.' - COPIED.');
            } catch (\Throwable $e) {
                dd($e);
                $attempts++;
                Log::channel("documents")->warning($templateDocumentId.' - COPYING ATTEMPT '.$attempts);
                Log::channel("documents")->warning($templateDocumentId.' - COPYING ERROR: '.$e->getMessage());
                sleep(1+1*$attempts);
                continue;
            }
            break;
        } while($attempts < Document::RETRYS);

        $documentCopyId = $driveResponse->id;

        return $documentCopyId;
    }

    /*COPIAR UN DOCUMENTO DESDE UN TEMPLATE*/
    public function downloadDocumentFromDrive($documentId, $driveService, $filename){
        Log::channel("documents")->debug($documentId.' - DOWNLOADING');
        $attempts = 0;
        do {
            try
            {
                /*
                $driveResponse = $driveService->files->get($documentId, array(
                    'fields' => 'id,webContentLink,exportLinks,webViewLink',
                    'mimeType' => 'pdf'
                ));
                $downloadPDF = $driveResponse->exportLinks["application/pdf"];
                //Answer: https://stackoverflow.com/questions/25938294/laravel-display-a-pdf-file-in-storage-without-forcing-download
                //return \Redirect::to($downloadPDF)->header('Content-disposition','inline; filename="'.$filename.'.pdf"');
                return \Illuminate\Support\Facades\Response::make(file_get_contents($downloadPDF), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$filename.'".pdf'
                ]);
                */
                $driveResponse = $driveService->files->export($documentId, 'application/pdf', array(
                    'alt' => 'media'));

                //dd($driveResponse);

                $statusCode = $driveResponse->getStatuscode();
                $contents = $driveResponse->getBody()->getContents();
                $headers = $driveResponse->getHeaders();

                Log::channel("documents")->debug($documentId.' - DOWNLOADED.');

                return \Illuminate\Support\Facades\Response::make($contents,$statusCode, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="'.$filename.'".pdf'
                ]);


            } catch (\Exception $e) {
                $attempts++;
                Log::channel("documents")->warning($documentId.' - DOWNLOADING ATTEMPT '.$attempts);
                Log::channel("documents")->warning($documentId.' - DOWNLOADING ERROR: '.$e->getMessage());
                sleep(1+1*$attempts);
                continue;
            }
            break;
        } while($attempts < Document::RETRYS);

    }
    //FUNCION DE HESER
    public function downloadDocumentAddedForPrintFromDrive($documentId, $driveService){
        Log::channel("documents")->debug($documentId.' - DOWNLOADING_ADDED');
        $attempts = 0;
        do {
            try
            {
                $fileName= $driveService->files->get($documentId)->getName();
                $driveResponse = $driveService->files->get($documentId, array('alt' => 'media' ));
                Log::channel("documents")->debug($documentId.' - DOWNLOADED_ADDED.');
                //ANSWER: https://github.com/ivanvermeyen/laravel-google-drive-demo/issues/24
                /*
                                return response($driveResponse->getBody(),200,$driveResponse->getHeaders())
                                    ->header('Content-disposition','inline;')
                                    ->header('Content-Type', $driveResponse->getHeaders()["Content-Type"]);
                */
                $content = $driveResponse->getBody();

                $headers = [
                    'Content-type'        => $driveResponse->getHeaders()["Content-Type"],
                    'Content-Disposition' => 'attachment; filename='.$fileName,
                ];

                return \Illuminate\Support\Facades\Response::make($content, 200, $headers);

            } catch (\Exception $e) {
                $attempts++;
                Log::channel("documents")->warning($documentId.' - DOWNLOADING_ADDED ATTEMPT '.$attempts);
                Log::channel("documents")->warning($documentId.' - DOWNLOADING_ADDED ERROR: '.$e->getMessage());
                sleep(1+1*$attempts);
                continue;
            }
            break;
        } while($attempts < Document::RETRYS);
    }

    /*ACTUALIZAR UN DOCUMENTO*/
    //FUNCION DE HESER
    public function updateDocument($requests, $documentId, $service){
        Log::channel("documents")->debug($documentId.' - UPDATING.');
        $attempts=0;
        $batchUpdateRequest = new Google_Service_Docs_BatchUpdateDocumentRequest(array(
            'requests' => $requests
        ));
        do {
            try
            {
                $response = $service->documents->batchUpdate($documentId, $batchUpdateRequest);
                Log::channel("documents")->debug($documentId.' - UPDATED.');
            } catch (\Exception $e) {
                $attempts++;
                Log::channel("documents")->warning($documentId.' - UPDATING ATTEMPT '.$attempts);
                Log::channel("documents")->warning($documentId.' - UPDATING ERROR: '.$e->getMessage());
                sleep(1+1*$attempts);
                continue;
            }
            break;
        } while($attempts < Document::RETRYS);


        return $response;
    }
    //FUNCION DE HESER
    public function updateSheet($requests, $documentId, $service){
        Log::channel("documents")->debug($documentId.' - UPDATING.');
        $attempts=0;
        $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);
        do {
            try
            {
                $response = $service->spreadsheets->batchUpdate($documentId, $batchUpdateRequest);
                Log::channel("documents")->debug($documentId.' - UPDATED.');
            } catch (\Exception $e) {
                $attempts++;
                Log::channel("documents")->warning($documentId.' - UPDATING ATTEMPT '.$attempts);
                Log::channel("documents")->warning($documentId.' - UPDATING ERROR: '.$e->getMessage());
                sleep(1+1*$attempts);
                continue;
            }
            break;
        } while($attempts < Document::RETRYS);

        return $response;
    }
    //FUNCION DE HESER
    public function updateSlide($requests, $documentId, $service){
        Log::channel("documents")->debug($documentId.' - UPDATING.');
        $attempts=0;
        $batchUpdateRequest = new Google_Service_Slides_BatchUpdatePresentationRequest(array(
            'requests' => $requests
        ));
        do {
            try
            {
                $response = $service->presentations->batchUpdate($documentId, $batchUpdateRequest);
                Log::channel("documents")->debug($documentId.' - UPDATED.');
            } catch (\Exception $e) {
                $attempts++;
                Log::channel("documents")->warning($documentId.' - UPDATING ATTEMPT '.$attempts);
                Log::channel("documents")->warning($documentId.' - UPDATING ERROR: '.$e->getMessage());
                sleep(1+1*$attempts);
                continue;
            }
            break;
        } while($attempts < Document::RETRYS);

        return $response;
    }

    //FUNCION DE HESER
    public function getGoogleServiceDocs($client){
        return new Google_Service_Docs($client);
    }

    //FUNCION DE HESER
    public function getGoogleServiceSheets($client){
        return new Google_Service_Sheets($client);
    }

    //FUNCION DE HESER
    public function getGoogleServiceSlides($client){
        return new Google_Service_Slides($client);
    }

    //FUNCION DE HESER
    public function getGoogleServiceDrive($client){
        return new Google_Service_Drive($client);
    }

    //FUNCION DE HESER
    public function getGoogleServiceDriveDriveFile($name,$folderId){
        return new Google_Service_Drive_DriveFile(array(
            'name' => $name,
            'parents' => array($folderId)
        ));
    }

    //FUNCION DE HESER
    public function replaceTextByType($replacedText, $replaceText, $documentType){
        switch ($documentType) {
            case Document::DOCS:
                return $this->replaceDocsText($replacedText, $replaceText);
                break;
            case Document::SHEETS:
                return $this->replaceSheetsText($replacedText, $replaceText);
                break;
            case Document::SLIDES:
                return $this->replaceSlidesText($replacedText, $replaceText);
                break;
        }
    }

    //FUNCION DE HESER
    public function replaceImageByType($imgUrl, $textReplace, $documentType, $document = NULL){
        switch ($documentType) {
            case Document::DOCS:
                return $this->replaceDocsImage($imgUrl,$textReplace, $document);
                break;
            case Document::SHEETS:
                return $this->replaceSheetsImage($imgUrl,$textReplace);
                break;
            case Document::SLIDES:
                return $this->replaceSlidesImage($imgUrl,$textReplace, $document);
                break;
        }
    }

    //GET DOCUMENT
    public function getDocumentByType($service, $documentId, $documentType){
        Log::channel("documents")->debug($documentId.' - RETRIEVING.');
        $attempts = 0;
        $document = "";
        switch ($documentType) {
            case Document::DOCS:
                do {
                    try
                    {
                        $document = $service->documents->get($documentId);
                    } catch (\Throwable $e) {
                        $attempts++;
                        Log::channel("documents")->warning($documentId.' - RETRIEVING ATTEMPT '.$attempts);
                        Log::channel("documents")->warning($documentId.' - RETRIEVING ERROR: '.$e->getMessage());
                        sleep(1+1*$attempts);
                        continue;
                    }
                    break;
                } while($attempts < Document::RETRYS);
                Log::channel("documents")->debug($documentId.' - RETRIEVED.');
                break;
            case Document::SHEETS:
                do {
                    try
                    {
                        $document = $service->spreadsheets->get($documentId);
                        Log::channel("documents")->debug($documentId.' - RETRIEVED.');
                    } catch (\Exception $e) {
                        $attempts++;
                        Log::channel("documents")->warning($documentId.' - RETRIEVING ATTEMPT '.$attempts);
                        Log::channel("documents")->warning($documentId.' - RETRIEVING ERROR: '.$e->getMessage());
                        sleep(1+1*$attempts);
                        continue;
                    }
                    break;
                } while($attempts < Document::RETRYS);
                break;
            case Document::SLIDES:
                do {
                    try
                    {
                        $document = $service->presentations->get($documentId);
                        Log::channel("documents")->debug($documentId.' - RETRIEVED.');
                    } catch (\Exception $e) {
                        $attempts++;
                        Log::channel("documents")->warning($documentId.' - RETRIEVING ATTEMPT '.$attempts);
                        Log::channel("documents")->warning($documentId.' - RETRIEVING ERROR: '.$e->getMessage());
                        sleep(1+1*$attempts);
                        continue;
                    }
                    break;
                } while($attempts < Document::RETRYS);
                break;
        }
        return $document;
    }

    //GET DOCUMENT
    public function getServiceByType($docsService, $sheetsService, $slidesService,  $documentType){
        switch ($documentType) {
            case Document::DOCS:
                return $docsService;
                break;
            case Document::SHEETS:
                return $sheetsService;
                break;
            case Document::SLIDES:
                return $slidesService;
                break;
        }
    }

    //UPDATE DOCUMENT
    public function updateDocumentByType($requests, $documentId, $service, $documentType){
        switch ($documentType) {
            case Document::DOCS:
                return $this->updateDocument($requests, $documentId, $service);
                break;
            case Document::SHEETS:
                return $this->updateSheet($requests, $documentId, $service);
                break;
            case Document::SLIDES:
                return $this->updateSlide($requests, $documentId, $service);
                break;
        }
    }

}
