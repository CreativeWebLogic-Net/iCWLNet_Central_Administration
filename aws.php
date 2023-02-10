<?php
   
        ini_set( 'display_errors', '1' );

        //try{
            require __DIR__.'/includes/aws/aws-autoloader.php';
            use Aws\S3\S3Client;  
            use Aws\Exception\Exception;
            /*
        }catch(Exception $e){
            throw new Exception($e);
           // print var_export($e,true);
            echo"-E33------------------------------------------------------------\n";
        }
        */
try{    
        try{
            //---------------------------------------------- Setup Server Details and Load PHP files----------------------------------------
            echo"-1------------------------------------------------------------\n";
            //---------------------------------------------- Digital Ocean S3 Server----------------------------------------
             
            //define('AWS_KEY', 'DO00W8B9UMK872XDKDM3');
            //define('AWS_SECRET_KEY', 'mtj4tsOeLL09RgrN8gqICgFak/fU9/LVhTqmFnG4s4Q');
            // define('AWS_END_POINT', 'https://static-cms.nyc3.digitaloceanspaces.com');
            //define('AWS_REGION', 'default-nyc1');
            
            //---------------------------------------------- Linode S3 Server----------------------------------------
            define('AWS_KEY', 'VN48WOEYUNOL6ZIO9HKV');
            define('AWS_SECRET_KEY', 'UAUDtcQ52e56fEzQpUFDgnqcQJyc8TS6IBJYNpvR');
            define('AWS_END_POINT', 'http://assets.w-d.biz');
            //define('AWS_END_POINT', 'http://assets.w-d.biz.us-southeast-1.linodeobjects.com');
            define('AWS_REGION', 'us-southeast-1');
            echo"-4------------------------------------------------------------\n";
           
        }catch(Exception $e){
            
            echo"-E33------------------------------------------------------------\n";
            throw new Exception($e);
           // print var_export($e,true);
        }
        
        try{
            //---------------------------------------------- Connects to S3 Server----------------------------------------
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
        }catch(s3Exception $e){
            
            echo"-E34------------------------------------------------------------\n";
            throw new Exception($e);
            //print var_export($e,true);
        }
        
        //print_r($s3Client);
        
        //echo"-5------------------------------------------------------------\n";
        //$s3Client->createBucket(array('Bucket' => 'mybucket'));
        echo"-52------------------------------------------------------------\n";
        
        try{
            //---------------------------------------------- Try to List Buckets----------------------------------------
            $result = $s3Client->listBuckets();
            $names = $result->search('Buckets[].Name');
            print_r($names);
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
        }catch(Exception $e){
            
            echo"-E63------------------------------------------------------------\n";
            throw new Exception($e);
            //print var_export($e,true);
        }
    
        try{
            
            echo"-62------------------------------------------------------------\n";
            //---------------------------------------------- Upload File to Server----------------------------------------
            
            //$result = $s3Client->putObject(array(
            // 'Bucket'     => 'mybucket',
            // 'Key'        => 'edit.gif',
            //  'SourceFile' => __DIR__.'/main/assets/images/edit.gif',
            //   'Metadata'   => array()
            //));
            
            echo"-63------------------------------------------------------------\n";
        }catch(Exception $e){
            
            echo"-E63------------------------------------------------------------\n";
            throw new Exception($e);
            //print var_export($e,true);
        }
        
        //---------------------------------------------- Set File Permissions----------------------------------------
        // Gets the access control policy for a bucket
        
        try{
            //---------------------------------------------- Permissions for Files on Server----------------------------------------
            echo"-6322------------------------------------------------------------\n";
            $bucket = 'mybucket';
            try {
                echo"-632299------------------------------------------------------------\n";
                $resp = $s3Client->getBucketAcl([
                    'Bucket' => $bucket
                ]);
                echo"-632299001------------------------------------------------------------\n";
                echo "Succeed in retrieving bucket ACL as follows: \n";
                print var_export($resp,true);
            }catch (S3Exception $e) {
                echo"-E665------------------------------------------------------------\n";
                // output error message if fails
                print_r($e);
                //throw new Exception($e);
                //echo $e;
            // echo "\n";
            }
            echo"-6355------------------------------------------------------------\n";
            // Sets the permissions on a bucket using access control lists (ACL).
            $params = [
            'ACL' => 'public-read',
            'AccessControlPolicy' => [
                // Information can be retrieved from `getBucketAcl` response
                'Grants' => [
                    [
                        'Grantee' => [
                            'Type' => 'CanonicalUser',
                        ],
                        'Permission' => 'FULL_CONTROL',
                    ],
                    // ...
                ],
            ],
            'Bucket' => $bucket,
            ];

            try {
                $resp = $s3Client->putBucketAcl($params);
                echo "Succeed in setting bucket ACL.\n";
            } catch (S3Exception $e) {
                // Display error message
                echo"-E77------------------------------------------------------------\n";
                throw new Exception($e);
            }
        }catch(S3Exception $e){
            //print var_export($e,true);
            echo"-E88------------------------------------------------------------\n";
            throw new Exception($e);
            
        }
        
}catch(Exception $e){
    print_r($e);
    echo"-E99------------------------------------------------------------\n";
}
?>