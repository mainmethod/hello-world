class apache2_utils {
  include apache2_utils::install
}

class apache2_utils::install {
  package { "apache2-utils":
    ensure => installed,
  }
}