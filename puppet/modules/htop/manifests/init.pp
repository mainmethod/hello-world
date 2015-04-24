class htop {
  include htop::install
}

class htop::install {
  package { "htop": 
    ensure => installed,
  }
}