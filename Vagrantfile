# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.vm.network :private_network, ip: '192.168.22.29'
  config.vm.hostname = "hello-world.local"
  config.vm.synced_folder ".", "/vagrant", disabled: true
  config.vm.synced_folder ".", "/var/www/hello-world.local", 
    create: true, 
    group: 'www-data',
    owner: 'www-data'

  #puppet configuration
  config.vm.provision "puppet" do |puppet|
    puppet.manifests_path = "puppet/manifests"
    puppet.manifest_file = "default.pp"
    puppet.module_path = "puppet/modules"
  end
end
