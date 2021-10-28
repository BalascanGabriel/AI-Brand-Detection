<?php

require_once 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;


$connectionString = "DefaultEndpointsProtocol=https;AccountName=servert3;AccountKey=Hoo8Fzt0jiP5/wndlJ7M2BQKAOQUFpgOMZFkQJmFXaU5yb0Hzs0b5qazKjli8CKbh7iaZ3WsptgFnvQydYhyNA==;EndpointSuffix=core.windows.net";

$blobClient = BlobRestProxy::createBlobService($connectionString);

$fileToUpload = $target_file;

$containerName = "container";
    
$content = fopen($fileToUpload, "r");
	
$blobClient->createBlockBlob($containerName, $fileToUpload, $content);
$listBlobsOptions = new ListBlobsOptions();
$listBlobsOptions->setPrefix($fileToUpload);
	

do {
     $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
     foreach ($result->getBlobs() as $blob) {
                $addr = $blob->getUrl();
                                            }
     $listBlobsOptions->setContinuationToken($result->getContinuationToken());
    } while ($result->getContinuationToken());
    

unlink($target_file);

$conn = new PDO("sqlsrv:server = tcp:servert3.database.windows.net,1433; Database = servert3", "servert3", "Server12345");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$db = 'insert into uploads(nume,link,rezultat)values(?,?,?)';
$numefis=basename($fileToUpload);
$stmt = $conn->prepare($db);
$stmt->execute([$numefis, $addr, $brand_gasit]);

$db = "SELECT nume,link,timp,rezultat FROM uploads";
echo '<head>
<title>Tema3</title>
</head>';

echo '<h1 style=color:#2FE0AA;text-align:center;font-size:50px>Istoric</h1><ol>';

$db=$conn->query($db);
foreach ( $db as $row) {
    echo '<li>Nume: ' . $row['nume'] ;
    echo '<ul>';	
    echo '<li>Brand: ' . $row['rezultat'] . '</li>';
    echo "<li>Link: <a href='" . $row["link"] . "'>" . $row["link"] . "</a></li>";
    echo '<li>Timp: ' . $row['timp'] . '</li>' . '</ul></li><br>';
}

echo '</ol>';


?>

