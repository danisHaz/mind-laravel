<?php

use Illuminate\Support\Facades\Auth;

Route::get('/signin', "SigninController@index")
    ->middleware("guest")
    ->name("signin");

Route::post("/signin", "SigninController@enter")
    ->middleware("guest");

Route::get("/out", "SigninController@logout")
    ->middleware("auth");

Route::middleware("auth")->group(function() {
    Route::get('/', "ProfileController@index")
        ->name("profile");

    Route::get("/setlocale/{locale}", "LocaleController@set");

    Route::prefix("/points")->group(function() {
        Route::get("add", "PointsController@add_index");
        Route::post("add", "PointsController@add");

        Route::get("", "PointsController@mine");

        Route::get("give", "PointsController@give_index");
        Route::post("give", "PointsController@give");

        Route::get("{student}", "PointsController@of_student");

    });

    Route::get("/timetable", "TimetableController@show")
        ->middleware("role:student");

    Route::prefix("/groups")->group(function() {
        Route::get("{group}", "GroupController@get");
        Route::get("", "GroupController@all");
    });

    Route::prefix("/users")->group(function() {
        Route::get("{user}", "UserController@show");
        Route::get("", "UserController@index");
    });

    Route::prefix("/questions")->middleware("auth")->group(function() {
        Route::get("", "QuestionController@show");
        Route::post("store", "QuestionController@store");
        Route::post("answer/{question}", "QuestionController@answer")
            ->middleware("can:answer,question");
        Route::delete("{question}", "QuestionController@delete")
            ->middleware("can:delete,question");
    });

    Route::resource("banners", "BannerController")->except([
        "show"
    ]);

    Route::resource("polls", "PollController");
    Route::resource("events", "EventController");
    Route::resource("documents", "DocumentController");

    Route::prefix("/polls")->group(function() {
        Route::post("{poll}/vote/{variant_id}", "PollController@vote");
    });

    Route::prefix("/settings")->middleware("auth")->group(function() {
        Route::get("", "SettingsController@index");
        Route::post("/change_password", "SettingsController@change_password");
    });

    Route::prefix("/data")->group(function() {
        Route::get("", "DataController@index");
        Route::post("", "DataController@upload");
    });

    Route::put("/notifications/{notif}/read", function($notif) {
        $notif = Auth::user()->notifications()->find($notif);
        if ($notif)
            $notif->markAsRead();

        return "";
    });
});
