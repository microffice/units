use Illuminate\Database\Migrations\Migration;

class SetupUnitsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the units table
        Schema::create(\Config::get('units.table_name'), function($table)
        {           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(\Config::get('units.table_name'));
    }

}