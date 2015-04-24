class mysql {
  include mysql::server
}

class mysql::server {
  include mysql::server::install, mysql::server::config, mysql::server::service
  Class['mysql::server::install'] -> Class['mysql::server::config'] -> Class['mysql::server::service']
}

class mysql::server::install {
  package { 'mysql-server':
    ensure => installed,
  }
}

class mysql::server::config {
  
}

class mysql::server::service {
  service { 'mysql':
    ensure => running,
    enable => true
  }
}