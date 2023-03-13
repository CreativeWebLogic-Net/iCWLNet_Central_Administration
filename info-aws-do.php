<?php
    ini_set( 'display_errors', '1' );
    echo"-1------------------------------------------------------------\n";
    require __DIR__.'/includes/aws/aws-autoloader.php';
    
    use Aws\S3\S3Client;  
    use Aws\Exception\AwsException;
    echo"-3------------------------------------------------------------\n";
    //---------------------------------------------- Digital Ocean S3 Server----------------------------------------
    /*
    define('AWS_KEY', 'DO00W8B9UMK872XDKDM3');
    define('AWS_SECRET_KEY', 'mtj4tsOeLL09RgrN8gqICgFak/fU9/LVhTqmFnG4s4Q');
    define('AWS_END_POINT', 'https://static-cms.nyc3.digitaloceanspaces.com');
    define('AWS_REGION', 'default-nyc1');
    */
    //---------------------------------------------- Linode S3 Server----------------------------------------
    define('AWS_KEY', 'VN48WOEYUNOL6ZIO9HKV');
    define('AWS_SECRET_KEY', 'UAUDtcQ52e56fEzQpUFDgnqcQJyc8TS6IBJYNpvR');
    //define('AWS_END_POINT', 'http://assets.w-d.biz');
    define('AWS_END_POINT', 'http://assets.w-d.biz.us-southeast-1.linodeobjects.com');
    define('AWS_REGION', 'us-southeast-1');
    echo"-4------------------------------------------------------------\n";
    
    $s3Client = new S3Client([
            'endpoint' => AWS_END_POINT,
        'region' => AWS_REGION,
        'version' => 'latest',
        'use_path_style_endpoint' => true,
        'credentials' => [
                'key'    => AWS_KEY,
                'secret' => AWS_SECRET_KEY,
        ],
    ]);
    //print_r($s3Client);
    echo"-5------------------------------------------------------------\n";
    $s3Client->createBucket(array('Bucket' => 'mybucket'));
    echo"-52------------------------------------------------------------\n";
    //Listing all S3 Bucket
    $buckets = $s3Client->listBuckets();
    $count=0;
    if(is_array($buckets['Buckets'])>0){
        foreach ($buckets['Buckets'] as $bucket) {
            echo $bucket['Name'] . "\n";
            $count++;
            if($count>100) break;
        }
    }else{
        echo "no buckets->\n";
    }
    print_r($buckets);
    
    echo"-62------------------------------------------------------------\n";
    
?>