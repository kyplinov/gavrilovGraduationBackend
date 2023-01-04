<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate-in-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the migrations in the order specified in the file app/Console/Comands/MigrateInOrder.php \n Drop all the table in db before execute the command.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** Specify the names of the migrations files in the order you want to
         * loaded
         * $migrations =[
         *               'xxxx_xx_xx_000000_create_nameTable_table.php',
         *    ];
         */
        $migrations = [
            '2014_10_12_000000_create_users_table.php',
            '2014_10_12_100000_create_password_resets_table.php',
            '2019_08_19_000000_create_failed_jobs_table.php',
            '2019_12_14_000001_create_personal_access_tokens_table.php',
            '2022_12_20_173139_create_departments_table.php',
            '2022_12_20_174627_create_files_table.php',
            '2022_12_20_183426_create_statuses_table.php',
            '2022_12_20_200820_create_configuration_unit_types_table.php',
            '2022_12_18_204400_create_areas_table.php',
            '2022_12_20_192452_create_photos_table.php',
            '2022_12_20_191903_create_employees_table.php',
            '2022_12_20_182033_create_configuration_units_table.php',
            '2022_12_20_184414_create_applications_table.php',
            '2022_12_20_185104_create_application_status_table.php',
            '2022_12_20_185653_create_application_file_table.php',
            '2022_12_20_190627_create_application_configuration_unit_table.php',
            '2022_12_20_195718_create_configuration_unit_employees_table.php',
        ];

        foreach($migrations as $migration)
        {
            $basePath = 'database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath.$migrationName;
            $this->call('migrate:refresh', [
                '--path' => $path ,
            ]);
        }
    }
}
