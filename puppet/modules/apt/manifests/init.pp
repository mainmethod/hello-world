class apt {
  include apt::update
}

class apt::update {
  exec { "apt-update":
    command => "/usr/bin/apt-get update",
  }
  exec { "apt-upgrade": 
    command => "/usr/bin/apt-get upgrade --quiet --yes",
    path => "/usr/bin:/usr/sbin:/bin:/usr/local/bin:/usr/local/sbin:/sbin",
    require => Exec['apt-update']
  }
}