use Illuminate\Database\Seeder;
use Microffice\Units\Unit;

class UnitsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the units table
        \DB::table(\Config::get('units.table_name'))->delete();

        // Fill the units table
        Unit::create(['unit' => 'm']);
    }
}
