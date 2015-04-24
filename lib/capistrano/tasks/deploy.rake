namespace :deploy do
  namespace :db do

    desc "backup db for revision"
    task :backup do
      on roles(:app) do
        within release_path do
          release_number = release_path.to_s.split("/").last
          set :wpcli_remote_db_file, "#{shared_path}/release_backups/#{release_number}.sql.gz"
          execute :wp, :db, :export, "- |", :gzip, ">", fetch(:wpcli_remote_db_file)
        end
      end
    end
  end
end