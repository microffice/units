use Illuminate\Database\Seeder;
use Microffice\Units\UnitModel;

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
        \DB::statement('ALTER TABLE ' . \Config::get('units.table_name') . ' AUTO_INCREMENT = 1');

        // Fill the units table
        UnitModel::create(['unit' => 'm']);
    }
}
