<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Type;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('types')->delete();
        $this->call([
            TypeBatteryAh::class,
            TypeBatterymAh::class,
            TypeBatteryPercentage::class,
            TypeElectricalVoltageV::class,
            TypeElectricityCurrentA::class,
            TypeElectricityCurrentmA::class,
            TypeLightSensor::class,
            TypeLiquidFlow::class,
            TypeSmokeLevel::class,
            TypeState::class,
            TypeThermometer::class,
            TypeUsagePercentage::class,
            TypeWeightKg::class,
            //UserAdmin::class,
            //UserUser::class,
        ]);
    }
}
