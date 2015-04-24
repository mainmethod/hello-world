namespace :wpcli do 
  namespace :db do
    namespace :backup do

      desc "restore remote DB from shared backup"
      task :restore do 
        on roles(:app) do
          within current_path do
            backups = capture("ls -A #{shared_path}/backups/").split("\n")
            unless backups.empty?
              puts "Available backups:\n\t#{backups.join("\n\t")}"
              ask :backup, proc {backups.last.chomp}.call
              set :backup, "#{shared_path}/backups/#{fetch(:backup)}"
              execute :gunzip, "<", fetch(:backup), "|", :wp, :db, :import, "-"
            else
              puts "No Backups to restore."
            end
          end
        end
      end

      desc "backup remote DB to shared backups directory"
      task :remote do
        on roles(:app) do
          within current_path do
            set :wpcli_remote_db_file, "#{shared_path}/backups/#{fetch(:application)}_#{fetch(:stage)}_#{Time.new.to_s.gsub(/[: ]/, "-")}.sql.gz"
            execute :wp, :db, :export, "- |", :gzip, ">", fetch(:wpcli_remote_db_file)
          end
        end
      end

      desc "backup remote DB to local directory"
      task :remote_to_local do
        on roles(:app) do 
          within current_path do
            set :wpcli_local_db_file, "/Users/robfarrell/sql_dumps/#{fetch(:application)}_#{fetch(:stage)}_#{Time.new.to_s.gsub(/[: ]/, "-")}.sql.gz"
            set :wpcli_remote_db_file, "/tmp/#{fetch(:application)}_#{fetch(:stage)}_#{Time.new.to_s.gsub(/[: ]/, "-")}.sql.gz"
            execute :wp, :db, :export, "- |", :gzip, ">", fetch(:wpcli_remote_db_file)
            download! fetch(:wpcli_remote_db_file), fetch(:wpcli_local_db_file)
            execute :rm, fetch(:wpcli_remote_db_file)
          end
        end
      end

      desc "backup local DB"
      task :local do
        run_locally do
          execute :wp, :db, :export, "- |", :gzip, ">", "/Users/robfarrell/sql_dumps/#{fetch(:application)}_development_#{Time.new.to_s.gsub(/[: ]/, "-")}.sql.gz"
        end
      end
    end
  end
end