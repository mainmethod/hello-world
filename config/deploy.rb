# config valid only for Capistrano 3.1
lock '3.2.1'

set :application, 'hello-world'
set :repo_url, 'git@github.com:mainmethod/hello-world.git'

# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }.call
set :branch, "master"

# Default deploy_to directory is /var/www/my_app
set :deploy_to, "/var/www/#{fetch(:application)}"

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
set :linked_files, %w{wp-config.php wp-content/advanced-cache.php}

# Default value for linked_dirs is []
set :linked_dirs, %w{wp-content/uploads}

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5

namespace :deploy do

  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do
      # Your restart mechanism here, for example:
      # execute :touch, release_path.join('tmp/restart.txt')
    end
  end

  # after :publishing, :restart

  # after :publishing, "deploy:db:backup"

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end

end
