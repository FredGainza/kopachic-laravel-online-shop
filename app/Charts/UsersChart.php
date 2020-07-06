<?php

declare(strict_types = 1);
namespace App\Charts;

use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use App\Models\User;

class UsersChart extends CommonChart
{
    public function handler(Request $request): Chartisan
    {
        return $this->chartisan(new User, 'Nouveaux clients');
    }
}