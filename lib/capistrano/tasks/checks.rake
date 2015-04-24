namespace :check do
  desc "Check that we can access everything"
  task :access do
    on roles(:all) do |host|
      if test("[ -w #{fetch(:deploy_to)} ]")
        info "#{fetch(:deploy_to)} is writable on #{host}"
      else
        error "#{fetch(:deploy_to)} is not writable on #{host}"
      end
    end
  end
  
  desc "Runs `printenv` remotely"
  task :env do
    on roles(:all) do |host|
      execute :printenv
    end
  end
  
  desc "tail application log"
  task :app_log do
    on roles(:app) do |host|
      execute :tail, "-f #{current_path}/log/#{fetch(:rails_env)}.log"
    end
  end
  
  desc "get current stage"
  task :stage do
    puts fetch(:stage)
  end
  
  desc "current revision"
  task :current_revision do
    on roles(:app) do |host|
      execute :cat, "#{current_path}/REVISION"
    end
  end

  desc "test task"
  task :test do
    on roles(:app) do |role|
      within release_path do
        execute :pwd
      end
    end
  end

  desc "ask to run DB sync (incomplete DO NOT USE)"
  task :sync_db do
    on roles(:app) do |role|
      set :confirmed, proc {
puts <<-SYNC 
  Do you want to sync your local db to the remote db?
SYNC
        ask :answer, "Type 'y/n'"
        fetch(:answer).downcase.start_with? 'y'
      }.call

      puts fetch(:confirmed)
    end
  end
end

