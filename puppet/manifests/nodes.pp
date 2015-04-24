node default {
  include apt
  include build_essential
  include git
  include htop
  include memcached
  include imagemagick
  class { 'apache2':
    sitename => 'hello-world.local'
  }
  include apache2_utils
  class { 'php': 
    modules => ['php5-mysql','php5-curl','php5-imagick','php5-memcached']
  }
  include mysql

  host { "api.wordpress.org":
    ip => "66.155.40.202",
  } 
}