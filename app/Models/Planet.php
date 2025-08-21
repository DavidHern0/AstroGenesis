<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Planet extends Model
{
    protected $fillable = ['user_id', 'name', 'type', 'solar_system_position', 'galaxy_position', 'position', 'info', 'variation'];

    /**
     * Crea un objeto Planet con valores por defecto.
     *
     * @param int $userId
     * @return Planet
     */

    public static function generateAIPlanetName()
    {
        $prefixes = [
            'Zor',
            'Neb',
            'Cry',
            'Vel',
            'Xan',
            'Tor',
            'Qua',
            'Lum',
            'Drak',
            'Mor',
            'Ael',
            'Vor',
            'Ser',
            'Gal',
            'Oph',
            'Trin',
            'Alt',
            'Kry',
            'Fen',
            'Rho',
            'Cen',
            'Ery',
            'Sol',
            'Pol',
            'Nym',
            'Thal',
            'Arg',
            'Kor',
            'Lys',
            'Omn'
        ];

        $middles = [
            'th',
            'br',
            'x',
            'm',
            'n',
            'l',
            'k',
            'vr',
            'st',
            'dr',
            'ph',
            'gr',
            'z',
            'q',
            'ch',
            'sh',
            'rk',
            'gh',
            'nt',
            'pt',
            'mn',
            'lt',
            'sk',
            'tr'
        ];

        $suffixes = [
            'ion',
            'ara',
            'on',
            'aris',
            'oria',
            'eus',
            'ar',
            'us',
            'ix',
            'on',
            'arae',
            'ara',
            'eus',
            'ora',
            'is',
            'oth',
            'ium',
            'or',
            'os',
            'an',
            'ara',
            'yx',
            'en',
            'othis',
            'ara',
            'ae',
            'araon',
            'il',
            'eus',
            'orix'
        ];

        $prefix = $prefixes[array_rand($prefixes)];
        $middle = $middles[array_rand($middles)];
        $suffix = $suffixes[array_rand($suffixes)];

        return $prefix . $middle . $suffix;
    }
    public static function createDefault($userId)
    {

        if ($userId === 1 || $userId <= (env('NUM_BOTS')+1)) { // AI planets
            $planetName = self::generateAIPlanetName();
        } else {
            if (App::getLocale() == 'es') {
                $planetName = 'Planeta Principal';
            } else if (App::getLocale() == 'en') {
                $planetName = 'Main Planet';
            } else {
                $planetName = 'Planet';
            }
        }
        $randomVariation = rand(1, 10);
        $randomSSP = 0;
        $randomG = 0;
        $biome = '';

        do {
            $randomSSP = rand(1, 12);
            $randomG = rand(1, env('MAX_GALAXY_POS'));
            $checkPosition = self::where('solar_system_position', $randomSSP)->where('galaxy_position', $randomG)->exists();
        } while ($checkPosition);

        if ($randomSSP == 1) {
            $biome = "dry";
        } else if ($randomSSP >= 2 && $randomSSP <= 3) {
            $biomeOptions = ["dry", "desert"];
            $biome = $biomeOptions[rand(0, 1)];
        } else if ($randomSSP >= 4 && $randomSSP <= 5) {
            $biomeOptions = ["desert", "savanna"];
            $biome = $biomeOptions[rand(0, 1)];
        } else if ($randomSSP >= 6 && $randomSSP <= 9) {
            $biomeOptions = ["savanna", "jungle", "water"];
            $biome = $biomeOptions[rand(0, 2)];
        } else {
            $biome = 'ice';
        }

        if (rand(1, 12) === 1) {
            $biome = 'gas';
        }

        return self::create([
            'user_id' => $userId,
            'name' => $planetName,
            'type' => 'planet',
            'biome' => $biome,
            'variation' => $randomVariation,
            'solar_system_position' => $randomSSP,
            'galaxy_position' => $randomG,
            'info' => ''
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
