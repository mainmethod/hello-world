class imagemagick {
  include imagemagick::install
}

class imagemagick::install {
  package { "imagemagick":
    ensure => installed
  }
}