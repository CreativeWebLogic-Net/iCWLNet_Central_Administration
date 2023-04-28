


require LWP::UserAgent;
 my $ua = LWP::UserAgent->new(env_proxy => 1,
                              keep_alive => 1,
                              timeout => 30,
                             );

$response = $ua->get('https://access.sitemanage.info/');
print $response;
print "hello world";