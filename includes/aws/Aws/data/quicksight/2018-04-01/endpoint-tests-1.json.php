<?php
// This file was auto-generated from sdk-root/src/data/quicksight/2018-04-01/endpoint-tests-1.json
return [ 'testCases' => [ [ 'documentation' => 'For region ap-south-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-south-1.api.aws', ], ], 'params' => [ 'Region' => 'ap-south-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-south-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-south-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-south-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-south-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-south-1.api.aws', ], ], 'params' => [ 'Region' => 'ap-south-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-south-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-south-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-south-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-gov-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-gov-east-1.api.aws', ], ], 'params' => [ 'Region' => 'us-gov-east-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-gov-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-gov-east-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-gov-east-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-gov-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-gov-east-1.api.aws', ], ], 'params' => [ 'Region' => 'us-gov-east-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-gov-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-gov-east-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-gov-east-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ca-central-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ca-central-1.api.aws', ], ], 'params' => [ 'Region' => 'ca-central-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ca-central-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ca-central-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'ca-central-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ca-central-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ca-central-1.api.aws', ], ], 'params' => [ 'Region' => 'ca-central-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ca-central-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ca-central-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'ca-central-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-central-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-central-1.api.aws', ], ], 'params' => [ 'Region' => 'eu-central-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-central-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-central-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-central-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-central-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-central-1.api.aws', ], ], 'params' => [ 'Region' => 'eu-central-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-central-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-central-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-central-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-west-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-west-2.api.aws', ], ], 'params' => [ 'Region' => 'us-west-2', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-west-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-west-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-west-2', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-west-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-west-2.api.aws', ], ], 'params' => [ 'Region' => 'us-west-2', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-west-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-west-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-west-2', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-north-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-north-1.api.aws', ], ], 'params' => [ 'Region' => 'eu-north-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-north-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-north-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-north-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-north-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-north-1.api.aws', ], ], 'params' => [ 'Region' => 'eu-north-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-north-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-north-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-north-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-west-3 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-west-3.api.aws', ], ], 'params' => [ 'Region' => 'eu-west-3', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-west-3 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-west-3.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-west-3', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-west-3 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-west-3.api.aws', ], ], 'params' => [ 'Region' => 'eu-west-3', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-west-3 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-west-3.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-west-3', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-west-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-west-2.api.aws', ], ], 'params' => [ 'Region' => 'eu-west-2', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-west-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-west-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-west-2', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-west-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-west-2.api.aws', ], ], 'params' => [ 'Region' => 'eu-west-2', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-west-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-west-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-west-2', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-west-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-west-1.api.aws', ], ], 'params' => [ 'Region' => 'eu-west-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-west-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.eu-west-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-west-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region eu-west-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-west-1.api.aws', ], ], 'params' => [ 'Region' => 'eu-west-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region eu-west-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.eu-west-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'eu-west-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-northeast-2.api.aws', ], ], 'params' => [ 'Region' => 'ap-northeast-2', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-northeast-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-northeast-2', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-northeast-2.api.aws', ], ], 'params' => [ 'Region' => 'ap-northeast-2', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-northeast-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-northeast-2', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-northeast-1.api.aws', ], ], 'params' => [ 'Region' => 'ap-northeast-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-northeast-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-northeast-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-northeast-1.api.aws', ], ], 'params' => [ 'Region' => 'ap-northeast-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-northeast-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-northeast-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region sa-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.sa-east-1.api.aws', ], ], 'params' => [ 'Region' => 'sa-east-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region sa-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.sa-east-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'sa-east-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region sa-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.sa-east-1.api.aws', ], ], 'params' => [ 'Region' => 'sa-east-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region sa-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.sa-east-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'sa-east-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region cn-north-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.cn-north-1.api.amazonwebservices.com.cn', ], ], 'params' => [ 'Region' => 'cn-north-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region cn-north-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.cn-north-1.amazonaws.com.cn', ], ], 'params' => [ 'Region' => 'cn-north-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region cn-north-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.cn-north-1.api.amazonwebservices.com.cn', ], ], 'params' => [ 'Region' => 'cn-north-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region cn-north-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.cn-north-1.amazonaws.com.cn', ], ], 'params' => [ 'Region' => 'cn-north-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-gov-west-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-gov-west-1.api.aws', ], ], 'params' => [ 'Region' => 'us-gov-west-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-gov-west-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-gov-west-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-gov-west-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-gov-west-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-gov-west-1.api.aws', ], ], 'params' => [ 'Region' => 'us-gov-west-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-gov-west-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-gov-west-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-gov-west-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-southeast-1.api.aws', ], ], 'params' => [ 'Region' => 'ap-southeast-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-southeast-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-southeast-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-southeast-1.api.aws', ], ], 'params' => [ 'Region' => 'ap-southeast-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-southeast-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-southeast-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-southeast-2.api.aws', ], ], 'params' => [ 'Region' => 'ap-southeast-2', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.ap-southeast-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-southeast-2', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-southeast-2.api.aws', ], ], 'params' => [ 'Region' => 'ap-southeast-2', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.ap-southeast-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'ap-southeast-2', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-east-1.api.aws', ], ], 'params' => [ 'Region' => 'us-east-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-east-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-east-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-east-1.api.aws', ], ], 'params' => [ 'Region' => 'us-east-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-east-1.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-east-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-east-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-east-2.api.aws', ], ], 'params' => [ 'Region' => 'us-east-2', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-east-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.us-east-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-east-2', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region us-east-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-east-2.api.aws', ], ], 'params' => [ 'Region' => 'us-east-2', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region us-east-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.us-east-2.amazonaws.com', ], ], 'params' => [ 'Region' => 'us-east-2', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region cn-northwest-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.cn-northwest-1.api.amazonwebservices.com.cn', ], ], 'params' => [ 'Region' => 'cn-northwest-1', 'UseFIPS' => true, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region cn-northwest-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight-fips.cn-northwest-1.amazonaws.com.cn', ], ], 'params' => [ 'Region' => 'cn-northwest-1', 'UseFIPS' => true, 'UseDualStack' => false, ], ], [ 'documentation' => 'For region cn-northwest-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.cn-northwest-1.api.amazonwebservices.com.cn', ], ], 'params' => [ 'Region' => 'cn-northwest-1', 'UseFIPS' => false, 'UseDualStack' => true, ], ], [ 'documentation' => 'For region cn-northwest-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://quicksight.cn-northwest-1.amazonaws.com.cn', ], ], 'params' => [ 'Region' => 'cn-northwest-1', 'UseFIPS' => false, 'UseDualStack' => false, ], ], [ 'documentation' => 'For custom endpoint with fips disabled and dualstack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://example.com', ], ], 'params' => [ 'Region' => 'us-east-1', 'UseFIPS' => false, 'UseDualStack' => false, 'Endpoint' => 'https://example.com', ], ], [ 'documentation' => 'For custom endpoint with fips enabled and dualstack disabled', 'expect' => [ 'error' => 'Invalid Configuration: FIPS and custom endpoint are not supported', ], 'params' => [ 'Region' => 'us-east-1', 'UseFIPS' => true, 'UseDualStack' => false, 'Endpoint' => 'https://example.com', ], ], [ 'documentation' => 'For custom endpoint with fips disabled and dualstack enabled', 'expect' => [ 'error' => 'Invalid Configuration: Dualstack and custom endpoint are not supported', ], 'params' => [ 'Region' => 'us-east-1', 'UseFIPS' => false, 'UseDualStack' => true, 'Endpoint' => 'https://example.com', ], ], ], 'version' => '1.0',];
