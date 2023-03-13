<?php
    ini_set( 'display_errors', '1' );
    echo"-1------------------------------------------------------------\n";
// Require the Composer autoloader.
    require __DIR__.'/includes/aws/aws-autoloader.php';
    echo"-2------------------------------------------------------------\n";
    use Aws\S3\S3Client;
    echo"-3------------------------------------------------------------\n";
    define('AWS_KEY', 'VN48WOEYUNOL6ZIO9HKV');
    define('AWS_SECRET_KEY', 'UAUDtcQ52e56fEzQpUFDgnqcQJyc8TS6IBJYNpvR');
    //$ENDPOINT = 'http://assets.w-d.biz';
    //$ENDPOINT = '<?php print $app_data['asset-sever']; ?>';
    $ENDPOINT = 'http://assets.w-d.biz.us-southeast-1.linodeobjects.com';
    echo"-4------------------------------------------------------------\n";
    // require the amazon sdk from your composer vendor dir
    //require __DIR__.'/vendor/autoload.php';

    // Instantiate the S3 class and point it at the desired host
    $client = new S3Client([
        //'region' =>'us-southeast-1.linodeobjects.com',// 'us-southeast-1.linodeobjects.com',
        'region' =>'us-southeast-1',
        'version' => '2006-03-01',
        'endpoint' => $ENDPOINT,
        'credentials' => [
            'key' => AWS_KEY,
            'secret' => AWS_SECRET_KEY
        ],
        // Set the S3 class to use objects.dreamhost.com/bucket
        // instead of bucket.objects.dreamhost.com
        'use_path_style_endpoint' => true
    ]);
    echo"-5------------------------------------------------------------\n";
    print_r($client);
    echo"-51------------------------------------------------------------\n";
    /*
    $listResponse = $client->listBuckets();
    print_r($client);
    $buckets = $listResponse['Buckets'];
    print_r($listResponse);
    print_r($buckets);
    foreach ($buckets as $bucket) {
        echo $bucket['Name'] . "\t" . $bucket['CreationDate'] . "\n";
    }
    */
    /*
    $bucketname="assets.w-d.biz";
    $objectsListResponse = $client->listObjects(['Bucket' => $bucketname]);
    print_r($objectsListResponse);
    echo"-61------------------------------------------------------------\n";
    $objects = $objectsListResponse['Contents'] ?? [];
    foreach ($objects as $object) {
        echo $object['Key'] . "\t" . $object['Size'] . "\t" . $object['LastModified'] . "\n";
    }
    */

    // Gets the access control policy for a bucket
    $bucket = 'assets.w-d.biz';
    try {
        $resp = $client->getBucketAcl([
            'Bucket' => $bucket
        ]);
        echo "Succeed in retrieving bucket ACL as follows: \n";
        var_dump($resp);
    } catch (AwsException $e) {
        // output error message if fails
        echo $e->getMessage();
        echo "\n";
    }
    echo"-62------------------------------------------------------------\n";
?>