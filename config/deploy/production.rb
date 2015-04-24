set :stage, :production

server 'hello-world.io', user: 'ubuntu', roles: %w{web app db}

#wp cli settings
set :wpcli_remote_url, "http://hello-world.io"
set :wpcli_local_url, "http://hello-world.local"
set :wpcli_local_uploads_dir, "~/Sites/hello-world/wp-content/uploads/"
set :wpcli_remote_uploads_dir, "#{shared_path}/wp-content/uploads/"