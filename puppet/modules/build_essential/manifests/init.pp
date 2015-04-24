class build_essential {
  include build_essential::install
}

class build_essential::install {
  package { "build-essential": 
    ensure => installed,
  }
}