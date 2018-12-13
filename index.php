<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


$bucket = 'bucketName';
$s3     = new S3Client(
    [
        'version' => 'latest',
        'region'  => 'eu-central-1',
    ]
);

/* Use the high-level iterators (returns ALL of your objects). */
try {
    $results = $s3->getPaginator(
        'ListObjects',
        [
            'Bucket' => $bucket,
        ]
    );

    foreach ($results as $result) {
        foreach ($result['Contents'] as $object) {
            echo $object['Key'].PHP_EOL.'<br />';
        }
    }
} catch (S3Exception $e) {
    echo $e->getMessage().PHP_EOL;
}

///* Use the plain API (returns ONLY up to 1000 of your objects).*/
try {
    $objects = $s3->listObjects(
        [
            'Bucket' => $bucket,
        ]
    );
    foreach ($objects['Contents'] as $object) {
        echo $object['Key'].PHP_EOL.'<br />';
    }
} catch (S3Exception $e) {
    echo $e->getMessage().PHP_EOL;
}

/* listBuckets */
try {
    echo '<pre>';
    echo $result = $s3->listBuckets();
    echo '</pre>';


} catch (S3Exception $e) {
    echo $e->getMessage()."\n";
}

/* createBucket */
echo '<pre>';
echo $s3->createBucket(['Bucket' => 'newBucketName']);
echo '</pre>';


/* listObjects */
echo '<pre>';
echo $s3->listObjects(
    [
        'Bucket' => $bucket,
    ]
);
echo '</pre>';


/* getObject */
try {
    $result = $s3->getObject(
        [
            'Bucket' => $bucket,
            'Key'    => 'IMG_20180613_202930.jpg',
        ]
    );
    header("Content-Type: {$result['ContentType']}");
    echo $result['Body'];
} catch (S3Exception $e) {
    echo $e->getMessage().PHP_EOL;
}