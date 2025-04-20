<?php
declare(strict_types=1);
namespace App\Tasks;

use App\Models\User;
use Faker\Factory;
use Phalcon\Cli\Task;

/**
 * Генерация пользователей.
 */
class UserTask extends Task
{
    /**
     * Генерация пользователей.
     * @param int $count Количество пользователей для генерации.
     */
    public function generateAction(int $count = 100): void
    {
        $faker = Factory::create('ru_RU');

        for ($i = 0; $i < $count; $i++) {
            $data = [
                'name'      => $faker->name,
                'email'     => $faker->email,
                'phone'     => $faker->phoneNumber,
                'address'   => $faker->address,
                'city'      => $faker->city,
                'country'   => $faker->country,
                'timestamp' => date('Y-m-d H:i:s'),
            ];
            $user = new User();
            $user->assign($data);
            $user->save();

            echo ($i + 1) . ". {$user->getName()}\n";
        }
    }
}