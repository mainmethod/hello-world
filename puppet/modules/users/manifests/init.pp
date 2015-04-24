class users {
  user { 'deploy':
    ensure     => 'present',
    groups     => ['sudo', 'ubuntu'],
    home       => '/home/deploy',
    managehome => true,
    shell      => '/bin/bash'
  } ->
  user { 'ubuntu': 
    ensure => 'present' 
  }
}