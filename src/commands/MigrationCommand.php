<?php namespace Microffice\Units;

use Illuminate\Database\Console\Migrations\BaseCommand;
use Symfony\Component\Console\Input\InputOption;

class MigrationCommand extends BaseCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'units:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Microffice/Units specifications.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $app = app();
        $app['view']->addNamespace('units',substr(__DIR__,0,-8).'views');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->line('');
        $this->info('The migration process will create a migration file and a seeder for the units list');
        
        $this->line('');
        // We check if the migrations are for unit testing purposes.
        // If it is we skip confirmation.
        if ( $this->input->getOption('unittesting') || $this->confirm("Proceed with the migration creation? [Yes|no]") )
        {
            $this->line('');

            $this->info( "Creating migration and seeder..." );
            if( $this->createMigration( 'units' ) )
            {
                if(! $this->input->getOption('unittesting'))
                {
                    $this->line('');
                    
                    $this->call('optimize', array());
                }
                
                $this->line('');
                
                $this->info( "Migration successfully created!" );
            }
            else{
                $this->error( 
                    "Coudn't create migration.\n Check the write permissions".
                    " within the app/database/migrations directory."
                );
            }

            $this->line('');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('unittesting', 'ut', InputOption::VALUE_NONE, 'Store created migrations in tests/migrations subdirectiory'),
            array('path', 'p', InputOption::VALUE_OPTIONAL, 'Path to the directory where \'migration/\' an \'seed/\' subdirectories reside or have to be created.'),/**/
        );
    }

    /**
     * Create the migration
     *
     * @param  string $name
     * @return bool
     */
    protected function createMigration()
    {
        //Create the migration
        $app = app();

        $basePath = ( $this->input->getOption('path') ) ? $this->input->getOption('path') : $this->getBasePath();

        $this->checkMigrationsDirectoriesExists($basePath);

        $migrationFiles = array(
            $basePath.'/migrations/*_create_units_table.php' => 'units::generators.migration'
        );

        $seconds = 0;

        foreach ($migrationFiles as $migrationFile => $outputFile) {            
            if (sizeof(glob($migrationFile)) == 0) {
                $migrationFile = str_replace('*', date('Y_m_d_His', strtotime('+' . $seconds . ' seconds')), $migrationFile);
                
                $fs = fopen($migrationFile, 'x');
                if ($fs) {
                    $output = "<?php\n\n" .$app['view']->make($outputFile)->with(array('table' => 'units'))->render();
                    
                    fwrite($fs, $output);
                    fclose($fs);
                } else {
                    return false;
                }

                $seconds++;
            }
        }

        //Create the seeder
        $seeder_file = $basePath.'/seeds/UnitsSeeder.php';

        $output = "<?php\n\n" .$app['view']->make('units::generators.seeder')->render();
        
        if (!file_exists( $seeder_file )) {
            $fs = fopen($seeder_file, 'x');
            if ($fs) {
                fwrite($fs, $output);
                fclose($fs);
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the target directory path.
     * In function of --unittesting flag
     *
     * @return string
     */
    protected function getBasePath()
    {
        // We check if the migrations are for unit testing purposes.
        // If it is we use the 'tests/migration' path relative to the package.
        // Else we use Laravel default storage place.
        return $this->input->getOption('unittesting') ? __DIR__.'/../../tests' : $this->laravel->path.'/../database';
    }

    /**
     * Check if "migrations/" and "seeds/" subdirectories exists in $basePath
     * and create them if necessary
     *
     * @param  string $basePath
     * @return void
     */
    protected function checkMigrationsDirectoriesExists($basePath)
    {
        if(! file_exists($basePath."/seeds"))
        {
            mkdir($basePath."/seeds", 0777, true);
        }

        if(! file_exists($basePath."/migrations"))
        {
            mkdir($basePath."/migrations", 0777, true);
        }
    }

}