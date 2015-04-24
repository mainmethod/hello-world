class php($modules=[]) {
  include php::install, php::config, php::modules
  Class['php::install'] -> Class['php::config'] -> Class['php::modules']
}

class php::install {
  package { "php5":
    ensure => installed,
  }
}

class php::config {
  file { "/etc/php5/apache2/php.ini":
    ensure => file,
    owner => 'root',
    group => 'root',
    content => template('php/php.ini.erb')
  }
}

class php::modules {
  package { $php::modules: 
    ensure => installed,
    notify => Service['apache2']
  }
}