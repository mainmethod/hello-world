class varnish {
  include varnish::install, varnish::config, varnish::service
  Class['varnish::install'] -> Class['varnish::config'] -> Class['varnish::service']
}

class varnish::install {
  package { "varnish":
    ensure => installed,
  }
}

class varnish::config {
  file { "default.vcl":
    path => "/etc/varnish/default.vcl",
    ensure => file,
    owner => 'root',
    group => 'root',
    content => template('varnish/default.vcl.erb')
  }->
  file { "varnish":
    path => "/etc/default/varnish",
    ensure => file,
    owner => 'root',
    group => 'root',
    content => template('varnish/varnish.erb')
  }
}

class varnish::service {
  service { "varnish":
    ensure => running,
    hasstatus => true,
    hasrestart => true,
    enable => true
  }
}