class memcached {
  include memcached::install
}

class memcached::install {
  package { 'memcached': 
    ensure => installed,
  }
}