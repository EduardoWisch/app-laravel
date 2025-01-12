<?php

use App\Models\{
    Course,
    Module,
    User,
    Preference
};
use Illuminate\Support\Facades\Route;

Route::get('/one-to-many', function() {
    // $course = Course::create(['name' => 'Curso de Laravel']);
    $course = Course::with('modules.lessons')->first();

    echo $course->name;
    echo '<br>';
    foreach ($course->modules as $module){
        echo "Módulo {$module->name} <br>";

        foreach ($module->lessons as $lesson){
            echo "Módulo {$lesson->name} <br>";
        }
    }

    $data = [
        'name' => 'Modulo x2',
    ];
    // $course->modules()->create($data);

    // Module::find(2)->update();

    // $course->modules()->get();
    $modules = $course->modules;

    dd($modules);
});

Route::get('/one-to-one', function () {
    $user = User::with('preference')->find(2);

    $data = [
        'background_color' => '#000',
    ];

    if($user->preference){
        $user->preference->update($data);
    }else{
        // $user->preference()->create($data);
        $preference = new Preference($data);
        $user->preference()->save($preference);
    }

    $user->refresh();
    var_dump($user->preference);

    $user->preference->delete();
    $user->refresh();

    dd($user->preference);
});

Route::get('/', function () {
    return view('welcome');
});
